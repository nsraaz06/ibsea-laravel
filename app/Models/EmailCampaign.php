<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'template_id', 'subject', 'recipients_type',
        'recipient_detail', 'sent_count', 'failed_count', 'status', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function recipientsLabel(): string
    {
        return match($this->recipients_type) {
            'all_members'     => 'All Members',
            'specific'        => 'Specific Members',
            'form_submitters' => 'Form Submitters',
            'custom'          => 'Custom Emails',
            default           => ucfirst($this->recipients_type),
        };
    }
}
