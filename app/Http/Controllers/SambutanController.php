<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use App\Models\Personel;
use App\Exports\SambutanRekapExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SambutanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('tab', 'permohonan');
        
        if ($jenis === 'hasil') {
            $query = Sambutan::with('petugas')
                ->where(function ($q) {
                    $q->whereNotNull('file_hasil_path')
                      ->orWhere('status', 'selesai');
                })
                ->orderBy('tgl_upload_hasil', 'desc')
                ->orderBy('created_at', 'desc');
        } else {
            $query = Sambutan::with('petugas')
                ->orderBy('created_at', 'desc');
        }

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

        if ($request->filled('filter_tahun')) {
            $query->whereYear('tanggal_terima', (int) $request->filter_tahun);
        }

        if ($request->filled('filter_bulan')) {
            $query->whereMonth('tanggal_terima', (int) $request->filter_bulan);
        }

        $sambutan = $query->paginate(10)->withQueryString();

        $pendingSambutan = Sambutan::whereNull('file_hasil_path')
            ->orderBy('created_at', 'desc')
            ->get();

        $filterTahun = $request->get('filter_tahun', '');
        $filterBulan = $request->get('filter_bulan', '');

        return view('sub-komunikasi-pimpinan.index', compact('sambutan', 'jenis', 'pendingSambutan', 'filterTahun', 'filterBulan'));
    }

    public function createPermohonan()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah permohonan sambutan.');
        }

        $personelList = $this->getPetugasDisposisiList();
        return view('sub-komunikasi-pimpinan.create-permohonan', compact('personelList'));
    }

    public function createHasil()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah hasil sambutan.');
        }

        $pendingSambutan = Sambutan::whereNull('file_hasil_path')
            ->orderBy('created_at', 'desc')
            ->get();

        $allSambutan = Sambutan::orderBy('created_at', 'desc')->get();

        return view('sub-komunikasi-pimpinan.create-hasil', compact('pendingSambutan', 'allSambutan'));
    }

    public function uploadHasil(Request $request, Sambutan $sambutan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah naskah sambutan.');
        }

        $request->validate([
            'dokumen_hasil' => 'required|file|mimes:pdf,doc,docx|max:15360',
            'catatan_hasil' => 'nullable|string',
            'status'        => 'nullable|in:diproses,selesai',
        ], [
            'dokumen_hasil.required' => 'File naskah hasil sambutan wajib diunggah.',
            'dokumen_hasil.mimes'    => 'Format file naskah harus berupa PDF, DOC, atau DOCX.',
            'dokumen_hasil.max'      => 'Ukuran file maksimal adalah 15MB.',
        ]);

        if ($sambutan->file_hasil_path) {
            Storage::disk('public')->delete($sambutan->file_hasil_path);
        }

        $file = $request->file('dokumen_hasil');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('sambutan/hasil', 'public');

        $status = $request->input('status', 'selesai');

        $sambutan->update([
            'file_hasil_path'  => $filePath,
            'file_hasil_name'  => $fileName,
            'tgl_upload_hasil' => now(),
            'catatan_hasil'    => $request->catatan_hasil,
            'status'           => $status,
        ]);

        return redirect()->back()->with('success', 'Naskah hasil sambutan berhasil disimpan dan disatukan ke surat nomor ' . $sambutan->nomor_surat . '.');
    }

    public function uploadHasilGlobal(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunggah naskah sambutan.');
        }

        $request->validate([
            'sambutan_id'   => 'required|exists:sambutan,id',
            'dokumen_hasil' => 'required|file|mimes:pdf,doc,docx|max:15360',
            'catatan_hasil' => 'nullable|string',
            'status'        => 'nullable|in:diproses,selesai',
        ], [
            'sambutan_id.required'   => 'Pilih surat permohonan sambutan terlebih dahulu.',
            'dokumen_hasil.required' => 'File naskah hasil sambutan wajib diunggah.',
            'dokumen_hasil.mimes'    => 'Format file naskah harus berupa PDF, DOC, atau DOCX.',
            'dokumen_hasil.max'      => 'Ukuran file maksimal adalah 15MB.',
        ]);

        $sambutan = Sambutan::findOrFail($request->sambutan_id);

        if ($sambutan->file_hasil_path) {
            Storage::disk('public')->delete($sambutan->file_hasil_path);
        }

        $file = $request->file('dokumen_hasil');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('sambutan/hasil', 'public');

        $status = $request->input('status', 'selesai');

        $sambutan->update([
            'file_hasil_path'  => $filePath,
            'file_hasil_name'  => $fileName,
            'tgl_upload_hasil' => now(),
            'catatan_hasil'    => $request->catatan_hasil,
            'status'           => $status,
        ]);

        return redirect()->route('sambutan.index', ['tab' => 'hasil'])
            ->with('success', 'Naskah hasil sambutan berhasil disimpan dan disatukan ke surat nomor ' . $sambutan->nomor_surat . '.');
    }

    public function deleteHasil(Sambutan $sambutan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus naskah sambutan.');
        }

        if ($sambutan->file_hasil_path) {
            Storage::disk('public')->delete($sambutan->file_hasil_path);
        }

        $sambutan->update([
            'file_hasil_path'  => null,
            'file_hasil_name'  => null,
            'tgl_upload_hasil' => null,
            'catatan_hasil'    => null,
            'status'           => 'diproses',
        ]);

        return redirect()->back()->with('success', 'Dokumen naskah hasil sambutan berhasil dihapus dari surat nomor ' . $sambutan->nomor_surat . '.');
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
            'waktu_acara'    => 'nullable|string|max:50',
            'asal_instansi'  => 'required|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'tujuan_custom'  => 'nullable|string|max:255',
            'perihal'        => 'required|string',
            'status'         => 'nullable|in:draft,diproses,proses,selesai',
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
        if ($status === 'proses') {
            $status = 'diproses';
        }

        $file     = $request->file('dokumen');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('sambutan', 'public');

        $sambutan = Sambutan::create([
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_acara'      => $request->tanggal_acara,
            'waktu_acara'        => $request->waktu_acara,
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

        $personelList = $this->getPetugasDisposisiList();
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
            'waktu_acara'    => 'nullable|string|max:50',
            'asal_instansi'  => 'required|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'tujuan_custom'  => 'nullable|string|max:255',
            'perihal'        => 'required|string',
            'status'         => 'nullable|in:draft,diproses,proses,selesai',
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

        $status = $request->input('status', $sambutan->status);
        if ($status === 'proses') {
            $status = 'diproses';
        }

        $data = [
            'nomor_surat'        => $request->nomor_surat,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_acara'      => $request->tanggal_acara,
            'waktu_acara'        => $request->waktu_acara,
            'asal_instansi'      => $request->asal_instansi,
            'tujuan'             => $tujuan,
            'perihal'            => $request->perihal,
            'deskripsi_singkat'  => $request->deskripsi_singkat,
            'tenggat_waktu'      => $request->tenggat_waktu,
            'deadline_at'        => $deadlineAt,
            'status'             => $status,
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

        if ($request->hasFile('dokumen_hasil')) {
            if ($sambutan->file_hasil_path) {
                Storage::disk('public')->delete($sambutan->file_hasil_path);
            }
            $fileHasil = $request->file('dokumen_hasil');
            $data['file_hasil_name'] = $fileHasil->getClientOriginalName();
            $data['file_hasil_path'] = $fileHasil->store('sambutan/hasil', 'public');
            $data['tgl_upload_hasil'] = now();
            if (!$request->filled('status') || $request->status === 'draft') {
                $data['status'] = 'selesai';
            }
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
        if ($sambutan->file_hasil_path) {
            Storage::disk('public')->delete($sambutan->file_hasil_path);
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
            if ($item->file_hasil_path) {
                Storage::disk('public')->delete($item->file_hasil_path);
            }
            $item->delete();
        }

        return redirect()->route('sambutan.index', ['tab' => $request->get('tab', 'permohonan')])
            ->with('success', count($items) . ' surat berhasil dihapus.');
    }

    /**
     * Mendapatkan daftar 3 pegawai khusus disposisi sambutan:
     * 1. AHMAD MUJADDID ABDURROYAN, S.Psi (NIP: 199702212025211055)
     * 2. MOCHAMAD ANGGA PRATAMA, S.I.Kom. (NIP: 199609052025211070)
     * 3. LIES RIKA FATIMAH, S.I.Kom (NIP: 197211232025212001)
     */
    public function exportRekap(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);
        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) now()->year;
        }

        $bulan = $request->filled('bulan') ? (int) $request->bulan : null;
        if ($bulan !== null && ($bulan < 1 || $bulan > 12)) {
            $bulan = null;
        }

        $export = new SambutanRekapExport($tahun, $bulan);
        return $export->download();
    }

    /**
     * Halaman Pratinjau Naskah Hasil Sambutan (Preview & Download Choice)
     */
    public function previewHasil(Sambutan $sambutan)
    {
        if (!$sambutan->file_hasil_path) {
            return redirect()->route('sambutan.index')->with('error', 'Naskah hasil sambutan belum diunggah.');
        }

        $path = storage_path('app/public/' . $sambutan->file_hasil_path);
        $fileExists = file_exists($path);
        $ext = strtolower(pathinfo($sambutan->file_hasil_path, PATHINFO_EXTENSION));
        $fileName = $sambutan->file_hasil_name ?: basename($sambutan->file_hasil_path);
        $fileSize = $fileExists ? filesize($path) : 0;

        return view('sub-komunikasi-pimpinan.preview-hasil', compact(
            'sambutan', 'fileExists', 'ext', 'fileName', 'fileSize'
        ));
    }

    /**
     * Buka dokumen secara inline langsung di browser tanpa download paksa
     */
    public function streamHasil(Sambutan $sambutan)
    {
        if (!$sambutan->file_hasil_path) {
            abort(404, 'File naskah hasil belum diunggah.');
        }

        $path = storage_path('app/public/' . $sambutan->file_hasil_path);
        if (!file_exists($path)) {
            abort(404, 'File naskah hasil tidak ditemukan di server.');
        }

        $fileName = $sambutan->file_hasil_name ?: basename($sambutan->file_hasil_path);
        $mime = mime_content_type($path) ?: 'application/octet-stream';

        return response()->file($path, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . addslashes($fileName) . '"',
        ]);
    }

    /**
     * Unduh file naskah hasil secara langsung
     */
    public function downloadHasil(Sambutan $sambutan)
    {
        if (!$sambutan->file_hasil_path) {
            abort(404, 'File naskah hasil belum diunggah.');
        }

        $path = storage_path('app/public/' . $sambutan->file_hasil_path);
        if (!file_exists($path)) {
            abort(404, 'File naskah hasil tidak ditemukan di server.');
        }

        $fileName = $sambutan->file_hasil_name ?: basename($sambutan->file_hasil_path);

        return response()->download($path, $fileName);
    }

    /**
     * Mendapatkan daftar 4 pegawai khusus disposisi sambutan:
     * 1. AHMAD MUJADDID ABDURROYAN, S.Psi (NIP: 199702212025211055)
     * 2. MOCHAMAD ANGGA PRATAMA, S.I.Kom. (NIP: 199609052025211070)
     * 3. LIES RIKA FATIMAH, S.I.Kom (NIP: 197211232025212001)
     * 4. RUDINI (Outsourcing, email: rudini@bandung.go.id)
     */
    private function getPetugasDisposisiList()
    {
        $targetNips = [
            '199702212025211055', // AHMAD MUJADDID ABDURROYAN, S.Psi
            '199609052025211070', // MOCHAMAD ANGGA PRATAMA, S.I.Kom.
            '197211232025212001', // LIES RIKA FATIMAH, S.I.Kom
        ];

        $targetEmails = [
            'ahmad.mujaddid@bandung.go.id',
            'mochamad.angga@bandung.go.id',
            'lies.rika@bandung.go.id',
            'rudini@bandung.go.id', // RUDINI (Outsourcing)
        ];

        $personels = Personel::where(function ($query) use ($targetNips, $targetEmails) {
            $query->whereIn('nip', $targetNips)
                  ->orWhereIn('email', $targetEmails)
                  ->orWhere('nama_lengkap', 'like', '%AHMAD MUJADDID%')
                  ->orWhere('nama_lengkap', 'like', '%MOCHAMAD ANGGA PRATAMA%')
                  ->orWhere('nama_lengkap', 'like', '%LIES RIKA FATIMAH%')
                  ->orWhere('nama_lengkap', 'like', '%RUDINI%');
        })->get();

        if ($personels->isEmpty()) {
            return Personel::all();
        }

        $orderMap = [
            '199702212025211055' => 1,
            '199609052025211070' => 2,
            '197211232025212001' => 3,
        ];

        return $personels->sortBy(function ($p) use ($orderMap) {
            if (isset($orderMap[$p->nip])) {
                return $orderMap[$p->nip];
            }
            if (str_contains($p->nama_lengkap, 'AHMAD MUJADDID')) return 1;
            if (str_contains($p->nama_lengkap, 'ANGGA PRATAMA')) return 2;
            if (str_contains($p->nama_lengkap, 'LIES RIKA')) return 3;
            if (str_contains($p->nama_lengkap, 'RUDINI')) return 4;
            return 99;
        })->values();
    }
}
