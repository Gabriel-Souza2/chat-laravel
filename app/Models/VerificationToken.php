<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;


class VerificationToken extends Model
{
    protected $fillable = ['token', 'type', 'user_id', 'exp'];

    public static function createToken($user_id, $type)
    {
        $token = Str::random(60);
        $exp = Carbon::now()->addHours();
        
        return self::create([
            'user_id' => $user_id,
            'token' => $token,
            'type' => $type,
            'exp' => $exp
        ]);
    }

    public static function isValid($token, $type, $user_id)
    {
        $resp = self::where('token', $token)
            ->where('user_id', $user_id)
            ->where('type', $type)
            ->where('exp', '>=', now()->toDateTimeString())
            ->first();

        return $resp ? $resp->delete() : false;
    }
}
