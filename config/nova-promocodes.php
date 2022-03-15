<?php

return [
    'models' => [
        'promocodes' => [
            'resource' => \Zorb\NovaPromocodes\Resources\Promocode::class,
        ],

        'users' => [
            'resource' => \App\Nova\User::class,
        ],
    ],
];
