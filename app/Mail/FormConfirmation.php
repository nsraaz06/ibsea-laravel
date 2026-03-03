<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public FormSubmission $submission;

    public function __construct(FormSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject('Thank you — Your Submission Has Been Received')
                    ->view('emails.form-confirmation');
    }
}
