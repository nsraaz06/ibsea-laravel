<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;

    /**
     * Create a new message instance.
     */
    public function __construct(FormSubmission $submission)
    {
        $submission->load('form', 'member');
        $this->submission = $submission;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Intelligence Logged: ' . $this->submission->form->title)
                    ->view('emails.form-submitted');
    }
}
