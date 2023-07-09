<?php

return [
    'models' => [
        'promocodes' => [
            'resource' => \Aberbin96\NovaPromocodes\Resources\Promocode::class,
        ],

        'users' => [
            'resource' => \App\Nova\User::class,
        ],
    ],
];
