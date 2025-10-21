<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register middleware alias for role checks
        if (method_exists(Route::getFacadeRoot(), 'aliasMiddleware')) {
            Route::aliasMiddleware('role', EnsureUserHasRole::class);
        }
    }
}
