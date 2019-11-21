<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EmailTokenRepositoryInterface 
{
    function createToken(Int $id): Model;
    function getToken(Int $id): String;
}
