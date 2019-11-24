<?php

namespace App\Http\Controllers\Api\Auth;
use App\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Contracts\Repositories\UserRepositoryInterface;

class RegisterController extends Controller
{
    public $repository;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->repository = $user;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->repository->create($request->all());

        $token = auth()->login($user);

        event(new Registered($user));

        return ['token' => $token];
    }

    public function verifyEmail()
    {
        $this->repository->markEmailAsVerified(Auth::id());
        
        return response()->json([], 204);
    }
}