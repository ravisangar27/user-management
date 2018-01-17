composer require aucos/laravel-permission-view,  

then  php artisan vendor:publish  Spatie\Permission and Aucos\Permissionview  

then php artisan migrate then add use Spatie\Permission\Traits\HasRoles and use HasRoles; in   auth user (App\User or etc) then   
composer dump-autoload  

then php artisan db:seed --class=PermissionViewSeeder 

This package comes with RoleMiddleware and PermissionMiddleware middleware. You can add them inside your app/Http/Kernel.php file.

protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
]; 


In your routes file you must call the permissionView route .

Route::permissionView();

