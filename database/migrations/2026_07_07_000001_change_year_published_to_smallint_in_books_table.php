<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Kolom `year_published` semula bertipe YEAR, yang di MySQL hanya bisa
     * menyimpan rentang 1901–2155. Perpustakaan ini mengoleksi buku domain
     * publik yang jauh lebih tua (mis. 1871, 1884), jadi tipe YEAR tidak
     * memadai — diganti SMALLINT UNSIGNED supaya tahun terbit berapa pun
     * bisa disimpan apa adanya.
     */
    public function up(): void
    {
        if (Schema::hasColumn('books', 'year_published')) {
            DB::statement('ALTER TABLE books MODIFY year_published SMALLINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('books', 'year_published')) {
            DB::statement('ALTER TABLE books MODIFY year_published YEAR NULL');
        }
    }
};
