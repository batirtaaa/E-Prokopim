<?php

namespace App\Http\Controllers;

use App\Models\GaleriArsip;
use App\Services\FileNamingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriArsipController extends Controller
{
    public function thumb($id)
    {
        $item = GaleriArsip::findOrFail($id);

        if (!$item->file_path || !Storage::disk('public')->exists($item->file_path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($item->file_path);
        $mime     = mime_content_type($fullPath) ?: 'image/jpeg';
        $base64   = base64_encode(file_get_contents($fullPath));

        // Kembalikan sebagai JSON agar IDM tidak bisa mencegat
        // IDM hanya mencegat response dengan Content-Type media (image/*, video/*)
        return response()->json([
            'data' => 'data:' . $mime . ';base64,' . $base64,
        ])->header('Cache-Control', 'public, max-age=86400');
    }

    public function thumbPaparan($id)
    {
        $item = GaleriArsip::findOrFail($id);

        if (!$item->file_paparan_path || !Storage::disk('public')->exists($item->file_paparan_path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($item->file_paparan_path);
        $mime     = mime_content_type($fullPath) ?: 'application/octet-stream';
        $base64   = base64_encode(file_get_contents($fullPath));

        return response()->json([
            'data'      => 'data:' . $mime . ';base64,' . $base64,
            'file_name' => $item->file_paparan_name,
        ])->header('Cache-Control', 'public, max-age=86400');
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'semua');

        $query = GaleriArsip::orderBy('tanggal_kegiatan', 'desc')
                             ->orderBy('created_at', 'desc');

        if ($tab !== 'semua') {
            $query->where('tipe', $tab);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('instansi', 'like', "%{$s}%")
                  ->orWhere('kode', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%")
                  ->orWhere('keywords', 'like', "%{$s}%")
                  ->orWhere('file_name', 'like', "%{$s}%")
                  ->orWhere('file_paparan_name', 'like', "%{$s}%")
                  ->orWhereHas('kegiatan', function ($kq) use ($s) {
                      $kq->where('judul', 'like', "%{$s}%")
                         ->orWhere('leading_sektor', 'like', "%{$s}%");
                  });
            });
        }

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where('keywords', 'like', "%{$kw}%");
        }

        if ($request->filled('akses')) {
            $query->where('akses', $request->akses);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_kegiatan', (int) $request->tahun);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kegiatan', (int) $request->bulan);
        }

        // Filter tanggal spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kegiatan', $request->tanggal);
        }

        // Filter by kegiatan_id (from kegiatan-pimpinan dropdown)
        if ($request->filled('kegiatan')) {
            $query->where('kegiatan_id', (int) $request->kegiatan);
        }

        if ($request->filled('urut')) {
            $query->reorder('tanggal_kegiatan', $request->urut === 'terlama' ? 'asc' : 'desc');
        }

        $items = $query->paginate(8)->withQueryString();

        // Hitung tahun yang tersedia dari data arsip
        $dbYears = GaleriArsip::whereNotNull('tanggal_kegiatan')
            ->selectRaw('YEAR(tanggal_kegiatan) as tahun')
            ->distinct()->pluck('tahun')->map(fn($y) => (int)$y)->toArray();
        $currentYear    = (int) now()->year;
        $defaultRange   = range($currentYear - 3, $currentYear + 1);
        $availableYears = collect(array_merge($defaultRange, $dbYears))->unique()->sortDesc()->values();

        $kegiatanList    = \App\Models\Kegiatan::orderBy('tanggal_mulai', 'desc')
                            ->select('id', 'nomor_agenda', 'judul', 'tanggal_mulai')
                            ->get();
        $filterKegiatanId = $request->filled('kegiatan') ? (int)$request->kegiatan : null;
        $filterKegiatan   = $filterKegiatanId
            ? \App\Models\Kegiatan::find($filterKegiatanId)
            : null;

        return view('sub-dokumentasi-pimpinan.galeri-arsip.index', compact(
            'items', 'tab', 'availableYears', 'kegiatanList', 'filterKegiatanId', 'filterKegiatan'
        ));
    }

    /**
     * Export Rekap Notulensi Kegiatan Pimpinan ke format Excel (.xls SpreadsheetML)
     */
    public function exportNotulensi(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);
        $export = new \App\Exports\NotulensiRekapExport($tahun);
        return $export->download();
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah arsip galeri.');
        }

        $request->validate([
            'judul'            => 'required|string|max:255',
            'instansi'         => 'nullable|string|max:255',
            'tipe'             => 'required|in:foto,video,notulensi',
            'tanggal_kegiatan' => 'required|date',
            'keterangan'       => 'nullable|string',
            'keywords'         => 'nullable|string|max:1000',
            'jumlah_foto'      => 'nullable|integer|min:1',
            'durasi_detik'     => 'nullable|integer|min:1',
            'file_arsip'       => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,pdf,doc,docx,ppt,pptx|max:153600',
            'file_paparan'     => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,odp|max:153600',
        ]);

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('file_arsip')) {
            $file     = $request->file('file_arsip');
            $isoName  = FileNamingService::formatIsoFileName(
                $request->tanggal_kegiatan,
                $request->judul,
                $file->getClientOriginalExtension()
            );
            $fileName = FileNamingService::ensureUniqueName('galeri-arsip', $isoName);
            $filePath = $file->storeAs('galeri-arsip', $fileName, 'public');
        }

        $filePaparanPath = null;
        $filePaparanName = null;
        if ($request->hasFile('file_paparan')) {
            $fPaparan        = $request->file('file_paparan');
            $isoPaparanName  = FileNamingService::formatIsoFileName(
                $request->tanggal_kegiatan,
                $request->judul,
                $fPaparan->getClientOriginalExtension(),
                'Paparan'
            );
            $filePaparanName = FileNamingService::ensureUniqueName('galeri-arsip', $isoPaparanName);
            $filePaparanPath = $fPaparan->storeAs('galeri-arsip', $filePaparanName, 'public');
        }

        GaleriArsip::create([
            'kode'              => GaleriArsip::generateKode(),
            'judul'             => $request->judul,
            'instansi'          => $request->instansi,
            'tipe'              => $request->tipe,
            'akses'             => 'internal',
            'file_path'         => $filePath,
            'file_name'         => $fileName,
            'file_paparan_path' => $filePaparanPath,
            'file_paparan_name' => $filePaparanName,
            'durasi_detik'      => $request->durasi_detik,
            'jumlah_foto'       => $request->jumlah_foto ?? 1,
            'keterangan'        => $request->keterangan,
            'keywords'          => $request->keywords,
            'tanggal_kegiatan'  => $request->tanggal_kegiatan,
            'kegiatan_id'       => $request->filled('kegiatan_id') ? (int)$request->kegiatan_id : null,
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('galeri-arsip.index', ['tab' => $request->tipe])
                         ->with('success', 'Arsip berhasil diunggah.');
    }

    public function update(Request $request, GaleriArsip $galeriArsip)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit arsip galeri.');
        }

        $request->validate([
            'judul'            => 'required|string|max:255',
            'instansi'         => 'nullable|string|max:255',
            'tipe'             => 'required|in:foto,video,notulensi',
            'tanggal_kegiatan' => 'required|date',
            'keterangan'       => 'nullable|string',
            'keywords'         => 'nullable|string|max:1000',
            'jumlah_foto'      => 'nullable|integer|min:1',
            'durasi_detik'     => 'nullable|integer|min:1',
            'file_arsip'       => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,pdf,doc,docx,ppt,pptx|max:153600',
            'file_paparan'     => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,odp|max:153600',
        ]);

        $data = [
            'judul'            => $request->judul,
            'instansi'         => $request->instansi,
            'tipe'             => $request->tipe,
            'akses'            => 'internal',
            'durasi_detik'     => $request->durasi_detik,
            'jumlah_foto'      => $request->jumlah_foto ?? 1,
            'keterangan'       => $request->keterangan,
            'keywords'         => $request->keywords,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'kegiatan_id'      => $request->filled('kegiatan_id') ? (int)$request->kegiatan_id : null,
        ];

        if ($request->hasFile('file_arsip')) {
            if ($galeriArsip->file_path) {
                Storage::disk('public')->delete($galeriArsip->file_path);
            }
            $file              = $request->file('file_arsip');
            $isoName           = FileNamingService::formatIsoFileName(
                $request->tanggal_kegiatan,
                $request->judul,
                $file->getClientOriginalExtension()
            );
            $fileName          = FileNamingService::ensureUniqueName('galeri-arsip', $isoName);
            $data['file_name'] = $fileName;
            $data['file_path'] = $file->storeAs('galeri-arsip', $fileName, 'public');
        }

        if ($request->hasFile('file_paparan')) {
            if ($galeriArsip->file_paparan_path) {
                Storage::disk('public')->delete($galeriArsip->file_paparan_path);
            }
            $fPaparan                  = $request->file('file_paparan');
            $isoPaparanName            = FileNamingService::formatIsoFileName(
                $request->tanggal_kegiatan,
                $request->judul,
                $fPaparan->getClientOriginalExtension(),
                'Paparan'
            );
            $paparanName               = FileNamingService::ensureUniqueName('galeri-arsip', $isoPaparanName);
            $data['file_paparan_name'] = $paparanName;
            $data['file_paparan_path'] = $fPaparan->storeAs('galeri-arsip', $paparanName, 'public');
        }

        $galeriArsip->update($data);

        return redirect()->route('galeri-arsip.index', ['tab' => $request->tipe])
                         ->with('success', 'Data arsip berhasil diperbarui.');
    }

    public function destroy(GaleriArsip $galeriArsip)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus arsip galeri.');
        }

        $tab = $galeriArsip->tipe;
        $galeriArsip->delete();

        return redirect()->route('galeri-arsip.index', ['tab' => $tab])
                         ->with('success', 'Arsip berhasil dipindahkan ke Sampah (Trash).');
    }

    public function bulkDestroy(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'Tidak ada item yang dipilih.');
        }

        $items = GaleriArsip::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        $count = $items->count();
        $tab   = $request->input('current_tab', 'semua');

        return redirect()->route('galeri-arsip.index', ['tab' => $tab])
                         ->with('success', "{$count} arsip berhasil dipindahkan ke Sampah (Trash).");
    }
}
