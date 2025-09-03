<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in as admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // If not, redirect to admin login
        return redirect()->route('admin.login')->with('error', 'You must be an admin to access this page.');
    }
}
