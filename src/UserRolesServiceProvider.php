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
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ]);
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

        // models
        $this->app->make('KevinOrriss\UserRoles\Models\Role');
        $this->app->make('KevinOrriss\UserRoles\Models\RoleGroup');

        // controllers
        $this->app->make('KevinOrriss\UserRoles\Controllers\RoleController');
        $this->app->make('KevinOrriss\UserRoles\Controllers\RoleGroupController');
    }
}
