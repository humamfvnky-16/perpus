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
        $cats = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Agama', 'Sastra', 'Biografi', 'Komik', 'Referensi'];
        foreach ($cats as $c) {
            BookCategory::firstOrCreate(['slug' => Str::slug($c)], ['name' => $c]);
        }

        // ---- Penulis kontemporer (koleksi umum, masih berhak cipta) ----
        $authors = [
            ['name' => 'Pramoedya Ananta Toer', 'nationality' => 'Indonesia', 'bio' => 'Sastrawan Indonesia paling dikenal secara internasional, penulis tetralogi "Bumi Manusia". Meninggal 30 April 2006.'],
            ['name' => 'Andrea Hirata', 'nationality' => 'Indonesia', 'bio' => 'Novelis asal Belitung, dikenal lewat tetralogi "Laskar Pelangi" yang diadaptasi ke film dan diterjemahkan ke puluhan bahasa.'],
            ['name' => 'Tere Liye', 'nationality' => 'Indonesia', 'bio' => 'Novelis populer Indonesia dengan puluhan judul best-seller di berbagai genre, mulai roman hingga fiksi anak.'],
            ['name' => 'Habiburrahman El Shirazy', 'nationality' => 'Indonesia', 'bio' => 'Novelis dan dai, dikenal lewat novel "Ayat-Ayat Cinta" yang memelopori genre fiksi islami populer di Indonesia.'],
            ['name' => 'Dee Lestari', 'nationality' => 'Indonesia', 'bio' => 'Penulis serial "Supernova", salah satu sastrawan populer Indonesia pasca-2000.'],
            ['name' => 'Eka Kurniawan', 'nationality' => 'Indonesia', 'bio' => 'Novelis Indonesia dengan karya-karya yang telah diterjemahkan ke banyak bahasa, dikenal lewat "Cantik Itu Luka".'],
        ];

        // ---- Penulis klasik / karya domain publik (lihat BookSeeder) ----
        // Sumber: Daftar karya domain publik di Indonesia (id.wikipedia.org) — dihitung
        // berdasarkan Pasal 58 UU No. 28/2014 (hidup pencipta + 70 tahun sejak meninggal,
        // terhitung 1 Januari tahun berikutnya).
        $classicAuthors = [
            ['name' => 'Merari Siregar', 'nationality' => 'Indonesia', 'bio' => 'Penulis novel "Azab dan Sengsara" (1920), sering disebut sebagai novel modern Indonesia pertama. Meninggal 1941; karya berstatus domain publik sejak 2012.'],
            ['name' => 'Marco Kartodikromo', 'nationality' => 'Indonesia', 'bio' => 'Jurnalis pergerakan yang dijuluki "Mas Marco", penulis novel "Student Hidjo" (1918). Meninggal 1932 dalam pembuangan di Boven Digoel.'],
            ['name' => 'Tulis Sutan Sati', 'nationality' => 'Indonesia', 'bio' => 'Sastrawan Minangkabau era Balai Pustaka, penulis "Sengsara Membawa Nikmat" (1929). Meninggal 1942; karya berstatus domain publik sejak 2013.'],
            ['name' => 'Amir Hamzah', 'nationality' => 'Indonesia', 'bio' => 'Pujangga Baru, dijuluki "Raja Penyair Pujangga Baru", penulis "Nyanyi Sunyi" dan "Buah Rindu". Wafat 20 Maret 1946; karya berstatus domain publik sejak 2017.'],
            ['name' => 'Chairil Anwar', 'birth_date' => '1922-07-26', 'nationality' => 'Indonesia', 'bio' => 'Pelopor Angkatan \'45 dan salah satu penyair terpenting Indonesia, penulis "Aku". Wafat 28 April 1949; karya berstatus domain publik sejak 2020.'],
            ['name' => 'Tan Malaka', 'birth_date' => '1897-06-02', 'nationality' => 'Indonesia', 'bio' => 'Pejuang kemerdekaan dan pemikir revolusioner, Pahlawan Nasional Indonesia, penulis "Menuju Republik Indonesia" (1925). Wafat 21 Februari 1949; karya berstatus domain publik sejak 2020.'],
            ['name' => 'Muhammad Musa', 'nationality' => 'Indonesia', 'bio' => 'Pujangga Sunda, penulis wawacan "Wawacan Panji Wulung" (1871), salah satu karya tertua dalam daftar domain publik Indonesia. Meninggal 1886.'],
            ['name' => 'Lie Kiem Hok', 'nationality' => 'Indonesia', 'bio' => 'Dijuluki "Bapak Sastra Melayu-Tionghoa", penulis "Malajoe Batawi" (1884). Meninggal 1912.'],
            ['name' => 'Tirto Adhi Soerjo', 'nationality' => 'Indonesia', 'bio' => 'Dijuluki "Bapak Pers Nasional Indonesia", perintis surat kabar Medan Prijaji. Meninggal 1918; karyanya berstatus domain publik sejak 1989.'],
            ['name' => 'Ki Padmosoesastro', 'nationality' => 'Indonesia', 'bio' => 'Pujangga Jawa awal abad ke-20, penulis "Rangsang Tuban" (1912). Meninggal 1926.'],
            ['name' => 'Sam Ratulangi', 'nationality' => 'Indonesia', 'bio' => 'Dr. G.S.S.J. Ratulangi, Pahlawan Nasional dari Sulawesi Utara, penulis "Sarekat Islam" (1913). Wafat 30 Juni 1949; karya berstatus domain publik sejak 2020.'],
            ['name' => 'Akhmad Bassah', 'nationality' => 'Indonesia', 'bio' => 'Menulis dengan nama pena "Joehanna", pengarang sastra Sunda "Tjarios Eulis Atjih" (1925). Meninggal 1930.'],
        ];

        foreach (array_merge($authors, $classicAuthors) as $a) {
            Author::updateOrCreate(
                ['slug' => Str::slug($a['name'])],
                [
                    'name'        => $a['name'],
                    'bio'         => $a['bio'] ?? null,
                    'nationality' => $a['nationality'] ?? null,
                    'birth_date'  => $a['birth_date'] ?? null,
                ]
            );
        }

        $pubs = [
            ['name' => 'Gramedia'],
            ['name' => 'Mizan'],
            ['name' => 'Bentang Pustaka'],
            ['name' => 'Erlangga'],
            ['name' => 'Republika'],
            ['name' => 'Penguin Random House'],
            // Penerbit negara untuk sastra berbahasa Melayu/Indonesia, didirikan 1917 —
            // menerbitkan sebagian besar novel domain publik era Balai Pustaka di atas.
            ['name' => 'Balai Pustaka', 'city' => 'Jakarta', 'country' => 'Indonesia'],
        ];
        foreach ($pubs as $p) {
            Publisher::firstOrCreate(['slug' => Str::slug($p['name'])], [
                'name'    => $p['name'],
                'city'    => $p['city'] ?? null,
                'country' => $p['country'] ?? null,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            Shelf::firstOrCreate(['code' => sprintf('R-%02d', $i)], [
                'name' => "Rak $i", 'floor' => 'Lantai 1', 'room' => 'Ruang Utama',
            ]);
        }
    }
}
