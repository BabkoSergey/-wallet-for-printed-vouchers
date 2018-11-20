<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class WalletPortal
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
        if ( Auth::check() && Auth::user()->hasPermissionTo('portal') )                
        {            
            if(empty(Auth::user()->portal_id)){
                return redirect('/new_portal');
            }
            
            return $next($request);
        }
        
        return redirect('/home');
    }
}
