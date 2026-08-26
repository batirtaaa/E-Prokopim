@extends('layouts.app')
@section('title', 'Arsip Surat — E-PROKOPIM')

@push('styles')
<style>
/* Page Layout */
.arsip-page {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.ar-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
}
.ar-header-left h1 {
    font-size: 26px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 4px 0;
}
.ar-header-left p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}
.ar-btn-unggah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s;
    white-space: nowrap;
}
.ar-btn-unggah:hover {
    background: #091c2f;
}
.ar-btn-unggah svg {
    width: 15px;
    height: 15px;
}

/* Filter Card */
.ar-filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 24px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}
.ar-filter-form {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    flex-wrap: wrap;
}
.ar-filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.ar-filter-label {
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
}
.ar-select-control {
    padding: 8px 34px 8px 14px;
    font-size: 13px;
    color: #1e293b;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 12px;
    appearance: none;
    outline: none;
    cursor: pointer;
    min-width: 160px;
    transition: border-color 0.15s;
}
.ar-select-control:focus {
    border-color: #3b82f6;
}

.ar-date-range-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}
.ar-date-control {
    padding: 8px 12px;
    font-size: 13px;
    color: #1e293b;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    outline: none;
    cursor: pointer;
    transition: border-color 0.15s;
}
.ar-date-control:focus {
    border-color: #3b82f6;
}
.ar-date-separator {
    color: #94a3b8;
    font-size: 14px;
}

.ar-btn-filter {
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
    background: #4fa8f6;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background 0.15s;
    height: 38px;
}
.ar-btn-filter:hover {
    background: #2563eb;
}
.ar-btn-filter svg {
    width: 15px;
    height: 15px;
}

/* Table Card */
.ar-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}
.ar-table-responsive {
    overflow-x: auto;
}
.ar-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.ar-table thead th {
    padding: 14px 18px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    background: #edf2f7;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.ar-table thead th.th-no {
    width: 50px;
    text-align: center;
}
.ar-table tbody td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.ar-table tbody tr:last-child td {
    border-bottom: none;
}

/* Clickable row with modern hover effect */
.ar-clickable-row {
    cursor: pointer;
    transition: background-color 0.15s ease;
}
.ar-clickable-row:hover {
    background-color: #f1f7ff !important;
}
.ar-clickable-row:active {
    background-color: #e2eeff !important;
}

.ar-cell-no {
    text-align: center;
    color: #475569;
    font-weight: 500;
}
.ar-doc-title {
    font-weight: 600;
    color: #0f172a;
    line-height: 1.45;
    max-width: 340px;
    word-break: break-word;
}
.ar-doc-nomor {
    color: #334155;
    font-size: 13px;
    white-space: nowrap;
}

/* Category Badges */
.ar-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    font-size: 11.5px;
    font-weight: 600;
    border-radius: 6px;
    white-space: nowrap;
    letter-spacing: 0.01em;
}
.ar-cat-badge.surat_masuk {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}
.ar-cat-badge.surat_keluar {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}
.ar-cat-badge.sk {
    background: #f5f3ff;
    color: #6d28d9;
    border: 1px solid #ddd6fe;
}
.ar-cat-badge.nota_dinas {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}
.ar-cat-badge.laporan {
    background: #f0fdfa;
    color: #0f766e;
    border: 1px solid #99f6e4;
}
.ar-cat-badge.peraturan {
    background: #fff1f2;
    color: #be123c;
    border: 1px solid #fecdd3;
}
.ar-cat-badge.lainnya {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}

/* File Type Badges */
.ar-filetype {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    font-size: 11.5px;
    white-space: nowrap;
}
.ar-filetype.pdf {
    color: #dc2626;
}
.ar-filetype.docx, .ar-filetype.doc {
    color: #2563eb;
}
.ar-filetype.xlsx, .ar-filetype.xls {
    color: #16a34a;
}
.ar-filetype.default {
    color: #475569;
}
.ar-filetype svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.ar-date-text {
    color: #334155;
    font-size: 12.5px;
    white-space: nowrap;
}
.ar-uploader-text {
    color: #334155;
    font-size: 13px;
    white-space: nowrap;
}

