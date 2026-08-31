<?php

namespace App\Http\Controllers;

use App\Models\MediaSosial;
use App\Exports\MediaSosialRekapExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaSosialController extends Controller
{
    // Daftar sub-kategori baku untuk infografis (digunakan di form upload)
    const SUB_KATEGORI_LIST = [
        'hari_besar'    => 'Hari Besar',
        'obituary'      => 'Obituary',
        'kamis_nyunda'  => 'Kamis Nyunda',
        'giat_pimpinan' => 'Giat Pimpinan',
    ];

    // Nama bulan dalam Bahasa Indonesia
    const NAMA_BULAN = [
        1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
        4  => 'April',    5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',     8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',  11 => 'November',  12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'infografis');

        // Validasi tab yang diperbolehkan
        $validTabs = ['infografis', 'videografis', 'media_luar_ruang'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'infografis';
        }

        // Semua tab → tampilkan grid folder 12 bulan (konsisten untuk semua)
        $dbYears = MediaSosial::where('kategori', $tab)
            ->whereNotNull('tanggal_publikasi')
            ->selectRaw('YEAR(tanggal_publikasi) as tahun')
            ->distinct()
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->toArray();

        $currentYear  = (int) now()->year;
        $defaultRange = range($currentYear - 3, $currentYear + 1);
        $availableYears = collect(array_merge($defaultRange, $dbYears))
            ->unique()
            ->sortDesc()
            ->values();

        $selectedTahun = (int) $request->get('tahun', $currentYear);
        if (!$availableYears->contains($selectedTahun)) {
            $availableYears->push($selectedTahun);
            $availableYears = $availableYears->unique()->sortDesc()->values();
        }

        // Hitung jumlah item per bulan untuk tahun terpilih
        $countsByMonth = MediaSosial::where('kategori', $tab)
            ->whereYear('tanggal_publikasi', $selectedTahun)
            ->selectRaw('MONTH(tanggal_publikasi) as bulan, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal_publikasi)')
            ->pluck('total', 'bulan')
            ->toArray();

        // Bangun 12 bulan lengkap (Januari - Desember)
        $folders = collect(range(1, 12))->map(function ($bulan) use ($selectedTahun, $countsByMonth) {
            return [
                'tahun' => $selectedTahun,
                'bulan' => $bulan,
                'label' => self::NAMA_BULAN[$bulan] . ' ' . $selectedTahun,
                'total' => $countsByMonth[$bulan] ?? 0,
            ];
        });

        $items = collect();

        return view('sub-komunikasi-pimpinan.media-sosial.index', compact(
            'tab', 'folders', 'availableYears', 'selectedTahun', 'items'
        ));
    }


    /**
     * Tampilkan isi folder berdasarkan kategori, bulan & tahun
     */
    public function folderBulan(Request $request, string $kategori, int $tahun, int $bulan)
    {
        // Validasi parameter
        $validKategori = ['infografis', 'videografis', 'media_luar_ruang'];
        if (!in_array($kategori, $validKategori) || $bulan < 1 || $bulan > 12 || $tahun < 2000 || $tahun > 2100) {
            abort(404);
        }

        $namaBulan   = self::NAMA_BULAN[$bulan] ?? 'Bulan';
        $folderLabel = $namaBulan . ' ' . $tahun;

        $query = MediaSosial::where('kategori', $kategori)
            ->whereYear('tanggal_publikasi', $tahun)
            ->whereMonth('tanggal_publikasi', $bulan);

        // Filter per Sub-Kategori (hanya berlaku untuk infografis)
        if ($kategori === 'infografis' && $request->filled('kat')) {
            $kat = $request->kat;
            if ($kat === 'lainnya') {
                $bakuKeys = array_keys(self::SUB_KATEGORI_LIST);
                $query->where(function ($q) use ($bakuKeys) {
                    $q->whereNotIn('sub_kategori', $bakuKeys)
                      ->orWhereNull('sub_kategori')
                      ->orWhere('sub_kategori', '');
                });
            } else {
                $query->where('sub_kategori', $kat);
            }
        }

        // Search: judul, deskripsi, platform, tanggal
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('deskripsi', 'like', "%{$s}%")
                  ->orWhere('sub_kategori', 'like', "%{$s}%")
                  ->orWhere('platform', 'like', "%{$s}%")
                  ->orWhereRaw("DATE_FORMAT(tanggal_publikasi, '%d %M %Y') LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("DATE_FORMAT(tanggal_publikasi, '%d-%m-%Y') LIKE ?", ["%{$s}%"])
                  ->orWhereRaw("DATE_FORMAT(tanggal_publikasi, '%d/%m/%Y') LIKE ?", ["%{$s}%"])
                  ->orWhere('tanggal_publikasi', 'like', "%{$s}%");
            });
        }

        $query->orderBy('tanggal_publikasi', 'desc')->orderBy('created_at', 'desc');
        $items = $query->paginate(8)->withQueryString();

        $subKategoriList = self::SUB_KATEGORI_LIST;
        $namaBulanList   = self::NAMA_BULAN;

        // Hitung tahun yang tersedia untuk filter / navigasi
        $dbYears = MediaSosial::where('kategori', $kategori)
            ->whereNotNull('tanggal_publikasi')
            ->selectRaw('YEAR(tanggal_publikasi) as tahun')
            ->distinct()->pluck('tahun')->map(fn($y) => (int)$y)->toArray();
        $currentYear    = (int) now()->year;
        $defaultRange   = range($currentYear - 3, $currentYear + 1);
        $availableYears = collect(array_merge($defaultRange, $dbYears, [$tahun]))->unique()->sortDesc()->values();

        return view('sub-komunikasi-pimpinan.media-sosial.folder', compact(
            'items', 'kategori', 'tahun', 'bulan', 'folderLabel', 'subKategoriList', 'namaBulanList', 'availableYears'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah media.');
        }

        $request->validate([
            'judul'             => 'required|string|max:255',
            'kategori'          => 'required|in:infografis,videografis,media_luar_ruang',
            'sub_kategori'      => 'nullable|string|max:100',
            'platform'          => 'required|string|max:50',
            'deskripsi'         => 'nullable|string',
            'tanggal_publikasi' => 'required|date',
            'status'            => 'required|in:dipublikasi,draft,dijadwalkan',
            'file_media'        => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,pdf|max:25600',
            'link_post'         => 'nullable|string|max:500',
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file_media')) {
            $file     = $request->file('file_media');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('media-sosial', 'public');
        }

        // Proses sub_kategori: jika pilih lainnya_custom → pakai teks custom
        $subKategori = null;
        if ($request->kategori === 'infografis') {
            if ($request->sub_kategori === 'lainnya_custom') {
                $subKategori = trim($request->sub_kategori_custom) ?: 'lainnya';
            } else {
                $subKategori = $request->sub_kategori;
            }
        }

        // Proses platform: jika pilih lainnya → pakai teks custom
        $platform = $request->platform;
        if ($platform === 'lainnya') {
            $platform = trim($request->platform_custom) ?: 'lainnya';
        }

        $linkPost = $request->link_post ? trim($request->link_post) : null;
        if ($linkPost && !preg_match('~^(?:f|ht)tps?://~i', $linkPost)) {
            $linkPost = 'https://' . $linkPost;
        }

        MediaSosial::create([
            'judul'             => $request->judul,
            'kategori'          => $request->kategori,
            'sub_kategori'      => $subKategori,
            'platform'          => strtolower($platform),
            'deskripsi'         => $request->deskripsi,
            'file_path'         => $filePath,
            'file_name'         => $fileName,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'status'            => $request->status,
            'link_post'         => $linkPost,
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('media-sosial.index', ['tab' => $request->kategori])
            ->with('success', 'Media berhasil ditambahkan ke arsip.');
    }

    public function update(Request $request, MediaSosial $mediaSosial)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit media.');
        }

        $request->validate([
            'judul'             => 'required|string|max:255',
            'kategori'          => 'required|in:infografis,videografis,media_luar_ruang',
            'sub_kategori'      => 'nullable|string|max:100',
            'platform'          => 'required|string|max:50',
            'deskripsi'         => 'nullable|string',
            'tanggal_publikasi' => 'required|date',
            'status'            => 'required|in:dipublikasi,draft,dijadwalkan',
            'file_media'        => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,pdf|max:25600',
            'link_post'         => 'nullable|string|max:500',
        ]);

        $subKategori = $mediaSosial->sub_kategori;
        if ($request->kategori === 'infografis') {
            if ($request->sub_kategori === 'lainnya_custom') {
                $subKategori = trim($request->sub_kategori_custom) ?: 'lainnya';
            } else {
                $subKategori = $request->sub_kategori;
            }
        } else {
            $subKategori = null;
        }

        // Proses platform: jika pilih lainnya → pakai teks custom
        $platform = $request->platform;
        if ($platform === 'lainnya') {
            $platform = trim($request->platform_custom) ?: 'lainnya';
        }

        $linkPost = $request->link_post ? trim($request->link_post) : null;
        if ($linkPost && !preg_match('~^(?:f|ht)tps?://~i', $linkPost)) {
            $linkPost = 'https://' . $linkPost;
        }

        $data = [
            'judul'             => $request->judul,
            'kategori'          => $request->kategori,
            'sub_kategori'      => $subKategori,
            'platform'          => strtolower($platform),
            'deskripsi'         => $request->deskripsi,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'status'            => $request->status,
            'link_post'         => $linkPost,
        ];

        if ($request->hasFile('file_media')) {
            if ($mediaSosial->file_path) {
                Storage::disk('public')->delete($mediaSosial->file_path);
            }
            $file              = $request->file('file_media');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('media-sosial', 'public');
        }

        $mediaSosial->update($data);

        return redirect()->route('media-sosial.index', ['tab' => $request->kategori])
            ->with('success', 'Data arsip media berhasil diperbarui.');
    }

    public function destroy(MediaSosial $mediaSosial)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus media.');
        }

        $tab = $mediaSosial->kategori;
        if ($mediaSosial->file_path) {
            Storage::disk('public')->delete($mediaSosial->file_path);
        }
        $mediaSosial->delete();

        return redirect()->route('media-sosial.index', ['tab' => $tab])
            ->with('success', 'Media berhasil dihapus dari arsip.');
    }

    /**
     * Export rekap upload per bulan ke Excel (SpreadsheetML)
     */
    public function exportRekap(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);

        // Batasi tahun agar wajar
        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = now()->year;
        }

        $export = new MediaSosialRekapExport($tahun);
        return $export->download();
    }
}
