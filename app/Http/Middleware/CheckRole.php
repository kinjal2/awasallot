<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Get the current user's role
        $userRole = getActiveRole(); // Assuming your custom getActiveRole() function

        // Check if the user has the required role
        if ($userRole !== $role) {
            // If the user does not have the required role, redirect them or show an error
            return redirect('/');  // Redirect to the home page or any other page
        }

        // If the user has the required role, allow the request to proceed
        return $next($request);
    }
}
