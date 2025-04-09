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
            if ($user->session_status == 1) {
                $storedSessionId = $user->session_id;
                $currentSessionId = \session('user_session_id');

                if ($storedSessionId !== $currentSessionId) {
                    // Invalidate user session
                    $user->update([
                        'session_status' => 0,
                        'session_id' => null,
                    ]);

                    
                    Auth::logout();

                    return redirect()->route('login')->withErrors('You were logged out from another device. Please log in again.');
                }
            }
        }

        return $next($request);
    }
}
