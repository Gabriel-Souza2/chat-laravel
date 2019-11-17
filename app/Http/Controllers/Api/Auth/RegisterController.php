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
        //Se o token existe
        //Se o token é do tipo email
        //Seo token não está expirado
        $user = Auth::user();
        $valid_token = $user->verificationToken()
            ->where('token', $token)
            ->where('type', 'email')
            ->first();
        if(isset($valid_token)){
            $user->email_verified_at = now();
            $user->save();
            VerificationToken::find($valid_token['id'])->delete();
            return response()->json(null, 204);
        }
        return response()->json(null, 422);
    }
}