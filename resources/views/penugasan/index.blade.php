@extends('layouts.app')
@section('title', 'Penugasan Personel — SIKOPIM')

@push('styles')
<style>
/* Base container & typography */
.penugasan-page {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.pn-header {
    margin-bottom: 24px;
}
.pn-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 4px 0;
}
.pn-subtitle {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

/* Main Grid Layout */
.pn-grid {
    display: grid;
    grid-template-columns: 1fr 240px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1024px) {
    .pn-grid {
        grid-template-columns: 1fr;
    }
    .pn-sidebar-card {
        display: none;
    }
}

/* Stats Cards */
.pn-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 768px) {
    .pn-stats-row {
        grid-template-columns: 1fr;
    }
}
.pn-stat-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 18px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 100px;
}
.pn-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.pn-stat-tag {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
}
.pn-stat-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pn-stat-icon-wrap.blue {
    background: #dbeafe;
    color: #2563eb;
}
.pn-stat-icon-wrap.orange {
    background: #ffedd5;
    color: #ea580c;
}
.pn-stat-icon-wrap.red {
    background: #fee2e2;
    color: #dc2626;
}
.pn-stat-body {
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
.pn-stat-number.red-val {
    color: #dc2626;
}
.pn-stat-unit {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
}

/* Card Wrapper */
.pn-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    overflow: hidden;
}

/* Filter Toolbar */
.pn-filter-section {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
}
.pn-search-container {
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
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
}
.pn-search-input::placeholder {
    color: #94a3b8;
}

.pn-actions-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pn-select-control {
    padding: 7px 30px 7px 12px;
    font-size: 13px;
    color: #334155;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 10px center / 12px;
    appearance: none;
    outline: none;
    cursor: pointer;
    min-width: 140px;
    transition: border-color 0.15s;
}
.pn-select-control:focus {
    border-color: #3b82f6;
}
.pn-date-control {
    padding: 7px 12px;
    font-size: 13px;
    color: #334155;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    outline: none;
    transition: border-color 0.15s;
}
.pn-date-control:focus {
    border-color: #3b82f6;
}
.pn-btn-tugas-baru {
    margin-left: 0;
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
}
.pn-btn-tugas-baru:hover {
    background: #081d30;
}

/* Table Style */
.pn-table-container {
    overflow-x: auto;
}
.pn-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.pn-table thead th {
    padding: 12px 18px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #475569;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.pn-table thead th:last-child {
    text-align: right;
}
.pn-table tbody td {
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.pn-table tbody tr:last-child td {
    border-bottom: none;
}
.pn-table tbody tr:hover {
    background: #fafcff;
}

/* Row elements */
.pn-agenda-title {
    font-weight: 600;
    font-size: 13.5px;
    color: #0f172a;
    line-height: 1.4;
}
.pn-agenda-time {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #64748b;
    margin-top: 3px;
}
.pn-agenda-time svg {
    width: 13px;
    height: 13px;
    color: #94a3b8;
}

.pn-lokasi-text {
    font-size: 13px;
    color: #334155;
}
.pn-pimpinan-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 4px;
    padding: 2px 8px;
    background: #e2e8f0;
    color: #1e293b;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
}
.pn-pimpinan-pill svg {
    width: 11px;
    height: 11px;
    color: #475569;
}

