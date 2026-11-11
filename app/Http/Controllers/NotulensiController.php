<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Kegiatan;
use App\Models\User;
use App\Services\FileNamingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotulensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Notulensi::with(['kegiatan', 'notulis'])->orderBy('tanggal_rapat', 'desc');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('keywords', 'like', '%' . $keyword . '%')
                  ->orWhere('isi_notulensi', 'like', '%' . $keyword . '%')
                  ->orWhere('agenda', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $notulensi = $query->paginate(10)->withQueryString();
        $kegiatan  = Kegiatan::orderBy('tanggal_mulai', 'desc')->get();
        $users     = User::where('is_active', true)->get();

        return view('notulensi.index', compact('notulensi', 'kegiatan', 'users'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah notulensi.');
        }

        $validated = $request->validate([
            'kegiatan_id'    => 'nullable|exists:kegiatan,id',
            'judul'          => 'required|string|max:255',
            'tanggal_rapat'  => 'required|date',
            'tempat'         => 'required|string|max:255',
            'peserta'        => 'nullable|string',
            'agenda'         => 'nullable|string',
            'isi_notulensi'  => 'required|string',
            'kesimpulan'     => 'nullable|string',
            'tindak_lanjut'  => 'nullable|string',
            'keywords'       => 'nullable|string|max:1000',
            'status'         => 'required|in:draft,final',
            'notulis_id'     => 'nullable|exists:users,id',
            'file_notulensi' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx|max:20480',
            'file_paparan'   => 'nullable|file|mimes:pdf,ppt,pptx|max:20480',
        ]);

        $validated['created_by'] = Auth::id();

        $tglNotulensi = now();
        if ($request->filled('kegiatan_id')) {
            $kg = Kegiatan::find($request->kegiatan_id);
            if ($kg && $kg->tanggal_mulai) {
                $tglNotulensi = $kg->tanggal_mulai;
            }
        }

        if ($request->hasFile('file_notulensi')) {
            $fNot = $request->file('file_notulensi');
            $isoNot = FileNamingService::formatIsoFileName(
                $tglNotulensi,
                $request->judul,
                $fNot->getClientOriginalExtension(),
                'Notulensi'
            );
            $safeNot = FileNamingService::ensureUniqueName('notulensi/dokumen', $isoNot);
            $validated['file_notulensi'] = $fNot->storeAs('notulensi/dokumen', $safeNot, 'public');
        }

        if ($request->hasFile('file_paparan')) {
            $fPap = $request->file('file_paparan');
            $isoPap = FileNamingService::formatIsoFileName(
                $tglNotulensi,
                $request->judul,
                $fPap->getClientOriginalExtension(),
                'Paparan'
            );
            $safePap = FileNamingService::ensureUniqueName('notulensi/paparan', $isoPap);
            $validated['file_paparan'] = $fPap->storeAs('notulensi/paparan', $safePap, 'public');
        }

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
        $users    = User::where('is_active', true)->get();

        return view('notulensi.edit', compact('notulensi', 'kegiatan', 'users'));
    }

    public function update(Request $request, Notulensi $notulensi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit notulensi.');
        }

        $validated = $request->validate([
            'kegiatan_id'    => 'nullable|exists:kegiatan,id',
            'judul'          => 'required|string|max:255',
            'tanggal_rapat'  => 'required|date',
            'tempat'         => 'required|string|max:255',
            'peserta'        => 'nullable|string',
            'agenda'         => 'nullable|string',
            'isi_notulensi'  => 'required|string',
            'kesimpulan'     => 'nullable|string',
            'tindak_lanjut'  => 'nullable|string',
            'keywords'       => 'nullable|string|max:1000',
            'status'         => 'required|in:draft,final',
            'notulis_id'     => 'nullable|exists:users,id',
            'file_notulensi' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx|max:20480',
            'file_paparan'   => 'nullable|file|mimes:pdf,ppt,pptx|max:20480',
        ]);

        $tglNotulensi = now();
        $kgId = $request->filled('kegiatan_id') ? $request->kegiatan_id : $notulensi->kegiatan_id;
        if ($kgId) {
            $kg = Kegiatan::find($kgId);
            if ($kg && $kg->tanggal_mulai) {
                $tglNotulensi = $kg->tanggal_mulai;
            }
        }

        // Handle file_notulensi upload
        if ($request->hasFile('file_notulensi')) {
            if ($notulensi->file_notulensi) {
                Storage::disk('public')->delete($notulensi->file_notulensi);
            }
            $fNot = $request->file('file_notulensi');
            $isoNot = FileNamingService::formatIsoFileName(
                $tglNotulensi,
                $request->judul ?: $notulensi->judul,
                $fNot->getClientOriginalExtension(),
                'Notulensi'
            );
            $safeNot = FileNamingService::ensureUniqueName('notulensi/dokumen', $isoNot);
            $validated['file_notulensi'] = $fNot->storeAs('notulensi/dokumen', $safeNot, 'public');
        } elseif ($request->boolean('hapus_file_notulensi')) {
            if ($notulensi->file_notulensi) {
                Storage::disk('public')->delete($notulensi->file_notulensi);
            }
            $validated['file_notulensi'] = null;
        }

        // Handle file_paparan upload
        if ($request->hasFile('file_paparan')) {
            if ($notulensi->file_paparan) {
                Storage::disk('public')->delete($notulensi->file_paparan);
            }
            $fPap = $request->file('file_paparan');
            $isoPap = FileNamingService::formatIsoFileName(
                $tglNotulensi,
                $request->judul ?: $notulensi->judul,
                $fPap->getClientOriginalExtension(),
                'Paparan'
            );
            $safePap = FileNamingService::ensureUniqueName('notulensi/paparan', $isoPap);
            $validated['file_paparan'] = $fPap->storeAs('notulensi/paparan', $safePap, 'public');
        } elseif ($request->boolean('hapus_file_paparan')) {
            if ($notulensi->file_paparan) {
                Storage::disk('public')->delete($notulensi->file_paparan);
            }
            $validated['file_paparan'] = null;
        }

        $notulensi->update($validated);

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy(Notulensi $notulensi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus notulensi.');
        }

        $notulensi->delete();

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil dipindahkan ke Sampah (Trash).');
    }

    public function download(Notulensi $notulensi, string $type = 'notulensi')
    {
        $path = $type === 'paparan' ? $notulensi->file_paparan : $notulensi->file_notulensi;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($path);
    }
}
