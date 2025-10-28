<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user has 'status' field and if it's active
            if (property_exists($user, 'status') && $user->status !== 'active') {
                auth()->logout();
                return redirect('/login')->with('error', 'Your account is not active. Please contact administrator.');
            }
        }

        return $next($request);
    }
}
