<?php

namespace App\Http\Middleware;

use Closure;

class CheckSocialType
{
    public $type = ['facebook', 'github', 'google'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!in_array($request->type,$this->type)){
            return response()->json([
                'message' => "login {$request->type} type not found!" 
            ]);
        }
        return $next($request);
    }
}
