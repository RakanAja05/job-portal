<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCustomHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add custom headers to response
        $response->headers->set('X-Custom-Header', 'Job Portal Application');
        $response->headers->set('X-Developer', 'Laravel Team');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        return $response;
    }
}
