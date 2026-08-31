<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Exports\KegiatanPimpinanRekapExport;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $kegiatan = $query->paginate(10)->withQueryString();

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
            'leading_sektor'  => $request->leading_sektor,
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

        return redirect()->route('kegiatan-pimpinan.success', $kegiatan);
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
        return view('kegiatan-pimpinan.create', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kegiatan.');
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
        $tanggalMulai = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $tanggalSelesai = $request->filled('waktu_selesai')
            ? Carbon::parse($request->tanggal . ' ' . $request->waktu_selesai)
            : null;

        $kegiatan->update([
            'judul'           => $request->nama_kegiatan,
            'leading_sektor'  => $request->leading_sektor,
            'deskripsi'       => $request->keterangan,
            'lokasi'          => $lokasiName,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'pimpinan'        => $request->input('pimpinan', []),
        ]);

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
