<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Contracts\Repositories\UserRepositoryInterface;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function callResetPassword(Request $request)
    {
        $this->reset($request);
    }

    protected function resetPassword($user, $password)
    {
        $this->user->update($user->id, ['password'=> $password]);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Password reset successfully.']);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Failed, Invalid Token.']);
    }
}
