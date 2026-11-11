<?php

namespace App\Http\Controllers;

use App\Models\AnalisisIsu;
use App\Models\Arahan;
use App\Models\Arsip;
use App\Models\AsetBarang;
use App\Models\AsetKendaraan;
use App\Models\DaftarHadir;
use App\Models\Dokumentasi;
use App\Models\GaleriArsip;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use App\Models\Laporan;
use App\Models\MediaSosial;
use App\Models\Notulensi;
use App\Models\Penugasan;
use App\Models\Personel;
use App\Models\Sambutan;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    /**
     * Map model keys to classes and metadata
     */
    protected function getModelConfig(): array
    {
        return [
            'kegiatan' => [
                'model'      => Kegiatan::class,
                'name'       => 'Kegiatan Pimpinan',
                'badge'      => 'bg-blue-100 text-blue-700',
                'title_col'  => 'judul',
                'sub_col'    => 'nomor_agenda',
                'file_cols'  => ['foto_kegiatan'],
                'icon'       => 'calendar',
            ],
            'sambutan' => [
                'model'      => Sambutan::class,
                'name'       => 'Sambutan',
                'badge'      => 'bg-indigo-100 text-indigo-700',
                'title_col'  => 'perihal',
                'sub_col'    => 'nomor_surat',
                'file_cols'  => ['file_path', 'file_hasil_path'],
                'icon'       => 'document-text',
            ],
            'media_sosial' => [
                'model'      => MediaSosial::class,
                'name'       => 'Media Sosial',
                'badge'      => 'bg-pink-100 text-pink-700',
                'title_col'  => 'judul',
                'sub_col'    => 'platform',
                'file_cols'  => ['file_path'],
                'icon'       => 'share',
            ],
            'analisis_isu' => [
                'model'      => AnalisisIsu::class,
                'name'       => 'Analisis Isu',
                'badge'      => 'bg-purple-100 text-purple-700',
                'title_col'  => 'judul',
                'sub_col'    => 'sumber_isu',
                'file_cols'  => ['file_lampiran'],
                'icon'       => 'chart-bar',
            ],
            'galeri_arsip' => [
                'model'      => GaleriArsip::class,
                'name'       => 'Galeri Arsip',
                'badge'      => 'bg-amber-100 text-amber-700',
                'title_col'  => 'judul',
                'sub_col'    => 'kode',
                'file_cols'  => ['file_path', 'file_paparan_path'],
                'icon'       => 'photo',
            ],
            'penugasan' => [
                'model'      => Penugasan::class,
                'name'       => 'Penugasan Protokol',
                'badge'      => 'bg-cyan-100 text-cyan-700',
                'title_col'  => 'peran',
                'sub_col'    => 'status',
                'file_cols'  => [],
                'icon'       => 'user-group',
            ],
            'arahan' => [
                'model'      => Arahan::class,
                'name'       => 'Arahan Pimpinan',
                'badge'      => 'bg-emerald-100 text-emerald-700',
                'title_col'  => 'judul',
                'sub_col'    => 'nomor_arahan',
                'file_cols'  => ['file_arahan'],
                'icon'       => 'speakerphone',
            ],
            'arsip' => [
                'model'      => Arsip::class,
                'name'       => 'Arsip Digital',
                'badge'      => 'bg-yellow-100 text-yellow-700',
                'title_col'  => 'judul',
                'sub_col'    => 'nomor_arsip',
                'file_cols'  => ['file_path'],
                'icon'       => 'archive-box',
            ],
            'aset_barang' => [
                'model'      => AsetBarang::class,
                'name'       => 'Aset Barang',
                'badge'      => 'bg-teal-100 text-teal-700',
                'title_col'  => 'nama_barang',
                'sub_col'    => 'kode_aset',
                'file_cols'  => ['foto_barang', 'dokumen_pendukung'],
                'icon'       => 'cube',
            ],
            'aset_kendaraan' => [
                'model'      => AsetKendaraan::class,
                'name'       => 'Aset Kendaraan',
                'badge'      => 'bg-orange-100 text-orange-700',
                'title_col'  => 'nama_kendaraan',
                'sub_col'    => 'plat_nomor',
                'file_cols'  => ['foto', 'dokumen'],
                'icon'       => 'truck',
            ],
            'pegawai' => [
                'model'      => Personel::class,
                'name'       => 'Pegawai',
                'badge'      => 'bg-green-100 text-green-700',
                'title_col'  => 'nama_lengkap',
                'sub_col'    => 'nip',
                'file_cols'  => ['photo'],
                'icon'       => 'user',
            ],
            'keuangan' => [
                'model'      => Keuangan::class,
                'name'       => 'Surat Masuk',
                'badge'      => 'bg-blue-100 text-blue-700',
                'title_col'  => 'perihal',
                'sub_col'    => 'nomor_surat',
                'file_cols'  => ['file_dokumen', 'file_bukti'],
                'icon'       => 'inbox-arrow-down',
            ],
            'surat_keluar' => [
                'model'      => SuratKeluar::class,
                'name'       => 'Surat Keluar',
                'badge'      => 'bg-sky-100 text-sky-700',
                'title_col'  => 'perihal',
                'sub_col'    => 'nomor_surat',
                'file_cols'  => ['file_dokumen'],
                'icon'       => 'paper-airplane',
            ],
            'notulensi' => [
                'model'      => Notulensi::class,
                'name'       => 'Notulensi',
                'badge'      => 'bg-amber-100 text-amber-700',
                'title_col'  => 'judul',
                'sub_col'    => 'tempat',
                'file_cols'  => ['file_notulensi', 'file_paparan'],
                'icon'       => 'clipboard-document-list',
            ],
            'dokumentasi' => [
                'model'      => Dokumentasi::class,
                'name'       => 'Dokumentasi',
                'badge'      => 'bg-violet-100 text-violet-700',
                'title_col'  => 'judul',
                'sub_col'    => 'fotografer',
                'file_cols'  => ['file_path'],
                'icon'       => 'camera',
            ],
            'laporan' => [
                'model'      => Laporan::class,
                'name'       => 'Laporan',
                'badge'      => 'bg-gray-100 text-gray-700',
                'title_col'  => 'judul',
                'sub_col'    => 'tipe',
                'file_cols'  => ['file_laporan'],
                'icon'       => 'document-chart-bar',
            ],
        ];
    }

    /**
     * Display recycle bin list
     */
    public function index(Request $request)
    {
        $configs = $this->getModelConfig();
        $selectedType = $request->query('type', 'all');
        $search = trim($request->query('search', ''));

        $counts = [];
        $totalTrashed = 0;

        foreach ($configs as $key => $cfg) {
            $modelClass = $cfg['model'];
            $c = $modelClass::onlyTrashed()->count();
            $counts[$key] = $c;
            $totalTrashed += $c;
        }

        $items = collect();

        if ($selectedType === 'all') {
            foreach ($configs as $key => $cfg) {
                $modelClass = $cfg['model'];
                $query = $modelClass::onlyTrashed();

                if ($search !== '') {
                    $titleCol = $cfg['title_col'];
                    $subCol   = $cfg['sub_col'];
                    $query->where(function ($q) use ($titleCol, $subCol, $search) {
                        $q->where($titleCol, 'like', "%{$search}%");
                        if ($subCol) {
                            $q->orWhere($subCol, 'like', "%{$search}%");
                        }
                    });
                }

                $records = $query->latest('deleted_at')->take(50)->get();

                foreach ($records as $item) {
                    $items->push($this->formatItem($item, $key, $cfg));
                }
            }
            $items = $items->sortByDesc('deleted_at_raw')->values();
        } else {
            if (isset($configs[$selectedType])) {
                $cfg = $configs[$selectedType];
                $modelClass = $cfg['model'];
                $query = $modelClass::onlyTrashed();

                if ($search !== '') {
                    $titleCol = $cfg['title_col'];
                    $subCol   = $cfg['sub_col'];
                    $query->where(function ($q) use ($titleCol, $subCol, $search) {
                        $q->where($titleCol, 'like', "%{$search}%");
                        if ($subCol) {
                            $q->orWhere($subCol, 'like', "%{$search}%");
                        }
                    });
                }

                $records = $query->latest('deleted_at')->get();

                foreach ($records as $item) {
                    $items->push($this->formatItem($item, $selectedType, $cfg));
                }
            }
        }

        return view('trash.index', compact('items', 'configs', 'counts', 'totalTrashed', 'selectedType', 'search'));
    }

    /**
     * Helper to transform model item into normalized row
     */
    protected function formatItem($record, string $type, array $cfg): array
    {
        $hasFiles = false;
        $fileList = [];
        foreach ($cfg['file_cols'] as $fCol) {
            if (!empty($record->{$fCol})) {
                $hasFiles = true;
                $fileList[] = $record->{$fCol};
            }
        }

        $titleCol = $cfg['title_col'];
        $subCol   = $cfg['sub_col'];

        $title = $record->{$titleCol} ?: 'Tanpa Judul';
        $sub   = $subCol ? ($record->{$subCol} ?: null) : null;

        // Custom tweaks for specific models
        if ($type === 'penugasan') {
            $personelName = $record->personel?->nama_lengkap ?? 'Pegawai';
            $kegiatanJudul = $record->kegiatan?->judul ?? 'Kegiatan';
            $title = "Penugasan: {$personelName} ({$record->peran})";
            $sub = "Kegiatan: {$kegiatanJudul}";
        }

        return [
            'id'             => $record->id,
            'type'           => $type,
            'type_name'      => $cfg['name'],
            'badge'          => $cfg['badge'],
            'title'          => $title,
            'sub'            => $sub,
            'has_files'      => $hasFiles,
            'files'          => $fileList,
            'deleted_at'     => $record->deleted_at ? $record->deleted_at->format('d M Y H:i') : '-',
            'deleted_at_raw' => $record->deleted_at,
            'time_ago'       => $record->deleted_at ? $record->deleted_at->diffForHumans() : '-',
        ];
    }

    /**
     * Restore single item
     */
    public function restore(string $type, $id)
    {
        $configs = $this->getModelConfig();
        if (!isset($configs[$type])) {
            return back()->with('error', 'Tipe data tidak valid.');
        }

        $modelClass = $configs[$type]['model'];
        $item = $modelClass::onlyTrashed()->find($id);

        if (!$item) {
            return back()->with('error', 'Data tidak ditemukan di Trash.');
        }

        $item->restore();

        return back()->with('success', "Data {$configs[$type]['name']} berhasil dipulihkan!");
    }

    /**
     * Bulk restore items
     */
    public function bulkRestore(Request $request)
    {
        $selected = $request->input('selected_items', []);
        if (empty($selected) || !is_array($selected)) {
            return back()->with('warning', 'Pilih minimal satu data untuk dipulihkan.');
        }

        $configs = $this->getModelConfig();
        $restoredCount = 0;

        foreach ($selected as $key) {
            // format: type:id
            $parts = explode(':', $key);
            if (count($parts) === 2) {
                [$type, $id] = $parts;
                if (isset($configs[$type])) {
                    $modelClass = $configs[$type]['model'];
                    $item = $modelClass::onlyTrashed()->find($id);
                    if ($item) {
                        $item->restore();
                        $restoredCount++;
                    }
                }
            }
        }

        return back()->with('success', "{$restoredCount} data berhasil dipulihkan dari Trash!");
    }

    /**
     * Permanently delete single item and its files
     */
    public function forceDelete(string $type, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat menghapus data secara permanen.');
        }

        $configs = $this->getModelConfig();
        if (!isset($configs[$type])) {
            return back()->with('error', 'Tipe data tidak valid.');
        }

        $cfg = $configs[$type];
        $modelClass = $cfg['model'];
        $item = $modelClass::onlyTrashed()->find($id);

        if (!$item) {
            return back()->with('error', 'Data tidak ditemukan di Trash.');
        }

        // Clean up files permanently from storage
        foreach ($cfg['file_cols'] as $fCol) {
            $path = $item->{$fCol};
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $item->forceDelete();

        return back()->with('success', "Data {$cfg['name']} telah dihapus secara permanen beserta lampirannya.");
    }

    /**
     * Bulk force delete items and their files
     */
    public function bulkForceDelete(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat menghapus data secara permanen.');
        }

        $selected = $request->input('selected_items', []);
        if (empty($selected) || !is_array($selected)) {
            return back()->with('warning', 'Pilih minimal satu data untuk dihapus secara permanen.');
        }

        $configs = $this->getModelConfig();
        $deletedCount = 0;

        foreach ($selected as $key) {
            $parts = explode(':', $key);
            if (count($parts) === 2) {
                [$type, $id] = $parts;
                if (isset($configs[$type])) {
                    $cfg = $configs[$type];
                    $modelClass = $cfg['model'];
                    $item = $modelClass::onlyTrashed()->find($id);
                    if ($item) {
                        foreach ($cfg['file_cols'] as $fCol) {
                            $path = $item->{$fCol};
                            if ($path && Storage::disk('public')->exists($path)) {
                                Storage::disk('public')->delete($path);
                            }
                        }
                        $item->forceDelete();
                        $deletedCount++;
                    }
                }
            }
        }

        return back()->with('success', "{$deletedCount} data telah dihapus permanen dari sistem.");
    }

    /**
     * Empty entire trash or for a specific category
     */
    public function emptyTrash(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengosongkan Trash.');
        }

        $type = $request->input('type', 'all');
        $configs = $this->getModelConfig();
        $totalDeleted = 0;

        if ($type === 'all') {
            foreach ($configs as $k => $cfg) {
                $modelClass = $cfg['model'];
                $items = $modelClass::onlyTrashed()->get();
                foreach ($items as $item) {
                    foreach ($cfg['file_cols'] as $fCol) {
                        $path = $item->{$fCol};
                        if ($path && Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                    $item->forceDelete();
                    $totalDeleted++;
                }
            }
            return back()->with('success', "Tempat Sampah berhasil dikosongkan! ({$totalDeleted} data dibersihkan)");
        } else {
            if (isset($configs[$type])) {
                $cfg = $configs[$type];
                $modelClass = $cfg['model'];
                $items = $modelClass::onlyTrashed()->get();
                foreach ($items as $item) {
                    foreach ($cfg['file_cols'] as $fCol) {
                        $path = $item->{$fCol};
                        if ($path && Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                    $item->forceDelete();
                    $totalDeleted++;
                }
                return back()->with('success', "Trash kategori {$cfg['name']} berhasil dikosongkan! ({$totalDeleted} data dibersihkan)");
            }
        }

        return back()->with('error', 'Kategori tidak valid.');
    }
}
