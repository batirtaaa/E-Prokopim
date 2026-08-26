@extends('layouts.app')
@section('title', 'Detail Kegiatan — SIKOPIM')
@section('topbar-title', 'Kegiatan')
@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-title">{{ $kegiatan->judul }}</h1>
        <p class="page-subtitle">{{ $kegiatan->tanggal_mulai->format('d F Y, H:i') }} WIB &middot; {{ $kegiatan->lokasi }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-outline">Edit</a>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Kembali</a>
    </div>
</div>
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;">
    <div>
        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Informasi Kegiatan</h3></div>
            <div class="card-body">
                <div class="form-row cols-2">
                    <div>
                        <div class="form-label">Pimpinan</div>
                        <span class="badge badge-blue" style="font-size:13px;padding:5px 14px;">{{ $kegiatan->pimpinan_label }}</span>
                    </div>
                    <div>
                        <div class="form-label">Status</div>
                        <span class="badge badge-{{ $kegiatan->status_color }}" style="font-size:13px;padding:5px 14px;">{{ $kegiatan->status_label }}</span>
                    </div>
                </div>
                @if($kegiatan->deskripsi)
                <div style="margin-top:16px;">
                    <div class="form-label">Deskripsi</div>
                    <p style="color:var(--text-secondary);font-size:13.5px;line-height:1.6;">{{ $kegiatan->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Penugasan --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tim Bertugas ({{ $kegiatan->penugasan->count() }})</h3>
            </div>
            <div class="table-wrapper" style="border:none;border-radius:0;">
                <table class="table">
                    <thead><tr><th>Personel</th><th>Peran</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($kegiatan->penugasan as $p)
                        <tr>
                            <td>{{ $p->personel?->nama_lengkap ?? '—' }}</td>
                            <td>{{ $p->peran }}</td>
                            <td><span class="badge badge-{{ $p->status_color }}">{{ $p->status_label }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--text-muted);padding:20px;">Belum ada penugasan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-body">
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <div class="form-label" style="margin-bottom:4px;">Waktu Mulai</div>
                        <div class="font-semibold">{{ $kegiatan->tanggal_mulai->format('d M Y') }}</div>
                        <div class="text-muted">{{ $kegiatan->tanggal_mulai->format('H:i') }} WIB</div>
                    </div>
                    @if($kegiatan->tanggal_selesai)
                    <div>
                        <div class="form-label" style="margin-bottom:4px;">Waktu Selesai</div>
                        <div class="font-semibold">{{ $kegiatan->tanggal_selesai->format('d M Y') }}</div>
                        <div class="text-muted">{{ $kegiatan->tanggal_selesai->format('H:i') }} WIB</div>
                    </div>
                    @endif
                    <div>
                        <div class="form-label" style="margin-bottom:4px;">Kategori</div>
                        <div class="font-semibold">{{ ucfirst($kegiatan->kategori) }}</div>
                    </div>
                    <div>
                        <div class="form-label" style="margin-bottom:4px;">Ditambahkan oleh</div>
                        <div class="font-semibold">{{ $kegiatan->createdBy?->name ?? 'System' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header"><h3 class="card-title" style="font-size:13px;">Notulensi ({{ $kegiatan->notulensi->count() }})</h3></div>
            <div class="card-body">
                @forelse($kegiatan->notulensi as $n)
                    <div style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div class="font-medium">{{ $n->judul }}</div>
                        <div class="text-sm text-muted">{{ $n->tanggal_rapat->format('d M Y') }}</div>
                    </div>
                @empty
                    <p class="text-muted text-sm">Belum ada notulensi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
