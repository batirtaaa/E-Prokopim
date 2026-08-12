@extends('layouts.app')
@section('title', 'Dokumentasi — SIKOPIM')
@section('topbar-title', 'Dokumentasi')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">Dokumentasi Kegiatan</h1><p class="page-subtitle">Kelola foto, video, dan dokumentasi kegiatan pimpinan</p></div>
    <button class="btn btn-primary" data-modal-open="#modal-upload-dok">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
        Upload Dokumentasi
    </button>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <div class="search-bar"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg><input type="text" name="search" placeholder="Cari dokumentasi..." value="{{ request('search') }}"></div>
            <select name="tipe" class="form-control">
                <option value="">Semua Tipe</option>
                <option value="foto" {{ request('tipe') === 'foto' ? 'selected' : '' }}>Foto</option>
                <option value="video" {{ request('tipe') === 'video' ? 'selected' : '' }}>Video</option>
                <option value="dokumen" {{ request('tipe') === 'dokumen' ? 'selected' : '' }}>Dokumen</option>
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead><tr><th>Judul</th><th>Kegiatan</th><th>Tipe</th><th>Tanggal</th><th>Fotografer</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($dokumentasi as $d)
                <tr>
                    <td><div class="font-semibold">{{ $d->judul }}</div><div class="text-sm text-muted">{{ $d->file_name }}</div></td>
                    <td class="text-muted">{{ $d->kegiatan?->judul ?? '—' }}</td>
                    <td><span class="badge {{ ['foto'=>'badge-blue','video'=>'badge-green','dokumen'=>'badge-gray'][$d->tipe] }}">{{ ucfirst($d->tipe) }}</span></td>
                    <td>{{ $d->tanggal_dokumentasi->format('d M Y') }}</td>
                    <td class="text-muted">{{ $d->fotografer ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ asset('storage/' . $d->file_path) }}" class="btn btn-xs btn-outline" target="_blank">Lihat</a>
                            <form method="POST" action="{{ route('dokumentasi.destroy', $d) }}" data-confirm="Hapus dokumentasi ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada dokumentasi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper"><span>{{ $dokumentasi->firstItem() ?? 0 }}–{{ $dokumentasi->lastItem() ?? 0 }} dari {{ $dokumentasi->total() }} item</span>{{ $dokumentasi->links() }}</div>
</div>

<div class="modal-overlay" id="modal-upload-dok">
    <div class="modal">
        <div class="modal-header"><h2 class="modal-title">Upload Dokumentasi</h2><button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <form method="POST" action="{{ route('dokumentasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="judul" class="form-control" required></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Kegiatan Terkait</label><select name="kegiatan_id" class="form-control"><option value="">Tidak ada</option>@foreach($kegiatan as $k)<option value="{{ $k->id }}">{{ $k->judul }}</option>@endforeach</select></div>
                    <div class="form-group"><label class="form-label">Tipe *</label><select name="tipe" class="form-control" required><option value="foto">Foto</option><option value="video">Video</option><option value="dokumen">Dokumen</option></select></div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Tanggal *</label><input type="date" name="tanggal_dokumentasi" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                    <div class="form-group"><label class="form-label">Fotografer/Pembuat</label><input type="text" name="fotografer" class="form-control"></div>
                </div>
                <div class="form-group"><label class="form-label">File *</label><input type="file" name="file" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Upload</button></div>
        </form>
    </div>
</div>
@endsection
