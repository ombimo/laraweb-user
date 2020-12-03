<?php

namespace Ombimo\LarawebUser;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LarawebUserServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        Route::pattern('locale', '[a-zA-Z]{2}');

        //route
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__ . '/../resources/view' => resource_path('views'),
            __DIR__ . '/../config/laraweb.php' => config_path('laraweb-user.php'),
        ]);

        $this->publishes([
            __DIR__.'/Database/Migrations' => database_path('migrations')
        ], 'migrations');
    }
}
