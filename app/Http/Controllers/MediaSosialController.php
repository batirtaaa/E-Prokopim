<?php

namespace App\Http\Controllers;

use App\Models\MediaSosial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaSosialController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'infografis');

        $query = MediaSosial::where('kategori', $tab)
            ->orderBy('tanggal_publikasi', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('deskripsi', 'like', "%{$s}%")
                  ->orWhere('platform', 'like', "%{$s}%");
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_publikasi', now()->month)
                  ->whereYear('tanggal_publikasi', now()->year);
        }

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(6)->withQueryString();

        return view('sub-komunikasi-pimpinan.media-sosial.index', compact('items', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'kategori'          => 'required|in:infografis,videografis,media_luar_ruang',
            'platform'          => 'required|string|max:50',
            'deskripsi'         => 'nullable|string',
            'tanggal_publikasi' => 'required|date',
            'status'            => 'required|in:dipublikasi,draft,dijadwalkan',
            'file_media'        => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,pdf|max:25600',
            'link_post'         => 'nullable|url',
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file_media')) {
            $file     = $request->file('file_media');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('media-sosial', 'public');
        }

        MediaSosial::create([
            'judul'             => $request->judul,
            'kategori'          => $request->kategori,
            'platform'          => strtolower($request->platform),
            'deskripsi'         => $request->deskripsi,
            'file_path'         => $filePath,
            'file_name'         => $fileName,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'status'            => $request->status,
            'link_post'         => $request->link_post,
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('media-sosial.index', ['tab' => $request->kategori])
            ->with('success', 'Media berhasil ditambahkan ke arsip.');
    }

    public function update(Request $request, MediaSosial $mediaSosial)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'kategori'          => 'required|in:infografis,videografis,media_luar_ruang',
            'platform'          => 'required|string|max:50',
            'deskripsi'         => 'nullable|string',
            'tanggal_publikasi' => 'required|date',
            'status'            => 'required|in:dipublikasi,draft,dijadwalkan',
            'file_media'        => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,pdf|max:25600',
            'link_post'         => 'nullable|url',
        ]);

        $data = [
            'judul'             => $request->judul,
            'kategori'          => $request->kategori,
            'platform'          => strtolower($request->platform),
            'deskripsi'         => $request->deskripsi,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'status'            => $request->status,
            'link_post'         => $request->link_post,
        ];

        if ($request->hasFile('file_media')) {
            if ($mediaSosial->file_path) {
                Storage::disk('public')->delete($mediaSosial->file_path);
            }
            $file              = $request->file('file_media');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('media-sosial', 'public');
        }

        $mediaSosial->update($data);

        return redirect()->route('media-sosial.index', ['tab' => $request->kategori])
            ->with('success', 'Data arsip media berhasil diperbarui.');
    }

    public function destroy(MediaSosial $mediaSosial)
    {
        $tab = $mediaSosial->kategori;
        if ($mediaSosial->file_path) {
            Storage::disk('public')->delete($mediaSosial->file_path);
        }
        $mediaSosial->delete();

        return redirect()->route('media-sosial.index', ['tab' => $tab])
            ->with('success', 'Media berhasil dihapus dari arsip.');
    }
}
