<?php

namespace App\Http\Middleware;

use Closure;

class EnsureAuthLogin
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
        if ($request->session()->get('auth_user') != 1) {
            return route('login');
        }
        return $next($request);
    }
}
