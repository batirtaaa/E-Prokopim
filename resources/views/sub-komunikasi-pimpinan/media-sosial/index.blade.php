@extends('layouts.app')
@section('title', 'Arsip Media Sosial — Komunikasi Pimpinan')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:20px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }

.btn-upload-top {
    display:inline-flex; align-items:center; gap:7px;
    padding:10px 18px; font-size:13.5px; font-weight:600;
    border-radius:8px; background:#1e3a5f; color:white;
    border:none; cursor:pointer; text-decoration:none;
    transition:background 0.15s;
}
.btn-upload-top:hover { background:#162f4f; }
.btn-upload-top svg { width:15px; height:15px; }

/* Toolbar & Tabs */
.ms-toolbar-wrap {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px 0 0;
}
.ms-tabs {
    display: flex;
    gap: 8px;
    padding-left: 16px;
}
.ms-tab {
    padding: 14px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 2.5px solid transparent;
    transition: all 0.15s;
    margin-bottom: -1px;
}
.ms-tab:hover { color: #111827; }
.ms-tab.active {
    color: #111827;
    font-weight: 600;
    border-bottom-color: #1e3a5f;
}

.ms-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
}
.ms-search-wrap { position:relative; width:220px; }
.ms-search-wrap svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:#9ca3af; }
.ms-search-input {
    width:100%; padding:7px 12px 7px 32px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:12.5px; color:#374151; background:#f9fafb; outline:none;
}
.ms-search-input:focus { border-color:#2563eb; background:white; }
.ms-btn-filter {
    display:inline-flex; align-items:center; gap:6px;
    padding:7px 12px; border:1px solid #e5e7eb; border-radius:8px;
    background:white; font-size:12.5px; color:#374151;
    cursor:pointer; text-decoration:none; transition:all 0.15s;
}
.ms-btn-filter:hover { border-color:#2563eb; color:#2563eb; }
.ms-btn-filter svg { width:14px; height:14px; }

/* ============================================================
   FOLDER GRID — khusus tab Infografis
   ============================================================ */
.folder-section-title {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.folder-section-title svg { width:18px; height:18px; color:#1e3a5f; }

.folder-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}
@media (min-width: 1400px) { .folder-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1100px) { .folder-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .folder-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .folder-grid { grid-template-columns: 1fr; } }

.folder-card {
    background: white;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px 18px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s cubic-bezier(.4,0,.2,1);
    position: relative;
    overflow: hidden;
}
.folder-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1e3a5f, #3b82f6);
    opacity: 0;
    transition: opacity 0.18s;
}
.folder-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 24px -4px rgba(30,58,95,0.12);
    transform: translateY(-3px);
}
.folder-card:hover::before { opacity: 1; }

.folder-icon-wrap {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    position: relative;
}

/* Ikon kalender mini di dalam folder */
.folder-cal-icon {
    width: 48px;
    height: 48px;
    border: 2px solid;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.folder-cal-top {
    color: white;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.05em;
    text-align: center;
    padding: 4px 0 3px;
    text-transform: uppercase;
    flex-shrink: 0;
}
.folder-cal-year {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 800;
    background: white;
}

.folder-icon-wrap svg { width: 32px; height: 32px; }

.folder-name {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    line-height: 1.3;
}
.folder-count {
    font-size: 12px;
    color: #6b7280;
    background: #f1f5f9;
    padding: 2px 10px;
    border-radius: 20px;
}
.folder-count strong { color: #1e3a5f; }

/* Folder "Tambah Baru" */
.folder-card-add {
    background: #f8faff;
    border: 2px dashed #bfdbfe;
    border-radius: 14px;
    padding: 24px 18px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s;
    min-height: 160px;
    justify-content: center;
}
.folder-card-add:hover {
    border-color: #3b82f6;
    background: #eff6ff;
    transform: translateY(-3px);
}

/* ============================================================
   CARD GRID — videografis / media luar ruang
   ============================================================ */
.ms-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}
@media (max-width: 1200px) { .ms-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .ms-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .ms-grid { grid-template-columns: 1fr; } }

/* Media Card */
.ms-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.15s, box-shadow 0.15s;
}
.ms-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px -4px rgba(0,0,0,0.06);
}
.ms-card-thumb {
    position: relative;
    height: 160px;
    background: #f1f5f9;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #f1f5f9;
}
.ms-card-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ms-mock-preview {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px;
    position: relative;
}
.ms-platform-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #1e293b;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.ms-card-body {
    padding: 16px 18px 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ms-card-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 8px;
}
.ms-card-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ms-menu-btn {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 2px 4px;
    border-radius: 4px;
    position: relative;
}
.ms-menu-btn:hover { color: #374151; background: #f3f4f6; }
.ms-card-desc {
    font-size: 12.5px;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 14px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.ms-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f3f4f6;
    font-size: 12px;
}
.ms-date {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #6b7280;
    font-size: 12px;
}
.ms-date svg { width: 13px; height: 13px; color: #9ca3af; }

.ms-status-badge {
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
}
.ms-status-dipublikasi {
    background: #e0f2fe;
    color: #0284c7;
}
.ms-status-draft {
    background: #e2e8f0;
    color: #475569;
}
.ms-status-dijadwalkan {
    background: #fef3c7;
    color: #d97706;
}

/* "Tambah Desain Baru" Card */
.ms-card-add {
    background: #f0f7ff;
    border: 2px dashed #bfdbfe;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 32px 24px;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    min-height: 290px;
}
.ms-card-add:hover {
    border-color: #2563eb;
    background: #eff6ff;
    transform: translateY(-2px);
}
.ms-add-icon-wrap {
    width: 48px;
    height: 48px;
    background: #dbeafe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e3a5f;
    margin-bottom: 16px;
}
.ms-add-icon-wrap svg { width: 22px; height: 22px; }
.ms-add-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 6px;
}
.ms-add-sub {
    font-size: 12px;
    color: #64748b;
    line-height: 1.45;
    max-width: 180px;
}

/* Dropdown Menu */
.dropdown-menu-card {
    position: absolute;
    right: 0;
    top: 100%;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    z-index: 50;
    min-width: 130px;
    display: none;
    padding: 4px;
}
.dropdown-menu-card.show { display: block; }
.dropdown-menu-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 10px;
    font-size: 12.5px;
    color: #374151;
    text-decoration: none;
    border-radius: 6px;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}
