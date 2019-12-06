<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    protected $fillable = ['token','user_id', 'exp'];
}
