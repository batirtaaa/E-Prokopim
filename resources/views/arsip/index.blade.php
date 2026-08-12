@extends('layouts.app')
@section('title', 'Arsip Digital — SIKOPIM')
@section('topbar-title', 'Arsip Digital')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">Arsip Digital</h1><p class="page-subtitle">Kelola dan simpan seluruh dokumen arsip digital secara aman. Total: <strong>{{ $totalArsip }}</strong> dokumen.</p></div>
    <button class="btn btn-primary" data-modal-open="#modal-upload-arsip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
        Unggah Dokumen
    </button>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <div class="search-bar"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg><input type="text" name="search" placeholder="Cari arsip..." value="{{ request('search') }}"></div>
            <select name="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach(['surat_masuk'=>'Surat Masuk','surat_keluar'=>'Surat Keluar','sk'=>'SK','peraturan'=>'Peraturan','laporan'=>'Laporan','foto'=>'Foto','video'=>'Video','lainnya'=>'Lainnya'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('kategori')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="tahun" class="form-control">
                <option value="">Semua Tahun</option>
                @for($y = date('Y'); $y >= 2020; $y--)<option value="{{ $y }}" {{ request('tahun')==$y ? 'selected' : '' }}>{{ $y }}</option>@endfor
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead><tr><th>No. Arsip</th><th>Judul Dokumen</th><th>Kategori</th><th>Tanggal</th><th>Ukuran</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($arsip as $a)
                <tr>
                    <td class="text-muted" style="font-family:monospace;font-size:12px;">{{ $a->nomor_arsip ?? '—' }}</td>
                    <td>
                        <div class="font-semibold">{{ $a->judul }}</div>
                        @if($a->is_rahasia)<span class="badge badge-red" style="font-size:10px;">RAHASIA</span>@endif
                    </td>
                    <td><span class="badge badge-blue" style="font-size:11px;">{{ str_replace('_',' ',strtoupper($a->kategori)) }}</span></td>
                    <td>{{ $a->tanggal_dokumen?->format('d M Y') ?? '—' }}</td>
                    <td class="text-muted">{{ $a->file_size_formatted }}</td>
                    <td><span class="badge {{ $a->status === 'aktif' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($a->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ asset('storage/' . $a->file_path) }}" class="btn btn-xs btn-outline" target="_blank" download>Unduh</a>
                            <form method="POST" action="{{ route('arsip.destroy', $a) }}" data-confirm="Hapus arsip ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada arsip digital</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper"><span>{{ $arsip->firstItem() ?? 0 }}–{{ $arsip->lastItem() ?? 0 }} dari {{ $arsip->total() }} arsip</span>{{ $arsip->links() }}</div>
</div>

<div class="modal-overlay" id="modal-upload-arsip">
    <div class="modal">
        <div class="modal-header"><h2 class="modal-title">Unggah Dokumen Arsip</h2><button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <form method="POST" action="{{ route('arsip.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">No. Arsip</label><input type="text" name="nomor_arsip" class="form-control" placeholder="ARS/001/2026"></div>
                    <div class="form-group"><label class="form-label">Kategori *</label><select name="kategori" class="form-control" required><option value="">Pilih Kategori</option>@foreach(['surat_masuk'=>'Surat Masuk','surat_keluar'=>'Surat Keluar','sk'=>'SK','peraturan'=>'Peraturan','laporan'=>'Laporan','foto'=>'Foto','video'=>'Video','lainnya'=>'Lainnya'] as $v=>$l)<option value="{{ $v }}">{{ $l }}</option>@endforeach</select></div>
                </div>
                <div class="form-group"><label class="form-label">Judul Dokumen *</label><input type="text" name="judul" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Tanggal Dokumen</label><input type="date" name="tanggal_dokumen" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Tahun</label><input type="text" name="tahun" class="form-control" value="{{ date('Y') }}" maxlength="4"></div>
                </div>
                <div class="form-group"><label class="form-label">File Dokumen *</label><input type="file" name="file" class="form-control" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip"></div>
                <div style="display:flex;align-items:center;gap:8px;margin-top:4px;"><input type="checkbox" name="is_rahasia" id="is_rahasia" value="1"><label for="is_rahasia" style="font-size:13px;cursor:pointer;">Tandai sebagai dokumen rahasia</label></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Unggah Dokumen</button></div>
        </form>
    </div>
</div>
@endsection
