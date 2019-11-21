<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface 
{
    function name(Int $id): String;
    function notify(Int $id, String $class): UserRepositoryInterface;
    function markEmailAsVerified(Int $id): Bool;
}