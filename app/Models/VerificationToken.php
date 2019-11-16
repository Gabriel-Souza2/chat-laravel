<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    protected $fillable = ['token', 'type', 'user_id'];
}
