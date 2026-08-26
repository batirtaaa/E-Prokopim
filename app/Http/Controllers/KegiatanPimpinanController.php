<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
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
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $kegiatan = $query->paginate(10)->withQueryString();

        return view('kegiatan-pimpinan.index', compact('kegiatan'));
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
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'nullable',
            'lokasi'        => 'required|string',
            'pimpinan'      => 'nullable|array',
            'keterangan'    => 'nullable|string',
            'nomor_agenda'  => 'nullable|string|max:100',
        ]);

        $lokasiMap = [
            'gedung_dprd'        => 'Gedung DPRD Kota Bandung',
            'balai_kota'         => 'Balai Kota Bandung',
            'taman_sekeloa'      => 'Taman Sekeloa',
            'kolam_retensi'      => 'Kolam Retensi Gedebage',
            'ruang_rapat_tengah' => 'Ruang Rapat Tengah',
        ];
        $lokasiName = $lokasiMap[$request->lokasi] ?? $request->lokasi;

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
            NotifikasiController::createForAllUsers(
                '📅 Kegiatan Baru: ' . $kegiatan->judul,
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
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'nullable',
            'lokasi'        => 'required|string',
            'pimpinan'      => 'nullable|array',
            'keterangan'    => 'nullable|string',
        ]);

        $lokasiMap = [
            'gedung_dprd'        => 'Gedung DPRD Kota Bandung',
            'balai_kota'         => 'Balai Kota Bandung',
            'taman_sekeloa'      => 'Taman Sekeloa',
            'kolam_retensi'      => 'Kolam Retensi Gedebage',
            'ruang_rapat_tengah' => 'Ruang Rapat Tengah',
        ];
        $lokasiName   = $lokasiMap[$request->lokasi] ?? $request->lokasi;
        $tanggalMulai = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $tanggalSelesai = $request->filled('waktu_selesai')
            ? Carbon::parse($request->tanggal . ' ' . $request->waktu_selesai)
            : null;

        $kegiatan->update([
            'judul'           => $request->nama_kegiatan,
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
}
