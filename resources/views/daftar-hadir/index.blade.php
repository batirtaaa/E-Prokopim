@extends('layouts.app')
@section('title', 'Daftar Hadir — SIKOPIM')
@section('topbar-title', 'Daftar Hadir')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">Daftar Hadir</h1><p class="page-subtitle">Kelola kehadiran peserta di setiap kegiatan pimpinan</p></div>
    <button class="btn btn-primary" data-modal-open="#modal-tambah-hadir">+ Tambah Kehadiran</button>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <select name="kegiatan_id" class="form-control">
                <option value="">Semua Kegiatan</option>
                @foreach($kegiatan as $k)<option value="{{ $k->id }}" {{ request('kegiatan_id')==$k->id ? 'selected' : '' }}>{{ $k->judul }}</option>@endforeach
            </select>
            <select name="status_hadir" class="form-control">
                <option value="">Semua Status</option>
                <option value="hadir" {{ request('status_hadir') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="tidak_hadir" {{ request('status_hadir') === 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                <option value="izin" {{ request('status_hadir') === 'izin' ? 'selected' : '' }}>Izin</option>
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead><tr><th>Nama Peserta</th><th>Jabatan</th><th>Instansi</th><th>Kegiatan</th><th>Jam Hadir</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($daftarHadir as $h)
                <tr>
                    <td class="font-semibold">{{ $h->nama_peserta }}</td>
                    <td class="text-muted">{{ $h->jabatan ?? '—' }}</td>
                    <td class="text-muted">{{ $h->instansi ?? '—' }}</td>
                    <td>{{ $h->kegiatan->judul }}</td>
                    <td>{{ $h->jam_hadir ?? '—' }}</td>
                    <td><span class="badge {{ ['hadir'=>'badge-green','tidak_hadir'=>'badge-red','izin'=>'badge-yellow'][$h->status_hadir] }}">{{ ucfirst(str_replace('_',' ',$h->status_hadir)) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('daftar-hadir.destroy', $h) }}" data-confirm="Hapus data kehadiran ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada data kehadiran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper"><span>{{ $daftarHadir->firstItem() ?? 0 }}–{{ $daftarHadir->lastItem() ?? 0 }} dari {{ $daftarHadir->total() }} peserta</span>{{ $daftarHadir->links() }}</div>
</div>

<div class="modal-overlay" id="modal-tambah-hadir">
    <div class="modal">
        <div class="modal-header"><h2 class="modal-title">Tambah Data Kehadiran</h2><button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <form method="POST" action="{{ route('daftar-hadir.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Kegiatan *</label><select name="kegiatan_id" class="form-control" required><option value="">Pilih Kegiatan</option>@foreach($kegiatan as $k)<option value="{{ $k->id }}">{{ $k->judul }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label">Nama Peserta *</label><input type="text" name="nama_peserta" class="form-control" required></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Jabatan</label><input type="text" name="jabatan" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Instansi</label><input type="text" name="instansi" class="form-control"></div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Status Hadir *</label><select name="status_hadir" class="form-control" required><option value="hadir">Hadir</option><option value="tidak_hadir">Tidak Hadir</option><option value="izin">Izin</option></select></div>
                    <div class="form-group"><label class="form-label">Jam Hadir</label><input type="time" name="jam_hadir" class="form-control"></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
@endsection
