<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class WalletAdmin
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
        if ( Auth::check() && Auth::user()->hasPermissionTo('admin_panel') )                
        {
            return $next($request);
        }
        
        return redirect('/home');
    }
}
