<?php

namespace Aucos\Permissionview;

use Illuminate\Support\ServiceProvider;

class PermissionviewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__ . '/../config/permissionview.php' => $this->app->configPath() . '/permissionview.php',
        ], 'config');

        if (!class_exists('CreatePermissionviewTable')) {
            
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                 __DIR__ . '/../database/migrations/create_permissionview_table.php' => $this->app->databasePath() . "/migrations/{$timestamp}_create_permissionview_table.php",
            ], 'migrations');
        }

        if (!class_exists('PermissionViewSeeder')) {

            $this->publishes([
                 __DIR__ . '/../database/seeds/PermissionViewSeeder.php' => $this->app->databasePath() . "/seeds/PermissionViewSeeder.php",
            ], 'migrations');
        }
       
        $this->loadViewsFrom(__DIR__.'/views', 'Permissionview');
        
        $this->publishes([
                __DIR__.'/views' => resource_path('views/vendor/Permissionview'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Aucos\Permissionview\Http\Controllers\RoleController'); 
    }
}
