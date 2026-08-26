<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GaleriArsip;
use App\Models\User;

class GaleriArsipSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::first()?->id;

        $data = [
            [
                'kode'             => '#KG-231005',
                'judul'            => 'Peresmian Taman Kota Tahap II Bersama Wali Kota',
                'tipe'             => 'foto',
                'akses'            => 'publik',
                'jumlah_foto'      => 1,
                'keterangan'       => 'Dokumentasi foto peresmian taman kota tahap II',
                'tanggal_kegiatan' => '2023-10-12',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-231004',
                'judul'            => 'Konferensi Pers Evaluasi Kinerja Kuartal',
                'tipe'             => 'video',
                'akses'            => 'internal',
                'durasi_detik'     => 225,
                'jumlah_foto'      => 1,
                'keterangan'       => 'Rekaman video konferensi pers evaluasi kinerja Q3',
                'tanggal_kegiatan' => '2023-10-10',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230928',
                'judul'            => 'Rapat Paripurna DPRD Pembahasan Anggaran',
                'tipe'             => 'foto',
                'akses'            => 'publik',
                'jumlah_foto'      => 12,
                'keterangan'       => 'Album foto rapat paripurna pembahasan APBD',
                'tanggal_kegiatan' => '2023-09-28',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230915',
                'judul'            => 'Tinjauan Lapangan Proyek Infrastruktur Jalan Tol',
                'tipe'             => 'foto',
                'akses'            => 'internal',
                'jumlah_foto'      => 1,
                'keterangan'       => 'Dokumentasi kunjungan lapangan proyek infrastruktur',
                'tanggal_kegiatan' => '2023-09-15',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230901',
                'judul'            => 'Sosialisasi Program Ketahanan Pangan Daerah',
                'tipe'             => 'video',
                'akses'            => 'publik',
                'durasi_detik'     => 485,
                'jumlah_foto'      => 1,
                'keterangan'       => 'Video dokumentasi sosialisasi program ketahanan pangan',
                'tanggal_kegiatan' => '2023-09-01',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230820',
                'judul'            => 'Notulensi Rapat Koordinasi Pengembangan UMKM',
                'tipe'             => 'notulensi',
                'akses'            => 'internal',
                'jumlah_foto'      => 1,
                'keterangan'       => 'Dokumen notulensi rapat koordinasi UMKM',
                'tanggal_kegiatan' => '2023-08-20',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230810',
                'judul'            => 'Notulensi Forum Musyawarah Perencanaan Pembangunan',
                'tipe'             => 'notulensi',
                'akses'            => 'publik',
                'jumlah_foto'      => 1,
                'keterangan'       => 'Dokumen resmi Musrenbang tahun 2023',
                'tanggal_kegiatan' => '2023-08-10',
                'created_by'       => $adminId,
            ],
            [
                'kode'             => '#KG-230805',
                'judul'            => 'Kunjungan Kerja ke Sentra Industri Kreatif',
                'tipe'             => 'foto',
                'akses'            => 'publik',
                'jumlah_foto'      => 8,
                'keterangan'       => 'Album foto kunjungan kerja ke industri kreatif lokal',
                'tanggal_kegiatan' => '2023-08-05',
                'created_by'       => $adminId,
            ],
        ];

        foreach ($data as $item) {
            GaleriArsip::create($item);
        }
    }
}
