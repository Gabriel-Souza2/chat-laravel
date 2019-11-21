<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Notifications\VerifyEmail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\EmailTokenRepositoryInterface;

class SendEmailVerification
{
    public $email;
    public $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EmailTokenRepositoryInterface $email, 
                                UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->email->createToken(Auth::id());
        $this->user->notify(Auth::id(), VerifyEmail::class);
    }
}
