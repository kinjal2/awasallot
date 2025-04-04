<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // If session_status is 0, log the user out
            if ($user->session_status == 0) {
                Auth::logout();
                return redirect()->route('login')->withErrors('You were logged out due to inactivity.');
            }
        }

        return $next($request);
    }
}
