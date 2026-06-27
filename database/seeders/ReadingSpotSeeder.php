<?php

namespace Database\Seeders;

use App\Models\AppProfile;
use App\Models\CheckoutSetting;
use App\Models\ReadingSpot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReadingSpotSeeder extends Seeder
{
    public function run(): void
    {
        $spots = [
            [
                'name' => 'SMPN 205 Jakarta',
                'type' => 'school',
                'npsn' => '20100123',
                'city' => 'Jakarta Barat',
                'province' => 'DKI Jakarta',
                'phone' => '021-5551234',
                'email' => 'perpus@smpn205.sch.id',
                'address' => 'Jl. Pendidikan No. 205, Jakarta Barat',
            ],
            [
                'name' => 'Perpustakaan Kota Bandung',
                'type' => 'library',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'phone' => '022-1234567',
                'email' => 'info@perpus-bdg.id',
            ],
            [
                'name' => 'Komunitas Baca Yogya',
                'type' => 'community',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
            ],
        ];

        foreach ($spots as $data) {
            $data['slug'] = Str::slug($data['name']);
            $spot = ReadingSpot::firstOrCreate(['slug' => $data['slug']], $data);

            AppProfile::firstOrCreate(
                ['reading_spot_id' => $spot->id],
                ['app_name' => $spot->name]
            );
            CheckoutSetting::firstOrCreate(['reading_spot_id' => $spot->id]);
        }
    }
}
