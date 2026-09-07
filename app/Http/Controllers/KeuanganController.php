<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Personel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KeuanganController extends Controller
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

        // Fetch distinct available years
        $dataYears = Keuangan::selectRaw('YEAR(COALESCE(tanggal_diterima, tanggal)) as tahun')
            ->whereNotNull('tanggal_diterima')
            ->orWhereNotNull('tanggal')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();
        $availableYears = array_unique(array_merge([$selectedTahun, now()->year], $dataYears));
        rsort($availableYears);

        $query = Keuangan::where(function ($q) use ($selectedTahun) {
            $q->whereYear('tanggal_diterima', $selectedTahun)
              ->orWhere(function ($sub) use ($selectedTahun) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $selectedTahun);
              });
        })->orderByRaw('COALESCE(tanggal_diterima, tanggal) DESC')->orderBy('id', 'desc');

        // Search
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('pengirim', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%")
                  ->orWhere('disposisi', 'like', "%{$s}%")
                  ->orWhere('no_bukti', 'like', "%{$s}%")
                  ->orWhere('uraian', 'like', "%{$s}%");
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->where(function ($q) use ($request) {
                $q->whereMonth('tanggal_diterima', $request->bulan)
                  ->orWhere(function ($sub) use ($request) {
                      $sub->whereNull('tanggal_diterima')->whereMonth('tanggal', $request->bulan);
                  });
            });
        }

        // Filter Status Print
        if ($request->filled('status_print')) {
            if ($request->status_print === '1' || $request->status_print === 'printed') {
                $query->where('is_printed', true);
            } elseif ($request->status_print === '0' || $request->status_print === 'unprinted') {
                $query->where(function ($q) {
                    $q->where('is_printed', false)->orWhereNull('is_printed');
                });
            }
        }

        // Statistics for current year
        $yearQuery = Keuangan::where(function ($q) use ($selectedTahun) {
            $q->whereYear('tanggal_diterima', $selectedTahun)
              ->orWhere(function ($sub) use ($selectedTahun) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $selectedTahun);
              });
        });

        $totalSurat   = (clone $yearQuery)->count();
        $totalPrinted = (clone $yearQuery)->where('is_printed', true)->count();
        $totalUnprinted = $totalSurat - $totalPrinted;

        $suratList = $query->paginate(15)->withQueryString();

        return view('keuangan.index', compact(
            'suratList',
            'selectedTahun',
            'availableYears',
            'totalSurat',
            'totalPrinted',
            'totalUnprinted'
        ));
    }

    public function create()
    {
        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('keuangan.create', compact('pegawaiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_diterima' => 'required|date',
            'nomor_surat'      => 'required|string|max:255',
            'pengirim'         => 'required|string|max:255',
            'perihal'          => 'required|string',
            'disposisi'        => 'nullable|string|max:500',
            'link_dokumen'     => 'nullable|string|max:500',
            'file_dokumen'     => 'nullable|file|mimes:pdf,doc,docx|max:15360',
            'is_printed'       => 'nullable|boolean',
        ], [
            'tanggal_diterima.required' => 'Tanggal Diterima wajib diisi.',
            'nomor_surat.required'      => 'Nomor Surat wajib diisi.',
            'pengirim.required'         => 'Asal Instansi wajib diisi.',
            'perihal.required'          => 'Perihal Surat wajib diisi.',
            'file_dokumen.mimes'        => 'Format berkas dokumen harus berupa PDF atau Word (.doc, .docx).',
            'file_dokumen.max'          => 'Ukuran file dokumen maksimal 15MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('keuangan/dokumen', 'public');
        }

        $isPrinted = $request->boolean('is_printed');

        Keuangan::create([
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'nomor_surat'      => $validated['nomor_surat'],
            'pengirim'         => $validated['pengirim'],
            'perihal'          => $validated['perihal'],
            'disposisi'        => $validated['disposisi'] ?? null,
            'link_dokumen'     => $validated['link_dokumen'] ?? null,
            'file_dokumen'     => $filePath,
            'is_printed'       => $isPrinted,
            'printed_at'       => $isPrinted ? now() : null,
            // Fallback for legacy fields
            'tanggal'          => $validated['tanggal_diterima'],
            'uraian'           => $validated['perihal'],
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('keuangan.index')
            ->with('success', 'Data surat masuk berhasil ditambahkan ke dalam sistem.');
    }

    public function edit(Keuangan $keuangan)
    {
        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('keuangan.edit', compact('keuangan', 'pegawaiList'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal_diterima' => 'required|date',
            'nomor_surat'      => 'required|string|max:255',
            'pengirim'         => 'required|string|max:255',
            'perihal'          => 'required|string',
            'disposisi'        => 'nullable|string|max:500',
            'link_dokumen'     => 'nullable|string|max:500',
            'file_dokumen'     => 'nullable|file|mimes:pdf,doc,docx|max:15360',
            'is_printed'       => 'nullable|boolean',
        ], [
            'tanggal_diterima.required' => 'Tanggal Diterima wajib diisi.',
            'nomor_surat.required'      => 'Nomor Surat wajib diisi.',
            'pengirim.required'         => 'Asal Instansi wajib diisi.',
            'perihal.required'          => 'Perihal Surat wajib diisi.',
            'file_dokumen.mimes'        => 'Format berkas dokumen harus berupa PDF atau Word (.doc, .docx).',
            'file_dokumen.max'          => 'Ukuran file dokumen maksimal 15MB.',
        ]);

        $filePath = $keuangan->file_dokumen;
        if ($request->hasFile('file_dokumen')) {
            if ($keuangan->file_dokumen && Storage::disk('public')->exists($keuangan->file_dokumen)) {
                Storage::disk('public')->delete($keuangan->file_dokumen);
            }
            $filePath = $request->file('file_dokumen')->store('keuangan/dokumen', 'public');
        }

        $isPrinted = $request->boolean('is_printed');

        $keuangan->update([
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'nomor_surat'      => $validated['nomor_surat'],
            'pengirim'         => $validated['pengirim'],
            'perihal'          => $validated['perihal'],
            'disposisi'        => $validated['disposisi'] ?? null,
            'link_dokumen'     => $validated['link_dokumen'] ?? null,
            'file_dokumen'     => $filePath,
            'is_printed'       => $isPrinted,
            'printed_at'       => $isPrinted ? ($keuangan->printed_at ?? now()) : null,
            // Fallback for legacy
            'tanggal'          => $validated['tanggal_diterima'],
            'uraian'           => $validated['perihal'],
        ]);

        return redirect()->route('keuangan.index')
            ->with('success', 'Data surat masuk berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        if ($keuangan->file_dokumen && Storage::disk('public')->exists($keuangan->file_dokumen)) {
            Storage::disk('public')->delete($keuangan->file_dokumen);
        }
        if ($keuangan->file_bukti && Storage::disk('public')->exists($keuangan->file_bukti)) {
            Storage::disk('public')->delete($keuangan->file_bukti);
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')
            ->with('success', 'Data surat masuk berhasil dihapus.');
    }

    public function togglePrint(Keuangan $keuangan, Request $request)
    {
        $newStatus = !$keuangan->is_printed;
        $keuangan->update([
            'is_printed' => $newStatus,
            'printed_at' => $newStatus ? now() : null,
        ]);

        $selectedTahun = $keuangan->tanggal_diterima ? $keuangan->tanggal_diterima->year : ($keuangan->tanggal ? $keuangan->tanggal->year : (int) $request->get('tahun', now()->year));

        $yearQuery = Keuangan::where(function ($q) use ($selectedTahun) {
            $q->whereYear('tanggal_diterima', $selectedTahun)
              ->orWhere(function ($sub) use ($selectedTahun) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $selectedTahun);
              });
        });

        $totalSurat     = (clone $yearQuery)->count();
        $totalPrinted   = (clone $yearQuery)->where('is_printed', true)->count();
        $totalUnprinted = $totalSurat - $totalPrinted;
        $percentage     = $totalSurat > 0 ? round(($totalPrinted / $totalSurat) * 100) : 0;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'         => true,
                'is_printed'      => $newStatus,
                'total_surat'     => $totalSurat,
                'total_printed'   => $totalPrinted,
                'total_unprinted' => $totalUnprinted,
                'percentage'      => $percentage,
                'message'         => $newStatus ? 'Status diubah: Sudah Diprint' : 'Status diubah: Belum Diprint',
            ]);
        }

        return back()->with('success', 'Status print berhasil diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            $items = Keuangan::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                if ($item->file_dokumen && Storage::disk('public')->exists($item->file_dokumen)) {
                    Storage::disk('public')->delete($item->file_dokumen);
                }
                $item->delete();
            }
            return redirect()->route('keuangan.index')
                ->with('success', count($ids) . ' data surat masuk berhasil dihapus.');
        }

        return redirect()->route('keuangan.index')
            ->with('warning', 'Tidak ada data yang dipilih.');
    }

    public function export(Request $request): StreamedResponse
    {
        $selectedTahun = (int) $request->get('tahun', now()->year);
        $selectedBulan = $request->filled('bulan') ? (int) $request->get('bulan') : null;
        $statusPrint   = $request->get('status_print');
        $search        = $request->get('search');

        $exporter = new \App\Exports\SuratMasukRekapExport($selectedTahun, $selectedBulan, $statusPrint, $search);
        return $exporter->stream();
    }
}
