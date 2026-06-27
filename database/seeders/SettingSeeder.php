<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'library.name', 'value' => 'Perpustakaan Digital', 'group' => 'general', 'label' => 'Nama Perpustakaan'],
            ['key' => 'library.logo', 'value' => '', 'group' => 'general', 'label' => 'Logo'],
            ['key' => 'library.timezone', 'value' => 'Asia/Jakarta', 'group' => 'general', 'label' => 'Timezone'],
            ['key' => 'loan.days', 'value' => '7', 'type' => 'int', 'group' => 'loan', 'label' => 'Lama Peminjaman (hari)'],
            ['key' => 'loan.max_per_member', 'value' => '3', 'type' => 'int', 'group' => 'loan', 'label' => 'Maksimum Pinjaman'],
            ['key' => 'fine.daily', 'value' => '1000', 'type' => 'int', 'group' => 'fine', 'label' => 'Denda Harian (Rp)'],
            ['key' => 'fine.damage', 'value' => '25000', 'type' => 'int', 'group' => 'fine', 'label' => 'Denda Kerusakan'],
            ['key' => 'fine.lost', 'value' => '100000', 'type' => 'int', 'group' => 'fine', 'label' => 'Denda Kehilangan'],
        ];
        foreach ($defaults as $row) Setting::firstOrCreate(['key' => $row['key']], $row);
    }
}
