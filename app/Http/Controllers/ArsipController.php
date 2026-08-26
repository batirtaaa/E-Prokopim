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
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nomor_arsip', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('jenis_surat') && $request->jenis_surat !== 'semua') {
            $query->where('kategori', $request->jenis_surat);
        } elseif ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('start_date')) {
            $startDate = $request->start_date;
            $query->where(function($q) use ($startDate) {
                $q->whereDate('tanggal_dokumen', '>=', $startDate)
                  ->orWhereDate('created_at', '>=', $startDate);
            });
        }
        if ($request->filled('end_date')) {
            $endDate = $request->end_date;
            $query->where(function($q) use ($endDate) {
                $q->whereDate('tanggal_dokumen', '<=', $endDate)
                  ->orWhereDate('created_at', '<=', $endDate);
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $perPage = $request->get('per_page', 10);
        $arsip = $query->paginate($perPage)->withQueryString();
        $totalArsip = Arsip::count();
        $customCategories = Arsip::select('kategori')
            ->whereNotNull('kategori')
            ->whereNotIn('kategori', ['surat_masuk', 'surat_keluar', 'sk', 'nota_dinas', 'laporan', 'peraturan', 'lainnya'])
            ->distinct()
            ->pluck('kategori');

        return view('arsip.index', compact('arsip', 'totalArsip', 'customCategories'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah arsip.');
        }

        $users = \App\Models\User::orderBy('name')->get();
        return view('arsip.create', compact('users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah arsip.');
        }

        $validated = $request->validate([
            'nomor_arsip' => 'required|string|max:100',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string',
            'kategori_custom' => 'nullable|string|max:100',
            'sifat_surat' => 'nullable|string',
            'file' => 'required|file|max:20480',
            'tanggal_dokumen' => 'required|date',
            'tahun' => 'nullable|string|max:4',
            'uploaded_by' => 'nullable|exists:users,id',
            'is_rahasia' => 'nullable|boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        $kategori = $validated['kategori'];
        if ($kategori === 'lainnya' && $request->filled('kategori_custom')) {
            $kategori = trim($request->kategori_custom);
        }

        Arsip::create([
            'nomor_arsip' => $validated['nomor_arsip'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kategori' => $kategori,
            'sifat_surat' => $validated['sifat_surat'] ?? 'biasa',
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'tahun' => $validated['tahun'] ?? date('Y', strtotime($validated['tanggal_dokumen'])),
            'is_rahasia' => ($request->sifat_surat === 'rahasia' || $request->boolean('is_rahasia')),
            'uploaded_by' => $validated['uploaded_by'] ?? Auth::id(),
        ]);

        return redirect()->route('arsip.index')->with('success', 'Dokumen arsip berhasil disimpan.');
    }

    public function destroy(Arsip $arsip)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus arsip.');
        }

        Storage::disk('public')->delete($arsip->file_path);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus.');
    }
}
