<?php

/*
|--------------------------------------------------------------------------
| API Routes — Perpustakaan Digital
|--------------------------------------------------------------------------
| Prefix otomatis: /api  (lihat bootstrap/app.php)
| Middleware default: 'api' + throttle:api
| Otentikasi: Sanctum bearer token
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/

Route::get('/ping', fn () => ['ok' => true, 'time' => now()->toIso8601String()]);

// Auth — login (dapat token)
Route::post('auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])
    ->middleware('throttle:login');

// Katalog publik
Route::get('books',         [\App\Http\Controllers\Api\BookApiController::class, 'index']);
Route::get('books/{book}',  [\App\Http\Controllers\Api\BookApiController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Authenticated API (Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('auth/me',      [\App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Riwayat pinjaman pengguna
    Route::get('my/borrows',   [\App\Http\Controllers\Api\BorrowApiController::class, 'myBorrows']);
    Route::get('my/fines',     [\App\Http\Controllers\Api\BorrowApiController::class, 'myFines']);
    Route::get('my/reservations', [\App\Http\Controllers\Api\BorrowApiController::class, 'myReservations']);

    // Transaksi
    Route::post('borrow',      [\App\Http\Controllers\Api\BorrowApiController::class, 'checkout']);
    Route::post('return',      [\App\Http\Controllers\Api\BorrowApiController::class, 'checkin']);
    Route::post('reservation', [\App\Http\Controllers\Api\BorrowApiController::class, 'reserve']);

    // Default user info (Sanctum bawaan)
    Route::get('/user', fn (Request $request) => $request->user());
});
