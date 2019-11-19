<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Contracts\Repositories\UserRepositoryInterface;

class VerifyEmail extends Notification
{
    use Queueable;

    public $repository;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->repository = $user;
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
            ->line("Olá {$this->repository->name()}, click no botão abaixo para ativar seu email!")
            ->action('Verificar Email',
                url("/register/verify_email?token={$this->repository->getToken('email')}")
            )
            ->line("Se não criou uma conta, por favor desconsiderar esse email!");
    }
}
