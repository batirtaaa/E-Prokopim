@extends('layouts.app')
@section('title', 'Arsip Terhapus')

@push('styles')
<style>
/* Page Header */
.trash-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
    flex-wrap: wrap;
}
.trash-header-left h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.trash-header-left p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}
.trash-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* Stat Cards */
.trash-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.trash-stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    transition: transform 0.2s, box-shadow 0.2s;
}
.trash-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.trash-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.trash-stat-icon svg {
    width: 24px;
    height: 24px;
}
.trash-stat-info {
    flex: 1;
}
.trash-stat-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 2px;
}
.trash-stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.2;
}
.trash-stat-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 2px;
}

/* Main Container Card */
.trash-container-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    overflow: hidden;
}

/* Filter Select */
.trash-filter-select {
    appearance: none;
    -webkit-appearance: none;
    background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 32px 8px 12px;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    min-width: 0;
    flex-shrink: 0;
    max-width: 210px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.trash-filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    background-color: #ffffff;
}

/* Unified Toolbar */
.trash-toolbar {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    flex-wrap: nowrap;
    overflow: hidden;
}
.trash-search-box {
    position: relative;
    flex: 1;
    min-width: 0;
}
.trash-search-box input {
    width: 100%;
    padding: 8px 10px 8px 34px;
    font-size: 12.5px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    background: #f8fafc;
    box-sizing: border-box;
}
.trash-search-box input:focus {
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
}
.trash-search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
    width: 14px;
    height: 14px;
}

.trash-bulk-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-trash-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
    text-decoration: none;
}
.btn-trash-restore-bulk {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.btn-trash-restore-bulk:hover:not(:disabled) {
    background: #10b981;
    color: #ffffff;
}
.btn-trash-delete-bulk {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.btn-trash-delete-bulk:hover:not(:disabled) {
    background: #ef4444;
    color: #ffffff;
}
.btn-trash-empty {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #cbd5e1;
}
.btn-trash-empty:hover {
    background: #fee2e2;
    color: #b91c1c;
    border-color: #fca5a5;
}
.btn-trash-action:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Table styling */
.trash-table-responsive {
    overflow-x: hidden;
}
.trash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    text-align: left;
    table-layout: fixed;
}
.trash-table thead th {
    background: #f8fafc;
    padding: 10px 14px;
    font-weight: 600;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    overflow: hidden;
}
.trash-table tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    vertical-align: middle;
    overflow: hidden;
}
.trash-table tbody tr:hover {
    background: #f8fafc;
}
.trash-table tbody tr.selected {
    background: #eff6ff;
}

