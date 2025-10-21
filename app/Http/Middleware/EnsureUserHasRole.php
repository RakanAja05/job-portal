<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * Roles can be provided as a single value or comma-separated list.
     */
    public function handle(Request $request, Closure $next, string $roles = null)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($roles) {
            $allowed = array_map('trim', explode(',', $roles));
            if (! in_array($user->role, $allowed, true)) {
                abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
