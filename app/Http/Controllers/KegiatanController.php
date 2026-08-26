<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::query()->orderBy('tanggal_mulai', 'desc');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('pimpinan')) {
            $query->where('pimpinan', $request->pimpinan);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_mulai', $request->bulan)
                  ->whereYear('tanggal_mulai', $request->tahun ?? Carbon::now()->year);
        }

        $kegiatan = $query->paginate(10)->withQueryString();

        return view('kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kegiatan.');
        }

        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kegiatan.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'pimpinan' => 'required|in:wali_kota,wakil_wali_kota,sekda,asisten',
            'status' => 'required|in:draft,terjadwal,berlangsung,selesai,dibatalkan',
            'kategori' => 'required|in:rapat,kunjungan,acara,audiensi,peresmian,lainnya',
        ]);

        $validated['created_by'] = Auth::id();
        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load('penugasan.personel', 'notulensi', 'dokumentasi', 'daftarHadir');
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kegiatan.');
        }

        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kegiatan.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'pimpinan' => 'required|in:wali_kota,wakil_wali_kota,sekda,asisten',
            'status' => 'required|in:draft,terjadwal,berlangsung,selesai,dibatalkan',
            'kategori' => 'required|in:rapat,kunjungan,acara,audiensi,peresmian,lainnya',
        ]);

        $kegiatan->update($validated);
        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus kegiatan.');
        }

        $kegiatan->delete();
        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