.dropdown-menu-item:hover { background: #f3f4f6; }
.dropdown-menu-item.danger { color: #dc2626; }
.dropdown-menu-item.danger:hover { background: #fee2e2; }

/* Pagination */
.ms-pagination-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
    margin-top: 10px;
}
.ms-page-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: white;
    font-size: 13px;
    color: #6b7280;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.15s;
}
.ms-page-btn:hover { border-color: #2563eb; color: #2563eb; }
.ms-page-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; font-weight: 600; }
.ms-page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
    padding: 20px;
}
.modal-content {
    background: white;
    border-radius: 14px;
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
    animation: scaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes scaleIn {
    from { opacity:0; transform:scale(0.95); }
    to   { opacity:1; transform:scale(1); }
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid #e5e7eb;
}
.modal-header h3 { font-size: 16px; font-weight: 700; color: #111827; }
.modal-close { background: none; border: none; font-size: 20px; color: #9ca3af; cursor: pointer; }
.modal-close:hover { color: #111827; }
.modal-body { padding: 22px 24px; }
.form-group-m { margin-bottom: 16px; }
.form-label-m { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
.form-label-m .req { color: #ef4444; }
.form-input-m, .form-select-m, .form-textarea-m {
    width: 100%; padding: 8px 12px;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; color: #111827; background: white;
    outline: none; font-family: inherit;
}
.form-input-m:focus, .form-select-m:focus, .form-textarea-m:focus { border-color: #2563eb; }
.form-textarea-m { resize: vertical; min-height: 70px; }
.modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #f9fafb;
    border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;
}

/* Sub Kategori field */
#subKategoriWrapper { transition: all 0.2s; }
#lainnyaCustomWrapper { margin-top: 8px; }
</style>
@endpush

@section('content')

{{-- Flash Messages --}}
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
        <h1>Arsip Media Sosial</h1>
        <p>Kelola dan pantau publikasi infografis, videografis, dan media luar ruang.</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <a href="javascript:void(0)" onclick="openExportModal()" class="ms-btn-filter" style="border-color:#16a34a;color:#16a34a;gap:7px;font-weight:600;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:15px;height:15px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Download Rekap Excel
        </a>
    </div>
</div>

{{-- Modal Pilih Tahun Export --}}
<div id="exportModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; width:360px; max-width:92vw; box-shadow:0 20px 60px -10px rgba(0,0,0,0.25); overflow:hidden;">
        <div style="background:#1e3a5f; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                <span style="font-size:15px;font-weight:700;color:white;">Download Rekap Excel</span>
            </div>
            <button onclick="document.getElementById('exportModal').style.display='none'" style="background:none;border:none;color:white;cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div style="padding:24px;">
            <p style="font-size:13px;color:#6b7280;margin-bottom:16px;line-height:1.6;">
                File Excel akan berisi <strong>Rekap Per Bulan</strong> (ringkasan) dan <strong>Detail</strong> upload Infografis, Videografis, dan Media Luar Ruang untuk tahun yang dipilih.
            </p>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Pilih Tahun</label>
            <select id="exportTahunSelect" style="width:100%;padding:10px 14px;border:1.5px solid #d1d5db;border-radius:8px;font-size:14px;font-weight:600;color:#1e3a5f;background:#f8fafc;outline:none;">
                @foreach($availableYears ?? [now()->year] as $yr)
                    <option value="{{ $yr }}" {{ ($selectedTahun ?? now()->year) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
            <div style="margin-top:8px;font-size:11.5px;color:#9ca3af;">Format: Microsoft Excel (.xls) — dapat dibuka di Excel, LibreOffice, Google Sheets</div>
        </div>
        <div style="padding:0 24px 20px;display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="document.getElementById('exportModal').style.display='none'" style="padding:9px 18px;border:1.5px solid #e5e7eb;border-radius:8px;background:white;font-size:13px;color:#374151;cursor:pointer;font-weight:500;">Batal</button>
            <a id="exportDownloadBtn" href="#" onclick="doExport()" style="padding:9px 22px;background:#16a34a;color:white;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;cursor:pointer;border:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Download
            </a>
        </div>
    </div>
</div>

{{-- Tabs & Toolbar --}}
<div class="ms-toolbar-wrap">
    <div class="ms-tabs">
        <a href="{{ route('media-sosial.index', ['tab' => 'infografis', 'tahun' => $selectedTahun ?? now()->year]) }}" class="ms-tab {{ $tab === 'infografis' ? 'active' : '' }}">Infografis</a>
        <a href="{{ route('media-sosial.index', ['tab' => 'videografis', 'tahun' => $selectedTahun ?? now()->year]) }}" class="ms-tab {{ $tab === 'videografis' ? 'active' : '' }}">Videografis</a>
        <a href="{{ route('media-sosial.index', ['tab' => 'media_luar_ruang', 'tahun' => $selectedTahun ?? now()->year]) }}" class="ms-tab {{ $tab === 'media_luar_ruang' ? 'active' : '' }}">Media Luar Ruang</a>
    </div>

    {{-- Filter Tahun di Toolbar — sama untuk semua tab --}}
    <div class="ms-toolbar-right" style="padding-right: 12px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:12.5px; font-weight:600; color:#64748b; display:flex; align-items:center; gap:5px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:15px;height:15px;color:#1e3a5f"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Tahun:
            </span>
            <select onchange="window.location.href='{{ route('media-sosial.index') }}?tab={{ $tab }}&tahun=' + this.value"
                    style="padding:6px 14px; font-size:13px; font-weight:700; border-radius:8px; border:1.5px solid #cbd5e1; background:#f8fafc; color:#1e3a5f; cursor:pointer; outline:none; transition:all 0.15s;">
                @foreach($availableYears ?? [now()->year] as $yr)
                    <option value="{{ $yr }}" {{ ($selectedTahun ?? now()->year) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- ============================================================
     SEMUA TAB → Tampilan Folder 12 Bulan (konsisten)
     ============================================================ --}}
@if(true)



<div class="folder-grid">
    @foreach($folders as $folder)
    @php
        // Warna folder berputar menggunakan indeks
        $colorSchemes = [
            ['bg' => '#eff6ff', 'accent' => '#2563eb', 'top' => '#3b82f6'],
            ['bg' => '#f0fdf4', 'accent' => '#16a34a', 'top' => '#22c55e'],
            ['bg' => '#fef3c7', 'accent' => '#d97706', 'top' => '#f59e0b'],
            ['bg' => '#fdf4ff', 'accent' => '#9333ea', 'top' => '#a855f7'],
            ['bg' => '#fff1f2', 'accent' => '#e11d48', 'top' => '#f43f5e'],
            ['bg' => '#ecfdf5', 'accent' => '#059669', 'top' => '#10b981'],
        ];
        $cs = $colorSchemes[($folder['bulan'] - 1) % count($colorSchemes)];
        $namaBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agt',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    @endphp
    <a href="{{ route('media-sosial.folder', [$tab, $folder['tahun'], str_pad($folder['bulan'], 2, '0', STR_PAD_LEFT)]) }}"
       class="folder-card" style="--folder-accent:{{ $cs['accent'] }}">
        {{-- Icon Kalender dengan angka bulan --}}
        <div class="folder-icon-wrap" style="background:{{ $cs['bg'] }}">
            <div class="folder-cal-icon" style="border-color:{{ $cs['accent'] }}">
                <div class="folder-cal-top" style="background:{{ $cs['top'] }}">
                    {{ $namaBulan[$folder['bulan']] ?? '' }}
                </div>
                <div class="folder-cal-year" style="color:{{ $cs['accent'] }}">
                    {{ $folder['tahun'] }}
                </div>
            </div>
        </div>
        <div class="folder-name">{{ $folder['label'] }}</div>
        @if($folder['total'] > 0)
        <div class="folder-count" style="background:#dbeafe; color:#1e40af; font-weight:700; border:1px solid #bfdbfe;">
            <strong>{{ $folder['total'] }}</strong> file
        </div>
        @else
        <div class="folder-count"><strong>0</strong> file</div>
        @endif
    </a>
    @endforeach
</div>


@endif {{-- end @if(true) --}}



{{-- ============================================================
     Upload / Create Modal
     ============================================================ --}}
<div id="uploadModal" class="modal-overlay" style="display:none">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">
                @if($tab === 'infografis') Upload Infografis Baru
                @elseif($tab === 'videografis') Upload Videografis Baru
                @else Upload Media Luar Ruang Baru @endif
            </h3>
            <button type="button" class="modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <form id="mediaForm" method="POST" action="{{ route('media-sosial.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            <input type="hidden" name="kategori" id="inputKategori" value="{{ $tab }}">
            <div class="modal-body">
                <div class="form-group-m">
                    <label class="form-label-m">Judul Media <span class="req">*</span></label>
                    <input type="text" class="form-input-m" name="judul" id="inputJudul" placeholder="Contoh: Capaian Kinerja Triwulan III..." required>
                </div>

                @if($tab === 'infografis')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group-m">
                        <label class="form-label-m">Kategori Infografis <span class="req">*</span></label>
                        <select class="form-select-m" name="sub_kategori" id="inputSubKategori" onchange="onSubKategoriChange(this.value)" required>
                            <option value="hari_besar">Hari Besar</option>
                            <option value="obituary">Obituary</option>
                            <option value="kamis_nyunda">Kamis Nyunda</option>
                            <option value="giat_pimpinan">Giat Pimpinan</option>
                            <option value="lainnya_custom">Dan Lainnya (Ketik Manual)</option>
                        </select>
                        {{-- Input teks bebas untuk "Dan Lainnya" --}}
                        <div id="lainnyaCustomWrapper" style="display:none; margin-top:8px">
                            <input type="text" class="form-input-m" name="sub_kategori_custom" id="inputSubKategoriCustom"
                                   placeholder="Ketik kategori infografis..." maxlength="100">
                        </div>
                    </div>
                    <div class="form-group-m">
                        <label class="form-label-m">Platform Media Sosial <span class="req">*</span></label>
                        <select class="form-select-m" name="platform" id="inputPlatform" onchange="onPlatformChange(this.value)" required>
                            <option value="instagram">Instagram</option>
                            <option value="facebook">Facebook</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                            <option value="x_twitter">X (Twitter)</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <div id="platformCustomWrapper" style="display:none; margin-top:8px">
                            <input type="text" class="form-input-m" name="platform_custom" id="inputPlatformCustom"
                                   placeholder="Ketik nama platform..." maxlength="100">
                        </div>
                    </div>
                </div>
                @elseif($tab === 'videografis')
                <div class="form-group-m">
                    <label class="form-label-m">Platform Media Sosial <span class="req">*</span></label>
                    <select class="form-select-m" name="platform" id="inputPlatform" onchange="onPlatformChange(this.value)" required>
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="tiktok">TikTok</option>
                        <option value="youtube">YouTube</option>
                        <option value="x_twitter">X (Twitter)</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                    <div id="platformCustomWrapper" style="display:none; margin-top:8px">
                        <input type="text" class="form-input-m" name="platform_custom" id="inputPlatformCustom"
                               placeholder="Ketik nama platform..." maxlength="100">
                    </div>
                </div>
                @else
                <div class="form-group-m">
                    <label class="form-label-m">Media Luar Ruang <span class="req">*</span></label>
                    <select class="form-select-m" name="platform" id="inputPlatform" onchange="onPlatformChange(this.value)" required>
                        <option value="billboard">Billboard</option>
                        <option value="videotron">Videotron</option>
                        <option value="baliho">Baliho</option>
                        <option value="spanduk">Spanduk / Banner</option>
                        <option value="lainnya">Lainnya (Ketik Manual)</option>
                    </select>
                    <div id="platformCustomWrapper" style="display:none; margin-top:8px">
                        <input type="text" class="form-input-m" name="platform_custom" id="inputPlatformCustom"
                               placeholder="Ketik jenis media luar ruang..." maxlength="100">
                    </div>
                </div>
                @endif

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group-m">
                        <label class="form-label-m">Tanggal Publikasi <span class="req">*</span></label>
                        <input type="date" class="form-input-m" name="tanggal_publikasi" id="inputTanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group-m">
                        <label class="form-label-m">Status <span class="req">*</span></label>
                        <select class="form-select-m" name="status" id="inputStatus" required>
                            <option value="dipublikasi">Dipublikasi</option>
                            <option value="draft">Draft</option>
                            <option value="dijadwalkan">Dijadwalkan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">Deskripsi Singkat</label>
                    <textarea class="form-textarea-m" name="deskripsi" id="inputDeskripsi" placeholder="Ringkasan singkat mengenai konten media..."></textarea>
                </div>
                @if($tab !== 'media_luar_ruang')
                <div class="form-group-m" id="linkPostWrapper">
                    <label class="form-label-m">Link / URL Postingan</label>
                    <input type="url" class="form-input-m" name="link_post" id="inputLinkPost" placeholder="Contoh: https://www.instagram.com/p/...">
                </div>
                @endif
                <div class="form-group-m">
                    <label class="form-label-m">File Media (.jpg, .png, .pdf, .mp4)</label>
                    <input type="file" class="form-input-m" name="file_media" id="inputFileMedia" accept=".jpg,.jpeg,.png,.webp,.pdf,.mp4">
                    <div id="fileHelpText" style="font-size:11.5px;color:#9ca3af;margin-top:4px">Maksimal ukuran file: 25MB</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ms-btn-filter" onclick="closeModal('uploadModal')">Batal</button>
                <button type="submit" class="btn-upload-top" id="btnSubmitModal">Simpan Media</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleCardMenu(event, menuId) {
    event.stopPropagation();
    document.querySelectorAll('.dropdown-menu-card').forEach(m => {
        if (m.id !== menuId) m.classList.remove('show');
    });
    const menu = document.getElementById(menuId);
    if (menu) menu.classList.toggle('show');
}

document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown-menu-card').forEach(m => m.classList.remove('show'));
});

function onSubKategoriChange(val) {
    const customWrap  = document.getElementById('lainnyaCustomWrapper');
    const customInput = document.getElementById('inputSubKategoriCustom');
    if (customWrap && customInput) {
        if (val === 'lainnya_custom') {
            customWrap.style.display = '';
            customInput.required = true;
        } else {
            customWrap.style.display = 'none';
            customInput.required = false;
        }
    }
}

function onPlatformChange(val) {
    const wrapper = document.getElementById('platformCustomWrapper');
    const input   = document.getElementById('inputPlatformCustom');
    if (wrapper && input) {
        if (val === 'lainnya') {
            wrapper.style.display = '';
            input.required = true;
            input.focus();
        } else {
            wrapper.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }
}

function openUploadModal(defaultKategori) {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "{{ route('media-sosial.store') }}";
    document.getElementById('methodField').innerHTML = '';
    
    const kat = defaultKategori || '{{ $tab }}';
    document.getElementById('inputKategori').value = kat;
    
    if (kat === 'infografis') {
        document.getElementById('modalTitle').textContent = 'Upload Infografis Baru';
    } else if (kat === 'videografis') {
        document.getElementById('modalTitle').textContent = 'Upload Videografis Baru';
    } else {
        document.getElementById('modalTitle').textContent = 'Upload Media Luar Ruang Baru';
    }
    
    document.getElementById('btnSubmitModal').textContent = 'Simpan Media';
    document.getElementById('inputTanggal').value = "{{ date('Y-m-d') }}";
    
    if (document.getElementById('inputLinkPost')) {
        document.getElementById('inputLinkPost').value = '';
    }
    
    const subKatSelect = document.getElementById('inputSubKategori');
    if (subKatSelect) {
        subKatSelect.value = 'hari_besar';
        onSubKategoriChange('hari_besar');
    }

    if (document.getElementById('platformCustomWrapper')) {
        document.getElementById('platformCustomWrapper').style.display = 'none';
    }
    if (document.getElementById('inputPlatformCustom')) {
        document.getElementById('inputPlatformCustom').value = '';
        document.getElementById('inputPlatformCustom').required = false;
    }
    
    document.getElementById('uploadModal').style.display = 'flex';
}

function editMedia(item) {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "/komunikasi-pimpinan/media-sosial/" + item.id;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('modalTitle').textContent = 'Edit Data Media';
    document.getElementById('btnSubmitModal').textContent = 'Perbarui Media';

    document.getElementById('inputJudul').value    = item.judul || '';
    document.getElementById('inputKategori').value = item.kategori || '{{ $tab }}';
    // Set platform, handle custom
    const knownPlatforms = ['instagram','facebook','tiktok','youtube','x_twitter','billboard','videotron','baliho','spanduk'];
    const platVal = item.platform || 'instagram';
    const platSelect = document.getElementById('inputPlatform');
    const platCustom = document.getElementById('inputPlatformCustom');
    if (knownPlatforms.includes(platVal)) {
        if (platSelect) platSelect.value = platVal;
        onPlatformChange(platVal);
    } else {
        if (platSelect) platSelect.value = 'lainnya';
        onPlatformChange('lainnya');
        if (platCustom) platCustom.value = platVal;
    }
    document.getElementById('inputTanggal').value  = item.tanggal_publikasi ? item.tanggal_publikasi.split('T')[0] : '';
    document.getElementById('inputStatus').value   = item.status || 'dipublikasi';
    document.getElementById('inputDeskripsi').value = item.deskripsi || '';
    if (document.getElementById('inputLinkPost')) {
        document.getElementById('inputLinkPost').value = item.link_post || '';
    }

    // Set sub_kategori jika ada
    const subKatSelect = document.getElementById('inputSubKategori');
    if (subKatSelect && item.kategori === 'infografis') {
        const knownKeys = ['hari_besar', 'obituary', 'kamis_nyunda', 'giat_pimpinan'];
        const sub = item.sub_kategori || '';
        if (knownKeys.includes(sub)) {
            subKatSelect.value = sub;
            onSubKategoriChange(sub);
        } else if (sub) {
            subKatSelect.value = 'lainnya_custom';
            onSubKategoriChange('lainnya_custom');
            const customInp = document.getElementById('inputSubKategoriCustom');
            if (customInp) customInp.value = sub;
        } else {
            subKatSelect.value = 'hari_besar';
            onSubKategoriChange('hari_besar');
        }
    }

    document.getElementById('uploadModal').style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}

function openExportModal() {
    document.getElementById('exportModal').style.display = 'flex';
}

function doExport() {
    const tahun = document.getElementById('exportTahunSelect').value;
    const url = '{{ route("media-sosial.export-rekap") }}?tahun=' + tahun;
    window.location.href = url;
    document.getElementById('exportModal').style.display = 'none';
}
</script>
@endpush
