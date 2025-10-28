<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpAddress
{
    /**
     * List of allowed IP addresses
     *
     * @var array
     */
    protected $allowedIps = [
        '127.0.0.1',
        '::1',
        // Add more allowed IPs here
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request IP is in the allowed list
        if (!in_array($request->ip(), $this->allowedIps)) {
            abort(403, 'Access denied from this IP address.');
        }

        return $next($request);
    }
}
