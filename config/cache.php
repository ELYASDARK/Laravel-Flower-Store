<?php

declare(strict_types=1);

return [
    'default' => env('CACHE_STORE', 'file'),

    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION'),
            'table' => env('CACHE_DATABASE_TABLE', 'cache'),
            'lock_connection' => env('CACHE_DATABASE_CONNECTION'),
            'lock_table' => env('CACHE_DATABASE_LOCK_TABLE'),
        ],
    ],

    'prefix' => env('CACHE_PREFIX', 'laravel_cache_'),
];