/* Personel Column */
.pn-tim-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.pn-tim-item {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pn-avatar-circle {
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
.pn-avatar-circle.av-blue { background: #3b82f6; }
.pn-avatar-circle.av-orange { background: #f97316; }
.pn-avatar-circle.av-purple { background: #8b5cf6; }
.pn-avatar-circle.av-pink { background: #ec4899; }
.pn-avatar-circle.av-teal { background: #14b8a6; }
.pn-avatar-circle.av-gray { background: #64748b; }
.pn-avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pn-tim-name {
    font-size: 12.5px;
    font-weight: 500;
    color: #0f172a;
}
.pn-tim-role {
    font-size: 11.5px;
    color: #64748b;
    margin-left: 3px;
}

/* Status Badges */
.pn-status-badge {
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
.pn-status-badge.dikonfirmasi {
    background: #dbeafe;
    color: #1d4ed8;
}
.pn-status-badge.dikonfirmasi .pn-status-dot {
    background: #2563eb;
}
.pn-status-badge.ditugaskan {
    background: #f1f5f9;
    color: #475569;
}
.pn-status-badge.ditugaskan .pn-status-dot {
    background: #64748b;
}
.pn-status-badge.berlangsung {
    background: #dcfce7;
    color: #15803d;
}
.pn-status-badge.berlangsung .pn-status-dot {
    background: #16a34a;
}
.pn-status-badge.selesai {
    background: #f0fdf4;
    color: #166534;
}
.pn-status-badge.selesai .pn-status-dot {
    background: #22c55e;
}
.pn-status-badge.tidak_hadir {
    background: #fee2e2;
    color: #b91c1c;
}
.pn-status-badge.tidak_hadir .pn-status-dot {
    background: #dc2626;
}

/* Action Dropdown */
.pn-action-menu {
    position: relative;
    display: inline-block;
}
.pn-btn-dots {
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.pn-btn-dots:hover {
    color: #1e293b;
    background: #f1f5f9;
}
.pn-dropdown-panel {
    position: absolute;
    right: 0;
    top: calc(100% + 4px);
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    min-width: 140px;
    z-index: 50;
    padding: 4px;
    display: none;
}
.pn-dropdown-panel.active {
    display: block;
}
.pn-dropdown-item {
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
}
.pn-dropdown-item:hover {
    background: #f8fafc;
}
.pn-dropdown-item.danger-text {
    color: #dc2626;
}
.pn-dropdown-item.danger-text:hover {
    background: #fee2e2;
}

/* Pagination */
.pn-pagination-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
}
.pn-nav-btns {
    display: flex;
    align-items: center;
    gap: 4px;
}
.pn-nav-btn {
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
.pn-nav-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.pn-nav-btn.active-page {
    background: #0f2942;
    border-color: #0f2942;
    color: #ffffff;
    font-weight: 600;
}
.pn-nav-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

/* Sidebar: Status Personel */
.pn-sidebar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    position: sticky;
    top: 80px;
}
.pn-sidebar-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 16px 0;
}
.pn-personel-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.pn-personel-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.pn-personel-info-group {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}
.pn-p-avatar-wrap {
    position: relative;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    flex-shrink: 0;
}
.pn-p-avatar-wrap .avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.pn-p-avatar-wrap .avatar-initials {
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

.pn-personel-text {
    min-width: 0;
}
.pn-personel-name {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pn-personel-role {
    font-size: 11.5px;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pn-personel-status-tag {
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    flex-shrink: 0;
}
.pn-personel-status-tag.tag-bertugas { color: #dc2626; }
.pn-personel-status-tag.tag-standby  { color: #16a34a; }
.pn-personel-status-tag.tag-cuti     { color: #94a3b8; }

/* Modal Styles */
.pn-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(3px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.pn-modal-backdrop.is-open {
    display: flex;
}
.pn-modal-dialog {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.pn-modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.pn-modal-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px 0;
}
.pn-modal-sub {
    font-size: 12.5px;
    color: #64748b;
    margin: 0;
}
.pn-modal-close-btn {
    background: none;
    border: none;
    font-size: 18px;
    color: #94a3b8;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    line-height: 1;
}
.pn-modal-close-btn:hover {
    color: #0f172a;
}
.pn-modal-body {
    padding: 20px 24px;
}
.pn-form-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
}
.pn-form-section-title svg {
    width: 16px;
    height: 16px;
    color: #2563eb;
}
.pn-form-group {
    margin-bottom: 14px;
}
.pn-field-label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.pn-field-label .required {
    color: #ef4444;
}
.pn-input-select, .pn-input-text, .pn-input-textarea {
    width: 100%;
    padding: 8px 12px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    box-sizing: border-box;
    transition: all 0.15s;
    font-family: inherit;
}
.pn-input-select:focus, .pn-input-text:focus, .pn-input-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pn-input-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 10px center / 12px;
    appearance: none;
    cursor: pointer;
}
.pn-field-hint {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 4px;
}
.pn-form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.pn-standby-counter {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    color: #16a34a;
    font-weight: 500;
    margin-top: 4px;
}
.pn-standby-counter::before {
    content: '●';
    font-size: 8px;
}

/* Personel Multi Tag Input */
.pn-tags-box {
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 8px;
    background: #ffffff;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
    min-height: 38px;
}
.pn-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 9999px;
    padding: 2px 8px 2px 4px;
    font-size: 11.5px;
    font-weight: 500;
    color: #1d4ed8;
}
.pn-chip-av {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #3b82f6;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8.5px;
    font-weight: 700;
}
.pn-chip-close {
    background: none;
    border: none;
    color: #93c5fd;
    cursor: pointer;
    font-size: 13px;
    line-height: 1;
    padding: 0;
    display: flex;
    align-items: center;
}
.pn-chip-close:hover {
    color: #1d4ed8;
}

.pn-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
}
.pn-btn-batal {
    padding: 8px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
}
.pn-btn-batal:hover {
    border-color: #94a3b8;
    color: #1e293b;
}
.pn-btn-simpan {
    padding: 8px 18px;
    border: none;
    border-radius: 8px;
    background: #0f2942;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background 0.15s;
}
.pn-btn-simpan:hover {
    background: #081d30;
}
</style>
@endpush

@section('content')
<div class="penugasan-page">

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

    {{-- Grid Layout: Main Content + Sidebar --}}
    <div class="pn-grid">
        {{-- Main Content Area --}}
        <div>
            {{-- 3 Stats Cards --}}
            <div class="pn-stats-row">
                {{-- Card 1: Total Penugasan --}}
                <div class="pn-stat-box">
                    <div class="pn-stat-header">
                        <span class="pn-stat-tag">Total Penugasan</span>
                        <div class="pn-stat-icon-wrap blue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-body">
                        <span class="pn-stat-number">{{ $totalPenugasan }}</span>
                        <span class="pn-stat-unit">Personel Hari Ini</span>
                    </div>
                </div>

                {{-- Card 2: Personel Siaga --}}
                <div class="pn-stat-box">
                    <div class="pn-stat-header">
                        <span class="pn-stat-tag">Personel Siaga</span>
                        <div class="pn-stat-icon-wrap orange">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.275a2.25 2.25 0 012.9 0l7.25 6.042a2.25 2.25 0 01.75 1.725v6.208a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.25v-6.208a2.25 2.25 0 01.75-1.725l6.3-5.25z" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-body">
                        <span class="pn-stat-number">{{ $personelSiaga }}</span>
                        <span class="pn-stat-unit">Personel</span>
                    </div>
                </div>

                {{-- Card 3: Belum Dikonfirmasi --}}
                <div class="pn-stat-box">
                    <div class="pn-stat-header">
                        <span class="pn-stat-tag">Belum Dikonfirmasi</span>
                        <div class="pn-stat-icon-wrap red">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="pn-stat-body">
                        <span class="pn-stat-number {{ $belumDikonfirmasi > 0 ? 'red-val' : '' }}">{{ $belumDikonfirmasi }}</span>
                        <span class="pn-stat-unit">Tugas</span>
                    </div>
                </div>
            </div>

            {{-- Main Table Card --}}
            <div class="pn-card">
                {{-- Filter and Search Bar --}}
                <div class="pn-filter-section">
                    <form method="GET" action="{{ route('penugasan.index') }}" id="pnFilterForm">
                        {{-- Search Input --}}
                        <div class="pn-search-container">
                            <svg class="pn-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input type="text" name="search" class="pn-search-input" placeholder="Cari agenda atau kegiatan..." value="{{ request('search') }}">
                        </div>

                        {{-- Filter Actions --}}
                        <div class="pn-actions-bar">
                            <select name="role" class="pn-select-control" onchange="document.getElementById('pnFilterForm').submit()">
                                <option value="">Semua Role</option>
                                <option value="Protokol" {{ request('role') == 'Protokol' ? 'selected' : '' }}>Protokol</option>
                                <option value="MC" {{ request('role') == 'MC' ? 'selected' : '' }}>MC</option>
                                <option value="Fotografer" {{ request('role') == 'Fotografer' ? 'selected' : '' }}>Fotografer</option>
                                <option value="Videografer" {{ request('role') == 'Videografer' ? 'selected' : '' }}>Videografer</option>
                                <option value="Notulis" {{ request('role') == 'Notulis' ? 'selected' : '' }}>Notulis</option>
                                <option value="Dokumentasi" {{ request('role') == 'Dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                            </select>

                            <input type="date" name="tanggal" class="pn-date-control" value="{{ request('tanggal') }}" onchange="document.getElementById('pnFilterForm').submit()">

                            <button type="button" class="pn-btn-tugas-baru" onclick="openPnModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Tugas Baru</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Table Content --}}
                <div class="pn-table-container">
                    <table class="pn-table">
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
                            @forelse($penugasan as $tugas)
                            @php
                                $colorClasses = ['av-blue', 'av-orange', 'av-purple', 'av-teal', 'av-pink', 'av-gray'];
                                $avColor = $colorClasses[$tugas->personel_id % count($colorClasses)];
                                $initials = $tugas->personel ? $tugas->personel->initials : '??';
                            @endphp
                            <tr>
                                {{-- Kegiatan & Waktu --}}
                                <td>
                                    <div class="pn-agenda-title">{{ $tugas->kegiatan->judul ?? '—' }}</div>
                                    <div class="pn-agenda-time">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>
                                            @if($tugas->kegiatan && $tugas->kegiatan->tanggal_mulai)
                                                @if($tugas->kegiatan->tanggal_mulai->isToday())
                                                    Hari ini, {{ $tugas->kegiatan->tanggal_mulai->format('H:i') }} WIB
                                                @else
                                                    {{ $tugas->kegiatan->tanggal_mulai->format('d M Y, H:i') }} WIB
                                                @endif
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </div>
                                </td>

                                {{-- Lokasi & Pimpinan --}}
                                <td>
                                    <div class="pn-lokasi-text">{{ $tugas->kegiatan->lokasi ?? '—' }}</div>
                                    <div class="pn-pimpinan-pill">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <span>{{ $tugas->kegiatan->pimpinan_label ?? 'Wali Kota' }}</span>
                                    </div>
                                </td>

                                {{-- Tim Bertugas --}}
                                <td>
                                    <div class="pn-tim-list">
                                        <div class="pn-tim-item">
                                            <div class="pn-avatar-circle {{ $avColor }}">
                                                @if($tugas->personel && $tugas->personel->photo)
                                                    <img src="{{ asset('storage/' . $tugas->personel->photo) }}" alt="">
                                                @else
                                                    {{ $initials }}
                                                @endif
                                            </div>
                                            <div>
                                                <span class="pn-tim-name">{{ $tugas->personel->nama_lengkap ?? '—' }}</span>
                                                <span class="pn-tim-role">({{ $tugas->peran }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="pn-status-badge {{ $tugas->status }}">
                                        <span class="pn-status-dot"></span>
                                        {{ $tugas->status_label }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td style="text-align: right;">
                                    <div class="pn-action-menu">
                                        <button type="button" class="pn-btn-dots" onclick="toggleMenu(event, 'menu-{{ $tugas->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                            </svg>
                                        </button>
                                        <div class="pn-dropdown-panel" id="menu-{{ $tugas->id }}">
                                            @if($tugas->status !== 'dikonfirmasi')
                                            <form method="POST" action="{{ route('penugasan.update', $tugas) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="dikonfirmasi">
                                                <button type="submit" class="pn-dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#2563eb" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            @endif
                                            @if($tugas->status !== 'berlangsung')
                                            <form method="POST" action="{{ route('penugasan.update', $tugas) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="berlangsung">
                                                <button type="submit" class="pn-dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#16a34a" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" /></svg>
                                                    Berlangsung
                                                </button>
                                            </form>
                                            @endif
                                            @if($tugas->status !== 'selesai')
                                            <form method="POST" action="{{ route('penugasan.update', $tugas) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="pn-dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#10b981" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    Selesai
                                                </button>
                                            </form>
                                            @endif
                                            <hr style="margin: 4px 0; border: none; border-top: 1px solid #f1f5f9;">
                                            <form method="POST" action="{{ route('penugasan.destroy', $tugas) }}" onsubmit="return confirm('Hapus penugasan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="pn-dropdown-item danger-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#dc2626" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px; height:40px; margin:0 auto 8px; display:block; opacity:0.4;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data penugasan</p>
                                    <button type="button" onclick="openPnModal()" style="color:#2563eb; background:none; border:none; cursor:pointer; font-size:12.5px; font-weight:600;">+ Buat Penugasan Baru</button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="pn-pagination-footer">
                    <span>Menampilkan {{ $penugasan->firstItem() ?? 0 }}–{{ $penugasan->lastItem() ?? 0 }} dari {{ $penugasan->total() }} tugas</span>
                    <div class="pn-nav-btns">
                        @if($penugasan->onFirstPage())
                            <span class="pn-nav-btn disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            </span>
                        @else
                            <a href="{{ $penugasan->previousPageUrl() }}" class="pn-nav-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            </a>
                        @endif

                        @php
                            $cur = $penugasan->currentPage();
                            $last = $penugasan->lastPage();
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
                                <span class="pn-nav-btn disabled" style="border:none;">…</span>
                            @elseif($p == $cur)
                                <span class="pn-nav-btn active-page">{{ $p }}</span>
                            @else
                                <a href="{{ $penugasan->url($p) }}" class="pn-nav-btn">{{ $p }}</a>
                            @endif
                        @endforeach

                        @if($penugasan->hasMorePages())
                            <a href="{{ $penugasan->nextPageUrl() }}" class="pn-nav-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        @else
                            <span class="pn-nav-btn disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Sidebar: Status Personel --}}
        <div class="pn-sidebar-card">
            <h3 class="pn-sidebar-title">Status Personel</h3>
            <div class="pn-personel-list">
                @foreach($personelStatus as $p)
                @php
                    $colors = ['av-blue', 'av-orange', 'av-purple', 'av-teal', 'av-pink', 'av-gray'];
                    $color = $colors[$p->id % count($colors)];
                    $st = strtolower($p->status_ketersediaan ?? 'standby');
                @endphp
                <div class="pn-personel-card">
                    <div class="pn-personel-info-group">
                        <div class="pn-p-avatar-wrap">
                            @if($p->photo)
                                <img src="{{ asset('storage/' . $p->photo) }}" class="avatar-img" alt="">
                            @else
                                <div class="avatar-initials {{ $color }}">{{ $p->initials }}</div>
                            @endif
                            <span class="pn-p-indicator-dot dot-{{ $st }}"></span>
                        </div>
                        <div class="pn-personel-text">
                            <div class="pn-personel-name">{{ $p->nama_lengkap }}</div>
                            <div class="pn-personel-role">{{ $p->jabatan }}</div>
                        </div>
                    </div>
                    <span class="pn-personel-status-tag tag-{{ $st }}">
                        {{ $p->status_label }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Buat Penugasan Baru --}}
<div class="pn-modal-backdrop" id="pnModal">
    <div class="pn-modal-dialog">
        {{-- Modal Header --}}
        <div class="pn-modal-header">
            <div>
                <h2 class="pn-modal-title">Buat Penugasan Baru</h2>
                <p class="pn-modal-sub">Isi formulir di bawah ini untuk menugaskan personel ke agenda pimpinan.</p>
            </div>
            <button type="button" class="pn-modal-close-btn" onclick="closePnModal()">&times;</button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('penugasan.store') }}" id="pnCreateForm">
            @csrf
            <div class="pn-modal-body">
                {{-- Section 1: Informasi Kegiatan --}}
                <div class="pn-form-section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span>Informasi Kegiatan</span>
                </div>

                <div class="pn-form-group">
                    <label class="pn-field-label">Pilih Kegiatan <span class="required">*</span></label>
                    <select name="kegiatan_id" class="pn-input-select" required>
                        <option value="">Pilih agenda pimpinan...</option>
                        @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}">{{ $k->judul }} ({{ $k->tanggal_mulai ? $k->tanggal_mulai->format('d M Y, H:i') : '' }} WIB)</option>
                        @endforeach
                    </select>
                    <div class="pn-field-hint">Kegiatan harus sudah terdaftar di modul 'Kegiatan Pimpinan'.</div>
                </div>

                {{-- Section 2: Detail Penugasan --}}
                <div class="pn-form-section-title" style="margin-top: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Detail Penugasan</span>
                </div>

                <div class="pn-form-row-2">
                    <div class="pn-form-group">
                        <label class="pn-field-label">Kategori Tugas <span class="required">*</span></label>
                        <select name="kategori_tugas" class="pn-input-select" id="kategoriSelect" onchange="updateRolesByKategori()">
                            <option value="">Pilih kategori...</option>
                            <option value="Protokol">Protokol</option>
                            <option value="Komunikasi Pimpinan">Komunikasi Pimpinan</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                        </select>
                    </div>

                    <div class="pn-form-group">
                        <label class="pn-field-label">Peran / Jobdesk <span class="required">*</span></label>
                        <select name="peran" class="pn-input-select" id="peranSelect" required>
                            <option value="">Pilih peran...</option>
                            <option value="Protokol">Protokol</option>
                            <option value="MC">MC</option>
                            <option value="Fotografer">Fotografer</option>
                            <option value="Videografer">Videografer</option>
                            <option value="Notulis">Notulis</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                        </select>
                    </div>
                </div>

                <div class="pn-form-group">
                    <label class="pn-field-label">Personel yang Ditugaskan <span class="required">*</span></label>
                    <select name="personel_ids[]" id="personelSelect" class="pn-input-select" required>
                        <option value="">Cari nama personel...</option>
                        @foreach($personelList as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama_lengkap }} ({{ $p->jabatan }})
                                @if($p->status_ketersediaan == 'standby') - [STANDBY] @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="pn-standby-counter">Standby: {{ $personelSiaga }}</div>
                </div>

                {{-- Section 3: Waktu & Instruksi --}}
                <div class="pn-form-section-title" style="margin-top: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Waktu &amp; Instruksi</span>
                </div>

                <div class="pn-form-group">
                    <label class="pn-field-label">Tenggat Waktu Berkumpul <span class="required">*</span></label>
                    <input type="datetime-local" name="tenggat_waktu" class="pn-input-text" required>
                </div>

                <div class="pn-form-group">
                    <label class="pn-field-label">Instruksi Tambahan</label>
                    <textarea name="catatan" class="pn-input-textarea" rows="3" placeholder="Masukkan catatan khusus, dresscode, atau peralatan spesifik yang perlu dibawa..."></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="pn-modal-footer">
                <button type="button" class="pn-btn-batal" onclick="closePnModal()">Batal</button>
                <button type="submit" class="pn-btn-simpan">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                        <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 004.835 9.25h8.415a.75.75 0 010 1.5H4.835a1.5 1.5 0 00-1.142 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                    </svg>
                    <span>Simpan &amp; Kirim Penugasan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Modal control
function openPnModal() {
    document.getElementById('pnModal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

function closePnModal() {
    document.getElementById('pnModal').classList.remove('is-open');
    document.body.style.overflow = '';
}

// Close modal when clicking backdrop
document.getElementById('pnModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePnModal();
    }
});

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePnModal();
        document.querySelectorAll('.pn-dropdown-panel').forEach(el => el.classList.remove('active'));
    }
});

// Dropdown Action Menu
function toggleMenu(event, menuId) {
    event.stopPropagation();
    const targetMenu = document.getElementById(menuId);
    const isOpen = targetMenu.classList.contains('active');
    
    // Close all other menus
    document.querySelectorAll('.pn-dropdown-panel').forEach(el => el.classList.remove('active'));
    
    if (!isOpen) {
        targetMenu.classList.add('active');
    }
}

document.addEventListener('click', function() {
    document.querySelectorAll('.pn-dropdown-panel').forEach(el => el.classList.remove('active'));
});

// Dynamic role by category
function updateRolesByKategori() {
    const kat = document.getElementById('kategoriSelect').value;
    const peran = document.getElementById('peranSelect');
    
    if (kat === 'Protokol') {
        peran.value = 'Protokol';
    } else if (kat === 'Komunikasi Pimpinan') {
        peran.value = 'MC';
    } else if (kat === 'Dokumentasi') {
        peran.value = 'Fotografer';
    }
}

// Open modal if errors exist
@if($errors->any())
    openPnModal();
@endif
</script>
@endpush
