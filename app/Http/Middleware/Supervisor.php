<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Supervisor
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
        if(Auth::user()->is_superviseur == false && Auth::user()->role != "admin" ){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
