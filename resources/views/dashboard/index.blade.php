@extends('layouts.app')
@section('title', 'Dashboard — E-PROKOPIM')

@push('styles')
<style>
/* ── Dashboard Header Banner ── */
.dash-welcome {
    background: linear-gradient(135deg, #1e3a5f 0%, #2b5687 60%, #173b64 100%);
    border-radius: 14px;
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(30, 58, 95, 0.12);
}
.dash-welcome::before {
    content: '';
    position: absolute;
    right: -40px; top: -50px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
.dash-welcome::after {
    content: '';
    position: absolute;
    right: 140px; bottom: -60px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}
.dash-welcome-text h2 {
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 6px;
    letter-spacing: -0.02em;
}
.dash-welcome-text p {
    font-size: 13.5px;
    color: rgba(255,255,255,0.8);
    max-width: 580px;
    line-height: 1.55;
    margin: 0;
}
.dash-welcome-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}
.btn-welcome-dark {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #0f172a;
    color: #ffffff;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.15);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.btn-welcome-dark:hover {
    background: #1e293b;
    color: #ffffff;
    transform: translateY(-1px);
}
.btn-welcome-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ffffff;
    color: #0f172a;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.btn-welcome-outline:hover {
    background: #f8fafc;
    color: #0f172a;
    transform: translateY(-1px);
}

/* ── Period Filter ── */
.period-filter {
    display: inline-flex;
    gap: 4px;
    margin-bottom: 20px;
    background: #e2e8f0;
    border-radius: 8px;
    padding: 3px;
}
.period-btn {
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.18s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.period-btn:hover {
    color: #0f172a;
    background: rgba(255,255,255,0.6);
}
.period-btn.active {
    background: #0f172a;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

/* ── Stat Cards ── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}
.dash-stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 22px;
    border: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    transform: translateY(-2px);
    border-color: #cbd5e1;
}
.dash-stat-label {
    font-size: 12.5px;
    color: #64748b;
    margin-bottom: 8px;
    font-weight: 500;
}
.dash-stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: 6px;
}
.dash-stat-sub {
    font-size: 11.5px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 4px;
}
.dash-stat-sub.success { color: #16a34a; font-weight: 500; }
.dash-stat-sub.danger  { color: #dc2626; font-weight: 500; }
.dash-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dash-stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
.dash-stat-icon.green  { background: #f0fdf4; color: #22c55e; }
.dash-stat-icon.orange { background: #fffbeb; color: #f59e0b; }
.dash-stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }

/* ── Main Grid ── */
.dash-main-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 1024px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-main-grid { grid-template-columns: 1fr; }
}

/* ── Chart Card ── */
.dash-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.dash-card-body { padding: 18px 20px 22px; }

/* Bar chart */
.chart-bars {
    display: flex;
    align-items: flex-end;
    gap: 14px;
    height: 190px;
    padding: 10px 6px 0;
}
.chart-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    justify-content: flex-end;
    gap: 8px;
    position: relative;
}
.chart-bar-tooltip {
    position: absolute;
    top: -24px;
    background: #0f172a;
    color: #ffffff;
    font-size: 10.5px;
    padding: 2px 6px;
    border-radius: 4px;
    opacity: 0;
    transform: translateY(4px);
    transition: all 0.15s ease;
    pointer-events: none;
    white-space: nowrap;
    z-index: 10;
}
.chart-bar-wrap:hover .chart-bar-tooltip {
    opacity: 1;
    transform: translateY(0);
}
.chart-bar {
    width: 100%;
    max-width: 42px;
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 4px 4px 0 0;
    min-height: 6px;
    transition: height 0.3s ease, opacity 0.18s;
    cursor: pointer;
}
.chart-bar:hover { opacity: 0.85; filter: brightness(1.1); }
.chart-bar-label {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}

/* Filter select */
.filter-select {
    font-size: 12.5px;
    padding: 6px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    color: #334155;
    background: #ffffff;
    cursor: pointer;
    outline: none;
    font-weight: 500;
}

