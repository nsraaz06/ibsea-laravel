<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class WelcomeGuestMember extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Welcome to IBSEA!'))
            ->greeting(Lang::get('Welcome, ' . $notifiable->name . '!'))
            ->line(Lang::get('Thank you for your purchase. We have created a member account for you.'))
            ->line(Lang::get('To access your dashboard and profile, please set up your account password using the link below.'))
            ->action(Lang::get('Set Personal Password'), $url)
            ->line(Lang::get('This password setup link will expire in 12 hours.'))
            ->line(Lang::get('If you did not make this purchase, no further action is required.'));
    }
}
