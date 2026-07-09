<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::table('settings')->insertOrIgnore([
            'key'         => 'banner.jumlah',
            'value'       => '5',
            'type'        => 'int',
            'group'       => 'Banner',
            'label'       => 'Jumlah Banner Ditampilkan',
            'description' => 'Jumlah maksimal banner yang tampil bergantian di halaman depan.',
            'is_public'   => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
    public function down(): void {
        DB::table('settings')->where('key', 'banner.jumlah')->delete();
    }
};
