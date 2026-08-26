<?php

namespace App\Http\Controllers;

use App\Models\DaftarHadir;
use App\Models\Kegiatan;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarHadirController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarHadir::with(['kegiatan', 'personel'])->orderBy('created_at', 'desc');
        if ($request->filled('kegiatan_id')) $query->where('kegiatan_id', $request->kegiatan_id);
        if ($request->filled('status_hadir')) $query->where('status_hadir', $request->status_hadir);
        $daftarHadir = $query->paginate(15)->withQueryString();
        $kegiatan = Kegiatan::orderBy('tanggal_mulai', 'desc')->get();
        $personel = Personel::all();
        return view('daftar-hadir.index', compact('daftarHadir', 'kegiatan', 'personel'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah data kehadiran.');
        }

        $validated = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_peserta' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'status_hadir' => 'required|in:hadir,tidak_hadir,izin',
            'jam_hadir' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);
        DaftarHadir::create($validated);
        return redirect()->route('daftar-hadir.index')->with('success', 'Data kehadiran berhasil disimpan.');
    }

    public function destroy(DaftarHadir $daftarHadir)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus data kehadiran.');
        }

        $daftarHadir->delete();
        return redirect()->route('daftar-hadir.index')->with('success', 'Data kehadiran berhasil dihapus.');
    }
}
