<?php
Route::resourceVerbs([
    'create' => 'neu',
    'edit' => 'bearbeiten',
]);
Route::get('test', function(){
	echo 'Hello from the calculator package!';
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('role', 'Aucos\Permissionview\Http\Controllers\RoleController'); 
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController'); 
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('user', 'Aucos\Permissionview\Http\Controllers\UserController'); 
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('permission', 'Aucos\Permissionview\Http\Controllers\PermissionController'); 
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('permissionAction', 'Aucos\Permissionview\Http\Controllers\PermissionActionController'); 
}); 

Route::group(['middleware' => ['web']], function () {
	Route::resource('permissionModel', 'Aucos\Permissionview\Http\Controllers\PermissionModelController'); 
});