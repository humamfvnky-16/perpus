<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\BookCategory;
use App\Models\Publisher;
use App\Models\Shelf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $cats = ['Fiksi','Non-Fiksi','Sains','Teknologi','Sejarah','Agama','Sastra','Biografi','Komik','Referensi'];
        foreach ($cats as $c) BookCategory::firstOrCreate(['slug' => Str::slug($c)], ['name' => $c]);

        $authors = ['Pramoedya Ananta Toer','Andrea Hirata','Tere Liye','Habiburrahman El Shirazy','Dee Lestari','Eka Kurniawan'];
        foreach ($authors as $a) Author::firstOrCreate(['slug' => Str::slug($a)], ['name' => $a]);

        $pubs = ['Gramedia','Mizan','Bentang Pustaka','Erlangga','Republika','Penguin Random House'];
        foreach ($pubs as $p) Publisher::firstOrCreate(['slug' => Str::slug($p)], ['name' => $p]);

        for ($i = 1; $i <= 6; $i++) {
            Shelf::firstOrCreate(['code' => sprintf('R-%02d', $i)], [
                'name' => "Rak $i", 'floor' => 'Lantai 1', 'room' => 'Ruang Utama',
            ]);
        }
    }
}
