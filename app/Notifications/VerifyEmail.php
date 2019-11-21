<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\EmailTokenRepositoryInterface;

class VerifyEmail extends Notification
{
    use Queueable;

    public $user;

    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->email = resolve(EmailTokenRepositoryInterface::class);
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
        return (new MailMessage)
            ->subject('Verifição de Email')
            ->line("Olá {$this->user->name(Auth::id())}, click no botão abaixo para ativar seu email!")
            ->action('Verificar Email',
                url("/register/verify_email?token={$this->email->getToken(Auth::id())}")
            )
            ->line("Se não criou uma conta, por favor desconsiderar esse email!");
    }
}
