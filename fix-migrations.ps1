# Rename file migration agar urutan dependensi benar
# Jalankan dari root proyek: .\fix-migrations.ps1

$ErrorActionPreference = 'Stop'
$dir = Join-Path $PSScriptRoot 'database\migrations'

# Urutan dependensi: tabel induk dulu, baru tabel yang punya FK
$order = @(
    'create_users_table',                  # 01 - induk: users
    'create_cache_jobs_tables',            # 02 - tanpa FK
    'create_permission_tables',            # 03 - butuh users
    'create_book_taxonomy_tables',         # 04 - induk: categories/authors/publishers/shelves
    'create_books_table',                  # 05 - butuh taxonomy
    'create_members_table',                # 06 - butuh users
    'create_ebooks_table',                 # 07 - butuh books
    'create_borrow_transactions_table',    # 08 - butuh members + books + users
    'create_return_transactions_table',    # 09 - butuh borrow_transactions
    'create_reservations_table',           # 10 - butuh members + books
    'create_fines_payments_tables',        # 11 - butuh members + borrow_transactions
    'create_reviews_wishlists_tables',     # 12 - butuh users + books
    'create_notification_log_tables',      # 13 - butuh users
    'create_settings_table',               # 14 - tanpa FK
    'create_personal_access_tokens_table'  # 15 - tanpa FK
)

$prefix = '2026_06_22_'
$i = 0

foreach ($name in $order) {
    $i++
    $seq = '{0:D6}' -f $i
    $newFile = "${prefix}${seq}_${name}.php"

    # cari file yang berakhir dengan _$name.php
    $existing = Get-ChildItem $dir -Filter "*_${name}.php" | Select-Object -First 1
    if (-not $existing) {
        Write-Host "  [SKIP] $name (tidak ditemukan)" -ForegroundColor Yellow
        continue
    }

    if ($existing.Name -eq $newFile) {
        Write-Host "  [OK ] $($existing.Name)" -ForegroundColor DarkGray
        continue
    }

    $target = Join-Path $dir $newFile
    Rename-Item -Path $existing.FullName -NewName $newFile
    Write-Host "  [REN] $($existing.Name) -> $newFile" -ForegroundColor Green
}

Write-Host ""
Write-Host "Selesai. Sekarang jalankan:" -ForegroundColor Cyan
Write-Host "  php artisan migrate:fresh --seed" -ForegroundColor White
