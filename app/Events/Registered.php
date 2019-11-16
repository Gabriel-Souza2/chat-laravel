<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
