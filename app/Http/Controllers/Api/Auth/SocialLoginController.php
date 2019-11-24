<?php

namespace App\Http\Controllers\Api\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\SocialLoginRequest;
use App\Contracts\Repositories\UserRepositoryInterface;

class SocialLoginController extends Controller
{
    public $user;

    private $scopes = [
        'github' => ['read:user'],
        'facebook' => ['user_age_range', 'user_gender'],
        'google' => ['profile']
    ];

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->middleware('social.type');
    }

    public function redirectToProvider($type)
    {
        return Socialite::driver($type)
                        ->stateless()
                        ->scopes($this->scopes[$type])
                        ->redirect();
    }

    public function handleProviderCallback($type)
    {
        $data = Socialite::driver($type)->stateless()->user();

        $user = $this->user->loginSocial($data);

        $token = JWTAuth::fromUser($user);
        
        return ['token' => $token];
    }
}
