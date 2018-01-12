<?php
Route::resourceVerbs([
    'create' => 'neu',
    'edit' => 'bearbeiten',
]); 
Route::group(['middleware' => ['web', 'role:super-admin']], function () {
	
	Route::resource('role', 'Aucos\Permissionview\Http\Controllers\RoleController'); 
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController'); 
	Route::resource('user', 'Aucos\Permissionview\Http\Controllers\UserController'); 
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController'); 
	Route::resource('permissionAction', 'Aucos\Permissionview\Http\Controllers\PermissionActionController'); 
	Route::resource('permissionModel', 'Aucos\Permissionview\Http\Controllers\PermissionModelController'); 
});


