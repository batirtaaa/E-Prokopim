@extends('layouts.app')
@section('title', 'Penugasan Personel — E-PROKOPIM')

@push('styles')
<style>
/* Page Base & Container */
.pn-container {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.pn-header {
    margin-bottom: 20px;
}
.pn-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 4px 0;
}
.pn-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

/* Main Grid Layout */
.pn-layout-grid {
    display: grid;
    grid-template-columns: 1fr 260px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1024px) {
    .pn-layout-grid {
        grid-template-columns: 1fr;
    }
    .pn-sidebar-card {
        display: none;
    }
}

/* 3 Top Stat Cards */
.pn-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 768px) {
    .pn-stats-grid {
        grid-template-columns: 1fr;
    }
}
.pn-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 18px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 96px;
}
.pn-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.pn-stat-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #475569;
}
.pn-stat-icon-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pn-stat-icon-circle.blue {
    background: #dbeafe;
    color: #2563eb;
}
.pn-stat-icon-circle.orange {
    background: #ffedd5;
    color: #ea580c;
}
.pn-stat-icon-circle.red {
    background: #fee2e2;
    color: #dc2626;
}
.pn-stat-val-group {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.pn-stat-number {
    font-size: 26px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
}
.pn-stat-number.red-text {
    color: #dc2626;
}
.pn-stat-unit {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
}

/* White Table Container Card */
.pn-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}

/* Filter Toolbar */
.pn-toolbar {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
}
.pn-search-box {
    margin-bottom: 12px;
    position: relative;
}
.pn-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    width: 15px;
    height: 15px;
    pointer-events: none;
}
.pn-search-input {
    width: 100%;
    padding: 8px 12px 8px 36px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.15s ease;
    box-sizing: border-box;
}
.pn-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pn-search-input::placeholder {
    color: #94a3b8;
}

.pn-filters-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pn-select-role {
    padding: 7px 32px 7px 12px;
    font-size: 13px;
    color: #334155;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 10px center / 12px;
    appearance: none;
    outline: none;
    cursor: pointer;
    min-width: 130px;
    transition: border-color 0.15s;
}
.pn-select-role:focus {
    border-color: #3b82f6;
}
.pn-date-input {
    padding: 7px 12px;
    font-size: 13px;
    color: #334155;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    outline: none;
    transition: border-color 0.15s;
    min-width: 140px;
}
.pn-date-input:focus {
    border-color: #3b82f6;
}
.pn-btn-tugas-baru {
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.15s;
    white-space: nowrap;
    text-decoration: none;
}
.pn-btn-tugas-baru:hover {
    background: #081d30;
    color: #ffffff;
}

/* Table Style */
.pn-table-responsive {
    overflow-x: auto;
}
.pn-data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.pn-data-table thead th {
    padding: 12px 18px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #475569;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.pn-data-table thead th:last-child {
    text-align: right;
}
.pn-data-table tbody td {
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.pn-data-table tbody tr:last-child td {
    border-bottom: none;
}
.pn-data-table tbody tr:hover {
    background: #fafcff;
}

/* Row Items */
.pn-kegiatan-name {
    font-weight: 700;
    font-size: 13.5px;
    color: #0f172a;
    line-height: 1.4;
}
.pn-kegiatan-time {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #64748b;
    margin-top: 3px;
}
.pn-kegiatan-time svg {
    width: 13px;
    height: 13px;
    color: #94a3b8;
    flex-shrink: 0;
}

.pn-lokasi-name {
    font-size: 13px;
    color: #334155;
}
.pn-pimpinan-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
    padding: 2px 8px;
    background: #e2e8f0;
    color: #1e293b;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
}
.pn-pimpinan-tag svg {
    width: 11px;
    height: 11px;
    color: #475569;
}

