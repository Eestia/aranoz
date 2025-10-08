<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/user/home'; // valeur par défaut (home)

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Cette fonction peut être utilisée par Laravel Breeze/Fortify pour rediriger après login.
     */
    public static function redirectTo(): string
    {
        $user = Auth::user();

        if (!$user) {
            return '/';
        }

        // Si admin → dashboard
        if ($user->is_admin) {
            return '/admin/dashboard';
        }

        // Sinon → home user
        return '/user/home';
    }

}
