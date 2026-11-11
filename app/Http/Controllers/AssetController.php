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

    public function editInventaris(AsetBarang $asset)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit aset.');
        }

        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('asset.edit-inventaris', compact('asset', 'pegawaiList'));
    }

    public function updateInventaris(Request $request, AsetBarang $asset)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit aset.');
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

        $data = [
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'lokasi' => $request->lokasi,
            'penanggung_jawab' => $request->penanggung_jawab,
            'kondisi' => $request->kondisi,
            'status' => $request->status,
        ];

        if ($request->hasFile('foto_barang')) {
            if ($asset->foto_barang) {
                Storage::disk('public')->delete($asset->foto_barang);
            }
            $data['foto_barang'] = $request->file('foto_barang')->store('aset/foto', 'public');
        }

        if ($request->hasFile('dokumen_pendukung')) {
            if ($asset->dokumen_pendukung) {
                Storage::disk('public')->delete($asset->dokumen_pendukung);
            }
            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('aset/dokumen', 'public');
        }

        $asset->update($data);

        return redirect()->route('asset.index', ['tab' => 'inventaris'])
            ->with('success', 'Aset inventaris barang berhasil diperbarui.');
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

    public function editKendaraan(AsetKendaraan $kendaraan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kendaraan.');
        }

        $pegawaiList = Personel::orderBy('nama_lengkap', 'asc')->get();
        return view('asset.edit-kendaraan', compact('kendaraan', 'pegawaiList'));
    }

    public function updateKendaraan(Request $request, AsetKendaraan $kendaraan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit kendaraan.');
        }

        $request->validate([
            'plat_nomor' => 'required|string|max:50|unique:aset_kendaraan,plat_nomor,' . $kendaraan->id,
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'pemegang_pengguna' => 'nullable|string|max:255',
            'tahun' => 'required|string|max:10',
            'status' => 'required|string|max:50',
            'foto' => 'nullable|image|max:5120',
            'dokumen' => 'nullable|file|max:10240',
            'catatan' => 'nullable|string',
        ]);

        $data = [
            'plat_nomor' => strtoupper($request->plat_nomor),
            'nama_kendaraan' => $request->nama_kendaraan,
            'jenis' => $request->jenis,
            'pemegang_pengguna' => $request->pemegang_pengguna ?: '-',
            'tahun' => $request->tahun,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ];

        if ($request->hasFile('foto')) {
            if ($kendaraan->foto) {
                Storage::disk('public')->delete($kendaraan->foto);
            }
            $data['foto'] = $request->file('foto')->store('kendaraan/foto', 'public');
        }

        if ($request->hasFile('dokumen')) {
            if ($kendaraan->dokumen) {
                Storage::disk('public')->delete($kendaraan->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('kendaraan/dokumen', 'public');
        }

        $kendaraan->update($data);

        return redirect()->route('asset.index', ['tab' => 'kendaraan'])
            ->with('success', 'Kendaraan operasional berhasil diperbarui.');
    }

    public function destroyInventaris(AsetBarang $asset)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus aset.');
        }

        $asset->delete();

        return redirect()->route('asset.index', ['tab' => 'inventaris'])
            ->with('success', 'Aset inventaris berhasil dipindahkan ke Sampah (Trash).');
    }

    public function destroyKendaraan(AsetKendaraan $kendaraan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus kendaraan.');
        }

        $kendaraan->delete();

        return redirect()->route('asset.index', ['tab' => 'kendaraan'])
            ->with('success', 'Kendaraan operasional berhasil dipindahkan ke Sampah (Trash).');
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'all');
        $export = new \App\Exports\AssetExport($type);
        return $export->download();
    }
}
