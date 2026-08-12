@extends('layouts.app')
@section('title', 'Laporan — SIKOPIM')
@section('topbar-title', 'Laporan')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">Laporan</h1><p class="page-subtitle">Buat dan kelola laporan kegiatan pimpinan secara periodik</p></div>
    <button class="btn btn-primary" data-modal-open="#modal-buat-laporan">+ Buat Laporan</button>
</div>

<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:20px;">
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Total Kegiatan {{ date('Y') }}</div>
            <div class="stat-card-value">{{ $totalKegiatan }}</div>
        </div>
        <div class="stat-card-icon blue"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg></div>
    </div>
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Total Dokumen Arsip</div>
            <div class="stat-card-value">{{ number_format($totalArsip) }}</div>
        </div>
        <div class="stat-card-icon gray"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M8.25 3h7.5M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg></div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">Daftar Laporan</h3></div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead><tr><th>Judul</th><th>Tipe</th><th>Periode</th><th>Status</th><th>Dibuat Oleh</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($laporan as $l)
                <tr>
                    <td class="font-semibold">{{ $l->judul }}</td>
                    <td><span class="badge badge-blue">{{ ucfirst($l->tipe) }}</span></td>
                    <td>
                        @if($l->periode_mulai && $l->periode_selesai)
                            {{ $l->periode_mulai->format('d M Y') }} – {{ $l->periode_selesai->format('d M Y') }}
                        @else<span class="text-muted">—</span>@endif
                    </td>
                    <td><span class="badge {{ $l->status === 'final' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($l->status) }}</span></td>
                    <td class="text-muted">{{ $l->createdBy?->name ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('laporan.destroy', $l) }}" data-confirm="Hapus laporan ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada laporan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper"><span>{{ $laporan->total() }} laporan</span>{{ $laporan->links() }}</div>
</div>

<div class="modal-overlay" id="modal-buat-laporan">
    <div class="modal">
        <div class="modal-header"><h2 class="modal-title">Buat Laporan Baru</h2><button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <form method="POST" action="{{ route('laporan.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Judul Laporan *</label><input type="text" name="judul" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Tipe Laporan *</label><select name="tipe" class="form-control" required><option value="kegiatan">Kegiatan</option><option value="penugasan">Penugasan</option><option value="arsip">Arsip</option><option value="dokumentasi">Dokumentasi</option><option value="custom">Custom</option></select></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Periode Mulai</label><input type="date" name="periode_mulai" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Periode Selesai</label><input type="date" name="periode_selesai" class="form-control"></div>
                </div>
                <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Buat Laporan</button></div>
        </form>
    </div>
</div>
@endsection
