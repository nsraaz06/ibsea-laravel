<?php

namespace App\Jobs;

use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessEmailCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    public $tries = 1;

    /** @var int — 300 emails × 7s = 2100s + buffer */
    public $timeout = 3600;

    /** @var int */
    private $campaignId;

    /** @var array */
    private $recipients;

    /** @var string */
    private $templateSubject;

    /** @var string */
    private $templateBody;

    /** @var int */
    private $delaySeconds;

    public function __construct(
        $campaignId,
        array $recipients,
        $templateSubject,
        $templateBody,
        $delaySeconds = 7
    ) {
        $this->campaignId      = $campaignId;
        $this->recipients      = $recipients;
        $this->templateSubject = $templateSubject;
        $this->templateBody    = $templateBody;
        $this->delaySeconds    = $delaySeconds;
    }

    public function handle()
    {
        $campaign = EmailCampaign::find($this->campaignId);

        if (! $campaign) {
            Log::error("ProcessEmailCampaign: campaign #{$this->campaignId} not found.");
            return;
        }

        $campaign->update(['status' => 'sending']);

        $sent   = 0;
        $failed = 0;
        $total  = count($this->recipients);

        foreach ($this->recipients as $index => $recipient) {
            try {
                $body = str_replace(
                    ['{{name}}', '{{email}}', '{{member_id}}', '{{date}}'],
                    [
                        $recipient['name']      ?? 'Valued Member',
                        $recipient['email']     ?? '',
                        $recipient['member_id'] ?? '',
                        now()->format('d M Y'),
                    ],
                    $this->templateBody
                );

                $subject = str_replace(
                    ['{{name}}', '{{email}}', '{{date}}'],
                    [
                        $recipient['name']  ?? 'Valued Member',
                        $recipient['email'] ?? '',
                        now()->format('d M Y'),
                    ],
                    $this->templateSubject
                );

                Mail::to($recipient['email'])->send(new CampaignMail($subject, $body));
                $sent++;

                // Update progress live after each successful send
                $campaign->update([
                    'sent_count'   => $sent,
                    'failed_count' => $failed,
                    'status'       => 'sending',
                ]);

                // Delay between sends — stays under Hostinger hourly SMTP limit
                if ($index < $total - 1) {
                    sleep($this->delaySeconds);
                }

            } catch (\Exception $e) {
                $failed++;
                Log::error("Campaign #{$this->campaignId}: failed for " .
                    ($recipient['email'] ?? 'unknown') . ' — ' . $e->getMessage());

                if ($index < $total - 1) {
                    sleep(2);
                }
            }
        }

        // Final status
        if ($sent === 0) {
            $finalStatus = 'failed';
        } elseif ($failed > 0) {
            $finalStatus = 'partial';
        } else {
            $finalStatus = 'sent';
        }

        $campaign->update([
            'sent_count'   => $sent,
            'failed_count' => $failed,
            'status'       => $finalStatus,
        ]);

        Log::info("Campaign #{$this->campaignId} complete — Sent: {$sent}, Failed: {$failed}.");
    }

    public function failed(\Exception $exception)
    {
        Log::error("Campaign #{$this->campaignId} job crashed: " . $exception->getMessage());

        EmailCampaign::where('id', $this->campaignId)
            ->where('status', 'sending')
            ->update(['status' => 'failed']);
    }
}
