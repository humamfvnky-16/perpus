<?php

namespace App\Console\Commands;

use App\Services\DatacenterClient;
use App\Services\DatacenterSync;
use Illuminate\Console\Command;

/**
 * Auto-sync semua siswa & guru dari Data Center menjadi anggota perpustakaan
 * (menggantikan alur import manual per-rombel di DatacenterImportController).
 *
 * Jadwalkan via cron (mis. tiap 10 menit) supaya anggota baru di Data Center
 * otomatis terdaftar tanpa perlu admin meng-import manual:
 *   php artisan datacenter:sync
 */
class SyncDatacenter extends Command
{
    protected $signature = 'datacenter:sync';

    protected $description = 'Sinkronkan siswa & guru dari Data Center sebagai anggota perpustakaan';

    public function handle(DatacenterClient $client, DatacenterSync $sync): int
    {
        $siswa = $client->allSiswa();
        $okSiswa = 0;
        foreach ($siswa as $s) {
            try {
                $sync->upsertSiswa($s);
                $okSiswa++;
            } catch (\Throwable $e) {
                $this->warn("Siswa NISN {$s['nisn']} dilewati: ".$e->getMessage());
            }
        }
        $this->info("{$okSiswa}/".count($siswa).' siswa tersinkron sebagai anggota.');

        $guru = $client->allGuru();
        $okGuru = 0;
        foreach ($guru as $g) {
            try {
                $sync->upsertGuru($g);
                $okGuru++;
            } catch (\Throwable $e) {
                $this->warn("Guru NIP {$g['nip']} dilewati: ".$e->getMessage());
            }
        }
        $this->info("{$okGuru}/".count($guru).' guru tersinkron sebagai anggota.');

        return self::SUCCESS;
    }
}
