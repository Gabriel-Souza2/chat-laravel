<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Requests\ResetRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\ResetPasswordRepositoryInterface;

class ResetPasswordController extends Controller
{
    public $user;

    public $password;

    public function __construct(UserRepositoryInterface $user,
                                ResetPasswordRepositoryInterface $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function forgot(ForgotRequest $request)
    {
        $token = $this->password->createToken($request->email);
        $this->user->sendResetPassword($request->email, $token);
        return response()->json(['message' => 'Password reset email sent!' ]);
    }

    public function reset(ResetRequest $request)
    {
        if(!$this->password->validate($request->email, $request->token)){
            return response()->json([
                'errors' => ['token' => 'Invalid Token!']
            ], 422);
        }

        $this->user->resetPassword($request->email, $request->password);
        return response()->json(['message' => 'Password reset successfully']);
    }
}
