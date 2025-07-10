<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionStatus
{
   public function handle(Request $request, Closure $next)
{    /*\Log::info('CHECK-SESSION', [
    'user_id' => Auth::id(),
    'db_session_id' => Auth::user()->session_id,
    'client_session_id' => session('user_session_id'),
]);*/
    if (Auth::check()) {
        $user = Auth::user();

        // Exclude routes that don't require session check
        $excludedRoutes = [
            'login', 'otp.login', 'otp.verification.form', 'otp.verify',
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        $storedSessionId = $user->session_id;
        $currentSessionId = session('user_session_id');

        // If no session id yet, allow
        if (!$currentSessionId) {
            return $next($request);
        }

        // If session inactive, logout immediately
        if ($user->session_status == 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors('You were logged out due to inactivity.');
        }

        // If session id mismatch, logout the user forcibly
        if ($user->session_status == 1 && $storedSessionId !== $currentSessionId) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors('Your session has ended because you logged in from another device.');
        }
    }

    // Prevent cache
    $response = $next($request);
    return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
}

}
