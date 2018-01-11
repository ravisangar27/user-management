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

    'merge_action' => [
        'store'  =>  'create', 
        'edit'   =>  'update'
    ], 

    'display_language' => 'german',

    'display_name' => [
        'german' => [
            'index' => 'Übersicht',
            'show' => 'Details',
            'create' => 'Erstellen',
            'update' => 'Bearbeiten',
            'delete' => 'Löschen',
            'restore' => 'Wiederherstellen',
        ]
    ]


];
