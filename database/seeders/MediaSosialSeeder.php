<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaSosial;
use App\Models\User;

class MediaSosialSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : null;

        $data = [
            // Infografis
            [
                'judul' => 'Capaian Kinerja Triwulan III 2023',
                'kategori' => 'infografis',
                'platform' => 'instagram',
                'deskripsi' => 'Ringkasan infografis mengenai pencapaian target kinerja pembangunan daerah...',
                'tanggal_publikasi' => '2023-10-24',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Alur Pelayanan Administrasi Kependudukan',
                'kategori' => 'infografis',
                'platform' => 'facebook',
                'deskripsi' => 'Edukasi warga terkait prosedur baru pembuatan izin dan administrasi...',
                'tanggal_publikasi' => '2023-10-20',
                'status' => 'draft',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Pertumbuhan Sektor Pariwisata',
                'kategori' => 'infografis',
                'platform' => 'website',
                'deskripsi' => 'Data tren kunjungan wisatawan domestik dan mancanegara tahun...',
                'tanggal_publikasi' => '2023-10-15',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
            // Videografis
            [
                'judul' => 'Highlight Penataan Ruang Terbuka Hijau',
                'kategori' => 'videografis',
                'platform' => 'youtube',
                'deskripsi' => 'Liputan dan rekapitulasi progres renovasi taman dan fasilitas umum kota.',
                'tanggal_publikasi' => '2023-10-22',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Sosialisasi Program Pengurangan Sampah',
                'kategori' => 'videografis',
                'platform' => 'tiktok',
                'deskripsi' => 'Video edukasi singkat gerakan pilah sampah dari sumbernya untuk generasi muda.',
                'tanggal_publikasi' => '2023-10-18',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
            // Media Luar Ruang
            [
                'judul' => 'Baliho Hari Jadi Kota Bandung ke-213',
                'kategori' => 'media_luar_ruang',
                'platform' => 'billboard',
                'deskripsi' => 'Desain materi billboard promosi rangkaian acara HUT Kota Bandung di titik-titik protokol.',
                'tanggal_publikasi' => '2023-10-12',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Videotron Layanan Darurat 112',
                'kategori' => 'media_luar_ruang',
                'platform' => 'videotron',
                'deskripsi' => 'Materi tayang LED Videotron simpang lima terkait nomor darurat respon cepat 24 jam.',
                'tanggal_publikasi' => '2023-10-10',
                'status' => 'dipublikasi',
                'created_by' => $adminId,
            ],
        ];

        foreach ($data as $item) {
            MediaSosial::create($item);
        }
    }
}
