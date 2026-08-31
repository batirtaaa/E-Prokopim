<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use App\Models\Personel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SambutanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('tab', 'permohonan');
        $query = Sambutan::with('petugas')
            ->where('jenis', $jenis)
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%")
                  ->orWhere('asal_instansi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_terima', now()->month)
                  ->whereYear('tanggal_terima', now()->year);
        }

        $sambutan = $query->paginate(10)->withQueryString();

        return view('sub-komunikasi-pimpinan.index', compact('sambutan', 'jenis'));
    }

    public function createPermohonan()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah permohonan sambutan.');
        }

        $personelList = Personel::all();
        return view('sub-komunikasi-pimpinan.create-permohonan', compact('personelList'));
    }

    public function createHasil()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah hasil sambutan.');
        }

        return view('sub-komunikasi-pimpinan.create-hasil');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah naskah sambutan.');
        }

        $request->validate([
            'nomor_surat'    => 'required|string|max:100',
            'tanggal_surat'  => 'required|date',
            'tanggal_acara'  => 'nullable|date',
            'asal_instansi'  => 'required|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'tujuan_custom'  => 'nullable|string|max:255',
            'perihal'        => 'required|string',
            'status'         => 'nullable|in:draft,diproses,selesai',
            'status_urgensi' => 'required|in:biasa,segera,penting',
            'jenis'          => 'required|in:permohonan,hasil',
            'tenggat_waktu'  => 'nullable|date',
            'deadline_jam'   => 'nullable|string',
            'dokumen'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'dokumen.required' => 'Dokumen pendukung wajib diunggah sebelum menyimpan dan melanjutkan.',
            'dokumen.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file maksimal adalah 10MB.',
        ]);

        if ($request->tujuan === 'lainnya') {
            $tujuan = trim($request->tujuan_custom) ?: 'Lainnya';
        } else {
            $tujuan = $request->tujuan;
        }

        $deadlineAt = null;
        if ($request->filled('tenggat_waktu')) {
            $jam = $request->filled('deadline_jam') ? $request->deadline_jam : '16:00:00';
            try {
                $deadlineAt = Carbon::parse($request->tenggat_waktu . ' ' . $jam);
            } catch (\Exception $e) {
                $deadlineAt = Carbon::parse($request->tenggat_waktu . ' 23:59:59');
            }
        }

        $status = $request->input('status', 'diproses');

        $file     = $request->file('dokumen');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('sambutan', 'public');

        $sambutan = Sambutan::create([
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_acara'      => $request->tanggal_acara,
            'asal_instansi'      => $request->asal_instansi,
            'tujuan'             => $tujuan,
            'perihal'            => $request->perihal,
            'deskripsi_singkat'  => $request->deskripsi_singkat,
            'tanggal_terima'     => now()->toDateString(),
            'tenggat_waktu'      => $request->tenggat_waktu,
            'deadline_at'        => $deadlineAt,
            'file_path'          => $filePath,
            'file_name'          => $fileName,
            'status_urgensi'     => $request->status_urgensi,
            'instruksi_disposisi'=> $request->instruksi,
            'petugas_id'         => $request->petugas_id ?: null,
            'jenis'              => $request->jenis,
            'status'             => $status,
            'created_by'         => Auth::id(),
        ]);

        return redirect()->route('sambutan.success', $sambutan);
    }

    public function success(Sambutan $sambutan)
    {
        $sambutan->load('petugas');
        return view('sub-komunikasi-pimpinan.success', compact('sambutan'));
    }

    public function edit(Sambutan $sambutan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit sambutan.');
        }

        if ($sambutan->jenis === 'hasil') {
            return view('sub-komunikasi-pimpinan.edit-hasil', compact('sambutan'));
        }

        $personelList = Personel::all();
        return view('sub-komunikasi-pimpinan.edit-permohonan', compact('sambutan', 'personelList'));
    }

    public function update(Request $request, Sambutan $sambutan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit sambutan.');
        }

        $request->validate([
            'nomor_surat'    => 'required|string|max:100',
            'tanggal_surat'  => 'required|date',
            'tanggal_acara'  => 'nullable|date',
            'asal_instansi'  => 'required|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'tujuan_custom'  => 'nullable|string|max:255',
            'perihal'        => 'required|string',
            'status'         => 'nullable|in:draft,diproses,selesai',
            'status_urgensi' => 'required|in:biasa,segera,penting',
            'tenggat_waktu'  => 'nullable|date',
            'deadline_jam'   => 'nullable|string',
        ]);

        if ($request->tujuan === 'lainnya') {
            $tujuan = trim($request->tujuan_custom) ?: 'Lainnya';
        } else {
            $tujuan = $request->tujuan;
        }

        $deadlineAt = null;
        if ($request->filled('tenggat_waktu')) {
            $jam = $request->filled('deadline_jam') ? $request->deadline_jam : '16:00:00';
            try {
                $deadlineAt = Carbon::parse($request->tenggat_waktu . ' ' . $jam);
            } catch (\Exception $e) {
                $deadlineAt = Carbon::parse($request->tenggat_waktu . ' 23:59:59');
            }
        }

        $data = [
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_acara'      => $request->tanggal_acara,
            'asal_instansi'      => $request->asal_instansi,
            'tujuan'             => $tujuan,
            'perihal'            => $request->perihal,
            'deskripsi_singkat'  => $request->deskripsi_singkat,
            'tenggat_waktu'      => $request->tenggat_waktu,
            'deadline_at'        => $deadlineAt,
            'status'             => $request->input('status', $sambutan->status),
            'status_urgensi'     => $request->status_urgensi,
            'instruksi_disposisi'=> $request->instruksi,
            'petugas_id'         => $request->petugas_id ?: null,
        ];

        if ($request->hasFile('dokumen')) {
            if ($sambutan->file_path) {
                Storage::disk('public')->delete($sambutan->file_path);
            }
            $file = $request->file('dokumen');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('sambutan', 'public');
        }

        $sambutan->update($data);

        return redirect()->route('sambutan.index', ['tab' => $sambutan->jenis])
            ->with('success', 'Data surat sambutan berhasil diperbarui.');
    }

    public function destroy(Sambutan $sambutan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus sambutan.');
        }

        if ($sambutan->file_path) {
            Storage::disk('public')->delete($sambutan->file_path);
        }
        $sambutan->delete();
        return redirect()->route('sambutan.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus surat.');
        }

        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:sambutan,id',
        ]);

        $items = Sambutan::whereIn('id', $request->selected_ids)->get();
        foreach ($items as $item) {
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }
            $item->delete();
        }

        return redirect()->route('sambutan.index', ['tab' => $request->get('tab', 'permohonan')])
            ->with('success', count($items) . ' surat berhasil dihapus.');
    }
}
