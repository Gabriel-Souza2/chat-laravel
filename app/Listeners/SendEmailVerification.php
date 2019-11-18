<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use App\Notifications\VerifyEmail;

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
        $user = $event->getUser();
        VerificationToken::createToken($user->id, 'email');
        $user->notify(new VerifyEmail);
    }
}
