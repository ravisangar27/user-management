<?php

return [
    'models' => [
        'action' => Aucos\Permissionview\Models\Action::class,
        'model' => Aucos\Permissionview\Models\Model::class,
    ],

    'table_names' => [
        'action' => 'actions',
        'model' => 'models'
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
