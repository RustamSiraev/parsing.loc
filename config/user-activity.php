<?php

return [
    'activated'        => true,
    'middleware'       => ['web', 'auth', 'role:root'],
    'route_path'       => 'admin/user-activity',
    'admin_panel_path' => 'admin/',
    'delete_limit'     => 7,

    'model' => [
        'user' => "App\Models\User"
    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true,
        'on_logout'     => true
    ]
];
