<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail as Mailable;
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
    public function __construct(UserRepositoryInterface $user, EmailTokenRepositoryInterface $email)
    {
        $this->user = $user;
        $this->email = $email;
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
        $name = $this->user->name($notifiable->id);
        $token = $this->email->getToken($notifiable->id);
        return Mail::to($notifiable->email)->queue(new Mailable($name, $token));
    }
}
