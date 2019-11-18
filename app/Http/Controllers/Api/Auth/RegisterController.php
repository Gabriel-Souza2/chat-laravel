<?php

namespace App\Http\Controllers\Api\Auth;
use App\Models\User;
use App\Events\Registered;
use Illuminate\Http\Request;
use App\Models\VerificationToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $user = User::create($data);
        $user->profile()->create($data);
        event(new Registered($user));
        return ['token' => auth()->login($user)];
    }

    public function verifyEmail($token = null)
    {
        if (!$token) return response()->json(['message'=>'token not passed'], 422);

        $token = VerificationToken::isValid($token, 'email', Auth::id());
        if($token){
            Auth::user()->markEmailAsVerified();
            return response()->json(null, 204);
        }
        return response()->json(['message'=>'Token is not valid or expired'], 422);
    }
}