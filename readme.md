#### install  #### 	
	
	composer require aucos/laravel-permission-view 

#### publish Spatie\Permission, spatie/laravel-activitylog and Aucos\Permissionview   ## ## 

	 php artisan vendor:publish 

#### then php artisan migrate  ####
	php artisan migrate 
###  use Spatie\Permission\Traits\HasRoles and use HasRoles; in   auth user (App\User or etc) ###
	[see you document](https://github.com/spatie/laravel-permission#usage).
###  use Spatie\Activitylog\Traits\CausesActivity; and use CausesActivity; in   auth user (App\User or etc) ###
	[see you document](https://docs.spatie.be/laravel-activitylog/v2/advanced-usage/logging-model-event).  
	go to Using the CausesActivity trait
#### then    #### 
	 composer dump-autoload  
#### seed ####
    php artisan db:seed --class=PermissionViewSeeder

#### This package comes with RoleMiddleware and PermissionMiddleware middleware. You can add them inside your app/Http/Kernel.php file. 

	protected $routeMiddleware = [
		// ...
		'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
		
	]; 


#### In your routes file you must call the permissionView route. ####

	Route::permissionView(); 


#### if you want, you can customize Route ####


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

		Route::get('user/{id}/log', '\Aucos\Permissionview\Http\Controllers\UserController@log')->name('userLog');
	
		Route::resource('activity', '\Aucos\Permissionview\Http\Controllers\ActivityController', ['only' => [
				'index', 'show'
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

