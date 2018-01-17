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
        
       // $this->loadRoutesFrom(__DIR__.'/routes.php'); 

         $this->registerRoutesMacro();

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
       
      //  $this->loadViewsFrom(__DIR__.'/views', 'Permissionview');
        
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

     /**
     * Register routes macro.
     *
     * @param   void
     * @return  void
     */
    protected function registerRoutesMacro()
    {
        $router = $this->app['router'];
        $router->macro('permissionView', function () use ($router) {
            $router->group(['middleware' => ['web', 'role:super-admin']], function () { 
                $router->resource('role', '\Aucos\Permissionview\Http\Controllers\RoleController', ['only' => [
                		'create', 'destroy'
                	]
                ]); 
                $router->resource('permissionAction', '\Aucos\Permissionview\Http\Controllers\PermissionActionController'); 
                $router->resource('permissionModel', '\Aucos\Permissionview\Http\Controllers\PermissionModelController'); 
                $router->resource('permission', '\Aucos\Permissionview\Http\Controllers\PermissionController', ['only' => [
                        'create', 'destroy', 'store'
                    ]
                ]); 
            });
            $router->group(['middleware' => ['web', 'role:super-admin|admin']], function () {
                
                $router->resource('role', '\Aucos\Permissionview\Http\Controllers\RoleController', ['except' => [
                        'create', 'destroy'
                    ]
                ]); 
                $router->resource('permission', '\Aucos\Permissionview\Http\Controllers\PermissionController', ['except' => [
                        'create', 'destroy', 'store'
                    ]
                ]); 
                $router->resource('user', '\Aucos\Permissionview\Http\Controllers\UserController'); 
                
            });
        });
    }
}
