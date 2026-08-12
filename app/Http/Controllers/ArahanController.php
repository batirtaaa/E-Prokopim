<?php

namespace App\Http\Controllers;

use App\Models\Arahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Arahan::orderBy('tanggal_arahan', 'desc');
        if ($request->filled('search')) $query->where('judul', 'like', '%' . $request->search . '%');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('prioritas')) $query->where('prioritas', $request->prioritas);
        $arahan = $query->paginate(10)->withQueryString();
        return view('arahan.index', compact('arahan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_arahan' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'isi_arahan' => 'required|string',
            'pimpinan' => 'required|in:wali_kota,wakil_wali_kota,sekda,asisten',
            'ditujukan_kepada' => 'nullable|string|max:255',
            'tanggal_arahan' => 'required|date',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'status' => 'required|in:belum_selesai,sedang_berjalan,selesai,melewati_deadline',
        ]);
        $validated['created_by'] = Auth::id();
        Arahan::create($validated);
        return redirect()->route('arahan.index')->with('success', 'Arahan berhasil disimpan.');
    }

    public function edit(Arahan $arahan)
    {
        return view('arahan.edit', compact('arahan'));
    }

    public function update(Request $request, Arahan $arahan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_arahan' => 'required|string',
            'pimpinan' => 'required|in:wali_kota,wakil_wali_kota,sekda,asisten',
            'tanggal_arahan' => 'required|date',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'status' => 'required|in:belum_selesai,sedang_berjalan,selesai,melewati_deadline',
        ]);
        $arahan->update($validated);
        return redirect()->route('arahan.index')->with('success', 'Arahan berhasil diperbarui.');
    }

    public function destroy(Arahan $arahan)
    {
        $arahan->delete();
        return redirect()->route('arahan.index')->with('success', 'Arahan berhasil dihapus.');
    }
}
