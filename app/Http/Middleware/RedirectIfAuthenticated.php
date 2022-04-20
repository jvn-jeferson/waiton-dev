<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(in_array(Auth::user()->role_id, [2,3])) {
                    return redirect('/accounting_office');
                }
                else if(in_array(Auth::user()->role_id, [4,5])){ 
                    return redirect('/client-home');
                }
                else if(in_array(Auth::user()->role_id, [1])){ 
                    return redirect('/administrator/home');
                }
                else {
                    abort(404);
                }
            }
        }

        return $next($request);
    }
}
