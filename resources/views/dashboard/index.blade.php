@extends('layouts.app')
@section('title', 'Dashboard — SIKOPIM')
@section('topbar-title', 'SIKOPIM')
@section('topbar-search', true)

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Selamat datang di SIKOPIM</h2>
        <p>Kelola agenda, kegiatan, dokumentasi, dan arsip pimpinan dalam satu sistem terintegrasi.</p>
    </div>
    <div class="welcome-actions">
        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Kegiatan
        </a>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline" style="background:rgba(255,255,255,0.1);color:white;border-color:rgba(255,255,255,0.2);">
            Lihat Agenda
        </a>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    {{-- Agenda Hari Ini --}}
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Agenda Hari Ini</div>
            <div class="stat-card-value">{{ $agendaCount }}</div>
            <div class="stat-card-sub">
                @if($waliKotaCount)
                    {{ $waliKotaCount }} Wali Kota
                @endif
                @if($wakilWaliKotaCount)
                    , {{ $wakilWaliKotaCount }} Wakil
                @endif
                @if($sekdaCount)
                    , {{ $sekdaCount }} Sekda
                @endif
                @if(!$waliKotaCount && !$wakilWaliKotaCount && !$sekdaCount)
                    Tidak ada agenda
                @endif
            </div>
        </div>
        <div class="stat-card-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008z" /></svg>
        </div>
    </div>

    {{-- Kegiatan Bulan Ini --}}
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Kegiatan Bulan Ini</div>
            <div class="stat-card-value">{{ $kegiatanBulanIni }}</div>
            <div class="stat-card-sub {{ $kenaikanPersen >= 0 ? 'success' : 'danger' }}">
                @if($kenaikanPersen >= 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                    +{{ $kenaikanPersen }}% dibanding bulan lalu
                @else
                    {{ $kenaikanPersen }}% dibanding bulan lalu
                @endif
            </div>
        </div>
        <div class="stat-card-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
        </div>
    </div>

    {{-- Arahan Belum Selesai --}}
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Arahan Belum Selesai</div>
            <div class="stat-card-value">{{ $arahanBelumSelesai }}</div>
            @if($arahanMelewatiDeadline > 0)
                <div class="stat-card-sub danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    {{ $arahanMelewatiDeadline }} melewati deadline
                </div>
            @else
                <div class="stat-card-sub">Semua dalam batas waktu</div>
            @endif
        </div>
        <div class="stat-card-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
    </div>

    {{-- Total Arsip --}}
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-label">Total Arsip</div>
            <div class="stat-card-value">{{ number_format($totalArsip) }}</div>
            <div class="stat-card-sub">Dokumen terarsip aman</div>
        </div>
        <div class="stat-card-icon gray">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
        </div>
    </div>
</div>

{{-- Agenda Hari Ini --}}
@if($agendaHariIni->count() > 0)
<div class="card" style="margin-top: 0;">
    <div class="card-header">
        <h3 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" style="vertical-align: middle; margin-right:6px;color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Agenda Hari Ini — {{ \Carbon\Carbon::today()->format('d F Y') }}
        </h3>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Kegiatan</th>
                    <th>Lokasi</th>
                    <th>Pimpinan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agendaHariIni as $agenda)
                <tr>
                    <td>
                        <span class="font-semibold">{{ $agenda->tanggal_mulai->format('H:i') }}</span>
                        @if($agenda->tanggal_selesai)
                            <span class="text-muted"> – {{ $agenda->tanggal_selesai->format('H:i') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="font-semibold">{{ $agenda->judul }}</div>
                        <div class="text-sm text-muted">{{ ucfirst($agenda->kategori) }}</div>
                    </td>
                    <td class="text-muted">{{ $agenda->lokasi ?? '—' }}</td>
                    <td>
                        <span class="badge badge-blue">{{ $agenda->pimpinan_label }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $agenda->status_color }}">
                            <span class="badge-dot"></span>
                            {{ $agenda->status_label }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="card">
    <div class="card-body" style="text-align:center;padding:40px;color:var(--text-muted);">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" width="48" height="48" style="margin:0 auto 12px;display:block;opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
        <p class="font-medium" style="color:var(--text-secondary)">Tidak ada agenda hari ini</p>
        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary" style="margin-top:12px;">+ Tambah Kegiatan</a>
    </div>
</div>
@endif

@endsection
