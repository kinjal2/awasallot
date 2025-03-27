<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if a custom role is stored in the session
        $sessionRole = session('role');

        if ($sessionRole === 'ddouser') {
            // Allow access if session contains 'ddouser'
            return $next($request);
        }

        // If session doesn't contain 'ddouser', check the role from the database
        $user = Auth::user();

        if ($user) {
            // Assuming 'is_admin' determines if the user is an admin
            $userRole = $user->is_admin ? 'admin' : 'user';

            // Check if the user's role matches the required role for this route
            if ($role === $userRole) {
                return $next($request);  // Allow access if roles match
            }
        }

        // Deny access if roles don't match or user is not authenticated
        return redirect()->route('custom.403.page')->with('error', 'You do not have permission to access this resource.');

    }
}
