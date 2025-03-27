<?php // app/Http/Middleware/SessionTimeout.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        // Set the maximum idle time in minutes (e.g., 15 minutes)
        $maxIdleTime = 15; // 15 minutes

        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = session('last_activity_time');
            $currentTime = Carbon::now();

            // If last activity time exists and exceeds the max idle time, log the user out
            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) > $maxIdleTime) {
                // Set the session status to 0 (inactive) in the database
                $user->update(['session_status' => 0]); // Set session_status to 0 (inactive)

                // Logout the user and clear session
                Auth::logout();
                session()->flush();
                return redirect()->route('login')->with('error', 'Session expired due to inactivity.');
            }

            // Update the last activity time on every request
            session(['last_activity_time' => Carbon::now()]);

            // Update session_status to 1 (active) in the database
            if ($user->session_status !== 1) {
                $user->update(['session_status' => 1]); // Set session_status to 1 (active)
            }
        }

        return $next($request);
    }
}
