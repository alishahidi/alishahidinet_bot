<?php

return [
    'limiter'      => [
        'enabled' => true,
    ],
    'logging'  => [
        'debug'  => storage_path('/php-telegram-bot-debug.log'),
        'error'  => storage_path('/php-telegram-bot-error.log'),
        'update' => storage_path('/php-telegram-bot-update.log'),
    ],
    'commands'     => [
        'paths'   => [
            base_path('app/Http/Commands')
        ],
        'configs' => [],
    ],
    'mysql'        => [
        'host'     => env("DB_HOST"),
        'user'     => env("DB_USERNAME"),
        'password' => env("DB_PASSWORD"),
        'database' => env("DB_DATABASE"),
    ],
];
