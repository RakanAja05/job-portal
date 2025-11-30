<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
            'log.after' => \App\Http\Middleware\LogAfterRequest::class,
            'log.requests' => \App\Http\Middleware\LogRequests::class,
            'check.age' => \App\Http\Middleware\CheckAge::class,
            'check.ip' => \App\Http\Middleware\CheckIpAddress::class,
            'check.token' => \App\Http\Middleware\CheckToken::class,
            'custom.header' => \App\Http\Middleware\AddCustomHeader::class,
        ]);

        // Sanctum stateful + throttle group for API
        $middleware->appendToGroup('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
