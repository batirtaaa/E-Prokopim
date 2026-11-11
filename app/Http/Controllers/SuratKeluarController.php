<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    const NAMA_BULAN = [
        1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
        4  => 'April',    5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',     8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',  11 => 'November',  12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $selectedTahun = (int) $request->get('tahun', now()->year);

        // Distinct years available
        $dataYears = SuratKeluar::selectRaw('YEAR(tanggal_surat) as tahun')
            ->whereNotNull('tanggal_surat')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();
        $availableYears = array_unique(array_merge([$selectedTahun, now()->year], $dataYears));
        rsort($availableYears);

        $query = SuratKeluar::whereYear('tanggal_surat', $selectedTahun)
            ->orderBy('tanggal_surat', 'desc')
            ->orderBy('id', 'desc');

        // Search
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        // Statistics
        $totalSuratMasuk = Keuangan::where(function ($q) use ($selectedTahun) {
            $q->whereYear('tanggal_diterima', $selectedTahun)
              ->orWhere(function ($sub) use ($selectedTahun) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $selectedTahun);
              });
        })->count();
        $totalSuratKeluar = SuratKeluar::whereYear('tanggal_surat', $selectedTahun)->count();
        $totalSemua = $totalSuratMasuk + $totalSuratKeluar;

        $suratList = $query->paginate(15)->withQueryString();

        return view('surat-keluar.index', compact(
            'suratList',
            'selectedTahun',
            'availableYears',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalSemua'
        ));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return view('surat-keluar.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'nomor_surat'   => 'required|string|max:255',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string',
            'keterangan'    => 'nullable|string',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx|max:15360',
        ], [
            'tanggal_surat.required' => 'Tanggal Surat wajib diisi.',
            'nomor_surat.required'   => 'Nomor Surat wajib diisi.',
            'tujuan.required'        => 'Instansi Tujuan wajib diisi.',
            'perihal.required'       => 'Perihal Surat wajib diisi.',
            'file_dokumen.mimes'     => 'Format berkas harus berupa PDF atau Word (.doc, .docx).',
            'file_dokumen.max'       => 'Ukuran file dokumen maksimal 15MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('surat-keluar/dokumen', 'public');
        }

        SuratKeluar::create([
            'tanggal_surat' => $validated['tanggal_surat'],
            'nomor_surat'   => $validated['nomor_surat'],
            'tujuan'        => $validated['tujuan'],
            'perihal'       => $validated['perihal'],
            'keterangan'    => $validated['keterangan'] ?? null,
            'file_dokumen'  => $filePath,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan ke dalam sistem.');
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return view('surat-keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'nomor_surat'   => 'required|string|max:255',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string',
            'keterangan'    => 'nullable|string',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx|max:15360',
        ], [
            'tanggal_surat.required' => 'Tanggal Surat wajib diisi.',
            'nomor_surat.required'   => 'Nomor Surat wajib diisi.',
            'tujuan.required'        => 'Instansi Tujuan wajib diisi.',
            'perihal.required'       => 'Perihal Surat wajib diisi.',
            'file_dokumen.mimes'     => 'Format berkas harus berupa PDF atau Word (.doc, .docx).',
            'file_dokumen.max'       => 'Ukuran file dokumen maksimal 15MB.',
        ]);

        $filePath = $suratKeluar->file_dokumen;
        if ($request->hasFile('file_dokumen')) {
            if ($suratKeluar->file_dokumen && Storage::disk('public')->exists($suratKeluar->file_dokumen)) {
                Storage::disk('public')->delete($suratKeluar->file_dokumen);
            }
            $filePath = $request->file('file_dokumen')->store('surat-keluar/dokumen', 'public');
        }

        $suratKeluar->update([
            'tanggal_surat' => $validated['tanggal_surat'],
            'nomor_surat'   => $validated['nomor_surat'],
            'tujuan'        => $validated['tujuan'],
            'perihal'       => $validated['perihal'],
            'keterangan'    => $validated['keterangan'] ?? null,
            'file_dokumen'  => $filePath,
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dipindahkan ke Sampah (Trash).');
    }

    public function bulkDestroy(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            $items = SuratKeluar::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $item->delete();
            }
            return redirect()->route('surat-keluar.index')
                ->with('success', count($ids) . ' surat keluar berhasil dipindahkan ke Sampah (Trash).');
        }

        return redirect()->route('surat-keluar.index')
            ->with('warning', 'Tidak ada data yang dipilih.');
    }

    public function export(Request $request)
    {
        $query = SuratKeluar::query();

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_surat', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        $data = $query->orderBy('tanggal_surat', 'desc')->orderBy('id', 'desc')->get();
        $filename = 'daftar_surat_keluar_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream(function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nomor Surat', 'Tanggal Surat', 'Tujuan', 'Perihal', 'Keterangan']);
            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->nomor_surat,
                    $row->tanggal_surat ? $row->tanggal_surat->format('Y-m-d') : '-',
                    $row->tujuan,
                    $row->perihal,
                    $row->keterangan ?? '-',
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }
}
