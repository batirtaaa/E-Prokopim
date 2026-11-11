<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileNamingService
{
    /**
     * Format penamaan file foto dan dokumen sesuai standar ISO yang diterapkan:
     * Format: Tanggal_Bulan_Tahun_Nama Kegiatan
     * Contoh: 11_11_2026_Rapat_Koordinasi_Pimpinan.jpg
     *
     * @param string|\DateTimeInterface|null $tanggal Tanggal kegiatan/dokumen
     * @param string|null $namaKegiatan Nama kegiatan atau judul dokumen
     * @param string $extension Ekstensi file (contoh: 'jpg', 'pdf', 'png', 'docx')
     * @param string|null $suffix Keterangan tambahan opsional (contoh: 'Paparan', 'Foto_1')
     * @return string
     */
    public static function formatIsoFileName($tanggal, ?string $namaKegiatan, string $extension, ?string $suffix = null): string
    {
        // 1. Tanggal_Bulan_Tahun (Format ISO d_m_Y)
        try {
            $datePart = $tanggal ? Carbon::parse($tanggal)->format('d_m_Y') : now()->format('d_m_Y');
        } catch (\Exception $e) {
            $datePart = now()->format('d_m_Y');
        }

        // 2. Pembersihan & Standardisasi Nama Kegiatan
        $cleanKegiatan = trim($namaKegiatan ?? 'Kegiatan');
        
        // Hapus karakter yang tidak diperbolehkan pada nama file di berbagai OS (\ / : * ? " < > |)
        $cleanKegiatan = preg_replace('/[\\\\\\/:*?"<>|]/u', '', $cleanKegiatan);
        
        // Ubah spasi ganda atau pemisah menjadi underscore (_) agar rapi dan kompatibel
        $cleanKegiatan = preg_replace('/\s+/', '_', trim($cleanKegiatan));
        $cleanKegiatan = trim($cleanKegiatan, '_-');

        if (empty($cleanKegiatan)) {
            $cleanKegiatan = 'Dokumentasi_Kegiatan';
        }

        // Batasi panjang maksimal nama kegiatan agar tidak melampaui batas filesystem (maks 100 karakter)
        $cleanKegiatan = Str::limit($cleanKegiatan, 100, '');
        $cleanKegiatan = rtrim($cleanKegiatan, '._-');

        // 3. Suffix (Keterangan tambahan jika ada, misal: Paparan, Notulensi, dsb.)
        $suffixPart = '';
        if (!empty($suffix)) {
            $cleanSuffix = preg_replace('/[\\\\\\/:*?"<>|\s]/u', '_', trim($suffix));
            $suffixPart = '_' . trim($cleanSuffix, '_');
        }

        // 4. Ekstensi file
        $ext = ltrim($extension, '.');
        $ext = strtolower($ext);

        return "{$datePart}_{$cleanKegiatan}{$suffixPart}.{$ext}";
    }

    /**
     * Memastikan nama file tidak menimpa file yang sudah ada di storage disk.
     * Jika sudah ada nama file yang sama, ditambahkan penomoran otomatis (_1, _2, dst.)
     *
     * @param string $directory Direktori storage (misal: 'galeri-arsip', 'dokumentasi')
     * @param string $filename Nama file yang diinginkan
     * @param string $disk Disk storage (default: 'public')
     * @return string Nama file unik yang aman digunakan
     */
    public static function ensureUniqueName(string $directory, string $filename, string $disk = 'public'): string
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

        $finalName = $filename;
        $counter = 1;

        $dirPrefix = trim($directory, '/');

        while (Storage::disk($disk)->exists($dirPrefix . '/' . $finalName)) {
            $finalName = "{$nameWithoutExt}_{$counter}.{$ext}";
            $counter++;
        }

        return $finalName;
    }
}

