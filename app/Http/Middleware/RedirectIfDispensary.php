<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfDispensary
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Check if the user is authenticated
       if (!Auth::check()) {
        return redirect()->route('login'); // Redirect to login if not authenticated
    }

    // Check if the user is an admin
    if (Auth::user()->is_admin) {
        abort(403, 'Unauthorized access'); // Return 403 Forbidden
    }

    return $next($request); // Allow access if user is an admin
    }
}
