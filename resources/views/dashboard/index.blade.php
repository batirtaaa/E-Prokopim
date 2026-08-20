@extends('layouts.app')
@section('title', 'Dashboard — E-PROKOPIM')

@push('styles')
<style>
/* ── Dashboard Layout ── */
.dash-welcome {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 60%, #1a4a7a 100%);
    border-radius: 14px;
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.dash-welcome::before {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.dash-welcome::after {
    content: '';
    position: absolute;
    right: 80px; bottom: -40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.dash-welcome-text h2 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
}
.dash-welcome-text p {
    font-size: 13.5px;
    color: rgba(255,255,255,0.72);
    max-width: 420px;
    line-height: 1.55;
}
.dash-welcome-actions {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}
.btn-welcome-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #fff;
    color: #1e3a5f;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity 0.18s;
}
.btn-welcome-primary:hover { opacity: 0.9; }
.btn-welcome-secondary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.25);
    cursor: pointer;
    text-decoration: none;
    transition: background 0.18s;
}
.btn-welcome-secondary:hover { background: rgba(255,255,255,0.22); }

/* ── Period Filter ── */
.period-filter {
    display: flex;
    gap: 4px;
    margin-bottom: 18px;
    background: #f3f4f6;
    border-radius: 8px;
    padding: 3px;
    width: fit-content;
}
.period-btn {
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.18s;
}
.period-btn.active, .period-btn:hover {
    background: #fff;
    color: #111827;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.period-btn.active { font-weight: 600; }

/* ── Stat Cards ── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}
.dash-stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    border: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    transition: box-shadow 0.18s, transform 0.18s;
}
.dash-stat-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.dash-stat-label {
    font-size: 12.5px;
    color: #6b7280;
    margin-bottom: 6px;
    font-weight: 500;
}
.dash-stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    line-height: 1.1;
    margin-bottom: 4px;
}
.dash-stat-sub {
    font-size: 11.5px;
    color: #6b7280;
}
.dash-stat-sub.success { color: #16a34a; }
.dash-stat-sub.danger  { color: #dc2626; }
.dash-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dash-stat-icon.blue   { background: #eff6ff; color: #2563eb; }
.dash-stat-icon.green  { background: #f0fdf4; color: #16a34a; }
.dash-stat-icon.orange { background: #fff7ed; color: #ea580c; }
.dash-stat-icon.purple { background: #faf5ff; color: #9333ea; }

/* ── Main Grid ── */
.dash-main-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 16px;
    margin-bottom: 20px;
}

/* ── Chart Card ── */
.dash-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}
.dash-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid #f3f4f6;
}
.dash-card-title {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
}
.dash-card-body { padding: 16px 22px 20px; }

/* Bar chart */
.chart-bars {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    height: 180px;
    padding: 0 4px;
}
.chart-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    justify-content: flex-end;
    gap: 6px;
}
.chart-bar {
    width: 100%;
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 4px 4px 0 0;
    min-height: 4px;
    transition: opacity 0.18s;
    cursor: pointer;
    position: relative;
}
.chart-bar:hover { opacity: 0.8; }
.chart-bar-label {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 500;
}

/* Filter select */
.filter-select {
    font-size: 12.5px;
    padding: 5px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    background: #fff;
    cursor: pointer;
}