/* Pagination Footer */
.ar-pagination-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
    flex-wrap: wrap;
    gap: 12px;
}
.ar-page-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}
.ar-page-btn {
    min-width: 30px;
    height: 30px;
    padding: 0 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    color: #64748b;
    font-size: 12.5px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
}
.ar-page-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.ar-page-btn.active {
    background: #0f62fe;
    border-color: #0f62fe;
    color: #ffffff;
    font-weight: 600;
}
.ar-page-btn.disabled {
    opacity: 0.35;
    cursor: not-allowed;
    pointer-events: none;
}

/* Upload Modal */
.ar-modal-backdrop {
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
.ar-modal-backdrop.is-open {
    display: flex;
}
.ar-modal-card {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.ar-modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.ar-modal-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px 0;
}
.ar-modal-sub {
    font-size: 12.5px;
    color: #64748b;
    margin: 0;
}
.ar-modal-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #94a3b8;
    cursor: pointer;
    padding: 2px 6px;
    border-radius: 4px;
    line-height: 1;
}
.ar-modal-close:hover {
    color: #0f172a;
}
.ar-modal-body {
    padding: 20px 24px;
}
.ar-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.ar-form-g {
    margin-bottom: 14px;
}
.ar-form-lbl {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.ar-form-lbl .req {
    color: #ef4444;
}
.ar-form-input, .ar-form-select, .ar-form-textarea {
    width: 100%;
    padding: 8px 12px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    box-sizing: border-box;
    font-family: inherit;
    transition: border-color 0.15s;
}
.ar-form-input:focus, .ar-form-select:focus, .ar-form-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ar-form-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 12px;
    appearance: none;
    cursor: pointer;
}
.ar-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
}
.ar-btn-cancel {
    padding: 8px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}
.ar-btn-cancel:hover {
    color: #1e293b;
    border-color: #94a3b8;
}
.ar-btn-submit {
    padding: 8px 18px;
    border: none;
    border-radius: 8px;
    background: #0f2942;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}
.ar-btn-submit:hover {
    background: #091c2f;
}

/* ========================================= */
/* SOFTFILE DOCUMENT VIEWER / LIGHTBOX MODAL */
/* ========================================= */
.ar-doc-viewer-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.78);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.ar-doc-viewer-overlay.active {
    display: flex;
}
.ar-doc-viewer-container {
    width: min(94vw, 1000px);
    height: 88vh;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: arModalScale 0.18s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes arModalScale {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}
.ar-viewer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    gap: 16px;
}
.ar-viewer-header-left {
    min-width: 0;
    flex: 1;
}
.ar-viewer-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0 0 3px 0;
}
.ar-viewer-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #64748b;
    flex-wrap: wrap;
}
.ar-viewer-meta span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.ar-viewer-header-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.ar-btn-viewer-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
    border: 1px solid transparent;
}
.ar-btn-viewer-action.primary {
    background: #0f2942;
    color: #ffffff;
}
.ar-btn-viewer-action.primary:hover {
    background: #1e3a5f;
}
.ar-btn-viewer-action.secondary {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #334155;
}
.ar-btn-viewer-action.secondary:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.ar-viewer-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    line-height: 1;
    transition: all 0.15s;
    margin-left: 4px;
}
.ar-viewer-close-btn:hover {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fecaca;
}

/* Viewer Frame Area */
.ar-viewer-content {
    flex: 1;
    width: 100%;
    height: calc(100% - 60px);
    background: #525659;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ar-viewer-iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
    background: #ffffff;
}
.ar-viewer-image {
    max-width: 95%;
    max-height: 95%;
    object-fit: contain;
    border-radius: 6px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
}
.ar-viewer-fallback {
    text-align: center;
    padding: 30px;
    color: #ffffff;
}
.ar-viewer-fallback svg {
    width: 54px;
    height: 54px;
    margin-bottom: 12px;
    opacity: 0.8;
}
.ar-viewer-fallback p {
    font-size: 14px;
    margin: 0 0 16px 0;
    color: #cbd5e1;
}
</style>
@endpush

