<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Kegiatan;
use App\Models\Personel;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PenugasanController extends Controller
{
    public function index(Request $request)
    {
        // Query activities that have penugasan
        $query = Kegiatan::whereHas('penugasan')
            ->with(['penugasan.personel'])
            ->orderBy('tanggal_mulai', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhereHas('penugasan.personel', function($pq) use ($search) {
                      $pq->where('nama_lengkap', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('role')) {
            $role = $request->role;
            $query->whereHas('penugasan', function($q) use ($role) {
                $q->where('peran', $role);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_mulai', $request->tanggal);
        }

        $kegiatanPenugasan = $query->paginate(10)->withQueryString();

        // Status personel sidebar
        $personelStatus = Personel::with('user')->orderBy('nama_lengkap', 'asc')->get();

        // Stats calculation
        $totalPenugasan = Penugasan::whereHas('kegiatan', fn($q) => $q->whereDate('tanggal_mulai', Carbon::today()))->count();
        if ($totalPenugasan === 0) {
            $totalPenugasan = Penugasan::count();
        }
        $personelSiaga = Personel::where('status_ketersediaan', 'standby')->count();
        $belumDikonfirmasi = Penugasan::where('status', 'ditugaskan')->count();

        $kegiatan = Kegiatan::where('status', '!=', 'dibatalkan')->orderBy('tanggal_mulai', 'desc')->get();
        $personelList = Personel::orderBy('nama_lengkap', 'asc')->get();

        return view('penugasan.index', compact(
            'kegiatanPenugasan', 'personelStatus', 'totalPenugasan',
            'personelSiaga', 'belumDikonfirmasi', 'kegiatan', 'personelList'
        ));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membuat penugasan.');
        }

        $kegiatan = Kegiatan::where('status', '!=', 'dibatalkan')->orderBy('tanggal_mulai', 'desc')->get();
        $personelList = Personel::orderBy('nama_lengkap', 'asc')->get();
        $personelSiaga = Personel::where('status_ketersediaan', 'standby')->count();

        return view('penugasan.create', compact('kegiatan', 'personelList', 'personelSiaga'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membuat penugasan.');
        }

        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'kategori_tugas' => 'nullable|string|max:100',
            'peran' => 'required|string|max:100',
            'status' => 'nullable|in:ditugaskan,dikonfirmasi,berlangsung,selesai,tidak_hadir',
            'catatan' => 'nullable|string',
            'tenggat_waktu' => 'nullable|string',
            'personel_ids' => 'nullable|array',
            'personel_id' => 'nullable|exists:personel,id',
        ]);

        $personelIds = [];
        if ($request->has('personel_ids') && is_array($request->personel_ids)) {
            $personelIds = array_filter($request->personel_ids);
        } elseif ($request->filled('personel_id')) {
            $personelIds = [$request->personel_id];
        }

        if (empty($personelIds)) {
            return back()->withErrors(['personel_ids' => 'Pilih minimal satu personel yang ditugaskan.'])->withInput();
        }

        $status = $request->input('status', 'ditugaskan');
        $catatan = $request->input('catatan');
        if ($request->filled('tenggat_waktu')) {
            $catatan = ($catatan ? $catatan . "\n" : '') . "Tenggat Waktu Berkumpul: " . $request->tenggat_waktu;
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

        // Kirim notifikasi ke semua user aktif tentang penugasan baru
        $kegiatan = Kegiatan::find($request->kegiatan_id);
        if ($kegiatan && !empty($personelIds)) {
            $jumlah = count($personelIds);
            NotifikasiController::createForAllUsers(
                '📋 Penugasan Baru: ' . $kegiatan->judul,
                "{$jumlah} personel telah ditugaskan untuk kegiatan '{$kegiatan->judul}'.",
                'penugasan',
                route('protokol-pimpinan.penugasan.index')
            );
        }

        return redirect()->route('protokol-pimpinan.penugasan.index')
            ->with('success', 'Penugasan personel berhasil disimpan dan dikirim.');
    }

    public function update(Request $request, Penugasan $penugasan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit penugasan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:ditugaskan,dikonfirmasi,berlangsung,selesai,tidak_hadir',
            'catatan' => 'nullable|string',
        ]);

        if ($validated['status'] === 'dikonfirmasi') {
            $validated['confirmed_at'] = now();
        }

        $penugasan->update($validated);

        if (in_array($validated['status'], ['selesai', 'tidak_hadir'])) {
            $activeOther = Penugasan::where('personel_id', $penugasan->personel_id)
                ->where('id', '!=', $penugasan->id)
                ->whereIn('status', ['ditugaskan', 'dikonfirmasi', 'berlangsung'])
                ->exists();
            if (!$activeOther) {
                Personel::where('id', $penugasan->personel_id)->update(['status_ketersediaan' => 'standby']);
            }
        }

        return redirect()->route('protokol-pimpinan.penugasan.index')
            ->with('success', 'Status penugasan berhasil diperbarui.');
    }

    public function destroy(Penugasan $penugasan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus penugasan.');
        }

        $personelId = $penugasan->personel_id;
        $penugasan->delete();

        $activeOther = Penugasan::where('personel_id', $personelId)
            ->whereIn('status', ['ditugaskan', 'dikonfirmasi', 'berlangsung'])
            ->exists();
        if (!$activeOther) {
            Personel::where('id', $personelId)->update(['status_ketersediaan' => 'standby']);
        }

        return redirect()->route('protokol-pimpinan.penugasan.index')
            ->with('success', 'Penugasan berhasil dihapus.');
    }
}
