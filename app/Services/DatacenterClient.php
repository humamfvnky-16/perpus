<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Klien HTTP ke API Data Center (routes/api.php di aplikasi Datacenter).
 * Semua endpoint dipanggil server-to-server pakai token Sanctum
 * (php artisan api:token perpus di aplikasi Datacenter).
 */
class DatacenterClient
{
    protected function client(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.datacenter.url'), '/'))
            ->withToken((string) config('services.datacenter.token'))
            ->acceptJson()
            ->timeout(10);
    }

    protected function get(string $path, array $query = []): array
    {
        try {
            $response = $this->client()->get($path, $query);
        } catch (ConnectionException $e) {
            throw new RuntimeException('Tidak bisa terhubung ke Data Center. Hubungi admin.', previous: $e);
        }

        if ($response->failed()) {
            throw new RuntimeException($response->json('message') ?: 'Data Center menolak permintaan.');
        }

        return $response->json() ?? [];
    }

    public function tahunAjaran(): array
    {
        return $this->get('/v1/tahun-ajaran')['data'] ?? [];
    }

    public function rombel(int $tahunAjaranId): array
    {
        return $this->get('/v1/rombel', ['tahun_ajaran_id' => $tahunAjaranId])['data'] ?? [];
    }

    public function siswaRombel(int $rombelId): array
    {
        return $this->get("/v1/rombel/{$rombelId}/siswa");
    }

    /**
     * Verifikasi NISN + password langsung ke Data Center. Melempar RuntimeException
     * dengan pesan Data Center kalau ditolak (401/403/423), tanpa pernah menyimpan
     * password siswa di Perpus.
     */
    public function verifySiswa(string $nisn, string $password): array
    {
        try {
            $response = $this->client()->post('/v1/auth/verify-siswa', [
                'username' => $nisn,
                'password' => $password,
            ]);
        } catch (ConnectionException $e) {
            throw new RuntimeException('Tidak bisa terhubung ke Data Center. Hubungi admin.', previous: $e);
        }

        if ($response->failed()) {
            throw new RuntimeException($response->json('message') ?: 'NISN atau password salah.');
        }

        return $response->json('data') ?? [];
    }

    /**
     * Verifikasi NIP + password guru ke Data Center (pola sama seperti verifySiswa,
     * dipakai TeacherLoginController — Perpus tidak pernah menyimpan password guru).
     */
    public function verifyGuru(string $nip, string $password): array
    {
        try {
            $response = $this->client()->post('/v1/auth/verify-guru', [
                'username' => $nip,
                'password' => $password,
            ]);
        } catch (ConnectionException $e) {
            throw new RuntimeException('Tidak bisa terhubung ke Data Center. Hubungi admin.', previous: $e);
        }

        if ($response->failed()) {
            throw new RuntimeException($response->json('message') ?: 'NIP atau password salah.');
        }

        return $response->json('data') ?? [];
    }

    /** Semua siswa (flat, semua rombel) — dipakai auto-sync anggota perpustakaan. */
    public function allSiswa(): array
    {
        return $this->fetchAllPaginated('/v1/siswa');
    }

    /** Semua guru — dipakai auto-sync anggota perpustakaan. */
    public function allGuru(): array
    {
        return $this->fetchAllPaginated('/v1/guru');
    }

    /**
     * Ambil seluruh data dari endpoint paginated Data Center (respons Laravel
     * paginator: { data, current_page, last_page, ... }) dgn menelusuri semua halaman.
     */
    protected function fetchAllPaginated(string $path, int $perPage = 200): array
    {
        $all = [];
        $page = 1;
        do {
            $res  = $this->get($path, ['per_page' => $perPage, 'page' => $page]);
            $data = $res['data'] ?? [];
            $all  = array_merge($all, $data);
            $last = (int) ($res['last_page'] ?? 1);
            $page++;
        } while ($page <= $last && ! empty($data));

        return $all;
    }
}
