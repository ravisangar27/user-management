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
// first field must be name (name or username ... etc)
    'user' => [
        'additional_fields' => [[
                'name' => '',
                'value' => ''
            ]
        ],
        'email' => '',
        'password' => '',
        // user name can change user_name, name or etc
        'userName' => 'name'
    ],

    // user request rule for user create

    'user_create_rule' => [
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6'
    ],
    // page size
    'pagination' => 20
];