@section('content')
<div class="arsip-page">

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
    <div class="ar-header-row">
        <div class="ar-header-left">
            <h1>Arsip Surat</h1>
            <p>Manajemen dokumentasi surat masuk dan keluar E-PROKOPIM</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('arsip.create') }}" class="ar-btn-unggah">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <span>Unggah Dokumen Baru</span>
        </a>
        @endif
    </div>

    {{-- Filter Card --}}
    <div class="ar-filter-card">
        <form method="GET" action="{{ route('arsip.index') }}" class="ar-filter-form">
            {{-- Jenis Surat --}}
            <div class="ar-filter-group">
                <label class="ar-filter-label">Jenis Surat</label>
                <select name="jenis_surat" class="ar-select-control">
                    <option value="">Semua Jenis</option>
                    <option value="surat_masuk" {{ request('jenis_surat') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="surat_keluar" {{ request('jenis_surat') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    <option value="sk" {{ request('jenis_surat') == 'sk' ? 'selected' : '' }}>SK (Surat Keputusan)</option>
                    <option value="nota_dinas" {{ request('jenis_surat') == 'nota_dinas' ? 'selected' : '' }}>Nota Dinas</option>
                    <option value="laporan" {{ request('jenis_surat') == 'laporan' ? 'selected' : '' }}>Laporan</option>
                    <option value="peraturan" {{ request('jenis_surat') == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                    <option value="lainnya" {{ request('jenis_surat') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    @if(isset($customCategories) && $customCategories->count() > 0)
                        <optgroup label="Kategori Khusus">
                            @foreach($customCategories as $cc)
                                <option value="{{ $cc }}" {{ request('jenis_surat') == $cc ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $cc)) }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>

            {{-- Rentang Tanggal --}}
            <div class="ar-filter-group">
                <label class="ar-filter-label">Rentang Tanggal</label>
                <div class="ar-date-range-wrap">
                    <input type="date" name="start_date" class="ar-date-control" value="{{ request('start_date') }}">
                    <span class="ar-date-separator">-</span>
                    <input type="date" name="end_date" class="ar-date-control" value="{{ request('end_date') }}">
                </div>
            </div>

            {{-- Submit Filter Button --}}
            <button type="submit" class="ar-btn-filter">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <span>Terapkan Filter</span>
            </button>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="ar-table-card">
        <div class="ar-table-responsive">
            <table class="ar-table">
                <thead>
                    <tr>
                        <th class="th-no">No</th>
                        <th>Nama Dokumen / Perihal</th>
                        <th>Kategori</th>
                        <th>Nomor Surat</th>
                        <th>Tipe File</th>
                        <th>Tanggal Unggah</th>
                        <th>Diunggah Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $index => $item)
                    @php
                        // Determine file extension and type
                        $ext = strtolower(pathinfo($item->file_name ?? $item->file_path, PATHINFO_EXTENSION));
                        $isPdf = in_array($ext, ['pdf']);
                        $isDoc = in_array($ext, ['doc', 'docx']);
                        $isXls = in_array($ext, ['xls', 'xlsx', 'csv']);
                        $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                        $typeLabel = strtoupper($ext ?: 'PDF');

                        $fileUrl = asset('storage/' . $item->file_path);
                        $formattedDate = $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : ($item->tanggal_dokumen ? $item->tanggal_dokumen->translatedFormat('d M Y') : '—');
                        $uploaderName = $item->uploadedBy?->name ?? 'Admin Prokopim';

                        $catKey = strtolower($item->kategori ?? 'lainnya');
                        $catLabels = [
                            'surat_masuk' => 'Surat Masuk',
                            'surat_keluar' => 'Surat Keluar',
                            'sk' => 'SK',
                            'nota_dinas' => 'Nota Dinas',
                            'laporan' => 'Laporan',
                            'peraturan' => 'Peraturan',
                            'lainnya' => 'Lainnya',
                        ];
                        $catLabel = $catLabels[$catKey] ?? ucwords(str_replace('_', ' ', $catKey));
                    @endphp
                    <tr class="ar-clickable-row" onclick="previewArsip('{{ $fileUrl }}', '{{ addslashes($item->judul) }}', '{{ addslashes($item->nomor_arsip ?? '—') }}', '{{ strtoupper($ext) }}', '{{ addslashes($item->file_name ?? $item->judul) }}', '{{ $formattedDate }}', '{{ addslashes($uploaderName) }}', '{{ addslashes($catLabel) }}')">
                        {{-- No --}}
                        <td class="ar-cell-no">
                            {{ $arsip->firstItem() ? $arsip->firstItem() + $index : $index + 1 }}
                        </td>

                        {{-- Nama Dokumen / Perihal --}}
                        <td>
                            <div class="ar-doc-title" title="{{ $item->judul }}">
                                {{ $item->judul }}
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td>
                            <span class="ar-cat-badge {{ $catKey }}">
                                {{ $catLabel }}
                            </span>
                        </td>

                        {{-- Nomor Surat --}}
                        <td>
                            <span class="ar-doc-nomor">{{ $item->nomor_arsip ?? '—' }}</span>
                        </td>

                        {{-- Tipe File --}}
                        <td>
                            @if($isPdf)
                                <div class="ar-filetype pdf">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9.5v-2H11c.83 0 1.5-.67 1.5-1.5S11.83 11 11 11H9.5v5H8V8h3c1.66 0 3 1.34 3 3s-1.34 3-3 3zm5-2.5c0 .83-.67 1.5-1.5 1.5h-2V8h2c.83 0 1.5.67 1.5 1.5v4zm-1.5-.5V9.5h-1v4h1z"/></svg>
                                    <span>PDF</span>
                                </div>
                            @elseif($isDoc)
                                <div class="ar-filetype docx">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                    <span>DOCX</span>
                                </div>
                            @elseif($isXls)
                                <div class="ar-filetype xlsx">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm-1 9h-2v2h2v-2zm-4 0H7v2h2v-2zm8 6H7v-2h10v2zm0-4h-2v-2h2v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                    <span>XLSX</span>
                                </div>
                            @else
                                <div class="ar-filetype default">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13z"/></svg>
                                    <span>{{ $typeLabel }}</span>
                                </div>
                            @endif
                        </td>

                        {{-- Tanggal Unggah --}}
                        <td>
                            <span class="ar-date-text">
                                {{ $formattedDate }}
                            </span>
                        </td>

                        {{-- Diunggah Oleh --}}
                        <td>
                            <span class="ar-uploader-text">
                                {{ $uploaderName }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px; height:40px; margin:0 auto 8px; display:block; opacity:0.4;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada arsip surat</p>
                            <a href="{{ route('arsip.create') }}" style="color:#2563eb; background:none; border:none; text-decoration:none; cursor:pointer; font-size:12.5px; font-weight:600;">+ Unggah Dokumen Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        <div class="ar-pagination-footer">
            <span>Menampilkan {{ $arsip->firstItem() ?? 0 }}-{{ $arsip->lastItem() ?? 0 }} dari {{ $arsip->total() }} data</span>
            <div class="ar-page-nav">
                @if($arsip->onFirstPage())
                    <span class="ar-page-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </span>
                @else
                    <a href="{{ $arsip->previousPageUrl() }}" class="ar-page-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </a>
                @endif

                @php
                    $cur = $arsip->currentPage();
                    $last = $arsip->lastPage();
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
                        <span class="ar-page-btn disabled" style="border:none;">…</span>
                    @elseif($p == $cur)
                        <span class="ar-page-btn active">{{ $p }}</span>
                    @else
                        <a href="{{ $arsip->url($p) }}" class="ar-page-btn">{{ $p }}</a>
                    @endif
                @endforeach

                @if($arsip->hasMorePages())
                    <a href="{{ $arsip->nextPageUrl() }}" class="ar-page-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span class="ar-page-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MODAL PREVIEW SOFTFILE DOKUMEN ARSIP (VIEWER) --}}
{{-- ============================================= --}}
<div class="ar-doc-viewer-overlay" id="arDocViewer">
    <div class="ar-doc-viewer-container" onclick="event.stopPropagation()">
        {{-- Header Viewer --}}
        <div class="ar-viewer-header">
            <div class="ar-viewer-header-left">
                <h3 class="ar-viewer-title" id="arViewTitle">Nama Dokumen</h3>
                <div class="ar-viewer-meta">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        No: <strong id="arViewNomor" style="color:#0f172a">—</strong>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386l4.412-2.595a2.25 2.25 0 00.902-1.282l1.58-6.32a2.25 2.25 0 00-.546-2.091L13.25 3.66A2.25 2.25 0 0011.659 3H9.568z" /></svg>
                        Kategori: <strong id="arViewKategori" style="color:#0f172a">—</strong>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span id="arViewDate">—</span>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        <span id="arViewUploader">—</span>
                    </span>
                </div>
            </div>

            <div class="ar-viewer-header-right">
                <a href="#" id="arBtnDownload" download class="ar-btn-viewer-action primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Unduh</span>
                </a>
                <a href="#" id="arBtnNewTab" target="_blank" class="ar-btn-viewer-action secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span>Buka Penuh</span>
                </a>
                <button type="button" class="ar-viewer-close-btn" onclick="closeArsipViewer()">&times;</button>
            </div>
        </div>

        {{-- Frame Container --}}
        <div class="ar-viewer-content" id="arViewerBody">
            <iframe id="arViewerIframe" class="ar-viewer-iframe" src=""></iframe>
            <img id="arViewerImg" class="ar-viewer-image" src="" style="display:none;" alt="">
            <div id="arViewerFallback" class="ar-viewer-fallback" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p id="arFallbackMsg">Pratinjau langsung tidak tersedia untuk format file ini.</p>
                <a href="#" id="arFallbackDownload" class="ar-btn-viewer-action primary" download>Unduh File Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ==========================
// PREVIEW SOFTFILE VIEWER
// ==========================
function previewArsip(fileUrl, judul, nomor, fileExt, fileName, tanggal, uploader, kategori) {
    if (!fileUrl) return;

    const overlay = document.getElementById('arDocViewer');
    const iframe = document.getElementById('arViewerIframe');
    const img = document.getElementById('arViewerImg');
    const fallback = document.getElementById('arViewerFallback');

    document.getElementById('arViewTitle').textContent = judul || fileName || 'Dokumen Arsip';
    document.getElementById('arViewNomor').textContent = nomor || '—';
    document.getElementById('arViewKategori').textContent = kategori || '—';
    document.getElementById('arViewDate').textContent = tanggal || '—';
    document.getElementById('arViewUploader').textContent = uploader || 'Admin Prokopim';

    document.getElementById('arBtnDownload').href = fileUrl;
    document.getElementById('arBtnNewTab').href = fileUrl;
    document.getElementById('arFallbackDownload').href = fileUrl;

    const ext = (fileExt || '').toLowerCase();

    // Reset viewer elements
    iframe.style.display = 'none';
    iframe.src = '';
    img.style.display = 'none';
    img.src = '';
    fallback.style.display = 'none';

    if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext)) {
        img.src = fileUrl;
        img.style.display = 'block';
    } else if (ext === 'pdf') {
        iframe.src = fileUrl;
        iframe.style.display = 'block';
    } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
        const googleDocsUrl = 'https://docs.google.com/gview?url=' + encodeURIComponent(fileUrl) + '&embedded=true';
        iframe.src = googleDocsUrl;
        iframe.style.display = 'block';
    } else {
        fallback.style.display = 'block';
        document.getElementById('arFallbackMsg').textContent = 'File berformat ' + (ext.toUpperCase() || 'DOKUMEN') + '. Silakan unduh untuk membuka.';
    }

    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeArsipViewer() {
    const overlay = document.getElementById('arDocViewer');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('arViewerIframe').src = '';
    document.getElementById('arViewerImg').src = '';
}

// Close viewer on backdrop click
document.getElementById('arDocViewer').addEventListener('click', function(e) {
    if (e.target === this) {
        closeArsipViewer();
    }
});

// Escape key listener for viewer modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeArsipViewer();
    }
});
</script>
@endpush
