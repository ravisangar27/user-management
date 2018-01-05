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
        
        include __DIR__.'/routes.php'; 

        $this->publishes([
            __DIR__ . '/../config/permissionview.php' => $this->app->configPath() . '/permissionview.php',
        ], 'config');

       
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
