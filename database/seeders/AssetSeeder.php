<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AsetBarang;
use App\Models\AsetKendaraan;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        // 1. Aset Barang (Inventaris)
        AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-001'], [
            'nama_barang' => 'Laptop Dell Latitude 5420',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-03-15',
            'lokasi' => 'Ruang Rapat Utama',
            'penanggung_jawab' => 'Budi Kurniawan',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $adminId,
        ]);

        AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-002'], [
            'nama_barang' => 'Meja Kerja Kayu Jati',
            'kategori' => 'Furnitur',
            'tanggal_perolehan' => '2023-01-20',
            'lokasi' => 'Ruang Kepala Bagian',
            'penanggung_jawab' => 'Siti Nurhayati',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $adminId,
        ]);

        AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-003'], [
            'nama_barang' => 'Kamera Sony A7 IV Mirrorless',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-04-10',
            'lokasi' => 'Studio Dokumentasi',
            'penanggung_jawab' => 'Fajar Nugraha',
            'kondisi' => 'baik',
            'status' => 'digunakan',
            'created_by' => $adminId,
        ]);

        AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-004'], [
            'nama_barang' => 'Proyektor Epson EB-X500',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-02-14',
            'lokasi' => 'Ruang Rapat Tengah',
            'penanggung_jawab' => 'Andi Pratama',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $adminId,
        ]);

        for ($i = 5; $i <= 48; $i++) {
            $cat = ['Elektronik', 'Furnitur', 'Peralatan Kantor', 'Dokumentasi', 'Lainnya'][rand(0, 4)];
            $loc = ['Ruang Rapat Utama', 'Ruang Kepala Bagian', 'Ruang Staf Protokol', 'Studio Dokumentasi', 'Gudang Inventaris'][rand(0, 4)];
            $nama = match($cat) {
                'Elektronik' => "Printer HP LaserJet Pro M{$i}",
                'Furnitur' => "Kursi Ergonomis Kantor Tipe {$i}",
                'Peralatan Kantor' => "Lemari Arsip Baja 4 Pintu {$i}",
                'Dokumentasi' => "Lensa Sony G-Master 24-70mm v{$i}",
                default => "Perangkat Inventaris Kantor No. {$i}",
            };
            AsetBarang::firstOrCreate(
                ['kode_aset' => sprintf('INV-2023-%03d', $i)],
                [
                    'nama_barang' => $nama,
                    'kategori' => $cat,
                    'tanggal_perolehan' => Carbon::parse('2023-01-01')->addDays($i * 5),
                    'lokasi' => $loc,
                    'penanggung_jawab' => ['Budi Kurniawan', 'Siti Nurhayati', 'Fajar Nugraha', 'Dina Wulandari'][rand(0, 3)],
                    'kondisi' => ['baik', 'baik', 'rusak_ringan'][rand(0, 2)],
                    'status' => ['tersedia', 'tersedia', 'digunakan', 'dipinjam'][rand(0, 3)],
                    'created_by' => $adminId,
                ]
            );
        }

        // 2. Aset Kendaraan Operasional
        AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1234 ABC'], [
            'nama_kendaraan' => 'Toyota Innova Zenix',
            'jenis' => 'Minibus',
            'pemegang_pengguna' => 'Kabag Protokol',
            'tahun' => '2023',
            'status' => 'sedang_digunakan',
            'created_by' => $adminId,
        ]);

        AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1456 XYZ'], [
            'nama_kendaraan' => 'Toyota Hiace Premio',
            'jenis' => 'Microbus',
            'pemegang_pengguna' => 'Tim Dokumentasi',
            'tahun' => '2022',
            'status' => 'tersedia',
            'created_by' => $adminId,
        ]);

        AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1990 DEF'], [
            'nama_kendaraan' => 'Mitsubishi Pajero Sport',
            'jenis' => 'SUV',
            'pemegang_pengguna' => 'Asisten Pemerintahan',
            'tahun' => '2021',
            'status' => 'sedang_digunakan',
            'created_by' => $adminId,
        ]);

        AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1122 GHI'], [
            'nama_kendaraan' => 'Honda CR-V',
            'jenis' => 'SUV',
            'pemegang_pengguna' => '-',
            'tahun' => '2020',
            'status' => 'perbaikan',
            'created_by' => $adminId,
        ]);

        $sampleKendaraan = [
            ['D 1345 JKL', 'Toyota Fortuner GR Sport', 'SUV', 'Sekretaris Daerah', '2023', 'sedang_digunakan'],
            ['D 1567 MNO', 'Toyota Alphard 2.5G', 'Minibus', 'Wali Kota', '2022', 'sedang_digunakan'],
            ['D 1789 PQR', 'Toyota Camry Hybrid', 'Sedan', 'Wakil Wali Kota', '2022', 'tersedia'],
            ['D 1890 STU', 'Isuzu Elf Microbus', 'Microbus', 'Tim Liputan Humas', '2021', 'tersedia'],
            ['D 1212 VWX', 'Honda PCX 160', 'Motor', 'Kurir / Administrasi', '2023', 'tersedia'],
            ['D 1313 YZA', 'Yamaha NMAX 155', 'Motor', 'Petugas Protokol', '2022', 'sedang_digunakan'],
        ];

        foreach ($sampleKendaraan as $knd) {
            AsetKendaraan::firstOrCreate(['plat_nomor' => $knd[0]], [
                'nama_kendaraan' => $knd[1],
                'jenis' => $knd[2],
                'pemegang_pengguna' => $knd[3],
                'tahun' => $knd[4],
                'status' => $knd[5],
                'created_by' => $adminId,
            ]);
        }

        for ($i = 11; $i <= 24; $i++) {
            AsetKendaraan::firstOrCreate(
                ['plat_nomor' => sprintf('D %d %s', rand(1000, 9999), chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)))],
                [
                    'nama_kendaraan' => ['Toyota Avanza Veloz', 'Daihatsu Gran Max Box', 'Honda Vario 160', 'Toyota Rush GR'][rand(0, 3)],
                    'jenis' => ['Minibus', 'Microbus', 'Motor', 'SUV'][rand(0, 3)],
                    'pemegang_pengguna' => ['Staf Protokol', 'Staf Kepegawaian', 'Tim Media Sosial', '-'][rand(0, 3)],
                    'tahun' => (string)(2019 + rand(0, 4)),
                    'status' => ['tersedia', 'sedang_digunakan', 'perbaikan'][rand(0, 2)],
                    'created_by' => $adminId,
                ]
            );
        }
    }
}
