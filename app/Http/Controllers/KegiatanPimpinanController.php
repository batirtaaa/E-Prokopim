<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\GaleriArsip;
use App\Services\FileNamingService;
use App\Exports\KegiatanPimpinanRekapExport;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KegiatanPimpinanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::query()->orderBy('tanggal_mulai', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nomor_agenda', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('leading_sektor', 'like', '%' . $search . '%');
            });
        }

        $kegiatan = $query->withCount([
            'galeriArsip as foto_count'      => fn($q) => $q->where('tipe', 'foto'),
            'galeriArsip as video_count'     => fn($q) => $q->where('tipe', 'video'),
            'galeriArsip as notulensi_count' => fn($q) => $q->where('tipe', 'notulensi'),
        ])->paginate(10)->withQueryString();

        $dbYears = Kegiatan::whereNotNull('tanggal_mulai')
            ->selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()->pluck('tahun')->map(fn($y) => (int)$y)->toArray();
        $currentYear    = (int) now()->year;
        $defaultRange   = range($currentYear - 3, $currentYear + 1);
        $availableYears = collect(array_merge($defaultRange, $dbYears))->unique()->sortDesc()->values();
        $selectedTahun  = $currentYear;

        return view('kegiatan-pimpinan.index', compact('kegiatan', 'availableYears', 'selectedTahun'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kegiatan.');
        }
        $today = date('Ymd');
        $countToday = Kegiatan::whereDate('created_at', Carbon::today())->count() + 1;
        $nomorAgenda = 'AG-' . $today . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        return view('kegiatan-pimpinan.create', compact('nomorAgenda'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kegiatan.');
        }
        $request->validate([
            'nama_kegiatan'  => 'required|string|max:255',
            'leading_sektor' => 'nullable|string|max:255',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'nullable',
            'lokasi'         => 'required|string',
            'pimpinan'       => 'nullable|array',
            'keterangan'     => 'nullable|string',
            'nomor_agenda'   => 'nullable|string|max:100',
            'dok_foto.*'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
            'dok_video.*'      => 'nullable|file|mimes:mp4,mov,avi|max:512000',
            'dok_notulensi.*'  => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200',
        ]);

        $lokasiMap = [
            'pendopo'     => 'Pendopo Kota Bandung',
            'balai_kota'  => 'Balai Kota Bandung',
            'gedung_dprd' => 'Gedung DPRD Kota Bandung',
        ];
        if ($request->lokasi === 'lainnya') {
            $lokasiName = trim($request->lokasi_custom) ?: 'Lainnya';
        } else {
            $lokasiName = $lokasiMap[$request->lokasi] ?? $request->lokasi;
        }

        if ($request->leading_sektor === 'lainnya') {
            $leadingSektor = trim($request->leading_sektor_custom) ?: 'Lainnya';
        } else {
            $leadingSektor = $request->leading_sektor;
        }

        $tanggalMulai = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $tanggalSelesai = $request->filled('waktu_selesai')
            ? Carbon::parse($request->tanggal . ' ' . $request->waktu_selesai)
            : null;

        $action = $request->input('action');
        $status = ($action === 'draft') ? 'draft' : 'terjadwal';

        $nomorAgenda = $request->input('nomor_agenda') ?: 'AG-' . date('Ymd') . '-' . str_pad(Kegiatan::count() + 1, 3, '0', STR_PAD_LEFT);

        $kegiatan = Kegiatan::create([
            'nomor_agenda'    => $nomorAgenda,
            'judul'           => $request->nama_kegiatan,
            'leading_sektor'  => $leadingSektor,
            'deskripsi'       => $request->keterangan,
            'lokasi'          => $lokasiName,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'pimpinan'        => $request->input('pimpinan', []),
            'status'          => $status,
            'kategori'        => 'rapat',
            'created_by'      => Auth::id(),
        ]);

        // Kirim notifikasi ke semua user jika bukan draft
        if ($status !== 'draft') {
            $tanggalLabel = $tanggalMulai->translatedFormat('d F Y, H:i');
            $instansiInfo = $kegiatan->leading_sektor ? " ({$kegiatan->leading_sektor})" : "";
            NotifikasiController::createForAllUsers(
                '📅 Kegiatan Baru: ' . $kegiatan->judul . $instansiInfo,
                "Kegiatan baru telah dijadwalkan di {$lokasiName} pada {$tanggalLabel}.",
                'kegiatan',
                route('kegiatan-pimpinan.index')
            );
        }

        // Simpan dokumentasi (foto/video/notulensi) ke galeri_arsip
        $this->saveDokumentasi($request, $kegiatan);

        return redirect()->route('kegiatan-pimpinan.success', $kegiatan);
    }

    /**
     * Simpan file dokumentasi dari form kegiatan ke tabel galeri_arsip
     */
    private function saveDokumentasi(Request $request, Kegiatan $kegiatan): void
    {
        $tanggal = $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('Y-m-d') : now()->format('Y-m-d');

        $tipeMap = [
            'foto'      => ['field' => 'dok_foto',      'judul_field' => 'dok_foto_judul',      'jumlah_field' => 'dok_foto_jumlah',   'durasi_field' => null],
            'video'     => ['field' => 'dok_video',     'judul_field' => 'dok_video_judul',     'jumlah_field' => null,                'durasi_field' => 'dok_video_durasi'],
            'notulensi' => ['field' => 'dok_notulensi', 'judul_field' => 'dok_notulensi_judul', 'jumlah_field' => null,                'durasi_field' => null],
        ];

        foreach ($tipeMap as $tipe => $cfg) {
            if (!$request->hasFile($cfg['field'])) continue;

            $files  = $request->file($cfg['field']);
            $judul  = trim($request->input($cfg['judul_field'], ''));
            $jumlah = $cfg['jumlah_field'] ? (int) $request->input($cfg['jumlah_field'], 1) : 1;
            $durasi = $cfg['durasi_field'] ? (int) $request->input($cfg['durasi_field'], 0) : null;

            // Konversi durasi menit -> detik
            $durasiDetik = ($durasi && $durasi > 0) ? $durasi * 60 : null;

            $fileIdx = 1;
            foreach ($files as $file) {
                if (!$file->isValid()) continue;

                $suffix = ($tipe === 'foto') ? (count($files) > 1 ? "Foto_{$fileIdx}" : 'Foto') : ($tipe === 'video' ? 'Video' : 'Notulensi');
                $isoName = FileNamingService::formatIsoFileName(
                    $tanggal,
                    $kegiatan->judul,
                    $file->getClientOriginalExtension(),
                    $suffix
                );
                $fileName = FileNamingService::ensureUniqueName('galeri-arsip', $isoName);
                $filePath = $file->storeAs('galeri-arsip', $fileName, 'public');
                $fileIdx++;

                $judulFinal = $judul ?: ($tipe === 'foto' ? 'Foto ' : ($tipe === 'video' ? 'Video ' : 'Notulensi ')) . $kegiatan->judul;

                GaleriArsip::create([
                    'kode'             => GaleriArsip::generateKode(),
                    'judul'            => $judulFinal,
                    'instansi'         => $kegiatan->leading_sektor,
                    'tipe'             => $tipe,
                    'akses'            => 'internal',
                    'file_path'        => $filePath,
                    'file_name'        => $fileName,
                    'jumlah_foto'      => ($tipe === 'foto') ? max(1, $jumlah) : 1,
                    'durasi_detik'     => $durasiDetik,
                    'keterangan'       => null,
                    'keywords'         => null,
                    'tanggal_kegiatan' => $tanggal,
                    'kegiatan_id'      => $kegiatan->id,
                    'created_by'       => Auth::id(),
                ]);
            }
        }
    }

    public function success(Kegiatan $kegiatan)
    {
        return view('kegiatan-pimpinan.success', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kegiatan.');
        }
        $kegiatan->load('galeriArsip');
        return view('kegiatan-pimpinan.create', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kegiatan.');
        }
        $request->validate([
            'nama_kegiatan'         => 'required|string|max:255',
            'leading_sektor'        => 'nullable|string|max:255',
            'leading_sektor_custom' => 'nullable|string|max:255',
            'tanggal'               => 'required|date',
            'waktu_mulai'           => 'required',
            'waktu_selesai'         => 'nullable',
            'lokasi'                => 'required|string',
            'pimpinan'              => 'nullable|array',
            'keterangan'            => 'nullable|string',
            'dok_foto.*'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
            'dok_video.*'           => 'nullable|file|mimes:mp4,mov,avi|max:512000',
            'dok_notulensi.*'       => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:51200',
        ]);

        $lokasiMap = [
            'pendopo'     => 'Pendopo Kota Bandung',
            'balai_kota'  => 'Balai Kota Bandung',
            'gedung_dprd' => 'Gedung DPRD Kota Bandung',
        ];
        if ($request->lokasi === 'lainnya') {
            $lokasiName = trim($request->lokasi_custom) ?: 'Lainnya';
        } else {
            $lokasiName = $lokasiMap[$request->lokasi] ?? $request->lokasi;
        }

        if ($request->leading_sektor === 'lainnya') {
            $leadingSektor = trim($request->leading_sektor_custom) ?: 'Lainnya';
        } else {
            $leadingSektor = $request->leading_sektor;
        }

        $tanggalMulai = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $tanggalSelesai = $request->filled('waktu_selesai')
            ? Carbon::parse($request->tanggal . ' ' . $request->waktu_selesai)
            : null;

        $kegiatan->update([
            'judul'           => $request->nama_kegiatan,
            'leading_sektor'  => $leadingSektor,
            'deskripsi'       => $request->keterangan,
            'lokasi'          => $lokasiName,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'pimpinan'        => $request->input('pimpinan', []),
        ]);

        // Tambahkan dokumentasi baru jika ada file yang diunggah
        $this->saveDokumentasi($request, $kegiatan);

        return redirect()->route('kegiatan-pimpinan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus kegiatan.');
        }
        $kegiatan->delete();
        return redirect()->route('kegiatan-pimpinan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus kegiatan.');
        }

        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            $count = count($ids);
            Kegiatan::whereIn('id', $ids)->delete();
            return redirect()->route('kegiatan-pimpinan.index')
                ->with('success', "{$count} kegiatan berhasil dihapus secara bersamaan.");
        }

        return redirect()->route('kegiatan-pimpinan.index')
            ->with('warning', 'Tidak ada kegiatan yang dipilih.');
    }

    /**
     * Export rekap kegiatan per bulan ke Excel
     */
    public function exportRekap(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);
        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) now()->year;
        }

        $export = new KegiatanPimpinanRekapExport($tahun);
        return $export->download();
    }
}