/* ── Agenda Timeline ── */
.agenda-timeline { display: flex; flex-direction: column; max-height: 250px; overflow-y: auto; }
.agenda-item {
    display: flex;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
    transition: background 0.15s;
}
.agenda-item:last-child { border-bottom: none; }
.agenda-item:hover { background: #f8fafc; }
.agenda-time {
    font-size: 12.5px;
    font-weight: 700;
    color: #0f172a;
    width: 44px;
    flex-shrink: 0;
    padding-top: 1px;
}
.agenda-line {
    width: 3px;
    border-radius: 2px;
    flex-shrink: 0;
    background: #cbd5e1;
}
.agenda-line.berlangsung { background: #3b82f6; }
.agenda-line.selesai     { background: #10b981; }
.agenda-line.terjadwal   { background: #f59e0b; }
.agenda-info { flex: 1; min-width: 0; }
.agenda-judul {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.agenda-meta {
    font-size: 11.5px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 4px;
}
.agenda-meta span { display: flex; align-items: center; gap: 3px; }
.agenda-badge {
    display: inline-block;
    font-size: 10.5px;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
}
.agenda-badge.berlangsung { background: #eff6ff; color: #2563eb; }
.agenda-badge.selesai     { background: #f0fdf4; color: #16a34a; }
.agenda-badge.terjadwal   { background: #fefce8; color: #ca8a04; }

/* ── Data Pegawai Table ── */
.dash-table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-table-header-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.dash-search-mini {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    background: #ffffff;
    width: 240px;
    transition: border-color 0.18s;
}
.dash-search-mini:focus-within { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
.dash-search-mini input {
    border: none;
    outline: none;
    font-size: 12.5px;
    color: #0f172a;
    width: 100%;
    background: transparent;
}
.dash-table {
    width: 100%;
    border-collapse: collapse;
}
.dash-table th {
    background: #f8fafc;
    padding: 11px 16px;
    font-size: 11.5px;
    font-weight: 600;
    color: #64748b;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.dash-table td {
    padding: 12px 16px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #f8fafc; }
.pegawai-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    flex-shrink: 0;
}
.pgw-status-pill {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 500;
    white-space: nowrap;
    text-align: center;
}
.pgw-status-pill.status-pns {
    background: #dbeafe;
    color: #1e40af;
}
.pgw-status-pill.status-pppk-penuh {
    background: #e0e7ff;
    color: #3730a3;
}
.pgw-status-pill.status-pppk-paruh {
    background: #e2e8f0;
    color: #334155;
}
.pgw-status-pill.status-outsourcing {
    background: #f1f5f9;
    color: #475569;
}
.pgw-status-pill.status-default {
    background: #f1f5f9;
    color: #475569;
}
.action-icons { display: flex; gap: 6px; align-items: center; }
.action-icon {
    width: 28px; height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    text-decoration: none;
}
.action-icon:hover { background: #f1f5f9; color: #0f172a; border-color: #cbd5e1; }

.dash-see-all {
    text-align: center;
    padding: 14px;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
}
.dash-see-all a {
    font-size: 13px;
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity 0.15s;
}
.dash-see-all a:hover { opacity: 0.8; text-decoration: underline; }

/* ── Modal Universal Overlay ── */
.custom-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(3px);
    z-index: 1050;
    align-items: center;
    justify-content: center;
}
.custom-modal-overlay.open { display: flex; }
.custom-modal-content {
    background: #ffffff;
    border-radius: 14px;
    width: 100%;
    max-width: 480px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: modal-slide 0.2s ease-out;
}
@keyframes modal-slide {
    from { transform: translateY(15px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}
.custom-modal-header {
    background: #1e3a5f;
    padding: 18px 22px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.custom-modal-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}
.custom-modal-close-btn {
    background: none;
    border: none;
    color: #ffffff;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.8;
    transition: opacity 0.15s;
}
.custom-modal-close-btn:hover { opacity: 1; }
.custom-modal-body { padding: 22px; }

/* Date Range Picker Modal Specifics */
.date-preset-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 18px;
}
.date-preset-btn {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    padding: 6px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s ease;
}
.date-preset-btn:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.date-input-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
}
.date-input-wrap label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.date-input-wrap input[type="date"] {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    color: #0f172a;
    outline: none;
    transition: border-color 0.18s;
}
.date-input-wrap input[type="date"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.custom-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
}
.btn-modal-cancel {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-modal-cancel:hover { background: #f8fafc; color: #0f172a; }
.btn-modal-submit {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    background: #0f172a;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-modal-submit:hover { background: #1e293b; }

/* Pegawai Modal Detail */
.pegawai-modal-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    background: #3b82f6;
    color: #ffffff;
    font-size: 24px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.pegawai-modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-top: 14px;
}
.pegawai-modal-item {
    background: #f8fafc;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}
.pegawai-modal-item label { font-size: 11px; color: #64748b; display: block; margin-bottom: 2px; }
.pegawai-modal-item span { font-size: 13px; font-weight: 600; color: #0f172a; }
</style>
@endpush

@section('content')

{{-- 1. Welcome Banner --}}
<div class="dash-welcome">
    <div class="dash-welcome-text">
        <h2>Selamat datang di E-PROKOPIM</h2>
        <p>Pantau kegiatan, agenda pimpinan, serta informasi internal Prokopim Kota Bandung dalam satu sistem terintegrasi.</p>
    </div>

    {{-- Role Condition: Admin & Super Admin punya tombol aksi tambah --}}
    @if(auth()->user()->isAdmin())
    <div class="dash-welcome-actions">
        <a href="{{ route('kegiatan-pimpinan.create') }}" class="btn-welcome-dark">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kegiatan
        </a>
        <a href="{{ route('pegawai.create') }}" class="btn-welcome-outline">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Tambah Pegawai
        </a>
    </div>
    @endif
</div>

{{-- 2. Period Filter --}}
<div class="period-filter">
    <a href="{{ route('dashboard', ['periode' => 1]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 1) ? 'active' : '' }}">1 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 3]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 3) ? 'active' : '' }}">3 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 6]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 6) ? 'active' : '' }}">6 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 12]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 12) ? 'active' : '' }}">1 Tahun</a>
    
    {{-- Custom Date Button --}}
    <button type="button" class="period-btn {{ $isCustom ? 'active' : '' }}" onclick="openCustomDateModal()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        @if($isCustom && $startDateStr && $endDateStr)
            {{ \Carbon\Carbon::parse($startDateStr)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($endDateStr)->translatedFormat('d M') }}
        @else
            Custom
        @endif
    </button>
</div>

{{-- 3. Stat Cards --}}
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                    +{{ $kenaikanPersen }}% dibanding periode lalu
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.306-4.307a11.95 11.95 0 015.814 5.519l2.74 1.22m0 0l-5.94 2.28m5.94-2.28l-2.28-5.941"/></svg>
                    {{ $kenaikanPersen }}% dibanding periode lalu
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
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

{{-- 4. Main Grid: Statistik Kegiatan & Agenda Pimpinan --}}
<div class="dash-main-grid">

    {{-- Statistik Kegiatan (Bar Chart) --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Statistik Kegiatan</span>
            <select class="filter-select" id="bidang-filter" onchange="filterChart(this.value)">
                <option value="semua">Semua Bidang</option>
                <option value="rapat">Rapat</option>
                <option value="kunjungan">Kunjungan</option>
                <option value="acara">Acara</option>
                <option value="audiensi">Audiensi</option>
            </select>
        </div>
        <div class="dash-card-body">
            @php
                $maxCount = collect($statistikBulanan)->max('count');
                $maxCount = $maxCount > 0 ? $maxCount : 1;
            @endphp
            <div class="chart-bars" id="chart-bars-container">
                @foreach($statistikBulanan as $stat)
                    @php $pct = round(($stat['count'] / $maxCount) * 100); @endphp
                    <div class="chart-bar-wrap" 
                         data-semua="{{ $stat['count'] }}" 
                         data-rapat="{{ $stat['rapat'] }}" 
                         data-kunjungan="{{ $stat['kunjungan'] }}" 
                         data-acara="{{ $stat['acara'] }}" 
                         data-audiensi="{{ $stat['audiensi'] }}">
                        <div class="chart-bar-tooltip">{{ $stat['label'] }}: {{ $stat['count'] }} kegiatan</div>
                        <div class="chart-bar" style="height: {{ max($pct, 6) }}%"></div>
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
                        <div class="agenda-time">{{ $agenda->tanggal_mulai ? $agenda->tanggal_mulai->format('H.i') : '—' }}</div>
                        <div class="agenda-line {{ $agenda->status }}"></div>
                        <div class="agenda-info">
                            <div class="agenda-judul" title="{{ $agenda->judul }}">{{ $agenda->judul }}</div>
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
            <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" width="40" height="40" style="margin:0 auto 10px;display:block;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <p style="font-size:13px;margin:0;">Tidak ada agenda hari ini</p>
            </div>
        @endif
    </div>
</div>

{{-- 5. Data Pegawai --}}
<div class="dash-table-card">
    <div class="dash-table-header">
        <span class="dash-table-header-title">Data Pegawai</span>
        <div class="dash-search-mini">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="color:#64748b"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" id="pegawai-search-input" placeholder="Cari pegawai..." onkeyup="searchPegawai(this.value)">
        </div>
    </div>
    <div style="overflow-x:auto">
        <table class="dash-table" id="pegawai-table">
            <thead>
                <tr>
                    <th style="width:60px">FOTO</th>
                    <th>NAMA PEGAWAI</th>
                    <th>NIP</th>
                    <th>JABATAN</th>
                    <th>STATUS</th>
                    <th style="text-align:right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personelList as $personel)
                <tr class="pegawai-row" 
                    data-nama="{{ strtolower($personel->nama_lengkap) }}" 
                    data-nip="{{ strtolower($personel->nip) }}" 
                    data-jabatan="{{ strtolower($personel->jabatan) }}" 
                    data-bagian="{{ strtolower($personel->bidang_label ?? $personel->bidang) }}">
                    <td>
                        @if($personel->photo)
                            <img src="{{ asset('storage/' . $personel->photo) }}" alt="{{ $personel->nama_lengkap }}" class="pegawai-avatar">
                        @else
                            <div class="pegawai-avatar">{{ $personel->initials }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-weight:600;color:#0f172a;font-size:13px">{{ $personel->nama_lengkap }}</span>
                            <span style="font-size:12px;color:#64748b;">{{ $personel->display_email }}</span>
                        </div>
                    </td>
                    <td style="font-size:12.5px;color:#334155;font-weight:500;">{{ $personel->nip ?: '-' }}</td>
                    <td style="color:#334155;font-size:13px">{{ $personel->jabatan }}</td>
                    <td>
                        <span class="pgw-status-pill {{ $personel->status_kepegawaian_badge_class }}">
                            {{ $personel->status_kepegawaian_label }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons" style="justify-content:flex-end">
                            {{-- Tombol Lihat (Mata) --}}
                            <a href="javascript:void(0)" class="action-icon" title="Lihat Detail" 
                               onclick="openPegawaiModal('{{ addslashes($personel->nama_lengkap) }}', '{{ $personel->nip ?: '-' }}', '{{ addslashes($personel->jabatan) }}', '{{ $personel->bidang_label }}', '{{ $personel->display_email }}', '{{ $personel->phone ?: '-' }}', '{{ $personel->photo ? asset('storage/' . $personel->photo) : '' }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>

                            {{-- Role Condition: Admin / Super Admin punya aksi Edit & Opsi Lain --}}
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('pegawai.edit', $personel->id) }}" class="action-icon" title="Edit Pegawai">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            <a href="{{ route('pegawai.index', ['search' => $personel->nama_lengkap]) }}" class="action-icon" title="Opsi lain">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="empty-pegawai-row">
                    <td colspan="6" style="text-align:center;padding:32px;color:#94a3b8">Belum ada data pegawai</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="dash-see-all">
        <a href="{{ route('pegawai.index') }}">
            Lihat Semua Pegawai
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</div>

{{-- ── MODAL 1: Date Range Picker (Custom Kalender) ── --}}
<div class="custom-modal-overlay" id="date-range-modal" onclick="closeDateRangeModal(event)">
    <div class="custom-modal-content" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Pilih Rentang Waktu
            </h3>
            <button type="button" class="custom-modal-close-btn" onclick="document.getElementById('date-range-modal').classList.remove('open')">✕</button>
        </div>
        <form method="GET" action="{{ route('dashboard') }}" class="custom-modal-body">
            <input type="hidden" name="periode" value="custom">

            {{-- Quick Presets --}}
            <div style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:8px">Pilihan Cepat:</div>
            <div class="date-preset-grid">
                <button type="button" class="date-preset-btn" onclick="setPreset('today')">Hari Ini</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('last7')">7 Hari Lalu</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('thisMonth')">Bulan Ini</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('lastMonth')">Bulan Lalu</button>
            </div>

            {{-- Date Inputs --}}
            <div class="date-input-group">
                <div class="date-input-wrap">
                    <label for="custom-start-date">Tanggal Mulai</label>
                    <input type="date" id="custom-start-date" name="start_date" 
                           value="{{ $startDateStr ?? \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}" required>
                </div>
                <div class="date-input-wrap">
                    <label for="custom-end-date">Tanggal Selesai</label>
                    <input type="date" id="custom-end-date" name="end_date" 
                           value="{{ $endDateStr ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="custom-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="document.getElementById('date-range-modal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn-modal-submit">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL 2: Detail Pegawai ── --}}
<div class="custom-modal-overlay" id="pegawai-modal" onclick="closePegawaiModal(event)">
    <div class="custom-modal-content" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <h3>Detail Pegawai</h3>
            <button type="button" class="custom-modal-close-btn" onclick="document.getElementById('pegawai-modal').classList.remove('open')">✕</button>
        </div>
        <div class="custom-modal-body">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px">
                <div id="modal-avatar-container"></div>
                <div>
                    <h3 id="modal-nama" style="margin:0 0 4px;font-size:16px;font-weight:700;color:#0f172a"></h3>
                    <div id="modal-nip" style="font-size:12.5px;color:#64748b;font-family:monospace"></div>
                </div>
            </div>
            <div class="pegawai-modal-grid">
                <div class="pegawai-modal-item">
                    <label>Jabatan</label>
                    <span id="modal-jabatan"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>Bagian</label>
                    <span id="modal-bagian"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>Email</label>
                    <span id="modal-email" style="font-size:12px;word-break:break-all"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>No. Telepon</label>
                    <span id="modal-phone"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Date Range Modal Logic ──
function openCustomDateModal() {
    document.getElementById('date-range-modal').classList.add('open');
}

function closeDateRangeModal(e) {
    if (e.target.id === 'date-range-modal') {
        document.getElementById('date-range-modal').classList.remove('open');
    }
}

function setPreset(type) {
    const today = new Date();
    const formatDate = (d) => d.toISOString().split('T')[0];

    const startInput = document.getElementById('custom-start-date');
    const endInput   = document.getElementById('custom-end-date');

    if (type === 'today') {
        startInput.value = formatDate(today);
        endInput.value   = formatDate(today);
    } else if (type === 'last7') {
        const past = new Date();
        past.setDate(today.getDate() - 7);
        startInput.value = formatDate(past);
        endInput.value   = formatDate(today);
    } else if (type === 'thisMonth') {
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        startInput.value = formatDate(firstDay);
        endInput.value   = formatDate(today);
    } else if (type === 'lastMonth') {
        const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
        const lastDayLastMonth  = new Date(today.getFullYear(), today.getMonth(), 0);
        startInput.value = formatDate(firstDayLastMonth);
        endInput.value   = formatDate(lastDayLastMonth);
    }
}

// ── Filter Chart Berdasarkan Kategori/Bidang ──
function filterChart(category) {
    const wraps = document.querySelectorAll('#chart-bars-container .chart-bar-wrap');
    let maxVal = 1;

    wraps.forEach(wrap => {
        const val = parseInt(wrap.getAttribute('data-' + category) || wrap.getAttribute('data-semua') || 0);
        if (val > maxVal) maxVal = val;
    });

    wraps.forEach(wrap => {
        const val = parseInt(wrap.getAttribute('data-' + category) || wrap.getAttribute('data-semua') || 0);
        const bar = wrap.querySelector('.chart-bar');
        const tooltip = wrap.querySelector('.chart-bar-tooltip');
        const label = wrap.querySelector('.chart-bar-label').textContent;

        const pct = Math.round((val / maxVal) * 100);
        bar.style.height = Math.max(pct, 6) + '%';
        tooltip.textContent = label + ': ' + val + ' kegiatan';
    });
}

// ── Live Search Data Pegawai ──
function searchPegawai(keyword) {
    keyword = keyword.toLowerCase().trim();
    const rows = document.querySelectorAll('#pegawai-table tbody tr.pegawai-row');

    rows.forEach(row => {
        const nama = row.getAttribute('data-nama') || '';
        const nip = row.getAttribute('data-nip') || '';
        const jabatan = row.getAttribute('data-jabatan') || '';
        const bagian = row.getAttribute('data-bagian') || '';

        if (nama.includes(keyword) || nip.includes(keyword) || jabatan.includes(keyword) || bagian.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// ── Modal Detail Pegawai ──
function openPegawaiModal(nama, nip, jabatan, bagian, email, phone, photo) {
    document.getElementById('modal-nama').textContent = nama;
    document.getElementById('modal-nip').textContent = 'NIP: ' + nip;
    document.getElementById('modal-jabatan').textContent = jabatan;
    document.getElementById('modal-bagian').textContent = bagian;
    document.getElementById('modal-email').textContent = email;
    document.getElementById('modal-phone').textContent = phone;

    const avatarContainer = document.getElementById('modal-avatar-container');
    if (photo) {
        avatarContainer.innerHTML = `<img src="${photo}" alt="${nama}" class="pegawai-modal-avatar">`;
    } else {
        const initial = (nama && nama.length > 0) ? nama.charAt(0).toUpperCase() : 'P';
        avatarContainer.innerHTML = `<div class="pegawai-modal-avatar">${initial}</div>`;
    }

    document.getElementById('pegawai-modal').classList.add('open');
}

function closePegawaiModal(e) {
    if (e.target.id === 'pegawai-modal') {
        document.getElementById('pegawai-modal').classList.remove('open');
    }
}
</script>
@endpush