/* Item Badges */
.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.type-badge-kegiatan       { background: #eff6ff; color: #1d4ed8; }
.type-badge-sambutan       { background: #e0e7ff; color: #4338ca; }
.type-badge-media_sosial   { background: #fdf2f8; color: #be185d; }
.type-badge-analisis_isu   { background: #f5f3ff; color: #6d28d9; }
.type-badge-galeri_arsip   { background: #fffbeb; color: #b45309; }
.type-badge-penugasan      { background: #ecfeff; color: #0e7490; }
.type-badge-arahan         { background: #f0fdf4; color: #15803d; }
.type-badge-arsip          { background: #fefce8; color: #a16207; }
.type-badge-aset_barang    { background: #f0fdfa; color: #0f766e; }
.type-badge-aset_kendaraan { background: #fff7ed; color: #c2410c; }
.type-badge-pegawai        { background: #f0fdf4; color: #166534; }
.type-badge-keuangan       { background: #eff6ff; color: #1e40af; }
.type-badge-surat_keluar   { background: #f0f9ff; color: #0369a1; }
.type-badge-notulensi      { background: #fffbeb; color: #d97706; }
.type-badge-dokumentasi    { background: #faf5ff; color: #7e22ce; }
.type-badge-laporan        { background: #f1f5f9; color: #475569; }

.file-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 4px;
    padding: 2px 7px;
    font-size: 11px;
    font-weight: 600;
}

/* Row Action Buttons */
.row-actions {
    display: flex;
    align-items: center;
    gap: 5px;
    justify-content: flex-end;
    flex-wrap: nowrap;
}
.btn-row-restore {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 5px 10px;
    border-radius: 6px;
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.btn-row-restore:hover {
    background: #10b981;
    color: #ffffff;
    border-color: #10b981;
}
.btn-row-delete {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 5px 8px;
    border-radius: 6px;
    background: #fff1f2;
    color: #e11d48;
    border: 1px solid #fecdd3;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.btn-row-delete:hover {
    background: #e11d48;
    color: #ffffff;
    border-color: #e11d48;
}

/* Meta info inside item cell */
.item-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 4px;
    flex-wrap: wrap;
}
.item-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 11px;
    color: #64748b;
}
.item-meta-chip svg {
    color: #94a3b8;
}

/* Empty State */
.trash-empty-state {
    padding: 60px 20px;
    text-align: center;
}
.trash-empty-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    color: #94a3b8;
}
.trash-empty-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
}
.trash-empty-desc {
    font-size: 13px;
    color: #64748b;
    max-width: 440px;
    margin: 0 auto;
}

/* Two Layer Soft Delete Banner */
.two-layer-banner {
    background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.two-layer-banner-icon {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #059669;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    flex-shrink: 0;
}
.two-layer-banner-text h4 {
    margin: 0 0 2px;
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
}
.two-layer-banner-text p {
    margin: 0;
    font-size: 12px;
    color: #475569;
    line-height: 1.4;
}

/* Modal Popup */
.trash-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1050;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.trash-modal-backdrop.show {
    display: flex;
}
.trash-modal-card {
    background: #ffffff;
    border-radius: 14px;
    max-width: 460px;
    width: 100%;
    padding: 24px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    animation: trashModalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes trashModalPop {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.trash-modal-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.trash-modal-icon.danger {
    background: #fee2e2;
    color: #ef4444;
}
.trash-modal-icon.success {
    background: #dcfce7;
    color: #16a34a;
}
.trash-modal-title {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 8px;
}
.trash-modal-message {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin-bottom: 20px;
}
.trash-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.trash-modal-btn-cancel {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
.trash-modal-btn-confirm {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    color: #ffffff;
}
.trash-modal-btn-confirm.danger {
    background: #ef4444;
}
.trash-modal-btn-confirm.danger:hover {
    background: #dc2626;
}
.trash-modal-btn-confirm.success {
    background: #10b981;
}
.trash-modal-btn-confirm.success:hover {
    background: #059669;
}
</style>
@endpush

@section('content')
<div class="trash-page-wrapper">

    {{-- Page Header --}}
    <div class="trash-header">
        <div class="trash-header-left">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="28" height="28" style="color: #ef4444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Arsip Terhapus
            </h1>
            <p>Kelola data dan dokumen yang dihapus dari seluruh modul dengan mekanisme hapus dua lapis (Soft Delete).</p>
        </div>

        <div class="trash-header-actions">
            @if($totalTrashed > 0)
                <button type="button" class="btn-trash-action btn-trash-empty" onclick="openEmptyTrashModal('{{ $selectedType }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    {{ $selectedType === 'all' ? 'Kosongkan Semua Arsip Terhapus' : 'Kosongkan Kategori Ini' }}
                </button>
            @endif
        </div>
    </div>

    {{-- Two Layer Soft Delete Banner --}}
    <div class="two-layer-banner">
        <div class="two-layer-banner-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
        </div>
        <div class="two-layer-banner-text">
            <h4>Mekanisme Perlindungan Data Dua Lapis Aktif</h4>
            <p>Data dan file yang dihapus di seluruh modul tersimpan aman di Arsip Terhapus ini. Anda dapat mengembalikannya kapan saja dengan tombol <strong>Pulihkan</strong>, atau menghapusnya secara permanen bersama lampirannya dengan <strong>Hapus Permanen</strong>.</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="trash-stats-grid">
        <div class="trash-stat-card">
            <div class="trash-stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </div>
            <div class="trash-stat-info">
                <div class="trash-stat-label">Total Arsip Terhapus</div>
                <div class="trash-stat-value">{{ number_format($totalTrashed) }}</div>
                <div class="trash-stat-sub">Item yang dapat dipulihkan</div>
            </div>
        </div>

        <div class="trash-stat-card">
            <div class="trash-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
            <div class="trash-stat-info">
                <div class="trash-stat-label">Status File & Dokumen</div>
                <div class="trash-stat-value" style="font-size: 18px; color: #059669;">100% Aman</div>
                <div class="trash-stat-sub">File tersimpan utuh di sistem</div>
            </div>
        </div>

        <div class="trash-stat-card">
            <div class="trash-stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <div class="trash-stat-info">
                <div class="trash-stat-label">Cakupan Modul</div>
                <div class="trash-stat-value">{{ count($configs) }} Modul</div>
                <div class="trash-stat-sub">Seluruh modul input terproteksi</div>
            </div>
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="trash-container-card">

        {{-- Unified Toolbar: Filter + Search + Bulk Actions --}}
        <form id="filter-form" method="GET" action="{{ route('trash.index') }}">
        <div class="trash-toolbar">

            {{-- Dropdown Filter Modul --}}
            <select name="type" class="trash-filter-select" onchange="document.getElementById('filter-form').submit()" title="Filter berdasarkan modul">
                <option value="all" {{ $selectedType === 'all' ? 'selected' : '' }}>Semua Data ({{ $totalTrashed }})</option>
                @foreach($configs as $key => $cfg)
                    <option value="{{ $key }}" {{ $selectedType === $key ? 'selected' : '' }}>
                        {{ $cfg['name'] }} ({{ $counts[$key] ?? 0 }})
                    </option>
                @endforeach
            </select>

            {{-- Search --}}
            <div class="trash-search-box">
                <svg class="trash-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, nomor..." onchange="this.form.submit()">
            </div>

            {{-- Bulk Actions --}}
            <div class="trash-bulk-actions" style="flex-shrink:0; display:flex; gap:6px;">
                <button type="button" id="btn-bulk-restore" class="btn-trash-action btn-trash-restore-bulk" disabled onclick="submitBulkRestore()" title="Pulihkan item terpilih">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Pulihkan (<span id="selected-count-restore">0</span>)
                </button>

                <button type="button" id="btn-bulk-delete" class="btn-trash-action btn-trash-delete-bulk" disabled onclick="openBulkDeleteModal()" title="Hapus permanen item terpilih">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Hapus (<span id="selected-count-delete">0</span>)
                </button>
            </div>
        </div>
        </form>

        {{-- Hidden Forms for Bulk Actions --}}
        <form id="form-bulk-restore" action="{{ route('trash.bulk-restore') }}" method="POST" style="display:none;">
            @csrf
            <div id="bulk-restore-inputs"></div>
        </form>

        <form id="form-bulk-force-delete" action="{{ route('trash.bulk-force-delete') }}" method="POST" style="display:none;">
            @csrf
            <div id="bulk-force-delete-inputs"></div>
        </form>

        {{-- Table --}}
        @if($items->count() > 0)
            <div class="trash-table-responsive">
                <table class="trash-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="check-all" onchange="toggleSelectAll(this)" style="cursor: pointer; width: 15px; height: 15px;">
                            </th>
                            <th style="width: 130px;">Modul / Tipe</th>
                            <th>Judul / Detail</th>
                            <th style="width: 175px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr id="row-{{ $item['type'] }}-{{ $item['id'] }}">
                                <td style="text-align: center;">
                                    <input type="checkbox" class="item-checkbox" value="{{ $item['type'] }}:{{ $item['id'] }}" onchange="updateSelectedCount()" style="cursor: pointer; width: 15px; height: 15px;">
                                </td>
                                <td>
                                    <span class="type-badge type-badge-{{ $item['type'] }}">
                                        {{ $item['type_name'] }}
                                    </span>
                                </td>
                                <td style="max-width: 0;">
                                    <div style="font-weight: 600; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $item['title'] }}
                                    </div>
                                    <div class="item-meta">
                                        @if($item['sub'])
                                            <span class="item-meta-chip">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                                                {{ $item['sub'] }}
                                            </span>
                                        @endif
                                        @if($item['has_files'])
                                            <span class="item-meta-chip" title="{{ count($item['files']) }} file lampiran">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="11" height="11" style="color:#0284c7;"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.37l-9.547 9.547a1.5 1.5 0 11-2.122-2.122l8.486-8.486" /></svg>
                                                <span style="color:#0369a1;">{{ count($item['files']) }} file</span>
                                            </span>
                                        @endif
                                        <span class="item-meta-chip">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $item['time_ago'] }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        {{-- Restore Button --}}
                                        <button type="button" class="btn-row-restore" onclick="openRestoreModal('{{ $item['type'] }}', '{{ $item['id'] }}', '{{ addslashes($item['title']) }}')" title="Pulihkan data">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="13" height="13">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                            Pulihkan
                                        </button>

                                        {{-- Force Delete Button --}}
                                        <button type="button" class="btn-row-delete" onclick="openForceDeleteModal('{{ $item['type'] }}', '{{ $item['id'] }}', '{{ addslashes($item['title']) }}')" title="Hapus permanen">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="13" height="13">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="trash-empty-state">
                <div class="trash-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="36" height="36">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="trash-empty-title">Arsip Terhapus Kosong</div>
                <div class="trash-empty-desc">
                    @if($search !== '')
                        Tidak ditemukan data di Arsip Terhapus yang cocok dengan pencarian "<strong>{{ $search }}</strong>".
                    @else
                        Tidak ada data yang terhapus pada kategori ini. Seluruh data aktif dan tersimpan rapi di sistem.
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>

{{-- Single Restore Modal --}}
<div class="trash-modal-backdrop" id="modal-restore">
    <div class="trash-modal-card">
        <div class="trash-modal-icon success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </div>
        <div class="trash-modal-title">Pulihkan Data?</div>
        <div class="trash-modal-message" id="modal-restore-message">
            Apakah Anda yakin ingin mengembalikan data ini ke modul asalnya?
        </div>
        <form id="form-single-restore" method="POST" action="">
            @csrf
            <div class="trash-modal-actions">
                <button type="button" class="trash-modal-btn-cancel" onclick="closeModal('modal-restore')">Batal</button>
                <button type="submit" class="trash-modal-btn-confirm success">Pulihkan Sekarang</button>
            </div>
        </form>
    </div>
</div>

{{-- Single Force Delete Modal --}}
<div class="trash-modal-backdrop" id="modal-force-delete">
    <div class="trash-modal-card">
        <div class="trash-modal-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <div class="trash-modal-title">Hapus Permanen Data?</div>
        <div class="trash-modal-message" id="modal-force-delete-message">
            Tindakan ini tidak dapat dibatalkan! Data dan seluruh file lampiran yang terkait akan dihapus secara permanen dari server.
        </div>
        <form id="form-single-force-delete" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="trash-modal-actions">
                <button type="button" class="trash-modal-btn-cancel" onclick="closeModal('modal-force-delete')">Batal</button>
                <button type="submit" class="trash-modal-btn-confirm danger">Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>

{{-- Empty Trash Modal --}}
<div class="trash-modal-backdrop" id="modal-empty-trash">
    <div class="trash-modal-card">
        <div class="trash-modal-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </div>
        <div class="trash-modal-title">Kosongkan Arsip Terhapus?</div>
        <div class="trash-modal-message">
            Seluruh data yang ada di arsip terhapus ini beserta file lampirannya akan <strong>dihapus secara permanen</strong> dan tidak dapat dikembalikan lagi.
        </div>
        <form method="POST" action="{{ route('trash.empty') }}">
            @csrf
            <input type="hidden" name="type" id="empty-trash-type" value="{{ $selectedType }}">
            <div class="trash-modal-actions">
                <button type="button" class="trash-modal-btn-cancel" onclick="closeModal('modal-empty-trash')">Batal</button>
                <button type="submit" class="trash-modal-btn-confirm danger">Ya, Kosongkan Semua</button>
            </div>
        </form>
    </div>
</div>

{{-- Bulk Force Delete Confirmation Modal --}}
<div class="trash-modal-backdrop" id="modal-bulk-delete">
    <div class="trash-modal-card">
        <div class="trash-modal-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <div class="trash-modal-title">Hapus Permanen Data Terpilih?</div>
        <div class="trash-modal-message" id="modal-bulk-delete-message">
            Apakah Anda yakin ingin menghapus data yang dipilih secara permanen?
        </div>
        <div class="trash-modal-actions">
            <button type="button" class="trash-modal-btn-cancel" onclick="closeModal('modal-bulk-delete')">Batal</button>
            <button type="button" class="trash-modal-btn-confirm danger" onclick="submitBulkForceDelete()">Hapus Permanen</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openRestoreModal(type, id, title) {
        const form = document.getElementById('form-single-restore');
        form.action = `/trash/restore/${type}/${id}`;
        document.getElementById('modal-restore-message').innerHTML = `Apakah Anda yakin ingin memulihkan "<strong>${title}</strong>"? Data dan file akan kembali ke posisi semula.`;
        document.getElementById('modal-restore').classList.add('show');
    }

    function openForceDeleteModal(type, id, title) {
        const form = document.getElementById('form-single-force-delete');
        form.action = `/trash/force-delete/${type}/${id}`;
        document.getElementById('modal-force-delete-message').innerHTML = `Peringatan: "<strong>${title}</strong>" dan semua file lampirannya akan <strong>dihapus permanen</strong> dari sistem dan tidak dapat dipulihkan!`;
        document.getElementById('modal-force-delete').classList.add('show');
    }

    function openEmptyTrashModal(type) {
        document.getElementById('empty-trash-type').value = type;
        document.getElementById('modal-empty-trash').classList.add('show');
    }

    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
            const row = document.getElementById(`row-${cb.value.replace(':', '-')}`);
            if (row) {
                if (masterCheckbox.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }
        });
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        const count = checked.length;
        
        document.getElementById('selected-count-restore').innerText = count;
        document.getElementById('selected-count-delete').innerText = count;
        
        const btnRestore = document.getElementById('btn-bulk-restore');
        const btnDelete = document.getElementById('btn-bulk-delete');
        
        if (count > 0) {
            btnRestore.removeAttribute('disabled');
            btnDelete.removeAttribute('disabled');
        } else {
            btnRestore.setAttribute('disabled', 'true');
            btnDelete.setAttribute('disabled', 'true');
        }

        // Highlight selected rows
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            const row = document.getElementById(`row-${cb.value.replace(':', '-')}`);
            if (row) {
                if (cb.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }
        });
    }

    function submitBulkRestore() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (checked.length === 0) return;

        const container = document.getElementById('bulk-restore-inputs');
        container.innerHTML = '';

        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('form-bulk-restore').submit();
    }

    function openBulkDeleteModal() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (checked.length === 0) return;

        document.getElementById('modal-bulk-delete-message').innerHTML = `Peringatan: <strong>${checked.length} data terpilih</strong> dan semua file lampirannya akan dihapus secara permanen dari server. Tindakan ini tidak dapat dibatalkan.`;
        document.getElementById('modal-bulk-delete').classList.add('show');
    }

    function submitBulkForceDelete() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (checked.length === 0) return;

        const container = document.getElementById('bulk-force-delete-inputs');
        container.innerHTML = '';

        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('form-bulk-force-delete').submit();
    }

    // Close modal on escape key or backdrop click
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.trash-modal-backdrop.show').forEach(m => m.classList.remove('show'));
        }
    });
    document.querySelectorAll('.trash-modal-backdrop').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
    });
</script>
@endpush
@endsection
