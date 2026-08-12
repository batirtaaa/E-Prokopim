<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Kegiatan;
use App\Models\Personel;
use App\Models\Penugasan;
use App\Models\Arahan;
use App\Models\Arsip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Budi Santoso, S.STP., M.Si.',
            'nip' => '19850720200501 1 003',
            'username' => 'admin',
            'email' => 'admin.prokopim@bandung.go.id',
            'phone' => '0812-3456-7890',
            'jabatan' => 'Administrator Prokopim',
            'role' => 'super_admin',
            'password' => Hash::make('admin123'),
            'is_active' => true,
        ]);

        // Operator Users
        $op1 = User::create([
            'name' => 'Siti Nurhayati',
            'nip' => '19900101201001 2 001',
            'username' => 'siti.n',
            'email' => 'siti.n@bandung.go.id',
            'phone' => '0813-1111-2222',
            'jabatan' => 'Protokol / MC',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        $op2 = User::create([
            'name' => 'Budi Kurniawan',
            'nip' => '19880615201501 1 002',
            'username' => 'budi.k',
            'email' => 'budi.k@bandung.go.id',
            'phone' => '0814-2222-3333',
            'jabatan' => 'Fotografer',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        $op3 = User::create([
            'name' => 'Fajar Nugraha',
            'nip' => '19921020201601 1 003',
            'username' => 'fajar.n',
            'email' => 'fajar.n@bandung.go.id',
            'phone' => '0815-3333-4444',
            'jabatan' => 'Videografer',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        $op4 = User::create([
            'name' => 'Dina Wulandari',
            'nip' => '19951215202001 2 004',
            'username' => 'dina.w',
            'email' => 'dina.w@bandung.go.id',
            'phone' => '0816-4444-5555',
            'jabatan' => 'Notulis',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        $op5 = User::create([
            'name' => 'Rizky Ramadhan',
            'nip' => '19940315202001 1 005',
            'username' => 'rizky.r',
            'email' => 'rizky.r@bandung.go.id',
            'phone' => '0817-5555-6666',
            'jabatan' => 'Fotografer',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        $op6 = User::create([
            'name' => 'Andi Pratama',
            'nip' => '19910822201801 1 006',
            'username' => 'andi.p',
            'email' => 'andi.p@bandung.go.id',
            'phone' => '0818-6666-7777',
            'jabatan' => 'Protokol',
            'role' => 'operator',
            'password' => Hash::make('password123'),
        ]);

        // Instansi
        Instansi::create([
            'nama_instansi' => 'Bagian Protokol dan Komunikasi Pimpinan',
            'pemerintah_daerah' => 'Pemerintah Kota Bandung',
            'alamat_lengkap' => 'Jl. Wastukencana No.2, Babakan Ciamis, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40117',
            'email_kontak' => 'prokopim@bandung.go.id',
            'nomor_telepon' => '(022) 4208000',
        ]);

        // Personel
        $p1 = Personel::create(['user_id' => $op1->id, 'nama_lengkap' => 'Siti Nurhayati', 'nip' => '19900101201001 2 001', 'jabatan' => 'Protokol / MC', 'bidang' => 'mc', 'phone' => '0813-1111-2222', 'status_ketersediaan' => 'bertugas']);
        $p2 = Personel::create(['user_id' => $op2->id, 'nama_lengkap' => 'Budi Kurniawan', 'nip' => '19880615201501 1 002', 'jabatan' => 'Fotografer', 'bidang' => 'fotografer', 'phone' => '0814-2222-3333', 'status_ketersediaan' => 'standby']);
        $p3 = Personel::create(['user_id' => $op3->id, 'nama_lengkap' => 'Fajar Nugraha', 'nip' => '19921020201601 1 003', 'jabatan' => 'Videografer', 'bidang' => 'videografer', 'phone' => '0815-3333-4444', 'status_ketersediaan' => 'bertugas']);
        $p4 = Personel::create(['user_id' => $op4->id, 'nama_lengkap' => 'Dina Wulandari', 'nip' => '19951215202001 2 004', 'jabatan' => 'Notulis', 'bidang' => 'notulis', 'phone' => '0816-4444-5555', 'status_ketersediaan' => 'cuti']);
        $p5 = Personel::create(['user_id' => $op5->id, 'nama_lengkap' => 'Rizky Ramadhan', 'nip' => '19940315202001 1 005', 'jabatan' => 'Fotografer', 'bidang' => 'fotografer', 'phone' => '0817-5555-6666', 'status_ketersediaan' => 'bertugas']);
        $p6 = Personel::create(['user_id' => $op6->id, 'nama_lengkap' => 'Andi Pratama', 'nip' => '19910822201801 1 006', 'jabatan' => 'Protokol', 'bidang' => 'protokol', 'phone' => '0818-6666-7777', 'status_ketersediaan' => 'bertugas']);

        // Kegiatan
        $k1 = Kegiatan::create([
            'judul' => 'Rapat Koordinasi Pengelolaan Sampah',
            'deskripsi' => 'Rapat koordinasi lintas dinas terkait pengelolaan sampah Kota Bandung',
            'lokasi' => 'Balai Kota Bandung',
            'tanggal_mulai' => Carbon::today()->setTime(9, 30),
            'tanggal_selesai' => Carbon::today()->setTime(12, 0),
            'pimpinan' => 'wali_kota',
            'status' => 'berlangsung',
            'kategori' => 'rapat',
            'created_by' => $admin->id,
        ]);

        $k2 = Kegiatan::create([
            'judul' => 'Audiensi UMKM Lokal',
            'deskripsi' => 'Audiensi dengan perwakilan UMKM lokal Kota Bandung',
            'lokasi' => 'Pendopo Kota Bandung',
            'tanggal_mulai' => Carbon::today()->setTime(13, 0),
            'tanggal_selesai' => Carbon::today()->setTime(15, 0),
            'pimpinan' => 'wakil_wali_kota',
            'status' => 'terjadwal',
            'kategori' => 'audiensi',
            'created_by' => $admin->id,
        ]);

        $k3 = Kegiatan::create([
            'judul' => 'Peresmian Taman Kota Tegalega',
            'deskripsi' => 'Peresmian revitalisasi Taman Kota Tegalega',
            'lokasi' => 'Taman Tegalega, Bandung',
            'tanggal_mulai' => Carbon::tomorrow()->setTime(9, 0),
            'tanggal_selesai' => Carbon::tomorrow()->setTime(11, 0),
            'pimpinan' => 'wali_kota',
            'status' => 'terjadwal',
            'kategori' => 'peresmian',
            'created_by' => $admin->id,
        ]);

        // More kegiatan for this month statistics
        for ($i = 1; $i <= 10; $i++) {
            Kegiatan::create([
                'judul' => "Kegiatan Rutin {$i}",
                'lokasi' => 'Balai Kota Bandung',
                'tanggal_mulai' => Carbon::now()->subDays($i)->setTime(9, 0),
                'pimpinan' => ['wali_kota', 'wakil_wali_kota', 'sekda'][rand(0, 2)],
                'status' => 'selesai',
                'kategori' => ['rapat', 'kunjungan', 'acara', 'audiensi'][rand(0, 3)],
                'created_by' => $admin->id,
            ]);
        }

        // Penugasan
        Penugasan::create(['kegiatan_id' => $k1->id, 'personel_id' => $p6->id, 'peran' => 'Protokol', 'status' => 'dikonfirmasi', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k1->id, 'personel_id' => $p5->id, 'peran' => 'Fotografer', 'status' => 'dikonfirmasi', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k2->id, 'personel_id' => $p1->id, 'peran' => 'MC', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k2->id, 'personel_id' => $p3->id, 'peran' => 'Videografer', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k3->id, 'personel_id' => $p6->id, 'peran' => 'Protokol', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k3->id, 'personel_id' => $p2->id, 'peran' => 'Fotografer', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k3->id, 'personel_id' => $p3->id, 'peran' => 'Videografer', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);
        Penugasan::create(['kegiatan_id' => $k3->id, 'personel_id' => $p1->id, 'peran' => 'MC', 'status' => 'ditugaskan', 'assigned_by' => $admin->id]);

        // More penugasan
        for ($i = 1; $i <= 4; $i++) {
            Penugasan::create([
                'kegiatan_id' => rand($k1->id, $k3->id),
                'personel_id' => rand($p1->id, $p6->id),
                'peran' => ['Protokol', 'MC', 'Dokumentasi'][rand(0, 2)],
                'status' => 'ditugaskan',
                'assigned_by' => $admin->id,
            ]);
        }

        // Arahan Pimpinan
        Arahan::create([
            'nomor_arahan' => 'AR/001/2026',
            'judul' => 'Percepatan Digitalisasi Layanan Publik',
            'isi_arahan' => 'Seluruh OPD agar segera melakukan transformasi digital pada pelayanan publik sesuai dengan roadmap Smart City Kota Bandung.',
            'pimpinan' => 'wali_kota',
            'ditujukan_kepada' => 'Seluruh OPD Kota Bandung',
            'tanggal_arahan' => Carbon::now()->subDays(5),
            'deadline' => Carbon::now()->addDays(30),
            'prioritas' => 'tinggi',
            'status' => 'sedang_berjalan',
            'created_by' => $admin->id,
        ]);

        Arahan::create([
            'nomor_arahan' => 'AR/002/2026',
            'judul' => 'Peningkatan Kualitas Dokumentasi Kegiatan',
            'isi_arahan' => 'Tim dokumentasi agar meningkatkan kualitas foto dan video kegiatan pimpinan, menggunakan standar yang telah ditetapkan.',
            'pimpinan' => 'sekda',
            'ditujukan_kepada' => 'Bagian Protokol dan Komunikasi Pimpinan',
            'tanggal_arahan' => Carbon::now()->subDays(10),
            'deadline' => Carbon::now()->subDays(3),
            'prioritas' => 'urgent',
            'status' => 'melewati_deadline',
            'created_by' => $admin->id,
        ]);

        // Arsip data
        for ($i = 1; $i <= 10; $i++) {
            Arsip::create([
                'nomor_arsip' => sprintf('ARS/%03d/2026', $i),
                'judul' => "Dokumen Arsip {$i}",
                'deskripsi' => "Deskripsi arsip nomor {$i}",
                'kategori' => ['surat_masuk', 'surat_keluar', 'sk', 'laporan', 'foto'][rand(0, 4)],
                'file_path' => "arsip/dummy_{$i}.pdf",
                'file_name' => "dokumen_{$i}.pdf",
                'file_size' => rand(100000, 5000000),
                'file_type' => 'application/pdf',
                'tanggal_dokumen' => Carbon::now()->subDays(rand(1, 100)),
                'tahun' => '2026',
                'status' => 'aktif',
                'uploaded_by' => $admin->id,
            ]);
        }

        // Login History
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '192.168.1.105', 'perangkat' => 'Chrome on Windows', 'status' => 'berhasil', 'login_at' => Carbon::parse('2023-10-24 08:15:00')]);
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '114.125.xx.xx', 'perangkat' => 'Safari on iPhone', 'status' => 'berhasil', 'login_at' => Carbon::parse('2023-10-23 17:30:00')]);
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '10.8.0.42', 'perangkat' => 'Firefox on macOS', 'status' => 'gagal', 'login_at' => Carbon::parse('2023-10-20 09:00:00')]);
    }
}
