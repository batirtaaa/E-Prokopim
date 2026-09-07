<?php

namespace App\Http\Controllers;

use App\Exports\AnalisisIsuRekapExport;
use App\Models\AnalisisIsu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalisisIsuController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mode 1 (default): 12-month folder grid for selected year.
     * Mode 2 (when ?bulan=XX): filtered table for that month.
     */
    public function index(Request $request)
    {
        $selectedTahun = (int) $request->get('tahun', now()->year);

        // Available years (years that have data + current year)
        $dataYears = AnalisisIsu::selectRaw('YEAR(tanggal) as tahun')
            ->whereNotNull('tanggal')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();
        $availableYears = array_unique(array_merge([$selectedTahun, now()->year], $dataYears));
        rsort($availableYears);

        // Global Statistics (always shown)
        $totalCount   = AnalisisIsu::whereYear('tanggal', $selectedTahun)->count();
        $positifCount = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('sentimen', 'Positif')->count();
        $negatifCount = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('sentimen', 'Negatif')->count();
        $netralCount  = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('sentimen', 'Netral')->count();
        $sosialCount  = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('jenis_media', 'Sosial')->count();
        $onlineCount  = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('jenis_media', 'Online')->count();
        $cetakCount   = AnalisisIsu::whereYear('tanggal', $selectedTahun)->where('jenis_media', 'Cetak')->count();

        $namaBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember',
        ];

        // ---- MODE 2: Table view filtered by month ----
        if ($request->filled('bulan')) {
            $selectedBulan = (int) $request->get('bulan');

            $query = AnalisisIsu::with('user')
                ->whereYear('tanggal', $selectedTahun)
                ->whereMonth('tanggal', $selectedBulan)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc');

            if ($request->filled('search')) {
                $s = trim($request->search);
                $query->where(function ($q) use ($s) {
                    $q->where('judul', 'like', "%{$s}%")
                      ->orWhere('sumber_isu', 'like', "%{$s}%")
                      ->orWhere('leading_sector', 'like', "%{$s}%")
                      ->orWhere('analisis', 'like', "%{$s}%");
                });
            }
            if ($request->filled('jenis_media')) {
                $query->where('jenis_media', $request->jenis_media);
            }
            if ($request->filled('sentimen')) {
                $query->where('sentimen', $request->sentimen);
            }

            $leadingSectors = AnalisisIsu::select('leading_sector')
                ->distinct()
                ->whereNotNull('leading_sector')
                ->orderBy('leading_sector')
                ->pluck('leading_sector');

            $analisisList = $query->paginate(15)->withQueryString();

            return view('sub-komunikasi-pimpinan.analisis.index', compact(
                'analisisList', 'selectedTahun', 'selectedBulan', 'availableYears',
                'totalCount', 'positifCount', 'negatifCount', 'netralCount',
                'sosialCount', 'onlineCount', 'cetakCount', 'leadingSectors', 'namaBulan'
            ) + ['viewMode' => 'list']);
        }

        // ---- MODE 1: 12-month folder grid ----
        $rows = AnalisisIsu::whereYear('tanggal', $selectedTahun)
            ->selectRaw('MONTH(tanggal) as bulan, sentimen, COUNT(*) as cnt')
            ->groupByRaw('MONTH(tanggal), sentimen')
            ->get();

        $byBulan = [];
        foreach ($rows as $row) {
            $b = (int) $row->bulan;
            if (!isset($byBulan[$b])) {
                $byBulan[$b] = ['total' => 0, 'positif' => 0, 'negatif' => 0, 'netral' => 0];
            }
            $byBulan[$b]['total'] += (int) $row->cnt;
            if ($row->sentimen === 'Positif') $byBulan[$b]['positif'] += (int) $row->cnt;
            if ($row->sentimen === 'Negatif') $byBulan[$b]['negatif'] += (int) $row->cnt;
            if ($row->sentimen === 'Netral')  $byBulan[$b]['netral']  += (int) $row->cnt;
        }

        $monthlyFolders = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyFolders[] = [
                'bulan'   => $m,
                'tahun'   => $selectedTahun,
                'label'   => ($namaBulan[$m] ?? '') . ' ' . $selectedTahun,
                'total'   => $byBulan[$m]['total']   ?? 0,
                'positif' => $byBulan[$m]['positif'] ?? 0,
                'negatif' => $byBulan[$m]['negatif'] ?? 0,
                'netral'  => $byBulan[$m]['netral']  ?? 0,
            ];
        }

        return view('sub-komunikasi-pimpinan.analisis.index', compact(
            'monthlyFolders', 'selectedTahun', 'availableYears',
            'totalCount', 'positifCount', 'negatifCount', 'netralCount',
            'sosialCount', 'onlineCount', 'cetakCount', 'namaBulan'
        ) + ['viewMode' => 'grid', 'selectedBulan' => null, 'leadingSectors' => collect(), 'analisisList' => null]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suggestedLeadingSectors = [
            'Bagian Protokol dan Komunikasi Pimpinan',
            'Dinas Komunikasi dan Informatika',
            'Dinas Perhubungan',
            'Satuan Polisi Pamong Praja (Satpol PP)',
            'Dinas Lingkungan Hidup',
            'Dinas Sumber Daya Air dan Bina Marga',
            'Dinas Kesehatan',
            'Dinas Pendidikan',
            'Dinas Sosial',
            'Dinas Perdagangan dan Perindustrian',
            'Dinas Kependudukan dan Pencatatan Sipil',
            'Dinas Kebakaran dan Penanggulangan Bencana',
            'Badan Perencanaan Pembangunan Daerah',
        ];

        return view('sub-komunikasi-pimpinan.analisis.create', compact('suggestedLeadingSectors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'                 => 'required|string|max:255',
            'tanggal'               => 'required|date',
            'jenis_media'           => 'required|in:Sosial,Online,Cetak',
            'sumber_isu'            => 'required|string|max:255',
            'analisis'              => 'required|string',
            'rekomendasi_kebijakan' => 'required|string',
            'rekomendasi_publikasi' => 'required|string',
            'leading_sector'        => 'required|string|max:255',
            'sentimen'              => 'required|in:Positif,Negatif,Netral',
            'link_sumber'           => 'nullable|url|max:500',
        ], [
            'judul.required'                 => 'Judul Isu wajib diisi.',
            'tanggal.required'               => 'Hari / Tanggal wajib ditentukan.',
            'jenis_media.required'           => 'Jenis Media (Sosial, Online, Cetak) wajib dipilih.',
            'sumber_isu.required'            => 'Sumber Isu wajib diisi.',
            'analisis.required'              => 'Uraian Analisis Isu wajib diisi.',
            'rekomendasi_kebijakan.required' => 'Rekomendasi Kebijakan wajib diisi.',
            'rekomendasi_publikasi.required' => 'Rekomendasi Publikasi wajib diisi.',
            'leading_sector.required'        => 'Leading Sector wajib diisi.',
            'sentimen.required'              => 'Sentimen Isu (Positif, Negatif, Netral) wajib dipilih.',
            'link_sumber.url'                => 'Format Link Sumber Berita harus berupa URL yang valid (awali dengan https://).',
        ]);

        $analisis = AnalisisIsu::create([
            'judul'                 => $validated['judul'],
            'tanggal'               => $validated['tanggal'],
            'jenis_media'           => $validated['jenis_media'],
            'sumber_isu'            => $validated['sumber_isu'],
            'analisis'              => $validated['analisis'],
            'rekomendasi_kebijakan' => $validated['rekomendasi_kebijakan'],
            'rekomendasi_publikasi' => $validated['rekomendasi_publikasi'],
            'leading_sector'        => $validated['leading_sector'],
            'sentimen'              => $validated['sentimen'],
            'link_sumber'           => $validated['link_sumber'] ?? null,
            'created_by'            => Auth::id(),
        ]);

        return redirect()->route('analisis.show', $analisis->id)
            ->with('success', 'Data analisis isu berhasil disimpan dan siap ditelaah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnalisisIsu $analisi, Request $request)
    {
        // Support JSON response for fast modal preview
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id'                    => $analisi->id,
                'judul'                 => $analisi->judul,
                'tanggal'               => $analisi->tanggal->format('Y-m-d'),
                'hari_tanggal'          => $analisi->hari_tanggal,
                'jenis_media'           => $analisi->jenis_media,
                'jenis_media_badge'     => $analisi->jenis_media_badge_class,
                'sumber_isu'            => $analisi->sumber_isu,
                'analisis'              => $analisi->analisis,
                'rekomendasi_kebijakan' => $analisi->rekomendasi_kebijakan,
                'rekomendasi_publikasi' => $analisi->rekomendasi_publikasi,
                'leading_sector'        => $analisi->leading_sector,
                'sentimen'              => $analisi->sentimen,
                'sentimen_badge'        => $analisi->sentimen_badge_class,
                'link_sumber'           => $analisi->link_sumber,
                'created_by_name'       => $analisi->user ? $analisi->user->name : 'Administrator',
                'created_at_formatted'  => $analisi->created_at ? $analisi->created_at->format('d M Y, H:i') : '-',
                'edit_url'              => route('analisis.edit', $analisi->id),
                'show_url'              => route('analisis.show', $analisi->id),
                'cetak_url'             => route('analisis.cetak', $analisi->id),
            ]);
        }

        return view('sub-komunikasi-pimpinan.analisis.show', compact('analisi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnalisisIsu $analisi)
    {
        $suggestedLeadingSectors = [
            'Bagian Protokol dan Komunikasi Pimpinan',
            'Dinas Komunikasi dan Informatika',
            'Dinas Perhubungan',
            'Satuan Polisi Pamong Praja (Satpol PP)',
            'Dinas Lingkungan Hidup',
            'Dinas Sumber Daya Air dan Bina Marga',
            'Dinas Kesehatan',
            'Dinas Pendidikan',
            'Dinas Sosial',
            'Dinas Perdagangan dan Perindustrian',
            'Dinas Kependudukan dan Pencatatan Sipil',
            'Dinas Kebakaran dan Penanggulangan Bencana',
            'Badan Perencanaan Pembangunan Daerah',
        ];

        return view('sub-komunikasi-pimpinan.analisis.edit', compact('analisi', 'suggestedLeadingSectors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnalisisIsu $analisi)
    {
        $validated = $request->validate([
            'judul'                 => 'required|string|max:255',
            'tanggal'               => 'required|date',
            'jenis_media'           => 'required|in:Sosial,Online,Cetak',
            'sumber_isu'            => 'required|string|max:255',
            'analisis'              => 'required|string',
            'rekomendasi_kebijakan' => 'required|string',
            'rekomendasi_publikasi' => 'required|string',
            'leading_sector'        => 'required|string|max:255',
            'sentimen'              => 'required|in:Positif,Negatif,Netral',
            'link_sumber'           => 'nullable|url|max:500',
        ], [
            'judul.required'                 => 'Judul Isu wajib diisi.',
            'tanggal.required'               => 'Hari / Tanggal wajib ditentukan.',
            'jenis_media.required'           => 'Jenis Media (Sosial, Online, Cetak) wajib dipilih.',
            'sumber_isu.required'            => 'Sumber Isu wajib diisi.',
            'analisis.required'              => 'Uraian Analisis Isu wajib diisi.',
            'rekomendasi_kebijakan.required' => 'Rekomendasi Kebijakan wajib diisi.',
            'rekomendasi_publikasi.required' => 'Rekomendasi Publikasi wajib diisi.',
            'leading_sector.required'        => 'Leading Sector wajib diisi.',
            'sentimen.required'              => 'Sentimen Isu (Positif, Negatif, Netral) wajib dipilih.',
            'link_sumber.url'                => 'Format Link Sumber Berita harus berupa URL yang valid (awali dengan https://).',
        ]);

        $analisi->update([
            'judul'                 => $validated['judul'],
            'tanggal'               => $validated['tanggal'],
            'jenis_media'           => $validated['jenis_media'],
            'sumber_isu'            => $validated['sumber_isu'],
            'analisis'              => $validated['analisis'],
            'rekomendasi_kebijakan' => $validated['rekomendasi_kebijakan'],
            'rekomendasi_publikasi' => $validated['rekomendasi_publikasi'],
            'leading_sector'        => $validated['leading_sector'],
            'sentimen'              => $validated['sentimen'],
            'link_sumber'           => $validated['link_sumber'] ?? null,
        ]);

        return redirect()->route('analisis.show', $analisi->id)
            ->with('success', 'Data analisis isu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnalisisIsu $analisi)
    {
        $analisi->delete();

        return redirect()->route('analisis.index')
            ->with('success', 'Data analisis isu berhasil dihapus.');
    }

    /**
     * Bulk delete items.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            AnalisisIsu::whereIn('id', $ids)->delete();
            return redirect()->route('analisis.index')
                ->with('success', count($ids) . ' data analisis isu berhasil dihapus.');
        }

        return redirect()->route('analisis.index')
            ->with('warning', 'Tidak ada data analisis yang dipilih.');
    }

    /**
     * Display printable official telaahan sheet.
     */
    public function cetak(AnalisisIsu $analisi)
    {
        return view('sub-komunikasi-pimpinan.analisis.cetak', compact('analisi'));
    }

    /**
     * Export rekapitulasi data to Excel (SpreadsheetML).
     */
    public function exportRekap(Request $request): StreamedResponse
    {
        $tahun = (int) $request->get('tahun', now()->year);
        return (new AnalisisIsuRekapExport($tahun))->stream();
    }
}
