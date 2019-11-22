<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\EmailTokenRepositoryInterface;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.auth.verify_email', [
            'name' => $this->name,
            'token' => $this->token
        ]);
    }
}
