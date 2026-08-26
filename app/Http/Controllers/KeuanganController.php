<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_bukti', 'like', "%{$search}%")
                  ->orWhere('uraian', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksi = $query->paginate(10)->withQueryString();
        $totalTransaksi = Keuangan::count();
        $totalNominal = Keuangan::where('status', 'selesai')->sum('nominal');

        return view('keuangan.index', compact('transaksi', 'totalTransaksi', 'totalNominal'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah transaksi keuangan.');
        }
        $kodeOtomatis = Keuangan::generateNextCode();
        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();

        return view('keuangan.create', compact('kodeOtomatis', 'pegawaiList'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah transaksi keuangan.');
        }
        $request->validate([
            'no_bukti' => 'nullable|string|max:50|unique:keuangan,no_bukti',
            'tanggal' => 'required|date',
            'uraian' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'nominal' => 'required|numeric|min:0',
            'penanggung_jawab' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
            'file_bukti' => 'nullable|file|max:10240',
            'catatan' => 'nullable|string',
        ]);

        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('keuangan/bukti', 'public');
        }

        $noBukti = $request->no_bukti ?: Keuangan::generateNextCode();

        Keuangan::create([
            'no_bukti' => $noBukti,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => $request->status,
            'file_bukti' => $filePath,
            'catatan' => $request->catatan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('keuangan.index')
            ->with('success', 'Data transaksi keuangan berhasil dicatat ke dalam sistem.');
    }

    public function edit(Keuangan $keuangan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit transaksi keuangan.');
        }
        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('keuangan.edit', compact('keuangan', 'pegawaiList'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit transaksi keuangan.');
        }
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'nominal' => 'required|numeric|min:0',
            'penanggung_jawab' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
            'file_bukti' => 'nullable|file|max:10240',
            'catatan' => 'nullable|string',
        ]);

        $filePath = $keuangan->file_bukti;
        if ($request->hasFile('file_bukti')) {
            if ($keuangan->file_bukti) {
                Storage::disk('public')->delete($keuangan->file_bukti);
            }
            $filePath = $request->file('file_bukti')->store('keuangan/bukti', 'public');
        }

        $keuangan->update([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => $request->status,
            'file_bukti' => $filePath,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('keuangan.index')
            ->with('success', 'Data transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus transaksi keuangan.');
        }
        if ($keuangan->file_bukti) {
            Storage::disk('public')->delete($keuangan->file_bukti);
        }
        $keuangan->delete();

        return redirect()->route('keuangan.index')
            ->with('success', 'Data transaksi keuangan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $data = Keuangan::orderBy('id', 'asc')->get();
        $filename = 'laporan_keuangan_prokopim_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream(function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'No Bukti', 'Tanggal', 'Uraian Kegiatan', 'Kategori', 'Jenis', 'Nominal (Rp)', 'Penanggung Jawab', 'Status']);
            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->no_bukti,
                    $row->tanggal ? $row->tanggal->format('Y-m-d') : '-',
                    $row->uraian,
                    $row->kategori,
                    ucfirst($row->jenis),
                    $row->nominal,
                    $row->penanggung_jawab ?? '-',
                    $row->status_label,
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }
}
