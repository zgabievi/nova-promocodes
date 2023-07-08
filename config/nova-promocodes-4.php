<?php

return [
    'models' => [
        'promocodes' => [
            'resource' => \Aberbin\NovaPromocodes\Resources\Promocode::class,
        ],

        'users' => [
            'resource' => \App\Nova\User::class,
        ],
    ],
];
