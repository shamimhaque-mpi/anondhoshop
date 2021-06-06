<?php

namespace App\Http\Middleware;

use Closure, Auth;

class User
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
        if(!Auth::guard('web')->check()){
            session()->put('intended', url()->current());
            return redirect(url('/login'));
        }
        return $next($request);
    }
}
