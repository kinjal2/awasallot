<?php

namespace App\Http\Middleware;

use Closure;

class PreventClickjacking
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
        $response = $next($request);

        // Set the HTTP header to prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Alternatively, you can use 'SAMEORIGIN' to allow embedding on the same origin
        // $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        return $response;
    }
}
