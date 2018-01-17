<?php
Route::resourceVerbs([
    'create' => 'neu',
    'edit' => 'bearbeiten',
]); 
Route::group(['middleware' => ['web', 'role:super-admin']], function () { 
	Route::resource('role', 'Aucos\Permissionview\Http\Controllers\RoleController', ['only' => [
			'create', 'destroy'
		]
	]); 
	Route::resource('permissionAction', 'Aucos\Permissionview\Http\Controllers\PermissionActionController'); 
	Route::resource('permissionModel', 'Aucos\Permissionview\Http\Controllers\PermissionModelController'); 
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController', ['only' => [
			'create', 'destroy', 'store'
		]
	]); 
});
Route::group(['middleware' => ['web', 'role:super-admin|admin']], function () {
	
	Route::resource('role', 'Aucos\Permissionview\Http\Controllers\RoleController', ['except' => [
			'create', 'destroy'
		]
	]); 
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController', ['except' => [
			'create', 'destroy', 'store'
		]
	]); 
	Route::resource('user', 'Aucos\Permissionview\Http\Controllers\UserController'); 
	
});


