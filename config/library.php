<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi domain perpustakaan
    |--------------------------------------------------------------------------
    | Semua nilai dapat di-override lewat tabel `settings` (key = sama).
    */
    'name'              => env('APP_NAME', 'Perpustakaan Digital'),
    'two_factor'        => filter_var(env('LIB_2FA_ENABLED', false), FILTER_VALIDATE_BOOLEAN),

    'roles' => ['super_admin', 'admin', 'staff', 'teacher', 'student'],

    'ebook_mimes' => ['pdf', 'epub', 'docx', 'pptx', 'mp3', 'mp4', 'webm'],
    'max_upload_mb' => 50,
];
