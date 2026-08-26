<?php

namespace App\Http\Controllers;

use App\Models\AsetBarang;
use App\Models\AsetKendaraan;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'inventaris');

        // 1. Query Inventaris Barang
        $inventarisQuery = AsetBarang::orderBy('id', 'asc');

        if ($request->filled('search_aset')) {
            $search = $request->search_aset;
            $inventarisQuery->where(function($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $inventarisQuery->where('kategori', $request->kategori);
        }

        if ($request->filled('status_aset')) {
            $inventarisQuery->where('status', $request->status_aset);
        }

        $inventaris = $inventarisQuery->paginate(10, ['*'], 'page_inventaris')->withQueryString();
        $totalInventaris = AsetBarang::count();

        // 2. Query Kendaraan Operasional
        $kendaraanQuery = AsetKendaraan::orderBy('id', 'asc');

        if ($request->filled('search_kendaraan')) {
            $search = $request->search_kendaraan;
            $kendaraanQuery->where(function($q) use ($search) {
                $q->where('plat_nomor', 'like', "%{$search}%")
                  ->orWhere('nama_kendaraan', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%")
                  ->orWhere('pemegang_pengguna', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $kendaraanQuery->where('jenis', $request->jenis);
        }

        if ($request->filled('status_kendaraan')) {
            $kendaraanQuery->where('status', $request->status_kendaraan);
        }

        $kendaraan = $kendaraanQuery->paginate(10, ['*'], 'page_kendaraan')->withQueryString();
        $totalKendaraan = AsetKendaraan::count();

        return view('asset.index', compact(
            'activeTab',
            'inventaris',
            'kendaraan',
            'totalInventaris',
            'totalKendaraan'
        ));
    }

    public function createInventaris()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah aset.');
        }

        $kodeOtomatis = AsetBarang::generateNextCode();
        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();

        return view('asset.create-inventaris', compact('kodeOtomatis', 'pegawaiList'));
    }

    public function storeInventaris(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah aset.');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tanggal_perolehan' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kondisi' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'foto_barang' => 'nullable|image|max:5120',
            'dokumen_pendukung' => 'nullable|file|max:10240',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_barang')) {
            $fotoPath = $request->file('foto_barang')->store('aset/foto', 'public');
        }

        $dokumenPath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPath = $request->file('dokumen_pendukung')->store('aset/dokumen', 'public');
        }

        $kodeAset = $request->input('kode_aset') ?: AsetBarang::generateNextCode();

        AsetBarang::create([
            'kode_aset' => $kodeAset,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'lokasi' => $request->lokasi,
            'penanggung_jawab' => $request->penanggung_jawab,
            'kondisi' => $request->kondisi,
            'status' => $request->status,
            'foto_barang' => $fotoPath,
            'dokumen_pendukung' => $dokumenPath,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('asset.index', ['tab' => 'inventaris'])
            ->with('success', 'Aset inventaris barang berhasil ditambahkan ke dalam sistem.');
    }

    public function createKendaraan()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kendaraan.');
        }

        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('asset.create-kendaraan', compact('pegawaiList'));
    }

    public function storeKendaraan(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah kendaraan.');
        }

        $request->validate([
            'plat_nomor' => 'required|string|max:50|unique:aset_kendaraan,plat_nomor',
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'pemegang_pengguna' => 'nullable|string|max:255',
            'tahun' => 'required|string|max:10',
            'status' => 'required|string|max:50',
            'foto' => 'nullable|image|max:5120',
            'dokumen' => 'nullable|file|max:10240',
            'catatan' => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kendaraan/foto', 'public');
        }

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')->store('kendaraan/dokumen', 'public');
        }

        AsetKendaraan::create([
            'plat_nomor' => strtoupper($request->plat_nomor),
            'nama_kendaraan' => $request->nama_kendaraan,
            'jenis' => $request->jenis,
            'pemegang_pengguna' => $request->pemegang_pengguna ?: '-',
            'tahun' => $request->tahun,
            'status' => $request->status,
            'foto' => $fotoPath,
            'dokumen' => $dokumenPath,
            'catatan' => $request->catatan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('asset.index', ['tab' => 'kendaraan'])
            ->with('success', 'Kendaraan operasional berhasil ditambahkan ke dalam sistem.');
    }

    public function destroyInventaris(AsetBarang $asset)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus aset.');
        }

        if ($asset->foto_barang) {
            Storage::disk('public')->delete($asset->foto_barang);
        }
        if ($asset->dokumen_pendukung) {
            Storage::disk('public')->delete($asset->dokumen_pendukung);
        }
        $asset->delete();

        return redirect()->route('asset.index', ['tab' => 'inventaris'])
            ->with('success', 'Aset inventaris berhasil dihapus.');
    }

    public function destroyKendaraan(AsetKendaraan $kendaraan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus kendaraan.');
        }

        if ($kendaraan->foto) {
            Storage::disk('public')->delete($kendaraan->foto);
        }
        if ($kendaraan->dokumen) {
            Storage::disk('public')->delete($kendaraan->dokumen);
        }
        $kendaraan->delete();

        return redirect()->route('asset.index', ['tab' => 'kendaraan'])
            ->with('success', 'Kendaraan operasional berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'inventaris');

        if ($type === 'kendaraan') {
            $data = AsetKendaraan::all();
            $filename = 'daftar_kendaraan_operasional_' . date('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            return response()->stream(function () use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['No', 'Plat Nomor', 'Nama Kendaraan', 'Jenis', 'Pemegang / Pengguna', 'Tahun', 'Status']);
                foreach ($data as $index => $row) {
                    fputcsv($file, [
                        $index + 1,
                        $row->plat_nomor,
                        $row->nama_kendaraan,
                        $row->jenis,
                        $row->pemegang_pengguna,
                        $row->tahun,
                        $row->status_label,
                    ]);
                }
                fclose($file);
            }, 200, $headers);
        } else {
            $data = AsetBarang::all();
            $filename = 'daftar_inventaris_barang_' . date('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            return response()->stream(function () use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Kode Aset', 'Nama Barang', 'Kategori', 'Lokasi', 'Penanggung Jawab', 'Kondisi', 'Status', 'Tanggal Perolehan']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->kode_aset,
                        $row->nama_barang,
                        $row->kategori,
                        $row->lokasi,
                        $row->penanggung_jawab,
                        ucfirst($row->kondisi),
                        $row->status_label,
                        $row->tanggal_perolehan ? $row->tanggal_perolehan->format('Y-m-d') : '-',
                    ]);
                }
                fclose($file);
            }, 200, $headers);
        }
    }
}
