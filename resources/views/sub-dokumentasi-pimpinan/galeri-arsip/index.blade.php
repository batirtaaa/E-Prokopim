@extends('layouts.app')
@section('title', 'Galeri Arsip Dokumentasi Pimpinan')

@push('styles')
<style>
/* Page Header */
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

/* Toolbar: Tabs + Filter buttons */
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
            Unggah Arsip Baru
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
<div class="ga-toolbar-wrap">
    <div class="ga-tabs">
        <a href="{{ route('galeri-arsip.index', ['tab' => 'semua']) }}" class="ga-tab {{ $tab === 'semua' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('galeri-arsip.index', ['tab' => 'foto']) }}"  class="ga-tab {{ $tab === 'foto' ? 'active' : '' }}">Foto</a>
        <a href="{{ route('galeri-arsip.index', ['tab' => 'video']) }}" class="ga-tab {{ $tab === 'video' ? 'active' : '' }}">Video</a>
        <a href="{{ route('galeri-arsip.index', ['tab' => 'notulensi']) }}" class="ga-tab {{ $tab === 'notulensi' ? 'active' : '' }}">Notulensi</a>
    </div>
    <div class="ga-toolbar-right">
        <button type="button" class="ga-btn-action">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Filter
        </button>
        <button type="button" class="ga-btn-action">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25"/></svg>
            Terbaru
        </button>
    </div>
</div>

{{-- Grid --}}
<div class="ga-grid">
    @forelse($items as $item)
    <div class="ga-card">
        {{-- Thumbnail - klik untuk preview --}}
        <div class="ga-thumb" onclick="openViewer(
            '{{ $item->tipe }}',
            {{ $item->id }},
            '{{ addslashes($item->judul) }}',
            '{{ addslashes($item->file_name ?? '') }}'
        )">
            @if($item->file_path)
                @if(Str::endsWith($item->file_path, ['.mp4', '.mov']))
                    {{-- Video: placeholder gelap + ikon, tanpa <video src> agar IDM tidak mencegat --}}
                    <div class="ga-thumb-placeholder ga-video-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                    </div>
                @else
                    {{-- Foto: URL disimpan di data attribute, dimuat via JS fetch() → Blob URL --}}
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
                <span class="ga-date">{{ $item->tanggal_kegiatan ? $item->tanggal_kegiatan->format('d M Y') : '—' }}</span>
            </div>
            <div class="ga-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
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
                            Unduh File
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
            <a id="viewerDocDownload" href="#" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Unduh
            </a>
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
                <div class="form-g">
                    <label class="form-lbl">Judul Arsip <span class="req">*</span></label>
                    <input type="text" class="form-inp" name="judul" id="gaJudul" placeholder="Contoh: Peresmian Taman Kota..." required>
                </div>
                <div class="form-g">
                    <label class="form-lbl">Tipe <span class="req">*</span></label>
                    <select class="form-sel" name="tipe" id="gaTipe" required onchange="toggleExtraFields()">
                        <option value="foto">Foto</option>
                        <option value="video">Video</option>
                        <option value="notulensi">Notulensi</option>
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
                    <label class="form-lbl" id="gaKeteranganLabel">Keterangan</label>
                    <textarea class="form-txa" name="keterangan" id="gaKeterangan" placeholder="Keterangan singkat mengenai arsip..."></textarea>
                </div>
                <div class="form-g">
                    <label class="form-lbl">File Arsip (.jpg, .png, .mp4, .pdf, .docx)</label>
                    <input type="file" class="form-inp" name="file_arsip" id="gaFile" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.pdf,.doc,.docx">
                    <div id="gaUploadProgress"><div id="gaUploadBar"></div></div>
                    <div id="gaUploadStatus" style="font-size:11.5px;color:#9ca3af;margin-top:4px">Maksimal 150MB</div>
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
    document.getElementById('galeriModalTitle').textContent = 'Unggah Arsip Baru';
    document.getElementById('gaSubmitBtn').textContent = 'Simpan Arsip';
    document.getElementById('gaSubmitBtn').disabled = false;
    document.getElementById('gaUploadProgress').style.display = 'none';
    document.getElementById('gaUploadBar').style.width = '0%';
    document.getElementById('gaUploadStatus').textContent = 'Maksimal 150MB';
    document.getElementById('gaUploadStatus').style.color = '#9ca3af';
    if (defaultTipe) document.getElementById('gaTipe').value = defaultTipe;
    document.getElementById('gaTanggal').value = new Date().toISOString().split('T')[0];
    toggleExtraFields();
    document.getElementById('galeriModal').style.display = 'flex';
}

function editGaleri(item) {
    document.getElementById('galeriForm').reset();
    document.getElementById('galeriForm').action = '/dokumentasi-pimpinan/galeri-arsip/' + item.id;
    document.getElementById('galeriMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('galeriModalTitle').textContent = 'Edit Data Arsip';
    document.getElementById('gaSubmitBtn').textContent = 'Perbarui Arsip';

    document.getElementById('gaJudul').value = item.judul || '';
    document.getElementById('gaTipe').value = item.tipe || 'foto';
    document.getElementById('gaTanggal').value = item.tanggal_kegiatan ? item.tanggal_kegiatan.split('T')[0] : '';
    document.getElementById('gaJumlahFoto').value = item.jumlah_foto || 1;
    document.getElementById('gaDurasi').value = item.durasi_detik || '';
    document.getElementById('gaKeterangan').value = item.keterangan || '';

    toggleExtraFields();
    document.getElementById('galeriModal').style.display = 'flex';
}

function toggleExtraFields() {
    const tipe = document.getElementById('gaTipe').value;
    document.getElementById('gaFotoCountWrap').style.display = (tipe === 'foto') ? '' : 'none';
    document.getElementById('gaDurasiWrap').style.display = (tipe === 'video') ? '' : 'none';

    const ketLabel = document.getElementById('gaKeteranganLabel');
    const ketInput = document.getElementById('gaKeterangan');
    if (ketLabel && ketInput) {
        if (tipe === 'notulensi') {
            ketLabel.textContent = 'Notulensi';
            ketInput.placeholder = 'Tuliskan catatan atau isi notulensi kegiatan...';
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

function openViewer(tipe, itemId, judul, fileName) {
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
document.addEventListener('DOMContentLoaded', loadThumbnails);
</script>
@endpush
