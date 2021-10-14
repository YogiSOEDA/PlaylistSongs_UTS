<?php

namespace App\Http\Middleware;

use App\Exceptions\PbeNotAuthenticatedException;
use Closure;

class PbeMiddleware
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
        if (empty($request->header('token'))){
            #Kondisi ketika token tidak dikirim melalui header
            throw new PbeNotAuthenticatedException();
        }
        #kondisi ketika tokennya ada
        return $next($request);
    }
}
