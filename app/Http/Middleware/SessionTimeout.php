<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        $maxIdleTime = config('session.lifetime', 30); // fallback to 30 mins if not in config

        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = session('last_activity_time');
            $currentTime = Carbon::now();

            if ($lastActivity) {
                $lastActivityTime = Carbon::parse($lastActivity);

                // If the session is idle too long, log out the user
                if ($lastActivityTime->diffInMinutes($currentTime) > $maxIdleTime) {
                    $user->update(['session_status' => 0]);

                    Auth::logout();
                    session()->flush();

                    return redirect()->route('login')->with('error', 'Session expired due to inactivity.');
                }
            }

            // Update the activity timestamp in session
            session(['last_activity_time' => $currentTime]);

            // Avoid unnecessary DB update
            if ($user->session_status !== 1) {
                $user->update(['session_status' => 1]);
            }

            // Optional: Check session ID for hijacking/concurrent session
            if ($user->session_id && session('user_session_id') !== $user->session_id) {
                Auth::logout();
                session()->flush();

                return redirect()->route('login')->withErrors('Session invalidated due to login from another device.');
            }
        }

        return $next($request);
    }
}
