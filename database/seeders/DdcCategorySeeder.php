<?php

namespace Database\Seeders;

use App\Models\DdcCategory;
use Illuminate\Database\Seeder;

class DdcCategorySeeder extends Seeder
{
    /**
     * 10 kelas utama DDC (Dewey Decimal Classification).
     */
    public function run(): void
    {
        $classes = [
            ['000', 'Karya Umum'],
            ['100', 'Filsafat & Psikologi'],
            ['200', 'Agama'],
            ['300', 'Ilmu Sosial'],
            ['400', 'Bahasa'],
            ['500', 'Sains Murni'],
            ['600', 'Teknologi & Ilmu Terapan'],
            ['700', 'Seni & Rekreasi'],
            ['800', 'Sastra'],
            ['900', 'Sejarah & Geografi'],
        ];
        foreach ($classes as $i => [$code, $name]) {
            DdcCategory::firstOrCreate(
                ['code' => $code],
                ['name' => $name, 'order' => $i]
            );
        }
    }
}
