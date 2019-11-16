<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $token = $notifiable->verificationToken()->where('type', 'email')->first();
        return (new MailMessage)
            ->subject('Verifição de Email')
            ->line("Olá {$notifiable->profile->name}, click no botão abaixo para ativar seu email!")
            ->action('Verificar Email',
                url("/register/verify_email?token={$token['token']}")
            )
            ->line("Se não criou uma conta, por favor desconsiderar esse email!");
    }
}
