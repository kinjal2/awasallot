<?php // app/Http/Middleware/CheckHostHeader.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class CheckHostHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the allowed hosts from the config
        $allowedHosts = config('app.allowed_hosts');
         // dd($allowedHosts );
        // Get the Host header from the incoming request
        $host = $request->getHost();

        // Check if the Host header is in the allowed hosts list
        if (!in_array($host, $allowedHosts)) {
            // Log the invalid attempt
            Log::error("Invalid Host header: $host");

            // Return a 400 Bad Request response if the Host header is not allowed
            return response('Bad Request: Invalid Host', 400);
        }

        return $next($request);
    }
}
