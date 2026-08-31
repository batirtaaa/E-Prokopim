@extends('layouts.app')
@section('title', "Infografis — {$folderLabel} — Arsip Media Sosial")

@push('styles')
<style>
/* ============================================================
   BREADCRUMB
   ============================================================ */
.folder-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.folder-breadcrumb a { color: #1e3a5f; text-decoration: none; font-weight: 500; transition: color 0.15s; }
.folder-breadcrumb a:hover { color: #2563eb; }
.folder-breadcrumb .sep { color: #d1d5db; font-size: 14px; }
.folder-breadcrumb .current { color: #111827; font-weight: 600; }

/* ============================================================
   FOLDER HEADER
   ============================================================ */
.folder-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
}
.folder-header-left { display: flex; align-items: center; gap: 16px; }

/* Mini kalender header */
.folder-header-cal {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border: 2px solid #3b82f6;
    flex-shrink: 0;
}
.folder-header-cal-top {
    background: #2563eb;
    color: white;
    font-size: 12px;
    font-weight: 800;
    text-align: center;
    padding: 5px 0 4px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.folder-header-cal-year {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    color: #2563eb;
    background: #eff6ff;
}

.folder-header-info h1 { font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 4px; }
.folder-header-info p  { font-size: 13px; color: #6b7280; }

.btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 16px; border: 1px solid #e5e7eb; border-radius: 8px;
    background: white; font-size: 13px; color: #374151; text-decoration: none;
    transition: all 0.15s; font-weight: 500; white-space: nowrap;
}
.btn-back:hover { border-color: #1e3a5f; color: #1e3a5f; background: #f8faff; }
.btn-back svg { width: 15px; height: 15px; }

.btn-upload-top {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; font-size: 13.5px; font-weight: 600;
    border-radius: 8px; background: #1e3a5f; color: white;
    border: none; cursor: pointer; text-decoration: none;
    transition: background 0.15s; white-space: nowrap;
}
.btn-upload-top:hover { background: #162f4f; }
.btn-upload-top svg { width: 15px; height: 15px; }

/* ============================================================
   SEARCH & FILTER BAR
   ============================================================ */
.folder-search-bar {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 16px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.folder-search-wrap { flex: 1; min-width: 200px; position: relative; }
.folder-search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px; height: 15px; color: #9ca3af;
}
.folder-search-input {
    width: 100%; padding: 8px 12px 8px 36px;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; color: #374151; background: #f9fafb;
    outline: none; transition: all 0.15s;
}
.folder-search-input:focus { border-color: #2563eb; background: white; }
.folder-search-input::placeholder { color: #9ca3af; }

.folder-filter-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border: 1px solid #e5e7eb; border-radius: 8px;
    background: white; font-size: 12.5px; color: #374151;
    cursor: pointer; text-decoration: none; transition: all 0.15s;
    white-space: nowrap;
}
.folder-filter-btn:hover { border-color: #2563eb; color: #2563eb; }
.folder-filter-btn svg { width: 14px; height: 14px; }
.folder-filter-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; }

/* Filter kategori badge buttons */
.kategori-filter-wrap {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.kat-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border: 1px solid #e5e7eb; border-radius: 20px;
    background: white; font-size: 12px; color: #374151;
    cursor: pointer; text-decoration: none; transition: all 0.15s;
    font-weight: 500;
}
.kat-btn:hover { border-color: #1e3a5f; color: #1e3a5f; }
.kat-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; }
.kat-btn-dot { width: 7px; height: 7px; border-radius: 50%; }

/* ============================================================
   GRID FILE
   ============================================================ */
.file-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 30px;
}
@media (max-width: 1200px) { .file-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .file-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .file-grid { grid-template-columns: 1fr; } }

.file-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: visible;
    display: flex;
    flex-direction: column;
    transition: transform 0.15s, box-shadow 0.15s;
    position: relative;
}
.file-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px -4px rgba(0,0,0,0.08);
}

.file-thumb {
    position: relative;
    height: 160px;
    background: #f1f5f9;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 12px 12px 0 0;
}
.file-thumb img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.2s;
}
.file-card:hover .file-thumb img { transform: scale(1.03); }

.file-thumb-empty {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
}
.file-thumb-empty svg { width: 40px; height: 40px; color: #94a3b8; }
.file-thumb-empty span { font-size: 11px; font-weight: 600; color: #64748b; letter-spacing: 0.05em; }

.file-platform-badge {
    position: absolute; top: 8px; right: 8px;
    background: rgba(30,41,59,0.85); backdrop-filter: blur(4px);
    color: white; font-size: 9.5px; font-weight: 700;
    padding: 3px 7px; border-radius: 4px;
    letter-spacing: 0.06em; text-transform: uppercase;
}

/* Kategori badge — pojok kiri bawah thumbnail */
.file-kat-badge {
    position: absolute; bottom: 8px; left: 8px;
    font-size: 10px; font-weight: 700;
    padding: 3px 8px; border-radius: 10px;
    letter-spacing: 0.03em;
}
.kat-hari-besar  { background: #fef3c7; color: #b45309; }
.kat-obituary    { background: #f3f4f6; color: #374151; }
.kat-kamis-nyunda{ background: #dcfce7; color: #15803d; }
.kat-giat-pimpinan{ background: #dbeafe; color: #1d4ed8; }
.kat-lainnya     { background: #f5f3ff; color: #6d28d9; }

.file-date-badge {
    position: absolute; bottom: 8px; right: 8px;
    background: rgba(255,255,255,0.92); backdrop-filter: blur(4px);
    color: #374151; font-size: 11px; font-weight: 600;
    padding: 3px 8px; border-radius: 4px;
    display: flex; align-items: center; gap: 4px;
}
.file-date-badge svg { width: 10px; height: 10px; color: #6b7280; }

.file-body { padding: 14px 16px 12px; flex: 1; display: flex; flex-direction: column; border-radius: 0 0 12px 12px; background: white; }
.file-header-row {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 8px; margin-bottom: 6px;
}
.file-title {
    font-size: 13.5px; font-weight: 700; color: #111827; line-height: 1.35;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.file-desc {
    font-size: 12px; color: #6b7280; line-height: 1.5; flex: 1;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; margin-bottom: 12px;
}
.file-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 10px; border-top: 1px solid #f3f4f6;
}
.file-status-badge {
    padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;
}
.status-dipublikasi { background: #e0f2fe; color: #0284c7; }
.status-draft       { background: #e2e8f0; color: #475569; }
.status-dijadwalkan { background: #fef3c7; color: #d97706; }

/* Dropdown */
.dropdown-menu-card {
    position: absolute; right: 0; top: calc(100% + 4px);
    background: white; border: 1px solid #e5e7eb;
    border-radius: 8px; box-shadow: 0 10px 25px -3px rgba(0,0,0,0.15);
    z-index: 999; min-width: 140px; display: none; padding: 4px;
}
.dropdown-menu-card.show { display: block; }
.dropdown-menu-item {
    display: flex; align-items: center; gap: 8px; padding: 7px 10px;
    font-size: 12.5px; color: #374151; text-decoration: none; border-radius: 6px;
    border: none; background: none; width: 100%; text-align: left; cursor: pointer;
}
.dropdown-menu-item:hover { background: #f3f4f6; }
.dropdown-menu-item.danger { color: #dc2626; }
.dropdown-menu-item.danger:hover { background: #fee2e2; }
.ms-menu-btn {
    background: none; border: none; color: #9ca3af;
    cursor: pointer; padding: 2px 4px; border-radius: 4px; position: relative;
}
.ms-menu-btn:hover { color: #374151; background: #f3f4f6; }

/* Empty State */
.empty-state {
    text-align: center; padding: 60px 24px;
    background: white; border: 1.5px dashed #e5e7eb;
    border-radius: 16px; margin-bottom: 24px;
}
.empty-state-icon {
    width: 72px; height: 72px; background: #f1f5f9; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; color: #94a3b8;
}
.empty-state-icon svg { width: 36px; height: 36px; }
.empty-state h3 { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 8px; }
.empty-state p  { font-size: 13px; color: #6b7280; margin-bottom: 20px; }

/* Pagination */
.ms-pagination-wrap {
    display: flex; justify-content: center; align-items: center;
    gap: 4px; margin-top: 10px;
}
.ms-page-btn {
    min-width: 32px; height: 32px; padding: 0 8px;
    border: 1px solid #e5e7eb; border-radius: 6px;
    background: white; font-size: 13px; color: #6b7280; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; transition: all 0.15s;
}
.ms-page-btn:hover { border-color: #2563eb; color: #2563eb; }
.ms-page-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; font-weight: 600; }
.ms-page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

/* Modal */
.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(15,23,42,0.6); z-index: 9999; display: none;
    align-items: center; justify-content: center; backdrop-filter: blur(2px); padding: 20px;
}
.modal-content {
    background: white; border-radius: 14px; width: 100%;
    max-width: 540px; max-height: 90vh; overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
    animation: scaleIn 0.2s cubic-bezier(0.16,1,0.3,1);
}
@keyframes scaleIn { from{opacity:0;transform:scale(0.95)} to{opacity:1;transform:scale(1)} }
.modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px; border-bottom: 1px solid #e5e7eb;
}
.modal-header h3 { font-size: 16px; font-weight: 700; color: #111827; }
.modal-close { background: none; border: none; font-size: 20px; color: #9ca3af; cursor: pointer; }
.modal-close:hover { color: #111827; }
.modal-body { padding: 22px 24px; }
.form-group-m { margin-bottom: 16px; }
.form-label-m { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
.form-label-m .req { color: #ef4444; }
.form-input-m, .form-select-m, .form-textarea-m {
    width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; color: #111827; background: white; outline: none; font-family: inherit;
}
.form-input-m:focus, .form-select-m:focus, .form-textarea-m:focus { border-color: #2563eb; }
.form-textarea-m { resize: vertical; min-height: 70px; }
.modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #f9fafb;
    border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;
}
</style>
@endpush

@section('content')

@php
    $namaBulanFull = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                      7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    $namaBulanShort= [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
                      7=>'Jul',8=>'Agt',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    // Warna kategori badge
    $katBadgeClass = [
        'hari_besar'    => 'kat-hari-besar',
        'obituary'      => 'kat-obituary',
        'kamis_nyunda'  => 'kat-kamis-nyunda',
        'giat_pimpinan' => 'kat-giat-pimpinan',
    ];
    $katColorDot = [
        'hari_besar'    => '#d97706',
        'obituary'      => '#6b7280',
        'kamis_nyunda'  => '#16a34a',
        'giat_pimpinan' => '#2563eb',
        'lainnya'       => '#7c3aed',
    ];
@endphp

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

{{-- Breadcrumb --}}
<div class="folder-breadcrumb">
    <a href="{{ route('media-sosial.index', ['tab' => 'infografis', 'tahun' => $tahun]) }}">Arsip Media Sosial</a>
    <span class="sep">/</span>
    <a href="{{ route('media-sosial.index', ['tab' => 'infografis', 'tahun' => $tahun]) }}">Infografis ({{ $tahun }})</a>
    <span class="sep">/</span>
    <span class="current">{{ $folderLabel }}</span>
</div>

{{-- Folder Header --}}
<div class="folder-header-row">
    <div class="folder-header-left">
        {{-- Mini Kalender --}}
        <div class="folder-header-cal">
            <div class="folder-header-cal-top">{{ $namaBulanShort[$bulan] ?? '' }}</div>
            <div class="folder-header-cal-year">{{ $tahun }}</div>
        </div>
        <div class="folder-header-info">
            <h1>{{ $folderLabel }}</h1>
            <p>
                <strong style="color:#1e3a5f">{{ $items->total() }}</strong> infografis ditemukan
                @if(request('search'))
                    &mdash; pencarian "<em>{{ request('search') }}</em>"
                @endif
                @if(request('kat'))
                    &mdash; kategori "<em>{{ $subKategoriList[request('kat')] ?? request('kat') }}</em>"
                @endif
            </p>
        </div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;align-items:center;">
        <a href="{{ route('media-sosial.export-rekap', ['tahun' => $tahun]) }}" class="btn-back" style="border-color:#16a34a;color:#16a34a;gap:7px;font-weight:600;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:15px;height:15px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Rekap Excel ({{ $tahun }})
        </a>
        <a href="{{ route('media-sosial.index', ['tab' => 'infografis', 'tahun' => $tahun]) }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Semua Bulan ({{ $tahun }})
        </a>
        @if(auth()->user()->isAdmin())
        <button type="button" onclick="document.getElementById('uploadModal').style.display='flex'" class="btn-upload-top">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Upload Media
        </button>
        @endif
    </div>
</div>

{{-- Search & Filter Bar --}}
<form method="GET" action="{{ route('media-sosial.folder', [$tahun, str_pad($bulan, 2, '0', STR_PAD_LEFT)]) }}" id="searchForm">
    <div class="folder-search-bar">
        <div class="folder-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" class="folder-search-input" name="search"
                   value="{{ request('search') }}"
                   id="searchInput"
                   placeholder="Cari judul atau tanggal (contoh: 17, Agustus, 17-08-2026)...">
        </div>
        @if(request('kat')) <input type="hidden" name="kat" value="{{ request('kat') }}"> @endif
        <button type="submit" class="folder-filter-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            Cari
        </button>

        {{-- Dropdown Pilih Bulan & Tahun --}}
        <div style="display:flex; align-items:center; gap:6px;">
            <div style="position:relative; display:flex; align-items:center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="position:absolute; left:10px; width:15px; height:15px; color:#1e3a5f; pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <select id="jumpBulanSelect" onchange="jumpToFolder()" class="folder-filter-btn" style="padding-left:32px; font-size:13px; font-weight:600; color:#1e3a5f; border-color:#cbd5e1; background:white; cursor:pointer; outline:none;" title="Pilih Bulan">
                    @foreach($namaBulanList ?? [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $mNum => $mName)
                        @php $padM = str_pad($mNum, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $padM }}" {{ (int)$bulan === (int)$mNum ? 'selected' : '' }}>
                            {{ $mName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <select id="jumpTahunSelect" onchange="jumpToFolder()" class="folder-filter-btn" style="font-size:13px; font-weight:600; color:#1e3a5f; border-color:#cbd5e1; background:white; cursor:pointer; outline:none;" title="Pilih Tahun">
                @foreach($availableYears ?? [now()->year] as $yr)
                    <option value="{{ $yr }}" {{ (int)$tahun === (int)$yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
            @if((int)$bulan !== (int)now()->month || (int)$tahun !== (int)now()->year)
            <a href="{{ route('media-sosial.folder', [now()->year, str_pad(now()->month, 2, '0', STR_PAD_LEFT)]) }}" class="folder-filter-btn" title="Pindah langsung ke Bulan Ini" style="color:#2563eb; border-color:#93c5fd; background:#eff6ff; font-weight:600;">
                Bulan Ini
            </a>
            @endif
        </div>

        @if(request('search') || request('kat'))
        <a href="{{ route('media-sosial.folder', [$tahun, str_pad($bulan, 2, '0', STR_PAD_LEFT)]) }}"
           class="folder-filter-btn" style="color:#ef4444;border-color:#fca5a5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </div>
</form>

{{-- Filter Kategori Chips --}}
<div class="kategori-filter-wrap">
    <a href="{{ route('media-sosial.folder', [$tahun, str_pad($bulan, 2, '0', STR_PAD_LEFT)]) }}{{ request('search') ? '?search='.urlencode(request('search')) : '' }}"
       class="kat-btn {{ !request('kat') ? 'active' : '' }}">
        Semua Kategori
    </a>
    @foreach($subKategoriList as $key => $label)
    @php $dotColor = $katColorDot[$key] ?? '#6b7280'; @endphp
    <a href="{{ route('media-sosial.folder', [$tahun, str_pad($bulan, 2, '0', STR_PAD_LEFT)]) }}?kat={{ $key }}{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
       class="kat-btn {{ request('kat') === $key ? 'active' : '' }}">
        <span class="kat-btn-dot" style="background:{{ $dotColor }}"></span>
        {{ $label }}
    </a>
    @endforeach
    <a href="{{ route('media-sosial.folder', [$tahun, str_pad($bulan, 2, '0', STR_PAD_LEFT)]) }}?kat=lainnya{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
       class="kat-btn {{ request('kat') === 'lainnya' ? 'active' : '' }}">
        <span class="kat-btn-dot" style="background:#7c3aed"></span>
        Lainnya
    </a>
</div>

{{-- File Grid --}}
@if($items->count() > 0)
<div class="file-grid">
    @foreach($items as $item)
    @php
        // Tentukan kelas badge kategori
        $badgeClass = $katBadgeClass[$item->sub_kategori] ?? 'kat-lainnya';
        $badgeLabel = $subKategoriList[$item->sub_kategori] ?? ($item->sub_kategori ?: 'Lainnya');
    @endphp
    <div class="file-card">
        {{-- Thumbnail --}}
        <div class="file-thumb">
            @if($item->file_path)
                @if(Str::endsWith($item->file_path, ['.mp4', '.mov']))
                    <video src="{{ asset('storage/' . $item->file_path) }}" style="width:100%;height:100%;object-fit:cover" muted></video>
                @else
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->judul }}" loading="lazy">
                @endif
            @else
                <div class="file-thumb-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    <span>INFOGRAFIS</span>
                </div>
            @endif
            {{-- Platform badge --}}
            <span class="file-platform-badge">{{ $item->platform_label }}</span>
            {{-- Kategori badge --}}
            <span class="file-kat-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            {{-- Tanggal badge pojok kanan bawah --}}
            @if($item->tanggal_publikasi)
            <div class="file-date-badge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ $item->tanggal_publikasi->format('d M Y') }}
            </div>
            @endif
        </div>

        {{-- Body --}}
        <div class="file-body">
            <div class="file-header-row">
                <div class="file-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                <div style="position:relative;flex-shrink:0">
                    <button type="button" class="ms-menu-btn" onclick="toggleCardMenu(event, 'fmenu-{{ $item->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                    </button>
                    <div id="fmenu-{{ $item->id }}" class="dropdown-menu-card">
                        @if(auth()->user()->isAdmin())
                        <button type="button" class="dropdown-menu-item" onclick="editMedia({{ json_encode($item) }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Edit
                        </button>
                        @endif
                        @if($item->link_post)
                        <a href="{{ $item->link_post }}" class="dropdown-menu-item" target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                            Buka Link URL
                        </a>
                        @endif
                        @if($item->file_path)
                        <a href="{{ asset('storage/' . $item->file_path) }}" class="dropdown-menu-item" download target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Unduh File
                        </a>
                        @if(!Str::endsWith($item->file_path, ['.mp4', '.mov', '.pdf']))
                        <a href="{{ asset('storage/' . $item->file_path) }}" class="dropdown-menu-item" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lihat File
                        </a>
                        @endif
                        @endif
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('media-sosial.destroy', $item) }}" onsubmit="return confirm('Hapus file ini dari arsip?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="dropdown-menu-item danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="file-desc">{{ $item->deskripsi ?: '—' }}</div>
            <div class="file-footer">
                <span class="file-status-badge status-{{ $item->status }}">{{ $item->status_label }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($items->hasPages())
<div class="ms-pagination-wrap">
    @if($items->onFirstPage())
        <span class="ms-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg></span>
    @else
        <a href="{{ $items->previousPageUrl() }}" class="ms-page-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg></a>
    @endif
    @for($page = 1; $page <= max(1, $items->lastPage()); $page++)
        @if($page == $items->currentPage())
            <span class="ms-page-btn active">{{ $page }}</span>
        @else
            <a href="{{ $items->url($page) }}" class="ms-page-btn">{{ $page }}</a>
        @endif
    @endfor
    @if($items->hasMorePages())
        <a href="{{ $items->nextPageUrl() }}" class="ms-page-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg></a>
    @else
        <span class="ms-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg></span>
    @endif
</div>
@endif

@else
{{-- Empty State --}}
<div class="empty-state">
    <div class="empty-state-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v8.25A2.25 2.25 0 004.5 16.5h15a2.25 2.25 0 002.25-2.25V7.5a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
    </div>
    <h3>
        @if(request('search') || request('kat'))
            Tidak ada file yang cocok
        @else
            Folder ini kosong
        @endif
    </h3>
    <p>
        @if(request('search'))
            Coba kata kunci lain, misalnya "17" untuk tanggal 17, atau "Agustus".
        @elseif(request('kat'))
            Tidak ada infografis kategori <strong>{{ $subKategoriList[request('kat')] ?? request('kat') }}</strong> di bulan ini.
        @else
            Belum ada infografis yang diarsipkan untuk <strong>{{ $folderLabel }}</strong>.
        @endif
    </p>
    @if(auth()->user()->isAdmin() && !request('search') && !request('kat'))
    <button type="button" onclick="openUploadModal()" class="btn-upload-top">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Upload Media
    </button>
    @endif
</div>
@endif

{{-- Upload / Edit Modal --}}
<div id="uploadModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Upload Infografis — {{ $folderLabel }}</h3>
            <button type="button" class="modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <form id="mediaForm" method="POST" action="{{ route('media-sosial.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            <input type="hidden" name="kategori" value="infografis">
            <div class="modal-body">
                <div class="form-group-m">
                    <label class="form-label-m">Judul Media <span class="req">*</span></label>
                    <input type="text" class="form-input-m" name="judul" id="inputJudul" placeholder="Contoh: Hari Kemerdekaan RI ke-81..." required>
                </div>

                {{-- Sub Kategori --}}
                <div class="form-group-m">
                    <label class="form-label-m">Kategori Infografis <span class="req">*</span></label>
                    <select class="form-select-m" name="sub_kategori" id="inputSubKategori" onchange="onSubKategoriChange(this.value)" required>
                        <option value="hari_besar">Hari Besar</option>
                        <option value="obituary">Obituary</option>
                        <option value="kamis_nyunda">Kamis Nyunda</option>
                        <option value="giat_pimpinan">Giat Pimpinan</option>
                        <option value="lainnya_custom">Dan Lainnya (Ketik Manual)</option>
                    </select>
                    <div id="lainnyaCustomWrapper" style="display:none;margin-top:8px">
                        <input type="text" class="form-input-m" name="sub_kategori_custom" id="inputSubKategoriCustom"
                               placeholder="Ketik kategori infografis..." maxlength="100">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
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
                    <div class="form-group-m">
                        <label class="form-label-m">Tanggal Publikasi <span class="req">*</span></label>
                        <input type="date" class="form-input-m" name="tanggal_publikasi" id="inputTanggal"
                               value="{{ $tahun }}-{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }}-{{ date('d') }}" required>
                    </div>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">Status <span class="req">*</span></label>
                    <select class="form-select-m" name="status" id="inputStatus" required>
                        <option value="dipublikasi">Dipublikasi</option>
                        <option value="draft">Draft</option>
                        <option value="dijadwalkan">Dijadwalkan</option>
                    </select>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">Deskripsi Singkat</label>
                    <textarea class="form-textarea-m" name="deskripsi" id="inputDeskripsi" placeholder="Ringkasan konten..."></textarea>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">Link / URL Postingan</label>
                    <input type="url" class="form-input-m" name="link_post" id="inputLinkPost" placeholder="Contoh: https://www.instagram.com/p/...">
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">File (.jpg, .png, .pdf, .mp4)</label>
                    <input type="file" class="form-input-m" name="file_media" id="inputFileMedia" accept=".jpg,.jpeg,.png,.webp,.pdf,.mp4">
                    <div style="font-size:11.5px;color:#9ca3af;margin-top:4px">Maks. 25MB</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-back" onclick="closeModal('uploadModal')">Batal</button>
                <button type="submit" class="btn-upload-top" id="btnSubmitModal">Simpan ke Arsip</button>
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
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu-card').forEach(m => m.classList.remove('show'));
});

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}

function onSubKategoriChange(val) {
    const customWrap  = document.getElementById('lainnyaCustomWrapper');
    const customInput = document.getElementById('inputSubKategoriCustom');
    if (val === 'lainnya_custom') {
        customWrap.style.display = '';
        customInput.required = true;
    } else {
        customWrap.style.display = 'none';
        customInput.required = false;
    }
}

function onPlatformChange(val) {
    const wrapper = document.getElementById('platformCustomWrapper');
    const input   = document.getElementById('inputPlatformCustom');
    if (wrapper && input) {
        if (val === 'lainnya') {
            wrapper.style.display = '';
            input.required = true;
        } else {
            wrapper.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }
}

function openUploadModal() {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "{{ route('media-sosial.store') }}";
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('modalTitle').textContent = 'Upload Infografis — {{ $folderLabel }}';
    document.getElementById('btnSubmitModal').textContent = 'Simpan ke Arsip';
    document.getElementById('inputTanggal').value = "{{ $tahun }}-{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }}-{{ date('d') }}";
    document.getElementById('inputLinkPost').value = '';
    onSubKategoriChange('hari_besar');
    document.getElementById('uploadModal').style.display = 'flex';
}

function editMedia(item) {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "/komunikasi-pimpinan/media-sosial/" + item.id;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('modalTitle').textContent = 'Edit Data Infografis';
    document.getElementById('btnSubmitModal').textContent = 'Perbarui Media';

    document.getElementById('inputJudul').value     = item.judul || '';
    // Set platform, handle custom
    const knownPlatforms = ['instagram','facebook','tiktok','youtube','x_twitter','billboard','videotron','baliho','spanduk'];
    const platVal = item.platform || 'instagram';
    const platSelect = document.getElementById('inputPlatform');
    const platCustom = document.getElementById('inputPlatformCustom');
    if (knownPlatforms.includes(platVal)) {
        platSelect.value = platVal;
        onPlatformChange(platVal);
    } else {
        platSelect.value = 'lainnya';
        onPlatformChange('lainnya');
        if (platCustom) platCustom.value = platVal;
    }
    document.getElementById('inputTanggal').value   = item.tanggal_publikasi ? item.tanggal_publikasi.split('T')[0] : '';
    document.getElementById('inputStatus').value    = item.status || 'dipublikasi';
    document.getElementById('inputDeskripsi').value = item.deskripsi || '';
    document.getElementById('inputLinkPost').value  = item.link_post || '';

    const knownKeys = ['hari_besar', 'obituary', 'kamis_nyunda', 'giat_pimpinan'];
    const sub = item.sub_kategori || '';
    if (knownKeys.includes(sub)) {
        document.getElementById('inputSubKategori').value = sub;
        onSubKategoriChange(sub);
    } else if (sub) {
        document.getElementById('inputSubKategori').value = 'lainnya_custom';
        onSubKategoriChange('lainnya_custom');
        document.getElementById('inputSubKategoriCustom').value = sub;
    } else {
        document.getElementById('inputSubKategori').value = 'hari_besar';
        onSubKategoriChange('hari_besar');
    }

    document.getElementById('uploadModal').style.display = 'flex';
}

// Enter pada search input langsung submit
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('searchForm').submit();
    }
});

function jumpToFolder() {
    const b = document.getElementById('jumpBulanSelect').value;
    const y = document.getElementById('jumpTahunSelect').value;
    const baseUrl = "{{ url('/komunikasi-pimpinan/media-sosial/infografis') }}";
    window.location.href = baseUrl + '/' + y + '/' + b;
}
</script>
@endpush
