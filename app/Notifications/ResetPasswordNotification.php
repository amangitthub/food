<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the branded password reset email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Reset Your Password | FOODKING')
            ->view('auth.reset-password-email', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'expiryMinutes' => config(
                    'auth.passwords.' . config('auth.defaults.passwords') . '.expire',
                    60
                ),
            ]);
    }
}