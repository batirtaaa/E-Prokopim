<?php

namespace App\Http\Controllers;

use App\Models\GaleriArsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriArsipController extends Controller
{
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
                  ->orWhere('kode', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        if ($request->filled('akses')) {
            $query->where('akses', $request->akses);
        }

        if ($request->filled('urut')) {
            $query->reorder('tanggal_kegiatan', $request->urut === 'terlama' ? 'asc' : 'desc');
        }

        $items = $query->paginate(8)->withQueryString();

        return view('sub-dokumentasi-pimpinan.galeri-arsip.index', compact('items', 'tab'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah arsip galeri.');
        }

        $request->validate([
            'judul'            => 'required|string|max:255',
            'tipe'             => 'required|in:foto,video,notulensi',
            'akses'            => 'required|in:publik,internal',
            'tanggal_kegiatan' => 'required|date',
            'keterangan'       => 'nullable|string',
            'jumlah_foto'      => 'nullable|integer|min:1',
            'durasi_detik'     => 'nullable|integer|min:1',
            'file_arsip'       => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,pdf,doc,docx|max:153600',
        ]);

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('file_arsip')) {
            $file     = $request->file('file_arsip');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('galeri-arsip', 'public');
        }

        GaleriArsip::create([
            'kode'             => GaleriArsip::generateKode(),
            'judul'            => $request->judul,
            'tipe'             => $request->tipe,
            'akses'            => $request->akses,
            'file_path'        => $filePath,
            'file_name'        => $fileName,
            'durasi_detik'     => $request->durasi_detik,
            'jumlah_foto'      => $request->jumlah_foto ?? 1,
            'keterangan'       => $request->keterangan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'created_by'       => Auth::id(),
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
            'tipe'             => 'required|in:foto,video,notulensi',
            'akses'            => 'required|in:publik,internal',
            'tanggal_kegiatan' => 'required|date',
            'keterangan'       => 'nullable|string',
            'jumlah_foto'      => 'nullable|integer|min:1',
            'durasi_detik'     => 'nullable|integer|min:1',
            'file_arsip'       => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,pdf,doc,docx|max:153600',
        ]);

        $data = [
            'judul'            => $request->judul,
            'tipe'             => $request->tipe,
            'akses'            => $request->akses,
            'durasi_detik'     => $request->durasi_detik,
            'jumlah_foto'      => $request->jumlah_foto ?? 1,
            'keterangan'       => $request->keterangan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ];

        if ($request->hasFile('file_arsip')) {
            if ($galeriArsip->file_path) {
                Storage::disk('public')->delete($galeriArsip->file_path);
            }
            $file              = $request->file('file_arsip');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('galeri-arsip', 'public');
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
        if ($galeriArsip->file_path) {
            Storage::disk('public')->delete($galeriArsip->file_path);
        }
        $galeriArsip->delete();

        return redirect()->route('galeri-arsip.index', ['tab' => $tab])
                         ->with('success', 'Arsip berhasil dihapus.');
    }
}
