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
        // Add X-Frame-Options header to prevent clickjacking
        return $next($request)->header('X-Frame-Options', 'DENY');
    }
}
