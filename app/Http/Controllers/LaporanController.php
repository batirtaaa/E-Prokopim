<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kegiatan;
use App\Models\Penugasan;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('createdBy')->orderBy('created_at', 'desc');
        if ($request->filled('tipe')) $query->where('tipe', $request->tipe);
        $laporan = $query->paginate(10)->withQueryString();

        // Summary stats
        $totalKegiatan = Kegiatan::whereYear('tanggal_mulai', Carbon::now()->year)->count();
        $totalArsip = Arsip::count();

        return view('laporan.index', compact('laporan', 'totalKegiatan', 'totalArsip'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membuat laporan.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:kegiatan,penugasan,arsip,dokumentasi,custom',
            'periode_mulai' => 'nullable|date',
            'periode_selesai' => 'nullable|date',
            'deskripsi' => 'nullable|string',
        ]);
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';
        Laporan::create($validated);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat.');
    }

    public function destroy(Laporan $laporan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus laporan.');
        }

        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
