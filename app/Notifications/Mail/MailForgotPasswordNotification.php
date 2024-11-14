<?php

namespace App\Notifications\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class MailForgotPasswordNotification extends Notification
{
    use Queueable;

    protected $email;
    protected $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($email,$token)
    {
        $this->email = $email;
        $this->token = $token;
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
        $resetPasswordUrl = URL::route('password.reset', ['email' => $this->email, 'token' => $this->token]);

        return (new MailMessage)
            ->subject('Reset Your Password - Personal Assistant')
            ->greeting('Welcome back to Personal Assistant!')
            ->line('Click in the link bellow to reset your account password:')
            ->action('RESET MY PASSWORD', $resetPasswordUrl)
            ->line("If you didn't asked for a new password, please, ignore this e-mail");
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
