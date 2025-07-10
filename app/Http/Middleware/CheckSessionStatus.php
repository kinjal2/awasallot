<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $storedSessionId = $user->session_id;
            $currentSessionId = session('user_session_id');

            // If no session ID stored in session (could be before login completes)
            if (!$currentSessionId) {
                return $next($request);
            }

            // If user is marked active but session IDs don't match => logout old session
            if ($user->session_status == 1 && $storedSessionId !== $currentSessionId) {
                // Invalidate the user record to block old sessions
                $user->update([
                    'session_status' => 0,
                    'session_id' => null,
                ]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors('You were logged out from another device. Please log in again.');
            }

            // If user is marked inactive, logout immediately
            if ($user->session_status == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors('You were logged out due to inactivity.');
            }
        }

        // Prevent browser back button caching after logout
        $response = $next($request);
        return $response->header('Cache-Control','no-cache, no-store, must-revalidate')
                        ->header('Pragma','no-cache')
                        ->header('Expires','0');
    }
}
