<?php

namespace KevinOrriss\UserRoles;

use Illuminate\Support\ServiceProvider;

class UserRolesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // migrations
        $this->publishes([__DIR__.'/../database/migrations/' => database_path('migrations')]);

        // configuration
        $this->publishes([__DIR__.'/../config/userroles.php' => config_path('userroles.php')], 'config');

        // views
        $this->loadViewsFrom(__DIR__.'/views', 'userroles');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // routes
        include __DIR__ . '/routes.php';

        // controllers
        $this->app->make('KevinOrriss\UserRoles\Controllers\RoleController');
        $this->app->make('KevinOrriss\UserRoles\Controllers\RoleGroupController');
    }
}
