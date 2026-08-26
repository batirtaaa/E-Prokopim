<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotulensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Notulensi::with(['kegiatan', 'notulis'])->orderBy('tanggal_rapat', 'desc');
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $notulensi = $query->paginate(10)->withQueryString();
        $kegiatan = Kegiatan::orderBy('tanggal_mulai', 'desc')->get();
        $users = User::where('is_active', true)->get();
        return view('notulensi.index', compact('notulensi', 'kegiatan', 'users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah notulensi.');
        }

        $validated = $request->validate([
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
            'judul' => 'required|string|max:255',
            'tanggal_rapat' => 'required|date',
            'tempat' => 'required|string|max:255',
            'peserta' => 'nullable|string',
            'agenda' => 'nullable|string',
            'isi_notulensi' => 'required|string',
            'kesimpulan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'status' => 'required|in:draft,final',
            'notulis_id' => 'nullable|exists:users,id',
        ]);
        $validated['created_by'] = Auth::id();
        Notulensi::create($validated);
        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil disimpan.');
    }

    public function show(Notulensi $notulensi)
    {
        return view('notulensi.show', compact('notulensi'));
    }

    public function edit(Notulensi $notulensi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit notulensi.');
        }

        $kegiatan = Kegiatan::orderBy('tanggal_mulai', 'desc')->get();
        $users = User::where('is_active', true)->get();
        return view('notulensi.edit', compact('notulensi', 'kegiatan', 'users'));
    }

    public function update(Request $request, Notulensi $notulensi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit notulensi.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_rapat' => 'required|date',
            'tempat' => 'required|string|max:255',
            'isi_notulensi' => 'required|string',
            'status' => 'required|in:draft,final',
        ]);
        $notulensi->update($validated);
        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy(Notulensi $notulensi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus notulensi.');
        }

        $notulensi->delete();
        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil dihapus.');
    }
}
