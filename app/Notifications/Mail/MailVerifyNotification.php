<?php

namespace App\Notifications\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class MailVerifyNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = URL::signedRoute('verification.verify', [
            'id' => $this->user->id,
            'hash' => sha1($this->user->email),
        ]);

        return (new MailMessage)
            ->subject('Verify your account - Personal Assistant')
            ->greeting('Welcome to Personal Assistant!')
            ->line('Click in the link bellow to verify your account:')
            ->action('VERIFY MY ACCOUNT', $verificationUrl)
            ->line('Thanks for registering in our website!')
            ->line("If you didn't registered in our site, please, ignore this e-mail");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
