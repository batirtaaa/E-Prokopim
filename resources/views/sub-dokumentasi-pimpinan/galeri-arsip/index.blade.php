@extends('layouts.app')
@section('title', 'Galeri Arsip Dokumentasi Pimpinan')

@push('styles')
<style>

.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }

.btn-unggah {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 20px; font-size:13.5px; font-weight:600;
    border-radius:8px; background:#1e3a5f; color:white;
    border:none; cursor:pointer; text-decoration:none;
    transition:background 0.15s; white-space:nowrap;
}
.btn-unggah:hover { background:#162f4f; }
.btn-unggah svg { width:16px; height:16px; }

.ga-toolbar-wrap {
    display:flex; align-items:center; justify-content:space-between;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 24px;
    padding-bottom: 0;
}
.ga-tabs { display:flex; gap:0; }
.ga-tab {
    padding: 12px 18px;
    font-size: 13.5px; font-weight: 500;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 2.5px solid transparent;
    transition: all 0.15s;
    margin-bottom: -1px;
    white-space: nowrap;
}
.ga-tab:hover { color: #111827; }
.ga-tab.active { color: #111827; font-weight: 600; border-bottom-color: #1e3a5f; }

.ga-toolbar-right { display:flex; align-items:center; gap:8px; padding-bottom:12px; }
.ga-btn-action {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 12px; border:1px solid #e5e7eb; border-radius:7px;
    background:white; font-size:12.5px; color:#374151;
    cursor:pointer; text-decoration:none; transition:all 0.15s;
}
.ga-btn-action:hover { border-color:#2563eb; color:#2563eb; }
.ga-btn-action svg { width:13px; height:13px; }

/* Grid */
.ga-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}
@media (max-width:1200px) { .ga-grid { grid-template-columns: repeat(3,1fr); } }
@media (max-width:900px)  { .ga-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width:580px)  { .ga-grid { grid-template-columns: 1fr; } }

/* Card */
.ga-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.15s, box-shadow 0.15s;
}
.ga-card:hover { transform:translateY(-2px); box-shadow:0 8px 20px -4px rgba(0,0,0,0.08); }

/* Thumbnail area */
.ga-thumb {
    position: relative;
    height: 170px;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ga-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.ga-thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #94a3b8;
}
.ga-thumb-placeholder svg { width:40px; height:40px; opacity:0.6; }
.ga-thumb-placeholder span { font-size:12px; font-weight:600; color:#94a3b8; }
.ga-video-placeholder {
    background: linear-gradient(135deg, #1e293b, #0f172a) !important;
}
.ga-video-placeholder svg { color: rgba(255,255,255,0.4) !important; }
/* Thumbnail foto via CSS background (menghindari <img src> yang dicegat IDM) */
.ga-thumb-bg {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-color: #e2e8f0;
}

/* Type badge top-left */
.ga-type-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 700;
    color: white;
    backdrop-filter: blur(4px);
}
.ga-type-badge.foto      { background: rgba(30,58,95,0.88); }
.ga-type-badge.video     { background: rgba(220,38,38,0.9); }
.ga-type-badge.notulensi { background: rgba(5,120,56,0.88); }
.ga-type-badge.album     { background: rgba(30,58,95,0.88); }
.ga-type-badge svg { width:11px; height:11px; }

/* Video duration badge bottom-right */
.ga-duration-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.72);
    color: white;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 7px;
    border-radius: 4px;
    letter-spacing: 0.03em;
}

/* Play icon overlay for video */
.ga-play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ga-play-btn {
    width: 42px; height: 42px;
    background: rgba(0,0,0,0.5);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: white;
    backdrop-filter: blur(2px);
}
.ga-play-btn svg { width:18px; height:18px; margin-left:2px; }

/* Card body */
.ga-card-body { padding: 14px 16px 14px; }

.ga-meta-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}
.ga-kode {
    font-size: 11.5px;
    font-weight: 700;
    color: #2563eb;
    background: #eff6ff;
    padding: 2px 7px;
    border-radius: 4px;
    text-decoration: none;
    white-space: nowrap;
}
.ga-kode:hover { background: #dbeafe; }
.ga-date {
    font-size: 11.5px;
    color: #9ca3af;
}

.ga-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    line-height: 1.4;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Keywords row & tags */
.ga-keywords-row {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 8px;
}
.ga-kw-badge {
    font-size: 11px;
    font-weight: 500;
    color: #0369a1;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    padding: 1px 6px;
    border-radius: 4px;
    text-decoration: none;
    transition: all 0.15s;
    line-height: 1.4;
}
.ga-kw-badge:hover {
    background: #e0f2fe;
    border-color: #7dd3fc;
    color: #0284c7;
}
.ga-kw-badge.more {
    color: #64748b;
    background: #f1f5f9;
    border-color: #e2e8f0;
    cursor: default;
}

/* File attachments row on card */
.ga-files-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
}
.ga-file-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.15s;
}
.ga-file-badge.notulensi {
    color: #047857;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
}
.ga-file-badge.notulensi:hover {
    background: #d1fae5;
}
.ga-file-badge.paparan {
    color: #1d4ed8;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
}
.ga-file-badge.paparan:hover {
    background: #dbeafe;
}
.ga-file-badge svg {
    width: 12px;
    height: 12px;
}

