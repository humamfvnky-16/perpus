@echo off
REM Rename file migration ke urutan dependensi yang benar.
REM Jalankan dari root proyek: fix-migrations.bat

setlocal
cd /d "%~dp0database\migrations"

if errorlevel 1 (
    echo ERROR: Folder database\migrations tidak ditemukan.
    exit /b 1
)

echo Renaming migration files...
echo.

REM Urutan: tabel induk dulu, tabel anak (yang punya FK) belakangan.
REM Tanggal dinaikkan agar urutan alphabetical = urutan eksekusi.

call :ren "2026_06_22_000001_create_users_table.php"                  "2026_06_01_000001_create_users_table.php"
call :ren "2026_06_22_000001_create_cache_jobs_tables.php"            "2026_06_02_000001_create_cache_jobs_tables.php"
call :ren "2026_06_22_000001_create_permission_tables.php"            "2026_06_03_000001_create_permission_tables.php"
call :ren "2026_06_22_000001_create_book_taxonomy_tables.php"         "2026_06_04_000001_create_book_taxonomy_tables.php"
call :ren "2026_06_22_000001_create_books_table.php"                  "2026_06_05_000001_create_books_table.php"
call :ren "2026_06_22_000001_create_members_table.php"                "2026_06_06_000001_create_members_table.php"
call :ren "2026_06_22_000001_create_ebooks_table.php"                 "2026_06_07_000001_create_ebooks_table.php"
call :ren "2026_06_22_000001_create_borrow_transactions_table.php"    "2026_06_08_000001_create_borrow_transactions_table.php"
call :ren "2026_06_22_000001_create_return_transactions_table.php"    "2026_06_09_000001_create_return_transactions_table.php"
call :ren "2026_06_22_000001_create_reservations_table.php"           "2026_06_10_000001_create_reservations_table.php"
call :ren "2026_06_22_000001_create_fines_payments_tables.php"        "2026_06_11_000001_create_fines_payments_tables.php"
call :ren "2026_06_22_000001_create_reviews_wishlists_tables.php"     "2026_06_12_000001_create_reviews_wishlists_tables.php"
call :ren "2026_06_22_000001_create_notification_log_tables.php"      "2026_06_13_000001_create_notification_log_tables.php"
call :ren "2026_06_22_000001_create_settings_table.php"               "2026_06_14_000001_create_settings_table.php"
call :ren "2026_06_22_000001_create_personal_access_tokens_table.php" "2026_06_15_000001_create_personal_access_tokens_table.php"

echo.
echo === Selesai. ===
echo.
echo Sekarang jalankan:
echo   php artisan migrate:fresh --seed
echo.
endlocal
exit /b 0

:ren
if exist %1 (
    if not exist %2 (
        ren %1 %2
        echo   [OK ]  %~1  -^>  %~2
    ) else (
        echo   [SKIP] %~2 sudah ada
    )
) else (
    echo   [MISS] %~1 tidak ditemukan
)
exit /b 0
