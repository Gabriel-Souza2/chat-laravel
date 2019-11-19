<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    protected $fillable = ['token', 'type', 'user_id', 'exp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isValid($token, $type, $user_id = null)
    {
        $resp = self::where('token', $token)
            ->where('type', $type)
            ->where('exp', '>=', now()->toDateTimeString());
        
        $user_id ? $resp->where('user_id', $user_id) : '';
        $resp->first();
        return $resp ? $resp->delete() : false;
    }
}
