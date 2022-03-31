<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles e Permissions do sistema
    |--------------------------------------------------------------------------
    |
    | Role (função/papel) são as chave e permission (permissão) os valores.
    |
    */

    'system-admin' => [
        'create users',
        'view-any users',
        'view users',
        'edit users',
        'delete users',
        'update users',

        'create entries',
        'view-any entries',
        'view entries',
        'edit entries',
        'delete entries',
        'update entries',

        'create products',
        'view-any products',
        'view products',
        'edit products',
        'delete products',
        'update products',
        'increment-quantity products',

        'create rooms',
        'view-any rooms',
        'view rooms',
        'edit rooms',
        'delete rooms',
        'update rooms',
        'edit-price rooms',
        'update-price rooms',
    ],
    'user-admin' => [
        'view-any entries',
        'view entries',

        'view-any products',
        'view products',
        'increment-quantity products',

        'view-any rooms',
        'view rooms',
        'edit-price rooms',
        'update-price rooms',
    ],
    'user-operator' => [
        'create entries',
        'view-any entries',
        'view entries',
        'edit entries',
        'delete entries',
        'update entries',
    ],
];
