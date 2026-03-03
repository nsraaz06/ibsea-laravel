<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PublicFormController extends Controller
{
    /**
     * Show the dynamic form.
     */
    public function show($slug)
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('forms.show', [
            'form' => $form
        ]);
    }

    /**
     * Process the form submission.
     */
    public function submit(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Dynamically build validation rules
        $rules = [];
        $fileFields = [];

        foreach ($form->fields as $field) {
            $type = $field['type'] ?? 'text';
            $name = $field['name'] ?? '';

            if (empty($name) || $type === 'hidden') continue;

            $fieldRule = [];
            $isRequired = isset($field['required']) && $field['required'];
            $fieldRule[] = $isRequired ? 'required' : 'nullable';

            switch ($type) {
                case 'email':
                    $fieldRule[] = 'email';
                    break;
                case 'number':
                    $fieldRule[] = 'numeric';
                    break;
                case 'date':
                    $fieldRule[] = 'date';
                    break;
                case 'url':
                    $fieldRule[] = 'url';
                    break;
                case 'file':
                case 'file_multiple':
                    $accept = $field['accept'] ?? null;
                    $fieldRule[] = $type === 'file_multiple' ? 'array' : 'file';
                    if ($accept) {
                        // Convert accept string to mimes rule (basic)
                        $exts = implode(',', array_map(fn($e) => ltrim(trim($e), '.'), explode(',', $accept)));
                        $fieldRule[] = 'mimes:' . $exts;
                    }
                    $fieldRule[] = 'max:10240'; // 10MB max
                    $fileFields[] = $name;
                    break;
                case 'image':
                    $fieldRule[] = 'image';
                    $fieldRule[] = 'max:5120'; // 5MB max
                    $fileFields[] = $name;
                    break;
                case 'checkbox_group':
                case 'select_multiple':
                    $fieldRule = [$isRequired ? 'required' : 'nullable', 'array'];
                    break;
            }

            $rules[$name] = implode('|', $fieldRule);

            // Array sub-field validation
            if (in_array($type, ['checkbox_group', 'select_multiple', 'file_multiple'])) {
                $rules[$name . '.*'] = 'string';
                if ($type === 'file_multiple') {
                    $accept = $field['accept'] ?? null;
                    $extRule = $accept ? ('mimes:' . implode(',', array_map(fn($e) => ltrim(trim($e), '.'), explode(',', $accept)))) : '';
                    $rules[$name . '.*'] = 'file|max:10240' . ($extRule ? '|' . $extRule : '');
                }
            }
        }

        $request->validate($rules);

        // Collect submitted data (non-file fields)
        $submittedData = [];
        foreach ($form->fields as $field) {
            $type = $field['type'] ?? 'text';
            $name = $field['name'] ?? '';
            if (empty($name) || $type === 'hidden') continue;

            if (in_array($type, ['file', 'image', 'file_multiple'])) {
                // Handle and store files
                if ($request->hasFile($name)) {
                    if ($type === 'file_multiple') {
                        $paths = [];
                        foreach ($request->file($name) as $f) {
                            $paths[] = $f->store('form-uploads', 'public');
                        }
                        $submittedData[$name] = $paths;
                    } else {
                        $submittedData[$name] = $request->file($name)->store('form-uploads', 'public');
                    }
                }
            } elseif (in_array($type, ['checkbox_group', 'select_multiple'])) {
                $submittedData[$name] = $request->input($name, []);
            } elseif ($type === 'toggle') {
                $submittedData[$name] = $request->boolean($name) ? 'Yes' : 'No';
            } else {
                $submittedData[$name] = $request->input($name);
            }
        }

        // Store the submission
        $submission = FormSubmission::create([
            'form_id'    => $form->id,
            'member_id'  => Auth::guard('member')->id(),
            'data'       => $submittedData,
            'ip_address' => $request->ip()
        ]);

        // Notify Admins
        try {
            $admins = \App\Models\Admin::all();
            foreach ($admins as $admin) {
                if ($admin->email) {
                    \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\FormSubmitted($submission));
                }
            }
        } catch (\Exception $e) {
            Log::error('Form Submission Email Failed: ' . $e->getMessage());
        }

        // Send confirmation email to the submitter
        try {
            $confirmedEmailKey = $form->settings['confirmation_email_field'] ?? null;

            if ($confirmedEmailKey === 'none' || $confirmedEmailKey === 'disable') {
                $submitterEmail = null;
            } elseif ($confirmedEmailKey) {
                $submitterEmail = $submittedData[$confirmedEmailKey] ?? null;
            } else {
                $emailField = collect($form->fields)->firstWhere('type', 'email');
                $submitterEmail = $emailField ? ($submittedData[$emailField['name']] ?? null) : null;
            }

            if ($submitterEmail && filter_var($submitterEmail, FILTER_VALIDATE_EMAIL)) {
                $templateId = $form->settings['confirmation_template_id'] ?? null;
                $template = $templateId ? \App\Models\EmailTemplate::find($templateId) : null;

                if ($template) {
                    // Variable Substitution
                    $vars = [
                        '{{date}}'       => now()->format('d M Y'),
                        '{{form_title}}' => $form->title,
                    ];

                    // Generate Summary Table
                    $summaryHtml = '<table style="width:100%; border-collapse:collapse; margin-top:20px;">';
                    foreach ($form->fields as $field) {
                        $name = $field['name'] ?? '';
                        $type = $field['type'] ?? '';
                        if (empty($name) || $type === 'hidden') continue;

                        $val = $submittedData[$name] ?? '—';
                        if (is_array($val)) $val = implode(', ', $val);

                        $summaryHtml .= sprintf(
                            '<tr><td style="padding:10px; border-bottom:1px solid #eee; font-weight:bold; width:40%%;">%s</td><td style="padding:10px; border-bottom:1px solid #eee;">%s</td></tr>',
                            $field['label'] ?? ucwords(str_replace('_', ' ', $name)),
                            $val
                        );

                        // Add individual field tag
                        $vars['{{' . $name . '}}'] = $val;
                    }
                    $summaryHtml .= '</table>';
                    $vars['{{form_summary}}'] = $summaryHtml;

                    $subject = str_replace(array_keys($vars), array_values($vars), $template->subject);
                    $body    = str_replace(array_keys($vars), array_values($vars), $template->body);

                    \Illuminate\Support\Facades\Mail::to($submitterEmail)
                        ->send(new \App\Mail\CampaignMail($subject, $body));
                } else {
                    // Fallback to default
                    \Illuminate\Support\Facades\Mail::to($submitterEmail)
                        ->send(new \App\Mail\FormConfirmation($submission));
                }
            }
        } catch (\Exception $e) {
            Log::error('Form Confirmation Email Failed: ' . $e->getMessage());
        }

        return back()->with('success', $form->settings['success_message'] ?? 'Your intelligence report has been received and logged.');
    }
}
