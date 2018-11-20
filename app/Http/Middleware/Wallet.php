<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Wallet
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
        if ( Auth::check() && Auth::user()->hasPermissionTo('distributor') )                
        {
            if(empty(Auth::user()->reseller_id)){
                return redirect('/home');
            }
            
            return $next($request);
        }
        
        return redirect('/home');
    }
}
