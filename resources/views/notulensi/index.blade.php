@extends('layouts.app')
@section('title', 'Notulensi — SIKOPIM')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-title">Notulensi Rapat</h1>
        <p class="page-subtitle">Kelola notulensi dan catatan hasil rapat pimpinan</p>
    </div>
    @if(auth()->user()->isAdmin())
    <button class="btn btn-primary" data-modal-open="#modal-notulensi-baru">+ Tambah Notulensi</button>
    @endif
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="search" placeholder="Cari notulensi..." value="{{ request('search') }}">
            </div>
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final</option>
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr><th>Judul</th><th>Tanggal Rapat</th><th>Tempat</th><th>Notulis</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($notulensi as $n)
                <tr>
                    <td><div class="font-semibold">{{ $n->judul }}</div><div class="text-sm text-muted">{{ $n->kegiatan?->judul ?? 'Tanpa kegiatan' }}</div></td>
                    <td>{{ $n->tanggal_rapat->format('d M Y') }}</td>
                    <td class="text-muted">{{ $n->tempat }}</td>
                    <td>{{ $n->notulis?->name ?? '—' }}</td>
                    <td><span class="badge {{ $n->status === 'final' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($n->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('notulensi.show', $n) }}" class="btn btn-xs btn-outline">Lihat</a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('notulensi.edit', $n) }}" class="btn btn-xs btn-outline">Edit</a>
                            <form method="POST" action="{{ route('notulensi.destroy', $n) }}" data-confirm="Hapus notulensi ini?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada notulensi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <span>{{ $notulensi->firstItem() ?? 0 }}–{{ $notulensi->lastItem() ?? 0 }} dari {{ $notulensi->total() }} notulensi</span>
        {{ $notulensi->links() }}
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-notulensi-baru">
    <div class="modal" style="max-width:700px;">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Notulensi</h2>
            <button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <form method="POST" action="{{ route('notulensi.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="judul" class="form-control" required></div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Kegiatan Terkait</label>
                        <select name="kegiatan_id" class="form-control">
                            <option value="">Tidak ada</option>
                            @foreach($kegiatan as $k) <option value="{{ $k->id }}">{{ $k->judul }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notulis</label>
                        <select name="notulis_id" class="form-control">
                            <option value="">Pilih Notulis</option>
                            @foreach($users as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Tanggal Rapat *</label><input type="datetime-local" name="tanggal_rapat" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Tempat *</label><input type="text" name="tempat" class="form-control" required></div>
                </div>
                <div class="form-group"><label class="form-label">Isi Notulensi *</label><textarea name="isi_notulensi" class="form-control" rows="5" required></textarea></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Kesimpulan</label><textarea name="kesimpulan" class="form-control" rows="2"></textarea></div>
                    <div class="form-group"><label class="form-label">Tindak Lanjut</label><textarea name="tindak_lanjut" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control"><option value="draft">Draft</option><option value="final">Final</option></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Notulensi</button>
            </div>
        </form>
    </div>
</div>
@endsection
