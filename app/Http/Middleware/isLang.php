<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class isLang
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
        // return $next($request);
        $lang = Session::get ('locale');
        if(!$lang){
            $lang = 'en';
            Session::put($lang);
        }
        \App::setLocale($lang);

        if(Auth::check()){
            if(Auth::user()->role_id == 1) {
                // return redirect('admin/login');
                return $next($request);
            } else {
                return $next($request);
                
            }
        }
        return $next($request);
         
        
        
        
    }
}
