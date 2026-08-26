<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;
use App\Models\User;
use Carbon\Carbon;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $sampleKeuangan = [
            [
                'no_bukti' => 'TRX-2023-001',
                'tanggal' => '2023-10-15',
                'uraian' => 'Belanja Konsumsi Rapat Koordinasi Pimpinan Wilayah Kota Bandung',
                'kategori' => 'Jamuan Tamu',
                'jenis' => 'pengeluaran',
                'nominal' => 4750000,
                'penanggung_jawab' => 'Budi Santoso, S.IP., M.Si.',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-002',
                'tanggal' => '2023-10-18',
                'uraian' => 'Biaya Perjalanan Dinas Tim Protokol Kunjungan Kerja ke Jakarta',
                'kategori' => 'Perjalanan Dinas',
                'jenis' => 'pengeluaran',
                'nominal' => 12500000,
                'penanggung_jawab' => 'Rizky Ramadhan, S.STP',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-003',
                'tanggal' => '2023-10-20',
                'uraian' => 'Honorarium Master of Ceremony (MC) Acara Peringatan Hari Jadi Kota Bandung',
                'kategori' => 'Honorarium',
                'jenis' => 'pengeluaran',
                'nominal' => 3500000,
                'penanggung_jawab' => 'Maya Indah Sari, S.I.Kom',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-004',
                'tanggal' => '2023-10-22',
                'uraian' => 'Pengadaan Perlengkapan Audio Visual & Live Streaming Pimpinan',
                'kategori' => 'Operasional',
                'jenis' => 'pengeluaran',
                'nominal' => 18250000,
                'penanggung_jawab' => 'Ahmad Hidayat, S.Kom.',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-005',
                'tanggal' => '2023-10-24',
                'uraian' => 'Pemeliharaan Rutin Kamera & Peralatan Dokumentasi Liputan Pimpinan',
                'kategori' => 'Pemeliharaan',
                'jenis' => 'pengeluaran',
                'nominal' => 2800000,
                'penanggung_jawab' => 'Fajar Nugraha',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-006',
                'tanggal' => '2023-10-25',
                'uraian' => 'Belanja Bahan Cetak Buku Panduan Protokol & Agenda Resmi Pemkot',
                'kategori' => 'Publikasi',
                'jenis' => 'pengeluaran',
                'nominal' => 6400000,
                'penanggung_jawab' => 'Siti Rahmawati, S.E.',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-007',
                'tanggal' => '2023-10-28',
                'uraian' => 'Operasional BBM & Tol Kendaraan Dinas Protokol Pimpinan',
                'kategori' => 'Operasional',
                'jenis' => 'pengeluaran',
                'nominal' => 3200000,
                'penanggung_jawab' => 'Kabag Protokol',
                'status' => 'selesai',
            ],
            [
                'no_bukti' => 'TRX-2023-008',
                'tanggal' => '2023-10-30',
                'uraian' => 'Honorarium Notulis Rapat Terbatas Wali Kota & Forum Forkopimda',
                'kategori' => 'Honorarium',
                'jenis' => 'pengeluaran',
                'nominal' => 1500000,
                'penanggung_jawab' => 'Dewi Lestari',
                'status' => 'selesai',
            ],
        ];

        foreach ($sampleKeuangan as $item) {
            Keuangan::firstOrCreate(
                ['no_bukti' => $item['no_bukti']],
                array_merge($item, ['created_by' => $adminId])
            );
        }

        // Additional transactions up to 35
        $kategoriList = ['Operasional', 'Perjalanan Dinas', 'Jamuan Tamu', 'Honorarium', 'Pemeliharaan', 'Publikasi'];
        $uraianSamples = [
            'Biaya Konsumsi Snack Box Penerimaan Kunjungan Studi Banding',
            'Sewa Kendaraan Tambahan Pengawalan Tamu VIP Asing',
            'Penggantian Suku Cadang & Servis Berkala Mobil Dinas Hiace',
            'Langganan Jaringan Internet dedicated Media Center Prokopim',
            'Honorarium Petugas Live Broadcasting Sidang Paripurna',
            'Belanja ATK dan Kertas Cetak Sambutan Pimpinan Triwulan IV',
            'Produksi Video Dokumenter Kilas Balik Pembangunan Kota Bandung',
            'Pengadaan Seragam Petugas Protokol Lapangan',
            'Bantuan Transportasi Petugas Liputan Luar Gedung',
        ];

        for ($i = 9; $i <= 35; $i++) {
            $kat = $kategoriList[rand(0, count($kategoriList) - 1)];
            $ur = $uraianSamples[rand(0, count($uraianSamples) - 1)] . " #{$i}";
            $nom = rand(5, 150) * 100000;
            $st = ['selesai', 'selesai', 'selesai', 'pending', 'proses', 'draft'][rand(0, 5)];

            Keuangan::firstOrCreate(
                ['no_bukti' => sprintf('TRX-2023-%03d', $i)],
                [
                    'tanggal' => Carbon::parse('2023-10-01')->addDays($i),
                    'uraian' => $ur,
                    'kategori' => $kat,
                    'jenis' => 'pengeluaran',
                    'nominal' => $nom,
                    'penanggung_jawab' => ['Budi Santoso, S.IP., M.Si.', 'Siti Rahmawati, S.E.', 'Ahmad Hidayat, S.Kom.', 'Rizky Ramadhan, S.STP'][rand(0, 3)],
                    'status' => $st,
                    'created_by' => $adminId,
                ]
            );
        }
    }
}
