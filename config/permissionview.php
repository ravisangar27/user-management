<?php

return [
    'models' => [
        'PermissionAction' => Aucos\Permissionview\Models\PermissionAction::class,
        'PermissionModel' => Aucos\Permissionview\Models\PermissionModel::class,
    ],

    'table_names' => [
        'permissionAction' => 'permission_actions',
        'permissionModel' => 'permission_models'
    ], 
// create a user as super-admin when seed 
    'user' =>[
        'status' => false,
        'name' => '',
        'email' =>  '',
        'password' => ''
    ]


];
