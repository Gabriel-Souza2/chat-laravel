<?php

namespace App\Http\Controllers\Api\Auth;
use App\Models\User;
use App\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfileResource;

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
}