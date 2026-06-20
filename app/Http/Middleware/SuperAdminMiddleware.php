<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | CHECK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {

            return redirect('/');
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role_id != 1) {

            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}