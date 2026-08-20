<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with('uploadedBy')->orderBy('created_at', 'desc');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_arsip', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('jenis_surat')) {
            $query->where('kategori', $request->jenis_surat);
        } elseif ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $arsip = $query->paginate(10)->withQueryString();
        $totalArsip = Arsip::count();

        return view('arsip.index', compact('arsip', 'totalArsip'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_arsip' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string',
            'file' => 'required|file|max:20480',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|string|max:4',
            'is_rahasia' => 'boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        Arsip::create([
            'nomor_arsip' => $validated['nomor_arsip'] ?? null,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kategori' => $validated['kategori'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            'tanggal_dokumen' => $validated['tanggal_dokumen'] ?? null,
            'tahun' => $validated['tahun'] ?? date('Y'),
            'is_rahasia' => $request->boolean('is_rahasia'),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('arsip.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy(Arsip $arsip)
    {
        Storage::disk('public')->delete($arsip->file_path);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus.');
    }
}