/* ── Agenda Timeline ── */
.agenda-timeline { display: flex; flex-direction: column; gap: 0; }
.agenda-item {
    display: flex;
    gap: 14px;
    padding: 14px 22px;
    border-bottom: 1px solid #f3f4f6;
    position: relative;
    transition: background 0.15s;
}
.agenda-item:last-child { border-bottom: none; }
.agenda-item:hover { background: #f9fafb; }
.agenda-time {
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    width: 38px;
    flex-shrink: 0;
    padding-top: 2px;
}
.agenda-line {
    width: 3px;
    background: #e5e7eb;
    border-radius: 2px;
    flex-shrink: 0;
    position: relative;
}
.agenda-line.berlangsung { background: #3b82f6; }
.agenda-line.selesai     { background: #9ca3af; }
.agenda-line.terjadwal   { background: #f59e0b; }
.agenda-info { flex: 1; min-width: 0; }
.agenda-judul {
    font-size: 13.5px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.agenda-meta {
    font-size: 12px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.agenda-meta span { display: flex; align-items: center; gap: 3px; }
.agenda-badge {
    display: inline-block;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600;
    margin-top: 5px;
}
.agenda-badge.berlangsung { background: #dbeafe; color: #1d4ed8; }
.agenda-badge.selesai     { background: #f3f4f6; color: #4b5563; }
.agenda-badge.terjadwal   { background: #fef9c3; color: #92400e; }

/* ── Data Pegawai Table ── */
.dash-table-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}
.dash-table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid #f3f4f6;
}
.dash-table-header-title {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
}
.dash-search-mini {
    display: flex;
    align-items: center;
    gap: 7px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    padding: 6px 12px;
    font-size: 12.5px;
    color: #9ca3af;
    background: #f9fafb;
    width: 200px;
}
.dash-table {
    width: 100%;
    border-collapse: collapse;
}
.dash-table th {
    background: #f9fafb;
    padding: 10px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-align: left;
    border-bottom: 1px solid #f3f4f6;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.dash-table td {
    padding: 12px 14px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f9fafb;
    vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #f9fafb; }
.pegawai-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
}
.badge-aktif {
    background: #dcfce7;
    color: #16a34a;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}
.badge-nonaktif {
    background: #fee2e2;
    color: #dc2626;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}
.action-icons { display: flex; gap: 8px; align-items: center; }
.action-icon {
    width: 28px; height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    border: 1px solid #e5e7eb;
    background: #fff;
    text-decoration: none;
}
.action-icon:hover { background: #f3f4f6; color: #374151; }

.dash-see-all {
    text-align: center;
    padding: 14px;
    border-top: 1px solid #f3f4f6;
}
.dash-see-all a {
    font-size: 13px;
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: opacity 0.15s;
}
.dash-see-all a:hover { opacity: 0.75; }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="dash-welcome">
    <div class="dash-welcome-text">
        <h2>Selamat datang di E-PROKOPIM</h2>
        <p>Pantau kegiatan, agenda pimpinan, serta informasi internal Prokopim Kota Bandung dalam satu sistem terintegrasi.</p>
    </div>
    <div class="dash-welcome-actions">
        <a href="{{ route('kegiatan.create') }}" class="btn-welcome-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kegiatan
        </a>
        <a href="{{ route('kegiatan.index') }}" class="btn-welcome-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            Tambah Pegawai
        </a>
    </div>
</div>

{{-- Period Filter --}}
<div class="period-filter">
    <button class="period-btn active" onclick="setPeriod(this, 1)">1 Bulan</button>
    <button class="period-btn" onclick="setPeriod(this, 3)">3 Bulan</button>
    <button class="period-btn" onclick="setPeriod(this, 6)">6 Bulan</button>
    <button class="period-btn" onclick="setPeriod(this, 12)">1 Tahun</button>
    <button class="period-btn" onclick="setPeriod(this, 0)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13" style="vertical-align:middle;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        Custom
    </button>
</div>

{{-- Stat Cards --}}
<div class="dash-stats">
    {{-- Total Pegawai --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Total Pegawai</div>
            <div class="dash-stat-value">{{ $totalPegawai }}</div>
            <div class="dash-stat-sub">Pegawai aktif</div>
        </div>
        <div class="dash-stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
    </div>

    {{-- Kegiatan Periode Ini --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Kegiatan Periode Ini</div>
            <div class="dash-stat-value">{{ $kegiatanBulanIni }}</div>
            <div class="dash-stat-sub {{ $kenaikanPersen >= 0 ? 'success' : 'danger' }}">
                @if($kenaikanPersen >= 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12" style="vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                    +{{ $kenaikanPersen }}% dibanding bulan lalu
                @else
                    {{ $kenaikanPersen }}% dibanding bulan lalu
                @endif
            </div>
        </div>
        <div class="dash-stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008z"/></svg>
        </div>
    </div>

    {{-- Agenda Hari Ini --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Agenda Hari Ini</div>
            <div class="dash-stat-value">{{ $agendaCount }}</div>
            <div class="dash-stat-sub">
                @if($agendaCount > 0) Memerlukan perhatian @else Tidak ada agenda @endif
            </div>
        </div>
        <div class="dash-stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>

    {{-- Agenda Mendatang --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Agenda Mendatang</div>
            <div class="dash-stat-value">{{ $agendaMendatang }}</div>
            <div class="dash-stat-sub">Dalam 7 hari ke depan</div>
        </div>
        <div class="dash-stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        </div>
    </div>
</div>

{{-- Main Grid: Chart + Agenda --}}
<div class="dash-main-grid">

    {{-- Statistik Kegiatan (Bar Chart) --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Statistik Kegiatan</span>
            <select class="filter-select">
                <option>Semua Bidang</option>
                <option>Rapat</option>
                <option>Kunjungan</option>
                <option>Acara</option>
                <option>Audiensi</option>
            </select>
        </div>
        <div class="dash-card-body">
            @php
                $maxCount = collect($statistikBulanan)->max('count');
                $maxCount = $maxCount > 0 ? $maxCount : 1;
            @endphp
            <div class="chart-bars">
                @foreach($statistikBulanan as $stat)
                    @php $pct = round(($stat['count'] / $maxCount) * 100); @endphp
                    <div class="chart-bar-wrap">
                        <div class="chart-bar" style="height: {{ max($pct, 4) }}%" title="{{ $stat['label'] }}: {{ $stat['count'] }} kegiatan"></div>
                        <div class="chart-bar-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Agenda Pimpinan Hari Ini --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Agenda Pimpinan Hari Ini</span>
        </div>
        @if($agendaHariIni->count() > 0)
            <div class="agenda-timeline">
                @foreach($agendaHariIni as $agenda)
                    <div class="agenda-item">
                        <div class="agenda-time">{{ $agenda->tanggal_mulai->format('H.i') }}</div>
                        <div class="agenda-line {{ $agenda->status }}"></div>
                        <div class="agenda-info">
                            <div class="agenda-judul">{{ $agenda->judul }}</div>
                            <div class="agenda-meta">
                                @if($agenda->lokasi)
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                        {{ $agenda->lokasi }}
                                    </span>
                                @endif
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    {{ $agenda->pimpinan_label ?? ucfirst(str_replace('_', ' ', $agenda->pimpinan)) }}
                                </span>
                            </div>
                            <div>
                                <span class="agenda-badge {{ $agenda->status }}">{{ $agenda->status_label ?? ucfirst($agenda->status) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="padding:32px;text-align:center;color:#9ca3af;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" width="40" height="40" style="margin:0 auto 10px;display:block;opacity:0.35"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <p style="font-size:13px">Tidak ada agenda hari ini</p>
            </div>
        @endif
    </div>
</div>

{{-- Data Pegawai --}}
<div class="dash-table-card">
    <div class="dash-table-header">
        <span class="dash-table-header-title">Data Pegawai</span>
        <div class="dash-search-mini">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            Cari pegawai...
        </div>
    </div>
    <table class="dash-table">
        <thead>
            <tr>
                <th style="width:52px">Foto</th>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Bagian</th>
                <th>Status</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($personelList as $personel)
            <tr>
                <td>
                    <div class="pegawai-avatar">{{ strtoupper(substr($personel->nama_lengkap, 0, 1)) }}</div>
                </td>
                <td><span style="font-weight:600;color:#111827">{{ $personel->nama_lengkap }}</span></td>
                <td style="font-size:12px;color:#6b7280;font-family:monospace">{{ $personel->nip }}</td>
                <td>{{ $personel->jabatan }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $personel->bidang)) }}</td>
                <td>
                    <span class="badge-aktif">Aktif</span>
                </td>
                <td>
                    <div class="action-icons" style="justify-content:flex-end">
                        <a href="#" class="action-icon" title="Lihat">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                        <a href="#" class="action-icon" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                        <a href="#" class="action-icon" title="Opsi lain">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:28px;color:#9ca3af">Belum ada data pegawai</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="dash-see-all">
        <a href="{{ route('kegiatan.index') }}">
            Lihat Semua Pegawai
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
function setPeriod(btn, months) {
    document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}
</script>
@endpush
