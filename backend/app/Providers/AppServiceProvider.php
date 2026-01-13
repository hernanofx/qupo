<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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
    public function boot(Router $router): void
    {
        // Register route middleware alias for role checks
        $router->aliasMiddleware('role', \App\Http\Middleware\EnsureRole::class);

        // Ensure routes/api.php is registered under API middleware so it is stateless (avoid CSRF for API calls)
        $apiRoutes = base_path('routes/api.php');
        if (file_exists($apiRoutes)) {
            \Illuminate\Support\Facades\Route::middleware('api')->group($apiRoutes);
        }
    }
}
