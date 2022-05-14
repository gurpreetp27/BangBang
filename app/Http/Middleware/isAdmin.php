<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isAdmin
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

        if(Auth::check()){
            if(Auth::user()->role_id == 1) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect('admin/login');
            }
        } else {
            return redirect('admin/login');
        }
    }
}
