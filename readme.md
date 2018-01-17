composer require aucos/laravel-permission-view,  

then  php artisan vendor:publish  Spatie\Permission and Aucos\Permissionview  

then php artisan migrate then add use Spatie\Permission\Traits\HasRoles and use HasRoles; in   auth user (App\User or etc) then   
composer dump-autoload  

then php artisan db:seed --class=PermissionViewSeeder 

This package comes with RoleMiddleware and PermissionMiddleware middleware. You can add them inside your app/Http/Kernel.php file.

protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    
]; 


In your routes file you must call the permissionView route .

Route::permissionView(); 


if you want, you can customize Route


Route::group(['middleware' => ['web', 'role:super-admin']], function () { 
	Route::resource('role', '\Aucos\Permissionview\Http\Controllers\RoleController', ['only' => [
			'create', 'destroy'
		]
	]);  
	Route::resource('permissionAction', '\Aucos\Permissionview\Http\Controllers\PermissionActionController'); 
	Route::resource('permissionModel', '\Aucos\Permissionview\Http\Controllers\PermissionModelController'); 
	Route::resource('permission', '\Aucos\Permissionview\Http\Controllers\PermissionController', ['only' => [
			'create', 'destroy', 'store'
		]
	]); 
});
Route::group(['middleware' => ['web', 'role:super-admin|admin']], function () {
	
	Route::resource('role', '\Aucos\Permissionview\Http\Controllers\RoleController', ['except' => [
			'create', 'destroy'
		]
	]); 
	Route::resource('permission', '\Aucos\Permissionview\Http\Controllers\PermissionController', ['except' => [
			'create', 'destroy', 'store'
		]
	]); 
	Route::resource('user', '\Aucos\Permissionview\Http\Controllers\UserController'); 
	
});

