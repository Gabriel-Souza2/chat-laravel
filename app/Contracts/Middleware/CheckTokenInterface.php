<?php

namespace App\Contracts\Middleware;

interface CheckTokenInterface
{
    function validate(String $token, Int $id): Bool;
}