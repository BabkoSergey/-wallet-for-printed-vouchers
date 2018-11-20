<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

use App\ApiKey;
use App\Portal;

class WalletAPI
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
        $error = 'Access Denied';
        
        if(!$request->header('authorization'))
            return response()->json($error, 422);
        
        $api_key = ApiKey::where('api_key', substr($request->header('authorization'),-12))->first();        
        $api_host = Portal::where('host', $request->header('Operator-Name'))->first();
        
        if(!$api_key || !$api_host || $api_host->status != "active" )
            return response()->json($error, 422);
                        
        return $next($request);
        
    }
}
