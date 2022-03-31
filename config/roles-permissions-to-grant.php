<?php

/*
    |--------------------------------------------------------------------------
    | Roles e permissions que serão concedidas a cada usuário
    |--------------------------------------------------------------------------
    |
    | Cada chave dentro de roles é a role a ser concedida ao usuário. E
    | cada chave dentro do nome de cada role é uma array com o nome
    | e email do usuário para qual aquela role será concedida. O mesmo
    | ocorre para as permissions.
    |
    */

$localRoles = [];
$localPermissions = [];

if (config('app.env') === 'local' && config('app.debug')) {
    $localRoles = [
        'system-admin' => [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ],
        ],
        'user-admin' => [
            [
                'name' => 'User Admin',
                'email' => 'useradmin@admin.com'
            ],
        ],
        'user-operator' => [
            [
                'name' => 'User Operator',
                'email' => 'useroperator@admin.com',
            ],
        ],
    ];

    $localPermissions = [];
}

return [
    'roles' => array_merge_recursive([], $localRoles),
    'permissions' => array_merge_recursive([], $localPermissions),
];
