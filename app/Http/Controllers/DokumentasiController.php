<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumentasi::with(['kegiatan', 'uploadedBy'])->orderBy('tanggal_dokumentasi', 'desc');
        if ($request->filled('search')) $query->where('judul', 'like', '%' . $request->search . '%');
        if ($request->filled('tipe')) $query->where('tipe', $request->tipe);
        $dokumentasi = $query->paginate(12)->withQueryString();
        $kegiatan = Kegiatan::orderBy('tanggal_mulai', 'desc')->get();
        return view('dokumentasi.index', compact('dokumentasi', 'kegiatan'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah dokumentasi.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kegiatan_id' => 'nullable|exists:kegiatan,id',
            'tipe' => 'required|in:foto,video,dokumen',
            'file' => 'required|file|max:51200',
            'tanggal_dokumentasi' => 'required|date',
            'fotografer' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('dokumentasi', 'public');

        Dokumentasi::create([
            'judul' => $validated['judul'],
            'kegiatan_id' => $validated['kegiatan_id'] ?? null,
            'tipe' => $validated['tipe'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'tanggal_dokumentasi' => $validated['tanggal_dokumentasi'],
            'fotografer' => $validated['fotografer'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diunggah.');
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus dokumentasi.');
        }

        Storage::disk('public')->delete($dokumentasi->file_path);
        $dokumentasi->delete();
        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
