<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use App\Models\Personel;
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
                  ->orWhere('perihal', 'like', "%{$s}%");
            });
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
        $personelList = Personel::all();
        return view('sub-komunikasi-pimpinan.create-permohonan', compact('personelList'));
    }

    public function createHasil()
    {
        return view('sub-komunikasi-pimpinan.create-hasil');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'    => 'required|string|max:100',
            'tanggal_surat'  => 'required|date',
            'asal_instansi'  => 'required|string|max:255',
            'perihal'        => 'required|string',
            'status_urgensi' => 'required|in:biasa,segera,penting',
            'jenis'          => 'required|in:permohonan,hasil',
            'dokumen'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'dokumen.required' => 'Dokumen pendukung wajib diunggah sebelum menyimpan dan melanjutkan.',
            'dokumen.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.max' => 'Ukuran file maksimal adalah 10MB.',
        ]);

        $file     = $request->file('dokumen');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('sambutan', 'public');

        $sambutan = Sambutan::create([
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'asal_instansi'      => $request->asal_instansi,
            'perihal'            => $request->perihal,
            'deskripsi_singkat'  => $request->deskripsi_singkat,
            'tanggal_terima'     => now()->toDateString(),
            'tenggat_waktu'      => $request->tenggat_waktu,
            'file_path'          => $filePath,
            'file_name'          => $fileName,
            'status_urgensi'     => $request->status_urgensi,
            'instruksi_disposisi'=> $request->instruksi,
            'petugas_id'         => $request->petugas_id ?: null,
            'jenis'              => $request->jenis,
            'status'             => 'diproses',
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
        if ($sambutan->jenis === 'hasil') {
            return view('sub-komunikasi-pimpinan.edit-hasil', compact('sambutan'));
        }

        $personelList = Personel::all();
        return view('sub-komunikasi-pimpinan.edit-permohonan', compact('sambutan', 'personelList'));
    }

    public function update(Request $request, Sambutan $sambutan)
    {
        $request->validate([
            'nomor_surat'    => 'required|string|max:100',
            'tanggal_surat'  => 'required|date',
            'asal_instansi'  => 'required|string|max:255',
            'perihal'        => 'required|string',
            'status_urgensi' => 'required|in:biasa,segera,penting',
        ]);

        $data = [
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'asal_instansi'      => $request->asal_instansi,
            'perihal'            => $request->perihal,
            'deskripsi_singkat'  => $request->deskripsi_singkat,
            'tenggat_waktu'      => $request->tenggat_waktu,
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
        if ($sambutan->file_path) {
            Storage::disk('public')->delete($sambutan->file_path);
        }
        $sambutan->delete();
        return redirect()->route('sambutan.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
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
