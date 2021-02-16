<?php

return [
    'roles_structure' => [
        'super_admin' => [
            'users'     => 'c,r,u,d',
            'absences'  => 'c,r,u,d',
            'salaries'  => 'c,r,u,d',
            'roles'     => 'c,r,u,d',
        ],
        'admin' => [
            'users'     => 'c,r,d',
            'absences'  => 'c,r,u,d',
            'salaries'  => 'c,r,u,d',
        ],
        'manage' => [
            'users'     => 'c,r',
            'absences'  => 'c,r',
            'salaries'  => 'c,r',
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
