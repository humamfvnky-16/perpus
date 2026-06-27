<?php

return [
    'name'     => env('APP_NAME', 'Perpustakaan Digital'),
    'env'      => env('APP_ENV', 'production'),
    'debug'    => (bool) env('APP_DEBUG', false),
    'url'      => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
    'locale'   => env('APP_LOCALE', 'id'),
    'fallback_locale' => 'en',
    'key'      => env('APP_KEY'),
    'cipher'   => 'AES-256-CBC',
    'providers' => \Illuminate\Support\ServiceProvider::defaultProviders()->merge([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
    ])->toArray(),
];
