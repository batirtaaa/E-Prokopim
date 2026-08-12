@extends('layouts.app')
@section('title', 'Detail Notulensi — SIKOPIM')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">{{ $notulensi->judul }}</h1><p class="page-subtitle">{{ $notulensi->tanggal_rapat->format('d F Y') }} &middot; {{ $notulensi->tempat }}</p></div>
    <div class="flex gap-2">
        <a href="{{ route('notulensi.edit', $notulensi) }}" class="btn btn-outline">Edit</a>
        <a href="{{ route('notulensi.index') }}" class="btn btn-outline">Kembali</a>
    </div>
</div>
<div class="card" style="max-width:900px;">
    <div class="card-body">
        @if($notulensi->isi_notulensi)
        <div style="margin-bottom:20px;"><div class="form-label">Isi Notulensi</div><div style="line-height:1.7;color:var(--text-primary);">{{ $notulensi->isi_notulensi }}</div></div>
        @endif
        @if($notulensi->kesimpulan)
        <div style="margin-bottom:16px;padding:14px;background:var(--info-bg);border-radius:var(--radius-sm);">
            <div class="font-semibold" style="margin-bottom:6px;color:var(--accent);">Kesimpulan</div>
            <div>{{ $notulensi->kesimpulan }}</div>
        </div>
        @endif
        @if($notulensi->tindak_lanjut)
        <div style="padding:14px;background:var(--warning-bg);border-radius:var(--radius-sm);">
            <div class="font-semibold" style="margin-bottom:6px;color:#d97706;">Tindak Lanjut</div>
            <div>{{ $notulensi->tindak_lanjut }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