/* Tim Bertugas list */
.pn-team-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.pn-team-member {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pn-member-av {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    color: #ffffff;
    flex-shrink: 0;
    overflow: hidden;
}
.pn-member-av.av-blue { background: #3b82f6; }
.pn-member-av.av-orange { background: #f97316; }
.pn-member-av.av-purple { background: #8b5cf6; }
.pn-member-av.av-pink { background: #ec4899; }
.pn-member-av.av-teal { background: #14b8a6; }
.pn-member-av.av-gray { background: #64748b; }
.pn-member-av img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pn-member-name {
    font-size: 12.5px;
    font-weight: 500;
    color: #0f172a;
}
.pn-member-role {
    font-size: 12px;
    color: #64748b;
    margin-left: 2px;
}

/* Status Badges */
.pn-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 500;
    white-space: nowrap;
}
.pn-status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}
.pn-status-pill.dikonfirmasi {
    background: #dbeafe;
    color: #1d4ed8;
}
.pn-status-pill.dikonfirmasi .pn-status-dot {
    background: #2563eb;
}
.pn-status-pill.ditugaskan {
    background: #f1f5f9;
    color: #475569;
}
.pn-status-pill.ditugaskan .pn-status-dot {
    background: #64748b;
}
.pn-status-pill.berlangsung {
    background: #dcfce7;
    color: #15803d;
}
.pn-status-pill.berlangsung .pn-status-dot {
    background: #16a34a;
}
.pn-status-pill.selesai {
    background: #f0fdf4;
    color: #166534;
}
.pn-status-pill.selesai .pn-status-dot {
    background: #22c55e;
}
.pn-status-pill.tidak_hadir {
    background: #fee2e2;
    color: #b91c1c;
}
.pn-status-pill.tidak_hadir .pn-status-dot {
    background: #dc2626;
}

/* Action Dropdown Menu */
.pn-action-menu-wrap {
    position: relative;
    display: inline-block;
}
.pn-btn-dots-menu {
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.pn-btn-dots-menu:hover {
    color: #1e293b;
    background: #f1f5f9;
}
.pn-actions-dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 4px);
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    min-width: 160px;
    z-index: 50;
    padding: 4px;
    display: none;
}
.pn-actions-dropdown.active {
    display: block;
}
.pn-dropdown-action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    font-size: 12px;
    color: #334155;
    background: none;
    border: none;
    border-radius: 6px;
    width: 100%;
    text-align: left;
    cursor: pointer;
    text-decoration: none;
}
.pn-dropdown-action-btn:hover {
    background: #f8fafc;
}
.pn-dropdown-action-btn.danger-action {
    color: #dc2626;
}
.pn-dropdown-action-btn.danger-action:hover {
    background: #fee2e2;
}

/* Pagination Footer */
.pn-pagination-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
}
.pn-page-controls {
    display: flex;
    align-items: center;
    gap: 4px;
}
.pn-page-btn {
    min-width: 28px;
    height: 28px;
    padding: 0 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    color: #64748b;
    font-size: 12px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
}
.pn-page-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.pn-page-btn.active {
    background: #0f2942;
    border-color: #0f2942;
    color: #ffffff;
    font-weight: 600;
}
.pn-page-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

/* Right Sidebar: Status Personel */
.pn-sidebar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    position: sticky;
    top: 80px;
}
.pn-sidebar-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 16px 0;
}
.pn-personel-items-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.pn-personel-row-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.pn-p-left-group {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}
.pn-p-avatar-circle-wrap {
    position: relative;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    flex-shrink: 0;
}
.pn-p-avatar-circle-wrap .avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.pn-p-avatar-circle-wrap .avatar-initials-badge {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #ffffff;
}
.pn-p-indicator-dot {
    position: absolute;
    bottom: -1px;
    right: -1px;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    border: 2px solid #ffffff;
}
.pn-p-indicator-dot.dot-bertugas { background: #dc2626; }
.pn-p-indicator-dot.dot-standby  { background: #16a34a; }
.pn-p-indicator-dot.dot-cuti     { background: #94a3b8; }
.pn-p-indicator-dot.dot-tidak_aktif { background: #dc2626; }

.pn-p-details {
    min-width: 0;
}
.pn-p-name {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pn-p-job {
    font-size: 11.5px;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pn-p-status-badge-text {
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    flex-shrink: 0;
}
.pn-p-status-badge-text.tag-bertugas { color: #dc2626; }
.pn-p-status-badge-text.tag-standby  { color: #16a34a; }
.pn-p-status-badge-text.tag-cuti     { color: #94a3b8; }
.pn-p-status-badge-text.tag-tidak_aktif { color: #dc2626; }
</style>
@endpush

@section('content')
<div class="pn-container">

    {{-- Flash message --}}
    @if(session('success'))
    <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; justify-content:space-between">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:18px;height:18px;color:#22c55e"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#166534; cursor:pointer; font-size:16px;">&times;</button>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="pn-header">
        <h1 class="pn-title">Penugasan Personel</h1>
        <p class="pn-subtitle">Kelola pembagian tugas tim Protokol, Komunikasi Pimpinan, dan Dokumentasi untuk setiap agenda pimpinan secara real-time.</p>
    </div>

    {{-- Grid Layout: Main Area + Right Sidebar --}}
    <div class="pn-layout-grid">
        {{-- Main Area --}}
        <div>
            {{-- Top 3 Metric Cards --}}
            <div class="pn-stats-grid">
                {{-- Card 1: Total Penugasan --}}
                <div class="pn-stat-card">
                    <div class="pn-stat-top">
                        <span class="pn-stat-label">TOTAL PENUGASAN</span>
                        <div class="pn-stat-icon-circle blue">
                            {{-- Team/Group SVG icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-val-group">
                        <span class="pn-stat-number">{{ $totalPenugasan }}</span>
                        <span class="pn-stat-unit">Personel Hari Ini</span>
                    </div>
                </div>

                {{-- Card 2: Personel Siaga --}}
                <div class="pn-stat-card">
                    <div class="pn-stat-top">
                        <span class="pn-stat-label">PERSONEL SIAGA</span>
                        <div class="pn-stat-icon-circle orange">
                            {{-- Raised Hand SVG icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.275a2.25 2.25 0 012.9 0l7.25 6.042a2.25 2.25 0 01.75 1.725v6.208a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.25v-6.208a2.25 2.25 0 01.75-1.725l6.3-5.25z" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-val-group">
                        <span class="pn-stat-number">{{ $personelSiaga }}</span>
                        <span class="pn-stat-unit">Personel</span>
                    </div>
                </div>

                {{-- Card 3: Belum Dikonfirmasi --}}
                <div class="pn-stat-card">
                    <div class="pn-stat-top">
                        <span class="pn-stat-label">BELUM DIKONFIRMASI</span>
                        <div class="pn-stat-icon-circle red">
                            {{-- Calendar Alert SVG icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-val-group">
                        <span class="pn-stat-number {{ $belumDikonfirmasi > 0 ? 'red-text' : '' }}">{{ $belumDikonfirmasi }}</span>
                        <span class="pn-stat-unit">Tugas</span>
                    </div>
                </div>
            </div>

            {{-- Main Table Container Card --}}
            <div class="pn-main-card">
                {{-- Filter Toolbar --}}
                <div class="pn-toolbar">
                    <form method="GET" action="{{ route('protokol-pimpinan.penugasan.index') }}" id="pnFilterForm">
                        {{-- Search Input --}}
                        <div class="pn-search-box">
                            <svg class="pn-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input type="text" name="search" class="pn-search-input" placeholder="Cari agenda atau kegiatan..." value="{{ request('search') }}">
                        </div>

                        {{-- Filters Row --}}
                        <div class="pn-filters-row">
                            <select name="role" class="pn-select-role" onchange="document.getElementById('pnFilterForm').submit()">
                                <option value="">Semua Role</option>
                                <option value="Protokol" {{ request('role') == 'Protokol' ? 'selected' : '' }}>Protokol</option>
                                <option value="MC" {{ request('role') == 'MC' ? 'selected' : '' }}>MC</option>
                                <option value="Fotografer" {{ request('role') == 'Fotografer' ? 'selected' : '' }}>Fotografer</option>
                                <option value="Videografer" {{ request('role') == 'Videografer' ? 'selected' : '' }}>Videografer</option>
                                <option value="Notulis" {{ request('role') == 'Notulis' ? 'selected' : '' }}>Notulis</option>
                                <option value="Dokumentasi" {{ request('role') == 'Dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                            </select>

                            <input type="date" name="tanggal" class="pn-date-input" value="{{ request('tanggal') }}" onchange="document.getElementById('pnFilterForm').submit()">

                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('protokol-pimpinan.penugasan.create') }}" class="pn-btn-tugas-baru">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Tugas Baru</span>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Table Responsive --}}
                <div class="pn-table-responsive">
                    <table class="pn-data-table">
                        <thead>
                            <tr>
                                <th>KEGIATAN &amp; WAKTU</th>
                                <th>LOKASI &amp; PIMPINAN</th>
                                <th>TIM BERTUGAS</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kegiatanPenugasan as $item)
                            @php
                                $colorClasses = ['av-blue', 'av-orange', 'av-purple', 'av-teal', 'av-pink', 'av-gray'];
                                
                                // Calculate overall status for the row
                                $statuses = $item->penugasan->pluck('status')->toArray();
                                if (in_array('berlangsung', $statuses)) {
                                    $overallStatus = 'berlangsung';
                                    $statusLabel = 'Berlangsung';
                                } elseif (in_array('dikonfirmasi', $statuses)) {
                                    $overallStatus = 'dikonfirmasi';
                                    $statusLabel = 'Dikonfirmasi';
                                } elseif (in_array('selesai', $statuses) && count(array_unique($statuses)) === 1) {
                                    $overallStatus = 'selesai';
                                    $statusLabel = 'Selesai';
                                } elseif (in_array('ditugaskan', $statuses)) {
                                    $overallStatus = 'ditugaskan';
                                    $statusLabel = 'Ditugaskan';
                                } else {
                                    $overallStatus = $statuses[0] ?? 'ditugaskan';
                                    $statusLabel = ucfirst($overallStatus);
                                }
                            @endphp
                            <tr>
                                {{-- 1. Kegiatan & Waktu --}}
                                <td>
                                    <div class="pn-kegiatan-name">{{ $item->judul }}</div>
                                    <div class="pn-kegiatan-time">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>
                                            @if($item->tanggal_mulai)
                                                @if($item->tanggal_mulai->isToday())
                                                    Hari ini, {{ $item->tanggal_mulai->format('H:i') }} WIB
                                                @elseif($item->tanggal_mulai->isTomorrow())
                                                    Besok, {{ $item->tanggal_mulai->format('H:i') }} WIB
                                                @else
                                                    {{ $item->tanggal_mulai->format('d M Y, H:i') }} WIB
                                                @endif
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </div>
                                </td>

                                {{-- 2. Lokasi & Pimpinan --}}
                                <td>
                                    <div class="pn-lokasi-name">{{ $item->lokasi ?? '—' }}</div>
                                    <div class="pn-pimpinan-tag">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <span>{{ $item->pimpinan_label ?? 'Wali Kota' }}</span>
                                    </div>
                                </td>

                                {{-- 3. Tim Bertugas (All members listed) --}}
                                <td>
                                    <div class="pn-team-group">
                                        @foreach($item->penugasan as $tugas)
                                        @php
                                            $pId = $tugas->personel_id ?? 1;
                                            $avColor = $colorClasses[$pId % count($colorClasses)];
                                            $pName = $tugas->personel->nama_lengkap ?? '—';
                                            $initials = $tugas->personel ? $tugas->personel->initials : '??';
                                            
                                            // Short role label: Fotografer -> Foto, Videografer -> Video
                                            $shortRole = match(strtolower($tugas->peran)) {
                                                'fotografer' => 'Foto',
                                                'videografer' => 'Video',
                                                default => $tugas->peran,
                                            };
                                        @endphp
                                        <div class="pn-team-member">
                                            <div class="pn-member-av {{ $avColor }}">
                                                @if($tugas->personel && $tugas->personel->photo)
                                                    <img src="{{ asset('storage/' . $tugas->personel->photo) }}" alt="">
                                                @else
                                                    {{ $initials }}
                                                @endif
                                            </div>
                                            <div>
                                                <span class="pn-member-name">{{ $pName }}</span>
                                                <span class="pn-member-role">({{ $shortRole }})</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>

                                {{-- 4. Status --}}
                                <td>
                                    <span class="pn-status-pill {{ $overallStatus }}">
                                        <span class="pn-status-dot"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- 5. Actions (3 dots) --}}
                                <td style="text-align: right;">
                                    @if(auth()->user()->isAdmin())
                                    <div class="pn-action-menu-wrap">
                                        <button type="button" class="pn-btn-dots-menu" onclick="toggleActionDropdown(event, 'menu-act-{{ $item->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                            </svg>
                                        </button>
                                        <div class="pn-actions-dropdown" id="menu-act-{{ $item->id }}">
                                            @foreach($item->penugasan as $tugas)
                                                @if($tugas->status !== 'dikonfirmasi')
                                                <form method="POST" action="{{ route('protokol-pimpinan.penugasan.update', $tugas) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="dikonfirmasi">
                                                    <button type="submit" class="pn-dropdown-action-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#2563eb" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                        Konfirmasi ({{ $tugas->personel->nama_lengkap ?? 'Personel' }})
                                                    </button>
                                                </form>
                                                @endif
                                            @endforeach

                                            @if($overallStatus !== 'berlangsung')
                                                @foreach($item->penugasan as $tugas)
                                                <form method="POST" action="{{ route('protokol-pimpinan.penugasan.update', $tugas) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="berlangsung">
                                                    <button type="submit" class="pn-dropdown-action-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#16a34a" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" /></svg>
                                                        Set Berlangsung ({{ $tugas->personel->nama_lengkap ?? 'Personel' }})
                                                    </button>
                                                </form>
                                                @endforeach
                                            @endif

                                            @if($overallStatus !== 'selesai')
                                                @foreach($item->penugasan as $tugas)
                                                <form method="POST" action="{{ route('protokol-pimpinan.penugasan.update', $tugas) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="pn-dropdown-action-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#10b981" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        Set Selesai ({{ $tugas->personel->nama_lengkap ?? 'Personel' }})
                                                    </button>
                                                </form>
                                                @endforeach
                                            @endif

                                            <hr style="margin: 4px 0; border: none; border-top: 1px solid #f1f5f9;">

                                            @foreach($item->penugasan as $tugas)
                                            <form method="POST" action="{{ route('protokol-pimpinan.penugasan.destroy', $tugas) }}" onsubmit="return confirm('Hapus penugasan {{ $tugas->personel->nama_lengkap ?? '' }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="pn-dropdown-action-btn danger-action">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#dc2626" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                    Hapus Penugasan ({{ $tugas->personel->nama_lengkap ?? '' }})
                                                </button>
                                            </form>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px; height:40px; margin:0 auto 8px; display:block; opacity:0.4;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data penugasan</p>
                                    <a href="{{ route('protokol-pimpinan.penugasan.create') }}" style="color:#2563eb; background:none; border:none; text-decoration:none; cursor:pointer; font-size:12.5px; font-weight:600;">+ Buat Penugasan Baru</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="pn-pagination-row">
                    <span>Menampilkan {{ $kegiatanPenugasan->firstItem() ?? 0 }}–{{ $kegiatanPenugasan->lastItem() ?? 0 }} dari {{ $kegiatanPenugasan->total() }} tugas</span>
                    <div class="pn-page-controls">
                        @if($kegiatanPenugasan->onFirstPage())
                            <span class="pn-page-btn disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            </span>
                        @else
                            <a href="{{ $kegiatanPenugasan->previousPageUrl() }}" class="pn-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            </a>
                        @endif

                        @php
                            $cur = $kegiatanPenugasan->currentPage();
                            $last = $kegiatanPenugasan->lastPage();
                            $pages = [];
                            if ($last <= 5) {
                                $pages = range(1, $last);
                            } else {
                                $pages = [1];
                                if ($cur > 2) $pages[] = '...';
                                if ($cur > 1 && $cur < $last) $pages[] = $cur;
                                if ($cur < $last - 1) $pages[] = '...';
                                $pages[] = $last;
                                $pages = array_unique($pages);
                            }
                        @endphp
                        @foreach($pages as $p)
                            @if($p === '...')
                                <span class="pn-page-btn disabled" style="border:none;">…</span>
                            @elseif($p == $cur)
                                <span class="pn-page-btn active">{{ $p }}</span>
                            @else
                                <a href="{{ $kegiatanPenugasan->url($p) }}" class="pn-page-btn">{{ $p }}</a>
                            @endif
                        @endforeach

                        @if($kegiatanPenugasan->hasMorePages())
                            <a href="{{ $kegiatanPenugasan->nextPageUrl() }}" class="pn-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        @else
                            <span class="pn-page-btn disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Sidebar: Status Personel --}}
        <div class="pn-sidebar-card">
            <h3 class="pn-sidebar-card-title">Status Personel</h3>
            <div class="pn-personel-items-list">
                @foreach($personelStatus as $p)
                @php
                    $colors = ['av-blue', 'av-orange', 'av-purple', 'av-teal', 'av-pink', 'av-gray'];
                    $color = $colors[$p->id % count($colors)];
                    $st = strtolower($p->status_ketersediaan ?? 'standby');
                @endphp
                <div class="pn-personel-row-card">
                    <div class="pn-p-left-group">
                        <div class="pn-p-avatar-circle-wrap">
                            @if($p->photo)
                                <img src="{{ asset('storage/' . $p->photo) }}" class="avatar-img" alt="">
                            @else
                                <div class="avatar-initials-badge {{ $color }}">{{ $p->initials }}</div>
                            @endif
                            <span class="pn-p-indicator-dot dot-{{ $st }}"></span>
                        </div>
                        <div class="pn-p-details">
                            <div class="pn-p-name">{{ $p->nama_lengkap }}</div>
                            <div class="pn-p-job">{{ $p->jabatan }}</div>
                        </div>
                    </div>
                    <span class="pn-p-status-badge-text tag-{{ $st }}">
                        {{ $p->status_label }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Action Dropdown Menu Toggle
function toggleActionDropdown(event, menuId) {
    event.stopPropagation();
    const targetMenu = document.getElementById(menuId);
    const isOpen = targetMenu.classList.contains('active');
    
    // Close all other menus
    document.querySelectorAll('.pn-actions-dropdown').forEach(el => el.classList.remove('active'));
    
    if (!isOpen) {
        targetMenu.classList.add('active');
    }
}

// Close dropdowns on outside click or Escape key
document.addEventListener('click', function() {
    document.querySelectorAll('.pn-actions-dropdown').forEach(el => el.classList.remove('active'));
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.pn-actions-dropdown').forEach(el => el.classList.remove('active'));
    }
});
</script>
@endpush
