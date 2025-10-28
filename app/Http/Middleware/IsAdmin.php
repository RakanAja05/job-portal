<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handle(Request $request, Closure $next): Response
	{
		// allow if user is authenticated and has role 'HR' or 'Admin'
		if (Auth::check() && in_array(Auth::user()->role, ['admin'], true)) {
			return $next($request);
		}

		// redirect to home when not authorized
		return redirect('/');
	}
}
