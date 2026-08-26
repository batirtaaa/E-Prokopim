<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Arsip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ArsipMockupSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin Prokopim',
            'nip' => '19850720200501 1 003',
            'username' => 'admin',
            'email' => 'admin.prokopim@bandung.go.id',
            'phone' => '0812-3456-7890',
            'jabatan' => 'Administrator Prokopim',
            'role' => 'super_admin',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ]);

        $budi = User::firstOrCreate(['email' => 'budi.santoso@bandung.go.id'], [
            'name' => 'Budi Santoso',
            'nip' => '19870815201001 1 004',
            'username' => 'budi.santoso',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'jabatan' => 'Pranata Humas',
            'phone' => '0813-2222-1111'
        ]);

        $siti = User::firstOrCreate(['email' => 'siti.aminah@bandung.go.id'], [
            'name' => 'Siti Aminah',
            'nip' => '19920310201502 2 001',
            'username' => 'siti.aminah',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'jabatan' => 'Arsiparis',
            'phone' => '0812-9876-5432'
        ]);

        // 1. Undangan Rapat Koordinasi Nasional Penyelenggaraan Pemerintahan Daerah.pdf
        Arsip::updateOrCreate(
            ['nomor_arsip' => 'B-123/PROK/2023'],
            [
                'judul' => 'Undangan Rapat Koordinasi Nasional Penyelenggaraan Pemerintahan Daerah.pdf',
                'deskripsi' => 'Undangan Rapat Koordinasi Nasional Penyelenggaraan Pemerintahan Daerah dari Kemendagri',
                'kategori' => 'surat_masuk',
                'file_path' => 'arsip/sample_undangan_rakornas.pdf',
                'file_name' => 'Undangan Rapat Koordinasi Nasional Penyelenggaraan Pemerintahan Daerah.pdf',
                'file_size' => 2450000,
                'file_type' => 'application/pdf',
                'tanggal_dokumen' => Carbon::parse('2023-10-12'),
                'tahun' => '2023',
                'uploaded_by' => $admin->id,
                'created_at' => Carbon::parse('2023-10-12 14:30:00'),
            ]
        );

        // 2. Pemberitahuan Pelaksanaan Pelatihan Kepemimpinan Tingkat IV.pdf
        Arsip::updateOrCreate(
            ['nomor_arsip' => '800/456-BKPSDM'],
            [
                'judul' => 'Pemberitahuan Pelaksanaan Pelatihan Kepemimpinan Tingkat IV.pdf',
                'deskripsi' => 'Pemberitahuan resmi pelaksanaan pelatihan kepemimpinan pengawas / tingkat IV tahun 2023',
                'kategori' => 'surat_masuk',
                'file_path' => 'arsip/sample_pelatihan_kepemimpinan.pdf',
                'file_name' => 'Pemberitahuan Pelaksanaan Pelatihan Kepemimpinan Tingkat IV.pdf',
                'file_size' => 1850000,
                'file_type' => 'application/pdf',
                'tanggal_dokumen' => Carbon::parse('2023-10-10'),
                'tahun' => '2023',
                'uploaded_by' => $budi->id,
                'created_at' => Carbon::parse('2023-10-10 09:15:00'),
            ]
        );

        // 3. Laporan Pertanggungjawaban Pelaksanaan APBD Tahun Anggaran 2022.docx
        Arsip::updateOrCreate(
            ['nomor_arsip' => '005/789/SETDA'],
            [
                'judul' => 'Laporan Pertanggungjawaban Pelaksanaan APBD Tahun Anggaran 2022.docx',
                'deskripsi' => 'Laporan Pertanggungjawaban Pelaksanaan APBD Sekretariat Daerah Kota Bandung Tahun Anggaran 2022',
                'kategori' => 'laporan',
                'file_path' => 'arsip/sample_lpj_apbd_2022.docx',
                'file_name' => 'Laporan Pertanggungjawaban Pelaksanaan APBD Tahun Anggaran 2022.docx',
                'file_size' => 3200000,
                'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'tanggal_dokumen' => Carbon::parse('2023-10-08'),
                'tahun' => '2023',
                'uploaded_by' => $siti->id,
                'created_at' => Carbon::parse('2023-10-08 11:45:00'),
            ]
        );
    }
}
