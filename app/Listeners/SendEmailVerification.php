<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Notifications\VerifyEmail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class SendEmailVerification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        (new UserRepository($event->getUser()))
            ->createToken('email')
            ->notify(VerifyEmail::class);
    }
}
