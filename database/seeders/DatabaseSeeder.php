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

        // Arsip data (Mockup match)
        $sitiAminah = User::firstOrCreate(['email' => 'siti.aminah@bandung.go.id'], [
            'name' => 'Siti Aminah',
            'nip' => '19920310201502 2 001',
            'username' => 'siti.aminah',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'jabatan' => 'Arsiparis',
            'phone' => '0812-9876-5432'
        ]);

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
                'uploaded_by' => $admin->id,
                'created_at' => Carbon::parse('2023-10-10 09:15:00'),
            ]
        );

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
                'uploaded_by' => $sitiAminah->id,
                'created_at' => Carbon::parse('2023-10-08 11:45:00'),
            ]
        );

        for ($i = 4; $i <= 45; $i++) {
            $cat = ['surat_masuk', 'surat_keluar', 'sk', 'nota_dinas', 'laporan', 'peraturan', 'lainnya'][rand(0, 6)];
            $isDocx = ($i % 3 === 0);
            $ext = $isDocx ? 'docx' : 'pdf';
            $mime = $isDocx ? 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : 'application/pdf';
            Arsip::create([
                'nomor_arsip' => sprintf('ARS/%03d/PROK/2023', $i),
                'judul' => "Dokumen Surat dan Laporan Administrasi Prokopim No. {$i}.{$ext}",
                'deskripsi' => "Deskripsi dan catatan dokumen arsip nomor {$i}",
                'kategori' => $cat,
                'file_path' => "arsip/sample_doc_{$i}.{$ext}",
                'file_name' => "dokumen_arsip_{$i}.{$ext}",
                'file_size' => rand(500000, 5000000),
                'file_type' => $mime,
                'tanggal_dokumen' => Carbon::now()->subDays($i),
                'tahun' => '2023',
                'status' => 'aktif',
                'uploaded_by' => ($i % 2 === 0) ? $admin->id : $sitiAminah->id,
                'created_at' => Carbon::now()->subDays($i)->setTime(rand(8, 16), rand(10, 50)),
            ]);
        }

        // Login History
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '192.168.1.105', 'perangkat' => 'Chrome on Windows', 'status' => 'berhasil', 'login_at' => Carbon::parse('2023-10-24 08:15:00')]);
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '114.125.xx.xx', 'perangkat' => 'Safari on iPhone', 'status' => 'berhasil', 'login_at' => Carbon::parse('2023-10-23 17:30:00')]);
        \App\Models\LoginHistory::create(['user_id' => $admin->id, 'ip_address' => '10.8.0.42', 'perangkat' => 'Firefox on macOS', 'status' => 'gagal', 'login_at' => Carbon::parse('2023-10-20 09:00:00')]);

        // Aset Barang (Inventaris)
        \App\Models\AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-001'], [
            'nama_barang' => 'Laptop Dell Latitude 5420',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-03-15',
            'lokasi' => 'Ruang Rapat Utama',
            'penanggung_jawab' => 'Budi Kurniawan',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-002'], [
            'nama_barang' => 'Meja Kerja Kayu Jati',
            'kategori' => 'Furnitur',
            'tanggal_perolehan' => '2023-01-20',
            'lokasi' => 'Ruang Kepala Bagian',
            'penanggung_jawab' => 'Siti Nurhayati',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-003'], [
            'nama_barang' => 'Kamera Sony A7 IV Mirrorless',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-04-10',
            'lokasi' => 'Studio Dokumentasi',
            'penanggung_jawab' => 'Fajar Nugraha',
            'kondisi' => 'baik',
            'status' => 'digunakan',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetBarang::firstOrCreate(['kode_aset' => 'INV-2023-004'], [
            'nama_barang' => 'Proyektor Epson EB-X500',
            'kategori' => 'Elektronik',
            'tanggal_perolehan' => '2023-02-14',
            'lokasi' => 'Ruang Rapat Tengah',
            'penanggung_jawab' => 'Andi Pratama',
            'kondisi' => 'baik',
            'status' => 'tersedia',
            'created_by' => $admin->id,
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
            \App\Models\AsetBarang::firstOrCreate(
                ['kode_aset' => sprintf('INV-2023-%03d', $i)],
                [
                    'nama_barang' => $nama,
                    'kategori' => $cat,
                    'tanggal_perolehan' => Carbon::parse('2023-01-01')->addDays($i * 5),
                    'lokasi' => $loc,
                    'penanggung_jawab' => ['Budi Kurniawan', 'Siti Nurhayati', 'Fajar Nugraha', 'Dina Wulandari'][rand(0, 3)],
                    'kondisi' => ['baik', 'baik', 'rusak_ringan'][rand(0, 2)],
                    'status' => ['tersedia', 'tersedia', 'digunakan', 'dipinjam'][rand(0, 3)],
                    'created_by' => $admin->id,
                ]
            );
        }

        // Aset Kendaraan Operasional
        \App\Models\AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1234 ABC'], [
            'nama_kendaraan' => 'Toyota Innova Zenix',
            'jenis' => 'Minibus',
            'pemegang_pengguna' => 'Kabag Protokol',
            'tahun' => '2023',
            'status' => 'sedang_digunakan',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1456 XYZ'], [
            'nama_kendaraan' => 'Toyota Hiace Premio',
            'jenis' => 'Microbus',
            'pemegang_pengguna' => 'Tim Dokumentasi',
            'tahun' => '2022',
            'status' => 'tersedia',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1990 DEF'], [
            'nama_kendaraan' => 'Mitsubishi Pajero Sport',
            'jenis' => 'SUV',
            'pemegang_pengguna' => 'Asisten Pemerintahan',
            'tahun' => '2021',
            'status' => 'sedang_digunakan',
            'created_by' => $admin->id,
        ]);

        \App\Models\AsetKendaraan::firstOrCreate(['plat_nomor' => 'D 1122 GHI'], [
            'nama_kendaraan' => 'Honda CR-V',
            'jenis' => 'SUV',
            'pemegang_pengguna' => '-',
            'tahun' => '2020',
            'status' => 'perbaikan',
            'created_by' => $admin->id,
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
            \App\Models\AsetKendaraan::firstOrCreate(['plat_nomor' => $knd[0]], [
                'nama_kendaraan' => $knd[1],
                'jenis' => $knd[2],
                'pemegang_pengguna' => $knd[3],
                'tahun' => $knd[4],
                'status' => $knd[5],
                'created_by' => $admin->id,
            ]);
        }

        for ($i = 11; $i <= 24; $i++) {
            \App\Models\AsetKendaraan::firstOrCreate(
                ['plat_nomor' => sprintf('D %d %s', rand(1000, 9999), chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)))],
                [
                    'nama_kendaraan' => ['Toyota Avanza Veloz', 'Daihatsu Gran Max Box', 'Honda Vario 160', 'Toyota Rush GR'][rand(0, 3)],
                    'jenis' => ['Minibus', 'Microbus', 'Motor', 'SUV'][rand(0, 3)],
                    'pemegang_pengguna' => ['Staf Protokol', 'Staf Kepegawaian', 'Tim Media Sosial', '-'][rand(0, 3)],
                    'tahun' => (string)(2019 + rand(0, 4)),
                    'status' => ['tersedia', 'sedang_digunakan', 'perbaikan'][rand(0, 2)],
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
