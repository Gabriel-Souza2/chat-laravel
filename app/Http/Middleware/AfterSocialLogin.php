<?php

namespace App\Http\Middleware;

use Closure;

class AfterSocialLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $next($request)->original['token'];

        $url = env('APP_URL');

        return redirect()->away("$url/auth/social/login/$token");
    }
}
