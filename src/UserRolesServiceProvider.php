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

        /*$this->publishes([
            __DIR__.'/models/' => app_path()
        ]);*/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        $this->app->make('KevinOrriss\UserRoles\RoleController');
        $this->app->make('KevinOrriss\UserRoles\RoleGroupController');
    }
}
