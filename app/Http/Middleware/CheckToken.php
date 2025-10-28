<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $tokenType  The type of token to check (api, session, etc.)
     */
    public function handle(Request $request, Closure $next, string $tokenType = 'api'): Response
    {
        // Get token from request
        $token = $request->header('Authorization') ?? $request->query('token');

        // Simple token validation
        if (!$token) {
            return response()->json([
                'error' => 'Token required',
                'message' => "Please provide a valid {$tokenType} token"
            ], 401);
        }

        // Check token format (Bearer token)
        if ($tokenType === 'api' && !str_starts_with($token, 'Bearer ')) {
            return response()->json([
                'error' => 'Invalid token format',
                'message' => 'Token must be in Bearer format'
            ], 401);
        }

        return $next($request);
    }
}
