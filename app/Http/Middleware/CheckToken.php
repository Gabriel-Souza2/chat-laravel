<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Middleware\CheckTokenInterface;

class CheckToken
{

    public $check;

    public function __construct(CheckTokenInterface $check)
    {
        $this->check = $check;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$token = $request->query('token')) {
            return response()->json(['message'=>'Token not passed'], 422);
        }

        if(!$this->check->validate($token, Auth::id())){
            return response()->json(['message'=>'Token is not valid or expired'], 422);
        }
        return $next($request);
    }
}
