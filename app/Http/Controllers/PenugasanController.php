<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Kegiatan;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PenugasanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penugasan::with(['kegiatan', 'personel'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->whereHas('kegiatan', fn($q) => $q->where('judul', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('role')) {
            $query->where('peran', $request->role);
        }
        if ($request->filled('tanggal')) {
            $query->whereHas('kegiatan', fn($q) => $q->whereDate('tanggal_mulai', $request->tanggal));
        }

        $penugasan = $query->paginate(10)->withQueryString();

        // Status personel sidebar
        $personelStatus = Personel::with('user')->get();

        // Stats
        $totalPenugasan = Penugasan::whereHas('kegiatan', fn($q) => $q->whereDate('tanggal_mulai', Carbon::today()))->count();
        $personelSiaga = Personel::where('status_ketersediaan', 'standby')->count();
        $belumDikonfirmasi = Penugasan::where('status', 'ditugaskan')->count();

        $kegiatan = Kegiatan::where('status', '!=', 'dibatalkan')->orderBy('tanggal_mulai', 'desc')->get();
        $personelList = Personel::all();

        return view('penugasan.index', compact(
            'penugasan', 'personelStatus', 'totalPenugasan',
            'personelSiaga', 'belumDikonfirmasi', 'kegiatan', 'personelList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'peran' => 'required|string|max:100',
            'status' => 'nullable|in:ditugaskan,dikonfirmasi,berlangsung,selesai,tidak_hadir',
            'catatan' => 'nullable|string',
            'tenggat_waktu' => 'nullable|string',
        ]);

        $personelIds = [];
        if ($request->has('personel_ids') && is_array($request->personel_ids)) {
            $personelIds = $request->personel_ids;
        } elseif ($request->filled('personel_id')) {
            $personelIds = [$request->personel_id];
        }

        if (empty($personelIds)) {
            return back()->withErrors(['personel_id' => 'Pilih minimal satu personel.'])->withInput();
        }

        $status = $request->input('status', 'ditugaskan');
        $catatan = $request->input('catatan');
        if ($request->filled('tenggat_waktu')) {
            $catatan = ($catatan ? $catatan . "\n" : '') . "Tenggat Waktu: " . $request->tenggat_waktu;
        }

        foreach ($personelIds as $pId) {
            Penugasan::create([
                'kegiatan_id' => $request->kegiatan_id,
                'personel_id' => $pId,
                'peran' => $request->peran,
                'status' => $status,
                'catatan' => $catatan,
                'assigned_by' => Auth::id(),
            ]);

            Personel::where('id', $pId)->update(['status_ketersediaan' => 'bertugas']);
        }

        return redirect()->route('penugasan.index')
            ->with('success', 'Penugasan berhasil dibuat.');
    }

    public function update(Request $request, Penugasan $penugasan)
    {
        $validated = $request->validate([
            'status' => 'required|in:ditugaskan,dikonfirmasi,berlangsung,selesai,tidak_hadir',
            'catatan' => 'nullable|string',
        ]);

        if ($validated['status'] === 'dikonfirmasi') {
            $validated['confirmed_at'] = now();
        }

        $penugasan->update($validated);
        return redirect()->route('penugasan.index')
            ->with('success', 'Status penugasan berhasil diperbarui.');
    }

    public function destroy(Penugasan $penugasan)
    {
        $penugasan->delete();
        return redirect()->route('penugasan.index')
            ->with('success', 'Penugasan berhasil dihapus.');
    }
}