/* Search bar inside toolbar */
.ga-search-form { display:inline-flex; align-items:center; }
.ga-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.ga-search-icon {
    position: absolute;
    left: 10px;
    width: 14px;
    height: 14px;
    color: #9ca3af;
    pointer-events: none;
}
.ga-search-inp {
    padding: 6px 28px 6px 30px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    font-size: 12.5px;
    color: #1f2937;
    background: white;
    width: 230px;
    transition: all 0.15s ease;
    outline: none;
}
.ga-search-inp:focus {
    border-color: #1e3a5f;
    box-shadow: 0 0 0 2px rgba(30,58,95,0.1);
    width: 290px;
}
.ga-search-clear {
    position: absolute;
    right: 8px;
    color: #9ca3af;
    font-size: 16px;
    line-height: 1;
    text-decoration: none;
    font-weight: 700;
}
.ga-search-clear:hover { color: #dc2626; }

.ga-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ga-akses {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #6b7280;
}
.ga-akses svg { width: 13px; height: 13px; color: #9ca3af; }

.ga-more-btn {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 3px 6px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    position: relative;
}
.ga-more-btn:hover { background: #f3f4f6; color: #374151; }
.ga-more-btn svg { width:16px; height:16px; }

/* Dropdown */
.ga-dropdown {
    position: absolute;
    right: 0; bottom: calc(100% + 4px);
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 20px -3px rgba(0,0,0,0.12);
    z-index: 50;
    min-width: 135px;
    padding: 4px;
    display: none;
}
.ga-dropdown.show { display: block; }
.ga-dd-item {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 10px;
    font-size: 12.5px; color: #374151;
    text-decoration: none;
    border-radius: 5px;
    border: none; background: none;
    width: 100%; text-align: left; cursor: pointer;
}
.ga-dd-item svg { width:13px; height:13px; flex-shrink:0; }
.ga-dd-item:hover { background: #f3f4f6; }
.ga-dd-item.danger { color: #dc2626; }
.ga-dd-item.danger:hover { background: #fee2e2; }

/* "Muat Lebih Banyak" button */
.ga-load-more-wrap { display:flex; justify-content:center; margin-top:8px; margin-bottom:20px; }
.ga-load-more-btn {
    display: inline-flex; align-items:center; gap:7px;
    padding: 9px 26px;
    border: 1.5px solid #d1d5db;
    border-radius: 20px;
    background: white;
    font-size: 13.5px; font-weight:500; color:#374151;
    cursor: pointer; text-decoration: none;
    transition: all 0.15s;
}
.ga-load-more-btn:hover { border-color:#1e3a5f; color:#1e3a5f; background:#f8faff; }

/* Upload Modal */
.modal-overlay {
    position: fixed; top:0; left:0;
    width:100vw; height:100vh;
    background: rgba(15,23,42,0.6);
    z-index: 9999;
    display: none; align-items:center; justify-content:center;
    backdrop-filter: blur(2px);
    padding: 20px;
}
.modal-content {
    background: white; border-radius:14px;
    width:100%; max-width:520px; max-height:90vh; overflow-y:auto;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
}
.modal-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 24px; border-bottom:1px solid #e5e7eb;
}
.modal-header h3 { font-size:16px; font-weight:700; color:#111827; }
.modal-close { background:none; border:none; font-size:20px; color:#9ca3af; cursor:pointer; }
.modal-close:hover { color:#111827; }
.modal-body { padding:22px 24px; }
.form-g { margin-bottom:16px; }
.form-lbl { display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; }
.form-lbl .req { color:#ef4444; }
.form-inp, .form-sel, .form-txa {
    width:100%; padding:8px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:13px; color:#111827; background:white;
    outline:none; font-family:inherit;
}
.form-inp:focus, .form-sel:focus, .form-txa:focus { border-color:#2563eb; }
.form-txa { resize:vertical; min-height:65px; }
.modal-footer {
    display:flex; justify-content:flex-end; gap:10px;
    padding:16px 24px; border-top:1px solid #e5e7eb; background:#f9fafb;
    border-bottom-left-radius:14px; border-bottom-right-radius:14px;
}
/* Thumbnail clickable */
.ga-thumb { cursor: pointer; }
.ga-thumb:hover::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.15);
    pointer-events: none;
}

/* ===== VIEWER MODAL ===== */
.viewer-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.92);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 16px;
    backdrop-filter: blur(6px);
}
.viewer-overlay.active { display: flex; }

.viewer-close {
    position: fixed; top: 16px; right: 20px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: white; font-size: 24px;
    width: 40px; height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
    z-index: 100000;
    line-height: 1;
}
.viewer-close:hover { background: rgba(255,255,255,0.25); }

.viewer-title {
    color: rgba(255,255,255,0.85);
    font-size: 13.5px;
    font-weight: 500;
    text-align: center;
    margin-bottom: 14px;
    max-width: 700px;
    padding: 0 50px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Foto lightbox */
#viewerImg {
    max-width: min(90vw, 1100px);
    max-height: 82vh;
    border-radius: 8px;
    object-fit: contain;
    box-shadow: 0 30px 60px -10px rgba(0,0,0,0.5);
    display: block;
}

/* Notulensi / PDF viewer */
.viewer-doc-wrap {
    width: min(90vw, 900px);
    height: 84vh;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 30px 60px -10px rgba(0,0,0,0.5);
    background: white;
    display: flex; flex-direction: column;
}
.viewer-doc-wrap iframe {
    flex: 1;
    width: 100%;
    border: none;
}
.viewer-doc-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 16px;
    background: #f3f4f6;
    border-bottom: 1px solid #e5e7eb;
    font-size: 13px; color: #374151;
}
.viewer-doc-toolbar a {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px;
    background: #1e3a5f; color: white;
    border-radius: 6px; font-size: 12.5px;
    text-decoration: none;
}

/* Upload progress */
#gaUploadProgress {
    display: none;
    margin-top: 10px;
    background: #e5e7eb;
    border-radius: 99px;
    height: 6px;
    overflow: hidden;
}
#gaUploadBar {
    height: 100%;
    background: linear-gradient(90deg, #1e3a5f, #2563eb);
    width: 0%;
    transition: width 0.3s;
    border-radius: 99px;
}
#gaUploadStatus { font-size: 12px; color: #6b7280; margin-top: 6px; text-align: center; }

/* ===== SELECT MODE / BULK DELETE ===== */
.ga-btn-select {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 7px;
    background: white; font-size: 12.5px; color: #374151;
    cursor: pointer; transition: all 0.15s;
}
.ga-btn-select:hover { border-color: #dc2626; color: #dc2626; }
.ga-btn-select.active { border-color: #dc2626; background: #fef2f2; color: #dc2626; font-weight: 600; }
.ga-btn-select svg { width: 13px; height: 13px; }

/* Checkbox overlay on thumb */
.ga-card-checkbox {
    display: none;
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}
.ga-card-checkbox input[type="checkbox"] {
    width: 20px; height: 20px;
    accent-color: #dc2626;
    cursor: pointer;
    border-radius: 4px;
    border: 2px solid white;
    box-shadow: 0 1px 4px rgba(0,0,0,0.3);
}
.select-mode .ga-card-checkbox { display: block; }
.select-mode .ga-card { cursor: pointer; user-select: none; }
.select-mode .ga-card.selected {
    border: 2px solid #dc2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.15);
}
.select-mode .ga-card.selected .ga-thumb::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(220,38,38,0.18);
    pointer-events: none;
}

/* Bulk action bar */
#gaBulkBar {
    display: none;
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9998;
    background: #1e293b;
    color: white;
    border-radius: 12px;
    padding: 12px 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.28);
    align-items: center;
    gap: 14px;
    font-size: 13.5px;
    min-width: 340px;
    animation: barSlideUp 0.2s ease-out;
}
@keyframes barSlideUp {
    from { opacity: 0; transform: translateX(-50%) translateY(12px); }
    to   { opacity: 1; transform: translateX(-50%) translateY(0); }
}
#gaBulkBar.show { display: flex; }
.ga-bulk-count {
    font-weight: 700;
    background: #dc2626;
    border-radius: 6px;
    padding: 2px 9px;
    font-size: 13px;
}
.ga-bulk-select-all {
    background: none; border: 1px solid rgba(255,255,255,0.3);
    color: white; border-radius: 7px;
    padding: 5px 12px; font-size: 12.5px;
    cursor: pointer; white-space: nowrap;
    transition: all 0.15s;
}
.ga-bulk-select-all:hover { background: rgba(255,255,255,0.1); }
.ga-bulk-delete {
    display: inline-flex; align-items: center; gap: 6px;
    background: #dc2626; color: white; border: none;
    border-radius: 7px; padding: 7px 16px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    transition: background 0.15s;
}
.ga-bulk-delete:hover { background: #b91c1c; }
.ga-bulk-delete svg { width: 14px; height: 14px; }
.ga-bulk-cancel {
    background: none; border: none;
    color: rgba(255,255,255,0.55); font-size: 12px;
    cursor: pointer; padding: 5px 8px;
    border-radius: 6px; transition: color 0.15s;
}
.ga-bulk-cancel:hover { color: white; }
</style>
@endpush

@section('content')

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:18px;font-size:13.5px;display:flex;align-items:center;justify-content:space-between">
    <div style="display:flex;align-items:center;gap:8px">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:18px;height:18px;color:#22c55e"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-size:16px;">&times;</button>
</div>
@endif

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Galeri Arsip Dokumentasi Pimpinan</h1>
        <p>Kelola dan telusuri arsip foto, video serta notulensi kegiatan.</p>
    </div>
    <div style="display:flex; align-items:center; gap:10px;">
        <a href="javascript:void(0)" onclick="openExportModal()" style="display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border:1px solid #16a34a;border-radius:8px;background:white;color:#16a34a;font-size:13.5px;font-weight:600;text-decoration:none;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='white'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Download Rekap Excel Notulensi
        </a>
        @if(auth()->user()->isAdmin())
        <button type="button" class="btn-unggah" onclick="openGaleriModal('{{ $tab !== 'semua' ? $tab : 'foto' }}')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            {{ $tab === 'notulensi' ? 'Unggah Notulensi Baru' : ($tab === 'video' ? 'Unggah Video Baru' : ($tab === 'foto' ? 'Unggah Foto Baru' : 'Unggah Arsip Baru')) }}
        </button>
        @endif
    </div>
</div>

{{-- Modal Pilih Tahun Export Notulensi --}}
<div id="exportNotulensiModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(2px); padding:20px;">
    <div style="background:white; border-radius:16px; width:380px; max-width:92vw; box-shadow:0 20px 60px -10px rgba(0,0,0,0.25); overflow:hidden;">
        <div style="background:#1e3a5f; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                <h4 style="color:white;font-size:15px;font-weight:700;margin:0;">Download Rekap Notulensi</h4>
            </div>
            <button type="button" onclick="closeExportModal()" style="background:none;border:none;color:rgba(255,255,255,0.7);font-size:22px;cursor:pointer;line-height:1;">&times;</button>
        </div>
        <form method="GET" action="{{ route('galeri-arsip.export-notulensi') }}" style="padding:22px 24px;">
            <p style="font-size:13px;color:#6b7280;margin:0 0 16px 0;line-height:1.5;">
                File Excel akan berisi rekapan per bulan (<strong>Januari s/d Desember</strong>) dalam bentuk tab multi-sheet dengan kolom Tanggal, Judul, Notulensi, dan Dokumentasi.
            </p>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;">Pilih Tahun Rekap</label>
                <select name="tahun" style="width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;color:#111827;background:white;outline:none;">
                    @foreach($availableYears ?? [now()->year] as $yr)
                        <option value="{{ $yr }}" {{ (int)now()->year === (int)$yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" onclick="closeExportModal()" style="padding:8px 16px;border:1px solid #d1d5db;background:white;border-radius:8px;font-size:13px;color:#4b5563;cursor:pointer;">Batal</button>
                <button type="submit" onclick="setTimeout(closeExportModal, 800)" style="padding:8px 20px;border:none;background:#16a34a;color:white;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Download Excel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabs + Right Filters --}}
<div class="ga-toolbar-wrap" style="flex-wrap:wrap;gap:0;">
    <div class="ga-tabs">
        <a href="{{ route('galeri-arsip.index', array_merge(request()->query(), ['tab' => 'semua'])) }}" class="ga-tab {{ $tab === 'semua' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('galeri-arsip.index', array_merge(request()->query(), ['tab' => 'foto'])) }}"  class="ga-tab {{ $tab === 'foto' ? 'active' : '' }}">Foto</a>
        <a href="{{ route('galeri-arsip.index', array_merge(request()->query(), ['tab' => 'video'])) }}" class="ga-tab {{ $tab === 'video' ? 'active' : '' }}">Video</a>
        <a href="{{ route('galeri-arsip.index', array_merge(request()->query(), ['tab' => 'notulensi'])) }}" class="ga-tab {{ $tab === 'notulensi' ? 'active' : '' }}">Notulensi</a>
    </div>
    <div class="ga-toolbar-right" style="flex-wrap:wrap;gap:8px;">
        {{-- Form Filter Tanggal / Bulan / Tahun & Pencarian --}}
        <form method="GET" action="{{ route('galeri-arsip.index') }}" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;" id="gaFilterForm">
            <input type="hidden" name="tab" value="{{ $tab }}">
            @if(request('kegiatan'))
            <input type="hidden" name="kegiatan" value="{{ request('kegiatan') }}">
            @endif
            @if(request('keyword'))
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            @endif

            {{-- Search Box Toolbar --}}
            <div class="ga-search-wrap">
                <svg class="ga-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" class="ga-search-inp" placeholder="{{ $tab === 'notulensi' ? 'Cari judul notulensi, instansi...' : 'Cari arsip, nama instansi...' }}" value="{{ request('search') }}">
                @if(request('search'))
                <a href="{{ route('galeri-arsip.index', array_merge(request()->except('search'), ['tab' => $tab])) }}" class="ga-search-clear" title="Hapus pencarian">&times;</a>
                @endif
            </div>

            {{-- Filter Tanggal Spesifik --}}
            <div style="display:flex;align-items:center;gap:6px;background:white;border:1px solid #e5e7eb;border-radius:8px;padding:2px 10px;height:36px;" title="Filter berdasarkan tanggal kegiatan">
                <span style="font-size:12px;color:#6b7280;font-weight:600;white-space:nowrap;">📅 Tanggal:</span>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="document.getElementById('gaFilterForm').submit()" style="border:none;outline:none;font-size:12.5px;color:#374151;background:transparent;cursor:pointer;">
            </div>

            {{-- Filter Bulan --}}
            <select name="bulan" id="gaFilterBulan" onchange="document.getElementById('gaFilterForm').submit()" style="padding:6px 10px;border:1px solid #e5e7eb;border-radius:8px;font-size:12.5px;color:#374151;background:white;outline:none;cursor:pointer;height:36px;" title="Filter berdasarkan bulan">
                <option value="">Semua Bulan</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $namaBulan)
                <option value="{{ $idx + 1 }}" {{ request('bulan') == ($idx + 1) ? 'selected' : '' }}>{{ $namaBulan }}</option>
                @endforeach
            </select>

            {{-- Filter Tahun --}}
            <select name="tahun" id="gaFilterTahun" onchange="document.getElementById('gaFilterForm').submit()" style="padding:6px 10px;border:1px solid #e5e7eb;border-radius:8px;font-size:12.5px;color:#374151;background:white;outline:none;cursor:pointer;height:36px;" title="Filter berdasarkan tahun">
                <option value="">Semua Tahun</option>
                @foreach($availableYears as $yr)
                <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>

            {{-- Reset jika ada filter aktif --}}
            @if(request('search') || request('keyword') || request('tanggal') || request('bulan') || request('tahun') || request('kegiatan'))
            <a href="{{ route('galeri-arsip.index', ['tab' => $tab]) }}" style="padding:6px 12px;border:1px solid #fecaca;background:#fef2f2;border-radius:8px;font-size:12.5px;color:#dc2626;text-decoration:none;display:inline-flex;align-items:center;gap:4px;height:36px;font-weight:600;" title="Reset semua filter">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Reset
            </a>
            @endif
        </form>

        @if(auth()->user()->isAdmin())
        <button type="button" id="gaBtnSelectMode" class="ga-btn-select" onclick="toggleSelectMode()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pilih Item
        </button>
        @endif
    </div>
</div>

{{-- Active Filter Banner --}}
@php
    $hasFilter = request('search') || request('keyword') || request('tanggal') || request('bulan') || request('tahun') || request('kegiatan');
    $namaBulanList = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
@endphp
@if($hasFilter)
<div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;background:#f0f9ff;border:1px solid #bae6fd;padding:9px 16px;border-radius:8px;font-size:13px;color:#0369a1;flex-wrap:wrap;">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/></svg>
    <span style="display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
        Filter aktif:
        @if($filterKegiatan)
        <span style="background:#e0e7ff;border:1px solid #c7d2fe;border-radius:6px;padding:2px 8px;font-weight:600;display:inline-flex;align-items:center;gap:5px;color:#3730a3;" title="Hanya menampilkan dokumentasi kegiatan ini">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253 3.75h18M4.5 7.5h15a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0119.5 22.5H4.5A2.25 2.25 0 012.25 20.25V9.75A2.25 2.25 0 014.5 7.5z"/></svg>
            Kegiatan: {{ $filterKegiatan->nomor_agenda ? '['.$filterKegiatan->nomor_agenda.'] ' : '' }}{{ Str::limit($filterKegiatan->judul, 36) }}
            <a href="{{ route('galeri-arsip.index', array_merge(request()->except(['kegiatan']), ['tab' => $tab])) }}" style="color:#4338ca;text-decoration:none;font-weight:bold;margin-left:2px;" title="Hapus filter kegiatan">&times;</a>
        </span>
        @endif
        @if(request('search') || request('keyword'))
        <span style="background:#dbeafe;border-radius:6px;padding:2px 8px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
            🔍 {{ request('search') ?: request('keyword') }}
            <a href="{{ route('galeri-arsip.index', array_merge(request()->except(['search','keyword']), ['tab' => $tab])) }}" style="color:#2563eb;text-decoration:none;font-weight:bold;margin-left:2px;" title="Hapus filter kata kunci">&times;</a>
        </span>
        @endif
        @if(request('tanggal'))
        <span style="background:#dbeafe;border-radius:6px;padding:2px 8px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
            📅 Tgl: {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d M Y') }}
            <a href="{{ route('galeri-arsip.index', array_merge(request()->except(['tanggal']), ['tab' => $tab])) }}" style="color:#2563eb;text-decoration:none;font-weight:bold;margin-left:2px;" title="Hapus filter tanggal">&times;</a>
        </span>
        @endif
        @if(request('bulan'))
        <span style="background:#dbeafe;border-radius:6px;padding:2px 8px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
            🗓️ Bulan: {{ $namaBulanList[(int)request('bulan')] ?? '' }}
            <a href="{{ route('galeri-arsip.index', array_merge(request()->except(['bulan']), ['tab' => $tab])) }}" style="color:#2563eb;text-decoration:none;font-weight:bold;margin-left:2px;" title="Hapus filter bulan">&times;</a>
        </span>
        @endif
        @if(request('tahun'))
        <span style="background:#dbeafe;border-radius:6px;padding:2px 8px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
            📆 Tahun: {{ request('tahun') }}
            <a href="{{ route('galeri-arsip.index', array_merge(request()->except(['tahun']), ['tab' => $tab])) }}" style="color:#2563eb;text-decoration:none;font-weight:bold;margin-left:2px;" title="Hapus filter tahun">&times;</a>
        </span>
        @endif
        <span style="color:#4b5563;">— Ditemukan <strong style="color:#0369a1;">{{ $items->total() }}</strong> arsip</span>
    </span>
    <a href="{{ route('galeri-arsip.index', ['tab' => $tab]) }}" style="margin-left:auto;color:#ef4444;text-decoration:none;font-weight:600;font-size:12.5px;display:inline-flex;align-items:center;gap:4px;white-space:nowrap;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Reset Semua Filter
    </a>
</div>
@endif

{{-- Bulk Delete Form (hidden) --}}
<form id="gaBulkDeleteForm" method="POST" action="{{ route('galeri-arsip.bulk-destroy') }}" style="display:none">
    @csrf
    @method('DELETE')
    <input type="hidden" name="current_tab" value="{{ $tab }}">
    <div id="gaBulkIdsContainer"></div>
</form>

{{-- Bulk Action Bar --}}
<div id="gaBulkBar">
    <span id="gaBulkCount" class="ga-bulk-count">0 dipilih</span>
    <button type="button" class="ga-bulk-select-all" onclick="selectAllItems()">Pilih Semua</button>
    <button type="button" class="ga-bulk-delete" onclick="confirmBulkDelete()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
        Hapus yang Dipilih
    </button>
    <button type="button" class="ga-bulk-cancel" onclick="toggleSelectMode(false)">Batal</button>
</div>

{{-- Grid --}}
<div class="ga-grid" id="gaGrid">
    @forelse($items as $item)
    <div class="ga-card" data-id="{{ $item->id }}" onclick="handleCardClick(event, this, {{ $item->id }})">
        {{-- Checkbox Overlay (select mode only) --}}
        <div class="ga-card-checkbox" onclick="event.stopPropagation()">
            <input type="checkbox" class="ga-item-checkbox" data-id="{{ $item->id }}" onchange="onCheckboxChange()">
        </div>

        {{-- Thumbnail - klik untuk preview --}}
        <div class="ga-thumb" id="gat-{{ $item->id }}" onclick="handleThumbClick(event, '{{ $item->tipe }}', {{ $item->id }}, '{{ addslashes($item->judul) }}', '{{ addslashes($item->file_name ?? '') }}', '{{ $item->file_paparan_path ? asset('storage/' . $item->file_paparan_path) : '' }}', '{{ addslashes($item->file_paparan_name ?? '') }}')">
            @if($item->file_path)
                @if(Str::endsWith($item->file_path, ['.mp4', '.mov']))
                    {{-- Video: placeholder gelap + ikon, tanpa <video src> agar IDM tidak mencegat --}}
                    <div class="ga-thumb-placeholder ga-video-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                    </div>
                @elseif($item->tipe === 'notulensi' && !Str::endsWith(strtolower($item->file_path), ['.jpg', '.jpeg', '.png', '.webp']))
                    {{-- Notulensi Dokumen Non-Gambar --}}
                    <div class="ga-thumb-placeholder" style="background:linear-gradient(135deg, #f0fdf4, #e2e8f0);color:#047857;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:12px;text-align:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" style="width:44px;height:44px;color:#059669;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        <span style="font-size:11.5px;font-weight:700;color:#047857;letter-spacing:0.02em;">DOKUMEN NOTULENSI</span>
                        @if($item->file_paparan_path)
                        <span style="font-size:10px;font-weight:600;color:#2563eb;background:#eff6ff;padding:2px 8px;border-radius:10px;border:1px solid #bfdbfe;">+ Paparan PPT</span>
                        @endif
                    </div>
                @else
                    {{-- Foto / Media Gambar: URL disimpan di data attribute, dimuat via JS fetch() → Blob URL --}}
                    <div class="ga-thumb-bg" data-thumb="{{ route('galeri-arsip.thumb', $item->id) }}"></div>
                @endif
            @else
                <div class="ga-thumb-placeholder">
                    @if($item->tipe === 'foto')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    @elseif($item->tipe === 'video')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    @endif
                </div>
            @endif

            {{-- Type / Album Badge --}}
            @if($item->tipe === 'foto' && $item->jumlah_foto > 1)
                <span class="ga-type-badge album">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    Album ({{ $item->jumlah_foto }})
                </span>
            @elseif($item->tipe === 'video')
                <span class="ga-type-badge video">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 4.5a3 3 0 00-3 3v9a3 3 0 003 3h8.25a3 3 0 003-3v-9a3 3 0 00-3-3H4.5zM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06z"/></svg>
                    Video
                </span>
            @elseif($item->tipe === 'notulensi')
                <span class="ga-type-badge notulensi">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Notulensi
                </span>
            @else
                <span class="ga-type-badge foto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                    Foto
                </span>
            @endif

            {{-- Play icon for video --}}
            @if($item->tipe === 'video')
                <div class="ga-play-overlay">
                    <div class="ga-play-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @if($item->durasi_format)
                    <span class="ga-duration-badge">{{ $item->durasi_format }}</span>
                @endif
            @endif
        </div>

        {{-- Card Body --}}
        <div class="ga-card-body">
            <div class="ga-meta-row">
                <span class="ga-kode">{{ $item->kode }}</span>
                <span class="ga-date">{{ $item->tanggal_kegiatan ? $item->tanggal_kegiatan->translatedFormat('d M Y') : '—' }}</span>
            </div>
            <div class="ga-title" title="{{ $item->judul }}">{{ $item->judul }}</div>

            {{-- Nama Instansi Badge --}}
            @php
                $itemInstansi = $item->instansi ?: ($item->kegiatan?->leading_sektor ?? null);
            @endphp
            @if($itemInstansi)
            <div style="margin-top:5px;display:flex;align-items:center;gap:5px;font-size:11.5px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:13px;height:13px;color:#2563eb;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                <a href="{{ route('galeri-arsip.index', ['tab' => $tab, 'search' => $itemInstansi]) }}" onclick="event.stopPropagation()" style="font-weight:600;color:#1e40af;background:#eff6ff;padding:2px 8px;border-radius:6px;border:1px solid #bfdbfe;text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%;display:inline-block;" title="Cari arsip dari: {{ $itemInstansi }}">
                    {{ $itemInstansi }}
                </a>
            </div>
            @endif

            {{-- Kegiatan Pimpinan Terkait Badge --}}
            @if($item->kegiatan)
            <div style="margin-top:5px;display:flex;align-items:center;gap:5px;font-size:11.5px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#059669" style="width:13px;height:13px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253 3.75h18M4.5 7.5h15a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0119.5 22.5H4.5A2.25 2.25 0 012.25 20.25V9.75A2.25 2.25 0 014.5 7.5z"/></svg>
                <a href="{{ route('galeri-arsip.index', ['tab' => $tab, 'kegiatan' => $item->kegiatan_id]) }}" onclick="event.stopPropagation()" style="font-weight:600;color:#047857;background:#ecfdf5;padding:2px 8px;border-radius:6px;border:1px solid #a7f3d0;text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%;display:inline-block;" title="Agenda: {{ $item->kegiatan->judul }}">
                    📋 {{ $item->kegiatan->nomor_agenda ? '['.$item->kegiatan->nomor_agenda.'] ' : '' }}{{ Str::limit($item->kegiatan->judul, 28) }}
                </a>
            </div>
            @endif

            {{-- File Attachment Badges (Khususnya Notulensi & Paparan) --}}
            @if($item->tipe === 'notulensi' && ($item->file_path || $item->file_paparan_path))
            <div class="ga-files-row" onclick="event.stopPropagation()">
                @if($item->file_path)
                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="ga-file-badge notulensi" title="{{ $item->file_name ?? 'Dokumen Notulensi Dinas' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Notulensi
                </a>
                @endif
                @if($item->file_paparan_path)
                <a href="{{ asset('storage/' . $item->file_paparan_path) }}" target="_blank" class="ga-file-badge paparan" title="{{ $item->file_paparan_name ?? 'File Paparan Rapat' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.143 2.143L15.429 6"/></svg>
                    Paparan PPT
                </a>
                @endif
            </div>
            @endif

            <div class="ga-footer">
                <div class="ga-akses">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                    {{ $item->akses_label }}
                </div>
                <div style="position:relative">
                    <button type="button" class="ga-more-btn" onclick="toggleGaMenu(event, 'gamenu-{{ $item->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                    </button>
                    <div id="gamenu-{{ $item->id }}" class="ga-dropdown">
                        @if(auth()->user()->isAdmin())
                        <button type="button" class="ga-dd-item" onclick="editGaleri({{ json_encode($item) }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Edit Data
                        </button>
                        @endif
                        @if($item->file_path)
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="ga-dd-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            {{ $item->tipe === 'notulensi' ? 'Unduh Notulensi' : 'Unduh File' }}
                        </a>
                        @endif
                        @if($item->file_paparan_path)
                        <a href="{{ asset('storage/' . $item->file_paparan_path) }}" target="_blank" class="ga-dd-item" style="color:#2563eb;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Unduh Paparan Dinas
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('galeri-arsip.destroy', $item) }}" onsubmit="return confirm('Hapus arsip ini?')" style="display:contents">
                            @csrf @method('DELETE')
                            <button type="submit" class="ga-dd-item danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:#9ca3af;font-size:14px">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:48px;height:48px;margin:0 auto 12px;display:block;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>
        Belum ada arsip pada kategori ini.
    </div>
    @endforelse
</div>

{{-- Muat Lebih Banyak --}}
@if($items->hasMorePages())
<div class="ga-load-more-wrap">
    <a href="{{ $items->nextPageUrl() }}" class="ga-load-more-btn">
        Muat Lebih Banyak
    </a>
</div>
@endif

{{-- ===== VIEWER MODALS ===== --}}

{{-- Foto Lightbox --}}
<div id="viewerFoto" class="viewer-overlay" onclick="closeViewer('viewerFoto')">
    <button class="viewer-close" onclick="closeViewer('viewerFoto')">&times;</button>
    <div class="viewer-title" id="viewerFotoTitle"></div>
    <img id="viewerImg" src="" alt="" onclick="event.stopPropagation()">
</div>

{{-- Video Player --}}
<div id="viewerVideo" class="viewer-overlay" onclick="closeViewer('viewerVideo')">
    <button class="viewer-close" onclick="closeViewer('viewerVideo')">&times;</button>
    <div class="viewer-title" id="viewerVideoTitle"></div>
    <video id="viewerVideoEl" controls autoplay onclick="event.stopPropagation()"
        style="max-width:min(94vw,1100px);max-height:82vh;border-radius:8px;background:#000;box-shadow:0 30px 60px -10px rgba(0,0,0,0.5)">
    </video>
</div>

{{-- Notulensi / Doc Viewer --}}
<div id="viewerDoc" class="viewer-overlay" onclick="closeViewer('viewerDoc')">
    <button class="viewer-close" onclick="closeViewer('viewerDoc')">&times;</button>
    <div class="viewer-title" id="viewerDocTitle"></div>
    <div class="viewer-doc-wrap" onclick="event.stopPropagation()">
        <div class="viewer-doc-toolbar">
            <span id="viewerDocName" style="font-size:13px;font-weight:500"></span>
            <div style="display:flex;align-items:center;gap:8px;">
                <a id="viewerDocDownload" href="#" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Unduh Notulensi
                </a>
                <a id="viewerPaparanDownload" href="#" target="_blank" style="display:none;background:#2563eb;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Unduh Paparan Dinas
                </a>
            </div>
        </div>
        <iframe id="viewerDocFrame" src="" allowfullscreen></iframe>
    </div>
</div>

{{-- Modal Upload --}}
<div id="galeriModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="galeriModalTitle">Unggah Arsip Baru</h3>
            <button type="button" class="modal-close" onclick="closeGaleriModal()">&times;</button>
        </div>
        <form id="galeriForm" method="POST" action="{{ route('galeri-arsip.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="galeriMethodField"></div>
            <div class="modal-body">
                {{-- Pilihan Kegiatan Pimpinan Terkait --}}
                <div class="form-g" id="gaKegiatanWrap">
                    <label class="form-lbl">
                        <span style="display:inline-flex;align-items:center;gap:6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#1e3a5f" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253 3.75h18M4.5 7.5h15a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0119.5 22.5H4.5A2.25 2.25 0 012.25 20.25V9.75A2.25 2.25 0 014.5 7.5z"/></svg>
                            Kegiatan Pimpinan Terkait
                        </span>
                        <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(Opsional)</span>
                    </label>
                    <select class="form-sel" name="kegiatan_id" id="gaKegiatanId" onchange="onKegiatanSelected(this)">
                        <option value="">-- Tidak Terhubung / Pilih Kegiatan Pimpinan --</option>
                        @if(isset($kegiatanList))
                            @foreach($kegiatanList as $k)
                                <option value="{{ $k->id }}" data-judul="{{ addslashes($k->judul) }}" data-tanggal="{{ $k->tanggal_mulai ? $k->tanggal_mulai->format('Y-m-d') : '' }}" {{ (isset($filterKegiatanId) && $filterKegiatanId == $k->id) ? 'selected' : '' }}>
                                    {{ $k->nomor_agenda ? '['.$k->nomor_agenda.'] ' : '' }}{{ $k->judul }} ({{ $k->tanggal_mulai ? $k->tanggal_mulai->format('d/m/Y') : '-' }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <div style="font-size:11.5px;color:#9ca3af;margin-top:4px">Hubungkan dokumentasi ini langsung ke agenda kegiatan pimpinan terkait.</div>
                </div>

                <div class="form-g">
                    <label class="form-lbl" id="gaJudulLabel">{{ $tab === 'notulensi' ? 'Judul Notulensi Rapat' : ($tab === 'video' ? 'Judul Video' : ($tab === 'foto' ? 'Judul Foto' : 'Judul Arsip')) }} <span class="req">*</span></label>
                    <input type="text" class="form-inp" name="judul" id="gaJudul" placeholder="{{ $tab === 'notulensi' ? 'Contoh: Notulensi Rapat Evaluasi Dinas...' : 'Contoh: Rapat Koordinasi Dinas...' }}" required>
                </div>
                <div class="form-g" id="gaTipeWrap" style="{{ $tab !== 'semua' ? 'display:none;' : '' }}">
                    <label class="form-lbl">Tipe <span class="req">*</span></label>
                    <select class="form-sel" name="tipe" id="gaTipe" required onchange="toggleExtraFields()">
                        <option value="foto" {{ $tab === 'foto' ? 'selected' : '' }}>Foto</option>
                        <option value="video" {{ $tab === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="notulensi" {{ $tab === 'notulensi' ? 'selected' : '' }}>Notulensi</option>
                    </select>
                </div>
                <div class="form-g">
                    <label class="form-lbl">Tanggal Kegiatan <span class="req">*</span></label>
                    <input type="date" class="form-inp" name="tanggal_kegiatan" id="gaTanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-g" id="gaFotoCountWrap">
                    <label class="form-lbl">Jumlah Foto (jika album)</label>
                    <input type="number" class="form-inp" name="jumlah_foto" id="gaJumlahFoto" value="1" min="1">
                </div>
                <div class="form-g" id="gaDurasiWrap" style="display:none">
                    <label class="form-lbl">Durasi Video</label>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="text" class="form-inp" id="gaDurasiDisplay" readonly placeholder="Otomatis terdeteksi saat video dipilih" style="background:#f3f4f6;color:#6b7280;cursor:default;flex:1">
                        <input type="hidden" name="durasi_detik" id="gaDurasi">
                    </div>
                    <div id="gaDurasiInfo" style="font-size:11.5px;color:#9ca3af;margin-top:4px">Durasi akan terisi otomatis setelah memilih file video.</div>
                </div>
                <div class="form-g">
                    <label class="form-lbl" id="gaKeteranganLabel">Keterangan / Ringkasan</label>
                    <textarea class="form-txa" name="keterangan" id="gaKeterangan" placeholder="Keterangan singkat mengenai arsip..."></textarea>
                </div>

                {{-- Input Nama Instansi / Dinas --}}
                <div class="form-g" id="gaInstansiWrap">
                    <label class="form-lbl">
                        Nama Instansi / Perangkat Daerah / Dinas
                        <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(Opsional)</span>
                    </label>
                    <input type="text" class="form-inp" name="instansi" id="gaInstansi" placeholder="Contoh: Dinas Pendidikan, Bappelitbang, Diskominfo, Bagian Umum...">
                    <input type="hidden" name="keywords" id="gaKeywords">
                    <div style="font-size:11.5px;color:#9ca3af;margin-top:4px">Memudahkan pencarian notulensi & arsip berdasarkan nama instansi terkait.</div>
                </div>

                {{-- Banner Standar ISO Penamaan File --}}
                <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:10px 12px;margin-bottom:14px;font-size:12px;color:#0369a1;display:flex;align-items:flex-start;gap:8px;line-height:1.45;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;flex-shrink:0;margin-top:2px;color:#0284c7;"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                    <div>
                        <strong style="color:#0c4a6e;">Standar ISO Penamaan File:</strong> Format penamaan foto &amp; dokumen disarankan <code>Tanggal_Bulan_Tahun_Nama Kegiatan</code> (contoh: <code>11_11_2026_Rapat_Koordinasi_Pimpinan.jpg</code>). <span style="display:block;margin-top:2px;font-size:11.5px;color:#0284c7;">Sistem secara otomatis menerapkan standardisasi nama file ini saat disimpan.</span>
                    </div>
                </div>

                {{-- Input File Utama (Foto / Video / Dokumen Notulensi) --}}
                <div class="form-g" id="gaFileArsipWrap">
                    <label class="form-lbl" id="gaFileLabel">File Arsip (.jpg, .png, .mp4, .pdf, .docx)</label>
                    <input type="file" class="form-inp" name="file_arsip" id="gaFile" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.pdf,.doc,.docx,.ppt,.pptx">
                    <div id="gaCurrentFileIndicator" style="display:none;font-size:12px;color:#059669;margin-top:5px;"></div>
                    <div id="gaUploadProgress"><div id="gaUploadBar"></div></div>
                    <div id="gaUploadStatus" style="font-size:11.5px;color:#9ca3af;margin-top:4px">Maksimal 150MB</div>
                </div>

                {{-- Input File Paparan / Presentasi PPT Rapat Dinas (Khusus Notulensi) --}}
                <div class="form-g" id="gaPaparanWrap" style="display:none">
                    <label class="form-lbl">
                        <span style="display:inline-flex;align-items:center;gap:6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2563eb" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.143 2.143L15.429 6"/></svg>
                            File Paparan / Materi Presentasi Rapat Dinas (.ppt, .pptx, .pdf)
                        </span>
                        <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(Opsional)</span>
                    </label>
                    <input type="file" class="form-inp" name="file_paparan" id="gaFilePaparan" accept=".ppt,.pptx,.pdf,.doc,.docx,.odp">
                    <div id="gaCurrentPaparanIndicator" style="display:none;font-size:12px;color:#2563eb;margin-top:5px;"></div>
                    <div style="font-size:11.5px;color:#9ca3af;margin-top:4px">Materi presentasi/paparan slide dari instansi atau dinas terkait.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ga-btn-action" onclick="closeGaleriModal()">Batal</button>
                <button type="submit" class="btn-unggah" id="gaSubmitBtn">Simpan Arsip</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ===== SELECT MODE / BULK DELETE =====
let isSelectMode = false;

function toggleSelectMode(forceState) {
    if (typeof forceState === 'boolean') {
        isSelectMode = forceState;
    } else {
        isSelectMode = !isSelectMode;
    }

    const grid = document.getElementById('gaGrid');
    const btn = document.getElementById('gaBtnSelectMode');
    const bar = document.getElementById('gaBulkBar');

    if (isSelectMode) {
        grid?.classList.add('select-mode');
        btn?.classList.add('active');
        if (btn) btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Batal Pilih`;
        bar?.classList.add('show');
        updateBulkCount();
    } else {
        grid?.classList.remove('select-mode');
        btn?.classList.remove('active');
        if (btn) btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Pilih Item`;
        bar?.classList.remove('show');
        
        // Reset all checkboxes & cards
        document.querySelectorAll('.ga-item-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.ga-card').forEach(c => c.classList.remove('selected'));
        const selectAllBtn = document.querySelector('.ga-bulk-select-all');
        if (selectAllBtn) selectAllBtn.textContent = 'Pilih Semua';
        updateBulkCount();
    }
}

function handleCardClick(event, cardEl, itemId) {
    if (!isSelectMode) return;
    
    // If user clicked directly on dropdown menu, don't trigger select
    if (event.target.closest('.ga-dropdown') || event.target.closest('.ga-more-btn')) {
        return;
    }

    const cb = cardEl.querySelector('.ga-item-checkbox');
    if (cb && event.target !== cb) {
        cb.checked = !cb.checked;
    }
    onCheckboxChange();
}

function handleThumbClick(event, tipe, itemId, judul, fileName, paparanUrl, paparanName) {
    if (isSelectMode) {
        event.stopPropagation();
        const card = event.target.closest('.ga-card');
        if (card) {
            const cb = card.querySelector('.ga-item-checkbox');
            if (cb) cb.checked = !cb.checked;
            onCheckboxChange();
        }
        return;
    }
    openViewer(tipe, itemId, judul, fileName, paparanUrl, paparanName);
}

function onCheckboxChange() {
    let checkedCount = 0;
    const allCbs = document.querySelectorAll('.ga-item-checkbox');
    document.querySelectorAll('.ga-card').forEach(card => {
        const cb = card.querySelector('.ga-item-checkbox');
        if (cb && cb.checked) {
            card.classList.add('selected');
            checkedCount++;
        } else {
            card.classList.remove('selected');
        }
    });

    const selectAllBtn = document.querySelector('.ga-bulk-select-all');
    if (selectAllBtn && allCbs.length > 0) {
        selectAllBtn.textContent = (checkedCount === allCbs.length) ? 'Batal Pilih Semua' : 'Pilih Semua';
    }

    updateBulkCount(checkedCount);
}

function updateBulkCount(count) {
    if (typeof count === 'undefined') {
        count = document.querySelectorAll('.ga-item-checkbox:checked').length;
    }
    const countEl = document.getElementById('gaBulkCount');
    if (countEl) {
        countEl.textContent = `${count} dipilih`;
    }
}

function selectAllItems() {
    const allCbs = document.querySelectorAll('.ga-item-checkbox');
    const checkedCbs = document.querySelectorAll('.ga-item-checkbox:checked');
    const selectAllBtn = document.querySelector('.ga-bulk-select-all');

    const shouldCheck = checkedCbs.length < allCbs.length;
    allCbs.forEach(cb => {
        cb.checked = shouldCheck;
    });

    onCheckboxChange();
    if (selectAllBtn) {
        selectAllBtn.textContent = shouldCheck ? 'Batal Pilih Semua' : 'Pilih Semua';
    }
}

function confirmBulkDelete() {
    const checked = document.querySelectorAll('.ga-item-checkbox:checked');
    if (checked.length === 0) {
        alert('Silakan pilih minimal satu item untuk dihapus.');
        return;
    }

    if (!confirm(`Apakah Anda yakin ingin menghapus ${checked.length} arsip yang dipilih? File fisik dan data yang dihapus tidak dapat dikembalikan.`)) {
        return;
    }

    const container = document.getElementById('gaBulkIdsContainer');
    container.innerHTML = '';
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.getAttribute('data-id');
        container.appendChild(input);
    });

    document.getElementById('gaBulkDeleteForm').submit();
}


function toggleGaMenu(e, id) {
    e.stopPropagation();
    document.querySelectorAll('.ga-dropdown').forEach(m => {
        if (m.id !== id) m.classList.remove('show');
    });
    document.getElementById(id)?.classList.toggle('show');
}
document.addEventListener('click', () => {
    document.querySelectorAll('.ga-dropdown').forEach(m => m.classList.remove('show'));
});

function openGaleriModal(defaultTipe) {
    document.getElementById('galeriForm').reset();
    document.getElementById('galeriForm').action = "{{ route('galeri-arsip.store') }}";
    document.getElementById('galeriMethodField').innerHTML = '';
    const pageTab = defaultTipe || '{{ $tab }}';
    if (pageTab === 'notulensi') {
        document.getElementById('galeriModalTitle').textContent = 'Unggah Notulensi Baru';
        if (document.getElementById('gaTipeWrap')) document.getElementById('gaTipeWrap').style.display = 'none';
        if (document.getElementById('gaJudulLabel')) document.getElementById('gaJudulLabel').innerHTML = 'Judul Notulensi Rapat <span class="req">*</span>';
        if (document.getElementById('gaJudul')) document.getElementById('gaJudul').placeholder = 'Contoh: Notulensi Rapat Evaluasi Dinas...';
    } else if (pageTab === 'video') {
        document.getElementById('galeriModalTitle').textContent = 'Unggah Video Baru';
        if (document.getElementById('gaTipeWrap')) document.getElementById('gaTipeWrap').style.display = 'none';
        if (document.getElementById('gaJudulLabel')) document.getElementById('gaJudulLabel').innerHTML = 'Judul Video Arsip <span class="req">*</span>';
    } else if (pageTab === 'foto') {
        document.getElementById('galeriModalTitle').textContent = 'Unggah Foto Baru';
        if (document.getElementById('gaTipeWrap')) document.getElementById('gaTipeWrap').style.display = 'none';
        if (document.getElementById('gaJudulLabel')) document.getElementById('gaJudulLabel').innerHTML = 'Judul Foto Arsip <span class="req">*</span>';
    } else {
        document.getElementById('galeriModalTitle').textContent = 'Unggah Arsip Baru';
        if (document.getElementById('gaTipeWrap')) document.getElementById('gaTipeWrap').style.display = '';
        if (document.getElementById('gaJudulLabel')) document.getElementById('gaJudulLabel').innerHTML = 'Judul Arsip <span class="req">*</span>';
    }

    document.getElementById('gaSubmitBtn').textContent = 'Simpan Arsip';
    document.getElementById('gaSubmitBtn').disabled = false;
    document.getElementById('gaUploadProgress').style.display = 'none';
    document.getElementById('gaUploadBar').style.width = '0%';
    document.getElementById('gaUploadStatus').textContent = 'Maksimal 150MB';
    document.getElementById('gaUploadStatus').style.color = '#9ca3af';
    
    if (document.getElementById('gaInstansi')) document.getElementById('gaInstansi').value = '';
    if (document.getElementById('gaKeywords')) document.getElementById('gaKeywords').value = '';
    const gaKegiatanId = document.getElementById('gaKegiatanId');
    if (gaKegiatanId) {
        gaKegiatanId.value = '{{ $filterKegiatanId ?? '' }}';
    }
    document.getElementById('gaFile').value = '';
    if (document.getElementById('gaFilePaparan')) document.getElementById('gaFilePaparan').value = '';
    const curFile = document.getElementById('gaCurrentFileIndicator');
    if (curFile) curFile.style.display = 'none';
    const curPaparan = document.getElementById('gaCurrentPaparanIndicator');
    if (curPaparan) curPaparan.style.display = 'none';

    if (defaultTipe) document.getElementById('gaTipe').value = defaultTipe;
    document.getElementById('gaTanggal').value = new Date().toISOString().split('T')[0];
    toggleExtraFields();
    document.getElementById('galeriModal').style.display = 'flex';
}

function editGaleri(item) {
    document.getElementById('galeriForm').reset();
    document.getElementById('galeriForm').action = '/dokumentasi-pimpinan/galeri-arsip/' + item.id;
    document.getElementById('galeriMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    const pageTab = '{{ $tab }}';
    if (pageTab === 'notulensi' || item.tipe === 'notulensi') {
        document.getElementById('galeriModalTitle').textContent = 'Edit Data Notulensi';
        if (pageTab === 'notulensi' && document.getElementById('gaTipeWrap')) {
            document.getElementById('gaTipeWrap').style.display = 'none';
        }
        if (document.getElementById('gaJudulLabel')) document.getElementById('gaJudulLabel').innerHTML = 'Judul Notulensi Rapat <span class="req">*</span>';
    } else if (pageTab === 'video' || item.tipe === 'video') {
        document.getElementById('galeriModalTitle').textContent = 'Edit Data Video';
        if (pageTab === 'video' && document.getElementById('gaTipeWrap')) {
            document.getElementById('gaTipeWrap').style.display = 'none';
        }
    } else if (pageTab === 'foto' || item.tipe === 'foto') {
        document.getElementById('galeriModalTitle').textContent = 'Edit Data Foto';
        if (pageTab === 'foto' && document.getElementById('gaTipeWrap')) {
            document.getElementById('gaTipeWrap').style.display = 'none';
        }
    } else {
        document.getElementById('galeriModalTitle').textContent = 'Edit Data Arsip';
        if (document.getElementById('gaTipeWrap')) document.getElementById('gaTipeWrap').style.display = '';
    }

    document.getElementById('gaSubmitBtn').textContent = 'Perbarui Arsip';

    document.getElementById('gaJudul').value = item.judul || '';
    if (document.getElementById('gaInstansi')) document.getElementById('gaInstansi').value = item.instansi || '';
    const gaKegiatanId = document.getElementById('gaKegiatanId');
    if (gaKegiatanId) gaKegiatanId.value = item.kegiatan_id || '';
    document.getElementById('gaTipe').value = item.tipe || 'foto';
    document.getElementById('gaTanggal').value = item.tanggal_kegiatan ? item.tanggal_kegiatan.split('T')[0] : '';
    document.getElementById('gaJumlahFoto').value = item.jumlah_foto || 1;
    document.getElementById('gaDurasi').value = item.durasi_detik || '';
    document.getElementById('gaKeterangan').value = item.keterangan || '';
    if (document.getElementById('gaKeywords')) document.getElementById('gaKeywords').value = item.keywords || '';

    const curFile = document.getElementById('gaCurrentFileIndicator');
    if (curFile) {
        if (item.file_name) {
            curFile.style.display = 'block';
            curFile.innerHTML = `File saat ini: <strong>${item.file_name}</strong> (Pilih file baru jika ingin mengganti)`;
        } else {
            curFile.style.display = 'none';
        }
    }

    const curPaparan = document.getElementById('gaCurrentPaparanIndicator');
    if (curPaparan) {
        if (item.file_paparan_name) {
            curPaparan.style.display = 'block';
            curPaparan.innerHTML = `File paparan saat ini: <strong>${item.file_paparan_name}</strong> (Pilih file baru jika ingin mengganti)`;
        } else {
            curPaparan.style.display = 'none';
        }
    }

    toggleExtraFields();
    document.getElementById('galeriModal').style.display = 'flex';
}

function onKegiatanSelected(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.value) {
        const gaJudul = document.getElementById('gaJudul');
        const gaTanggal = document.getElementById('gaTanggal');
        const defaultTipe = document.getElementById('gaTipe') ? document.getElementById('gaTipe').value : 'foto';
        const judulKegiatan = opt.getAttribute('data-judul') || '';
        
        if (gaJudul && (!gaJudul.value || gaJudul.value.trim() === '')) {
            if (defaultTipe === 'notulensi') {
                gaJudul.value = 'Notulensi: ' + judulKegiatan;
            } else if (defaultTipe === 'video') {
                gaJudul.value = 'Video: ' + judulKegiatan;
            } else {
                gaJudul.value = 'Dokumentasi: ' + judulKegiatan;
            }
        }
        if (gaTanggal && opt.getAttribute('data-tanggal')) {
            gaTanggal.value = opt.getAttribute('data-tanggal');
        }
    }
}

function toggleExtraFields() {
    const tipe = document.getElementById('gaTipe').value;
    document.getElementById('gaFotoCountWrap').style.display = (tipe === 'foto') ? '' : 'none';
    document.getElementById('gaDurasiWrap').style.display = (tipe === 'video') ? '' : 'none';

    const gaPaparanWrap = document.getElementById('gaPaparanWrap');
    if (gaPaparanWrap) {
        gaPaparanWrap.style.display = (tipe === 'notulensi') ? '' : 'none';
    }

    const gaFileLabel = document.getElementById('gaFileLabel');
    if (gaFileLabel) {
        if (tipe === 'notulensi') {
            gaFileLabel.innerHTML = 'File Dokumen Notulensi Rapat Dinas <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(.pdf, .doc, .docx)</span>';
        } else if (tipe === 'video') {
            gaFileLabel.innerHTML = 'File Video <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(.mp4, .mov)</span>';
        } else {
            gaFileLabel.innerHTML = 'File Foto <span style="font-size:11.5px;font-weight:normal;color:#6b7280;">(.jpg, .png, .webp)</span>';
        }
    }

    const ketLabel = document.getElementById('gaKeteranganLabel');
    const ketInput = document.getElementById('gaKeterangan');
    if (ketLabel && ketInput) {
        if (tipe === 'notulensi') {
            ketLabel.textContent = 'Notulensi / Ringkasan Rapat';
            ketInput.placeholder = 'Tuliskan catatan atau ringkasan isi notulensi kegiatan...';
        } else {
            ketLabel.textContent = 'Keterangan';
            ketInput.placeholder = 'Keterangan singkat mengenai arsip...';
        }
    }
}

function closeGaleriModal() {
    document.getElementById('galeriModal').style.display = 'none';
}

// ===== VIEWER FUNCTIONS =====
// Semua file dimuat via fetch JSON → base64 → Blob URL agar IDM tidak mencegat
const THUMB_BASE = '{{ url("/dokumentasi-pimpinan/galeri-arsip/thumb") }}';
const THUMB_PAPARAN_BASE = '{{ url("/dokumentasi-pimpinan/galeri-arsip/thumb-paparan") }}';

function dataURItoBlob(dataURI) {
    const parts  = dataURI.split(',');
    const mime   = parts[0].match(/:(.*?);/)[1];
    const binary = atob(parts[1]);
    const arr    = new Uint8Array(binary.length);
    for (let i = 0; i < binary.length; i++) arr[i] = binary.charCodeAt(i);
    return new Blob([arr], { type: mime });
}

function fetchAsBlob(itemId) {
    return fetch(THUMB_BASE + '/' + itemId, {
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(json) {
        if (!json || !json.data) throw new Error('no data');
        return URL.createObjectURL(dataURItoBlob(json.data));
    });
}

function fetchPaparanAsBlob(itemId) {
    return fetch(THUMB_PAPARAN_BASE + '/' + itemId, {
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(json) {
        if (!json || !json.data) throw new Error('no data');
        return URL.createObjectURL(dataURItoBlob(json.data));
    });
}

function openViewer(tipe, itemId, judul, fileName, paparanUrl, paparanName) {
    if (!itemId) return;

    if (tipe === 'foto') {
        document.getElementById('viewerFotoTitle').textContent = judul;
        document.getElementById('viewerFoto').classList.add('active');
        document.body.style.overflow = 'hidden';
        document.getElementById('viewerImg').src = '';
        fetchAsBlob(itemId).then(function(blobUrl) {
            document.getElementById('viewerImg').src = blobUrl;
        }).catch(function() {});

    } else if (tipe === 'video') {
        document.getElementById('viewerVideoTitle').textContent = judul;
        document.getElementById('viewerVideo').classList.add('active');
        document.body.style.overflow = 'hidden';
        const v = document.getElementById('viewerVideoEl');
        v.src = '';
        fetchAsBlob(itemId).then(function(blobUrl) {
            v.src = blobUrl;
            v.play().catch(function() {});
        }).catch(function() {});

    } else if (tipe === 'notulensi') {
        document.getElementById('viewerDocTitle').textContent = judul;
        document.getElementById('viewerDocName').textContent = fileName || judul;
        document.getElementById('viewerDocFrame').src = '';
        document.getElementById('viewerDocDownload').href = '#';
        document.getElementById('viewerDocDownload').onclick = null;

        const paparanBtn = document.getElementById('viewerPaparanDownload');
        if (paparanBtn) {
            if (paparanUrl) {
                paparanBtn.style.display = 'inline-flex';
                paparanBtn.onclick = function(e) {
                    e.preventDefault();
                    fetchPaparanAsBlob(itemId).then(function(blobUrl) {
                        const a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = paparanName || 'paparan-rapat.pptx';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }).catch(function() {
                        window.open(paparanUrl, '_blank');
                    });
                };
            } else {
                paparanBtn.style.display = 'none';
            }
        }

        document.getElementById('viewerDoc').classList.add('active');
        document.body.style.overflow = 'hidden';
        fetchAsBlob(itemId).then(function(blobUrl) {
            document.getElementById('viewerDocFrame').src = blobUrl;
            // Tombol Unduh: buka blob URL di tab baru
            document.getElementById('viewerDocDownload').onclick = function(e) {
                e.preventDefault();
                window.open(blobUrl, '_blank');
            };
        }).catch(function() {});
    }
}

function closeViewer(id) {
    const el = document.getElementById(id);
    el.classList.remove('active');
    document.body.style.overflow = '';
    if (id === 'viewerVideo') {
        const v = document.getElementById('viewerVideoEl');
        v.pause(); v.src = '';
    }
    if (id === 'viewerDoc') {
        document.getElementById('viewerDocFrame').src = '';
    }
}

// Close viewer on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['viewerFoto','viewerVideo','viewerDoc'].forEach(closeViewer);
        closeGaleriModal();
    }
});

// ===== UPLOAD via XHR dengan progress bar =====
document.getElementById('galeriForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    const progress  = document.getElementById('gaUploadProgress');
    const bar       = document.getElementById('gaUploadBar');
    const status    = document.getElementById('gaUploadStatus');
    const submitBtn = document.getElementById('gaSubmitBtn');

    progress.style.display = 'block';
    bar.style.width = '0%';
    status.textContent = 'Mengunggah...';
    status.style.color = '#6366f1';
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengunggah...';

    xhr.upload.addEventListener('progress', function(ev) {
        if (ev.lengthComputable) {
            const pct = Math.round((ev.loaded / ev.total) * 100);
            bar.style.width = pct + '%';
            status.textContent = 'Mengunggah... ' + pct + '%';
        }
    });

    xhr.addEventListener('load', function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Ikuti redirect dari Laravel
            const redirectUrl = xhr.responseURL || '{{ route("galeri-arsip.index") }}';
            window.location.href = redirectUrl;
        } else {
            bar.style.width = '0%';
            progress.style.display = 'none';
            status.textContent = 'Gagal mengunggah. Coba lagi.';
            status.style.color = '#ef4444';
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.dataset.origText || 'Simpan Arsip';
        }
    });

    xhr.addEventListener('error', function() {
        bar.style.width = '0%';
        progress.style.display = 'none';
        status.textContent = 'Koneksi gagal. Coba lagi.';
        status.style.color = '#ef4444';
        submitBtn.disabled = false;
        submitBtn.textContent = submitBtn.dataset.origText || 'Simpan Arsip';
    });

    // simpan teks asli tombol
    submitBtn.dataset.origText = submitBtn.textContent;
    xhr.open('POST', form.action);
    xhr.send(formData);
});

// Auto-detect durasi video saat file dipilih
document.getElementById('gaFile').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const isVideo = file.type.startsWith('video/');
    const durasiWrap = document.getElementById('gaDurasiWrap');

    if (isVideo && durasiWrap.style.display !== 'none') {
        const url = URL.createObjectURL(file);
        const video = document.createElement('video');
        video.preload = 'metadata';
        video.src = url;

        const display = document.getElementById('gaDurasiDisplay');
        const hidden  = document.getElementById('gaDurasi');
        const info    = document.getElementById('gaDurasiInfo');

        display.placeholder = 'Membaca durasi...';
        info.textContent = 'Sedang membaca durasi video...';
        info.style.color = '#6366f1';

        video.onloadedmetadata = function() {
            URL.revokeObjectURL(url);
            const totalDetik = Math.round(video.duration);
            const jam    = Math.floor(totalDetik / 3600);
            const menit  = Math.floor((totalDetik % 3600) / 60);
            const detik  = totalDetik % 60;

            let formatted = '';
            if (jam > 0) {
                formatted = jam + ' jam ' + String(menit).padStart(2,'0') + ' menit ' + String(detik).padStart(2,'0') + ' detik';
            } else if (menit > 0) {
                formatted = menit + ' menit ' + String(detik).padStart(2,'0') + ' detik';
            } else {
                formatted = detik + ' detik';
            }

            display.value = formatted;
            hidden.value  = totalDetik;
            display.placeholder = '';
            info.textContent = '\u2713 Durasi terdeteksi otomatis dari file video.';
            info.style.color = '#10b981';
        };

        video.onerror = function() {
            URL.revokeObjectURL(url);
            display.value = '';
            hidden.value  = '';
            display.placeholder = 'Gagal membaca durasi, pilih file lain.';
            info.textContent = 'Tidak dapat membaca durasi. Pastikan file video valid.';
            info.style.color = '#ef4444';
        };
    }
});
// ===== EXPORT REKAP NOTULENSI MODAL =====
function openExportModal() {
    const m = document.getElementById('exportNotulensiModal');
    if (m) m.style.display = 'flex';
}
function closeExportModal() {
    const m = document.getElementById('exportNotulensiModal');
    if (m) m.style.display = 'none';
}

// ===== LOAD THUMBNAILS via fetch JSON → base64 data URI (bypass IDM sepenuhnya) =====
// IDM mencegat Content-Type: image/* dan video/* tetapi TIDAK PERNAH mencegat application/json
function loadThumbnails() {
    document.querySelectorAll('.ga-thumb-bg[data-thumb]').forEach(function(el) {
        const url = el.getAttribute('data-thumb');
        if (!url) return;
        // fetch JSON — Content-Type: application/json, IDM tidak mencegat
        fetch(url, {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(json) {
            if (json && json.data) {
                el.style.backgroundImage = "url('" + json.data + "')";
            }
        })
        .catch(function() {
            el.classList.add('ga-thumb-error');
        });
    });
}
document.addEventListener('DOMContentLoaded', function() {
    loadThumbnails();
    
    // Auto open modal jika ada parameter action=upload
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'upload') {
        const tipe = urlParams.get('tab') || 'foto';
        openGaleriModal(tipe);
    }
});
</script>
@endpush
