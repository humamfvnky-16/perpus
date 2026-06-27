<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi domain perpustakaan
    |--------------------------------------------------------------------------
    | Semua nilai dapat di-override lewat tabel `settings` (key = sama).
    */
    'name'              => env('APP_NAME', 'Perpustakaan Digital'),
    'default_loan_days' => (int) env('LIB_DEFAULT_LOAN_DAYS', 7),
    'max_per_member'    => (int) env('LIB_MAX_BOOKS_PER_MEMBER', 3),
    'daily_fine'        => (int) env('LIB_DAILY_FINE', 1000),
    'damage_fine'       => (int) env('LIB_DAMAGE_FINE', 25000),
    'lost_fine'         => (int) env('LIB_LOST_FINE', 100000),
    'renew_limit'       => (int) env('LIB_RENEW_LIMIT', 1),
    'reservation_hours' => (int) env('LIB_RESERVATION_HOURS', 48),
    'two_factor'        => filter_var(env('LIB_2FA_ENABLED', false), FILTER_VALIDATE_BOOLEAN),

    'roles' => ['super_admin', 'admin', 'staff', 'teacher', 'student'],

    'ebook_mimes' => ['pdf', 'epub', 'docx', 'pptx', 'mp3', 'mp4', 'webm'],
    'max_upload_mb' => 50,
];
