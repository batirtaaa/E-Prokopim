<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kegiatan;

echo "Total kegiatan before: " . Kegiatan::count() . "\n";

$k = Kegiatan::create([
    'nomor_agenda' => 'AG-TEST-001',
    'judul' => 'Uji Coba Simpan Publikasi Kegiatan Pimpinan',
    'deskripsi' => 'Pengujian integrasi database',
    'lokasi' => 'Balai Kota Bandung',
    'tanggal_mulai' => now(),
    'tanggal_selesai' => now()->addHours(2),
    'pimpinan' => ['wali_kota', 'sekda'],
    'status' => 'terjadwal',
    'kategori' => 'rapat',
]);

echo "Created ID: " . $k->id . "\n";
echo "Nomor Agenda: " . $k->nomor_agenda . "\n";
echo "Pimpinan Badges: " . json_encode($k->pimpinan_badges) . "\n";
echo "Pimpinan Label: " . $k->pimpinan_label . "\n";
echo "Total kegiatan after: " . Kegiatan::count() . "\n";
