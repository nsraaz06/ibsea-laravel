<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\EmailCampaign;
use App\Models\Member;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Mail\CampaignMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailTemplateController extends Controller
{
    /* ── Template CRUD ─────────────────────────────────────────────── */

    public function index()
    {
        $templates = EmailTemplate::withCount('campaigns')
            ->orderByDesc('updated_at')->paginate(20);
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);
        EmailTemplate::create($request->only('name', 'subject', 'body'));
        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);
        $emailTemplate->update($request->only('name', 'subject', 'body'));
        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return back()->with('success', 'Template deleted.');
    }

    /* ── Send Form (from template page) ────────────────────────────── */

    public function send(EmailTemplate $emailTemplate)
    {
        $forms   = Form::where('is_active', true)->get();
        $members = Member::select('id', 'name', 'email')->orderBy('name')->get();
        return view('admin.email-templates.send', compact('emailTemplate', 'forms', 'members'));
    }

    /* ── Compose (pick template + recipients in one page) ───────────── */

    public function compose()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        $forms     = Form::where('is_active', true)->get();
        $members   = Member::select('id', 'name', 'email')->orderBy('name')->get();
        return view('admin.email-campaigns.compose', compact('templates', 'forms', 'members'));
    }

    public function composeAndSend(Request $request)
    {
        $request->validate([
            'template_id'          => 'required|exists:email_templates,id',
            'recipients_type'      => 'required|in:all_members,specific,form_submitters,custom',
            'specific_member_ids'  => 'nullable|array',
            'form_id'              => 'nullable|exists:forms,id',
            'custom_emails'        => 'nullable|string',
        ]);

        $emailTemplate = EmailTemplate::findOrFail($request->template_id);
        return $this->sendCampaign($request, $emailTemplate);
    }

    public function sendCampaign(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'recipients_type'      => 'required|in:all_members,specific,form_submitters,custom',
            'specific_member_ids'  => 'nullable|array',
            'form_id'              => 'nullable|exists:forms,id',
            'custom_emails'        => 'nullable|string',
        ]);

        // ── Daily quota check (Hostinger: ~500/day; we cap at 300) ──
        $DAILY_LIMIT = 300;

        $sentTodayTotal = EmailCampaign::whereDate('sent_at', today())
            ->whereIn('status', ['sent', 'partial', 'sending', 'queued'])
            ->sum('sent_count');

        $remainingQuota = max(0, $DAILY_LIMIT - $sentTodayTotal);

        if ($remainingQuota === 0) {
            return back()->with('error',
                "Daily email limit of {$DAILY_LIMIT} reached. Try again tomorrow.");
        }

        $allRecipients = $this->resolveRecipients($request);

        if (empty($allRecipients)) {
            return back()->with('error', 'No valid recipients found.');
        }

        // Trim to remaining quota
        $recipients = array_slice($allRecipients, 0, $remainingQuota);
        $skipped    = count($allRecipients) - count($recipients);

        // ── Pre-log the campaign as 'queued' so history shows it immediately ──
        $campaign = EmailCampaign::create([
            'template_id'      => $emailTemplate->id,
            'subject'          => $emailTemplate->subject,
            'recipients_type'  => $request->recipients_type,
            'recipient_detail' => json_encode($recipients),
            'sent_count'       => 0,
            'failed_count'     => 0,
            'status'           => 'queued',
            'sent_at'          => now(),
        ]);

        // ── Dispatch job to background queue ──
        \App\Jobs\ProcessEmailCampaign::dispatch(
            $campaign->id,
            $recipients,
            $emailTemplate->subject,
            $emailTemplate->body,
            7  // delay seconds between each email
        )->onQueue('emails');

        $msg = "✅ Campaign queued! {$campaign->total_recipients} emails sending in background (7s apart).";
        if ($skipped > 0) {
            $msg .= " ⚠️ {$skipped} recipients skipped (daily quota of {$DAILY_LIMIT} reached).";
        }

        return redirect()->route('admin.email-campaigns.index')->with('success', $msg);
    }



    /* ── Campaign History ───────────────────────────────────────────── */

    public function campaigns()
    {
        $campaigns = EmailCampaign::with('template')
            ->orderByDesc('sent_at')->paginate(20);
        return view('admin.email-campaigns.index', compact('campaigns'));
    }

    /* ── Private helpers ────────────────────────────────────────────── */

    private function resolveRecipients(Request $request): array
    {
        return match($request->recipients_type) {
            'all_members' => Member::whereNotNull('email')
                ->get()->map(fn($m) => [
                    'name'      => $m->name,
                    'email'     => $m->email,
                    'member_id' => $m->member_id ?? $m->id,
                ])->toArray(),

            'specific' => Member::whereIn('id', $request->specific_member_ids ?? [])
                ->get()->map(fn($m) => [
                    'name'      => $m->name,
                    'email'     => $m->email,
                    'member_id' => $m->member_id ?? $m->id,
                ])->toArray(),

            'form_submitters' => FormSubmission::where('form_id', $request->form_id)
                ->get()->flatMap(function ($sub) {
                    $data = $sub->data ?? [];
                    // Find any key that looks like an email
                    foreach ($data as $key => $val) {
                        if (is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                            return [[
                                'name'      => $data['full_name'] ?? $data['name'] ?? 'Valued Respondent',
                                'email'     => $val,
                                'member_id' => '',
                            ]];
                        }
                    }
                    return [];
                })->unique('email')->values()->toArray(),

            'custom' => collect(preg_split('/[\s,;]+/', $request->custom_emails ?? ''))
                ->filter(fn($e) => filter_var(trim($e), FILTER_VALIDATE_EMAIL))
                ->unique()
                ->map(fn($e) => [
                    'name'      => '',
                    'email'     => trim($e),
                    'member_id' => '',
                ])->toArray(),

            default => [],
        };
    }
}
