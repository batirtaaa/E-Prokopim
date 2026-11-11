@extends('layouts.app')
@section('title', 'Kegiatan Pimpinan')

@push('styles')
<style>
/* Page Header */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
}
.page-header-left h1 { font-size: 26px; font-weight: 700; color: #111827; margin-bottom: 4px; }
.page-header-left p  { font-size: 13.5px; color: #6b7280; }

/* Toolbar */
.kg-toolbar {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 0;
}
.kg-search-wrap {
    position: relative;
    flex: 1;
    max-width: 300px;
}
.kg-search-wrap svg {
    position: absolute;
    left: 10px; top: 50%;
    transform: translateY(-50%);
    width: 15px; height: 15px;
    color: #9ca3af;
}
.kg-search-input {
    width: 100%;
    padding: 7px 12px 7px 34px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    transition: border-color 0.15s, background 0.15s;
}
.kg-search-input:focus { border-color: #2563eb; background: white; }
.kg-search-input::placeholder { color: #9ca3af; }
.kg-icon-btn {
    width: 36px; height: 36px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #6b7280;
    transition: all 0.15s;
    text-decoration: none;
    flex-shrink: 0;
}
.kg-icon-btn:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.kg-icon-btn svg { width: 15px; height: 15px; }

/* Table Wrapper */
.kg-table-wrap {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 12px;
}
.kg-table {
    width: 100%;
    border-collapse: collapse;
}
.kg-table thead tr {
    background: #f8fafc;
}
.kg-table thead th {
    padding: 11px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}
.kg-table thead th.th-center { text-align: center; }
.kg-table thead th.th-right  { text-align: right; }
.kg-table tbody td {
    padding: 15px 16px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f9fafb;
    vertical-align: middle;
}
.kg-table tbody tr:last-child td { border-bottom: none; }
.kg-table tbody tr:hover { background: #fafbff; }
.kg-table tbody tr.row-selected { background: #eff6ff !important; }

/* Bulk selection action bar */
.selection-action-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 16px;
    margin-top: 14px;
    margin-bottom: 2px;
    animation: kgFadeIn 0.15s ease;
}
@keyframes kgFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}
.selection-info {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.selection-badge {
    background: #1e3a5f;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
}
.btn-bulk-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-bulk-delete:hover {
    background: #dc2626;
}
.custom-checkbox {
    width: 17px;
    height: 17px;
    accent-color: #1e3a5f;
    cursor: pointer;
    vertical-align: middle;
}

/* ID */
.kg-id {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

/* Judul */
.kg-judul { font-weight: 500; font-size: 13px; line-height: 1.45; }
.kg-judul-sub { font-size: 11.5px; color: #9ca3af; }
.kg-leading-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 500;
    color: #1d4ed8;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    padding: 1px 7px;
    border-radius: 6px;
    max-width: 220px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.kg-leading-tag svg {
    width: 11px;
    height: 11px;
    flex-shrink: 0;
    color: #3b82f6;
}

/* Tanggal & Waktu */
.kg-tanggal-date { font-weight: 500; font-size: 13px; color: #111827; }
.kg-tanggal-time { font-size: 12px; color: #6b7280; margin-top: 2px; }

/* Pimpinan Avatars */
.kg-avatars { display: flex; align-items: center; }
.kg-avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: #1d4ed8;
    color: white;
    font-size: 10px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid white;
    margin-right: -6px;
    cursor: default;
    letter-spacing: -0.5px;
}
.kg-avatar:nth-child(1) { background: #1d4ed8; }
.kg-avatar:nth-child(2) { background: #2563eb; }
.kg-avatar:nth-child(3) { background: #16a34a; }
.kg-avatar-more {
    background: #e5e7eb;
    color: #6b7280;
    font-size: 9px;
    font-weight: 700;
}

/* Lokasi */
.kg-lokasi {
    display: flex; align-items: flex-start; gap: 5px;
    font-size: 13px; color: #374151;
}
.kg-lokasi svg { width: 13px; height: 13px; color: #9ca3af; flex-shrink: 0; margin-top: 2px; }

/* Aksi */
.kg-aksi { display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
.kg-aksi-btn {
    width: 30px; height: 30px;
    border: none; background: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #9ca3af;
    transition: all 0.15s;
    text-decoration: none;
}
.kg-aksi-btn:hover { background: #f3f4f6; color: #374151; }
.kg-aksi-btn.danger:hover { background: #fee2e2; color: #dc2626; }
.kg-aksi-btn svg { width: 16px; height: 16px; }

/* Dokumentasi Dropdown */
.kg-dok-wrap { position: relative; display: inline-block; }
.kg-dok-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 7px;
    background: white;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.kg-dok-btn:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.kg-dok-btn svg { width: 13px; height: 13px; flex-shrink: 0; }
.kg-dok-btn .kg-dok-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 9px;
    background: #1e3a5f;
    color: white;
    font-size: 10px;
    font-weight: 700;
}
.kg-dok-btn .kg-dok-badge.empty {
    background: #e5e7eb;
    color: #9ca3af;
}
.kg-dok-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 6px);
    min-width: 190px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 8px 28px -4px rgba(0,0,0,0.13);
    z-index: 999;
    overflow: hidden;
}
.kg-dok-menu.open { display: block; }
.kg-dok-menu-header {
    padding: 9px 14px 7px;
    font-size: 10px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 1px solid #f3f4f6;
}
.kg-dok-menu-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 14px;
    font-size: 13px;
    color: #374151;
    text-decoration: none;
    transition: background 0.12s;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}
.kg-dok-menu-item:hover { background: #f5f8ff; color: #1d4ed8; }
.kg-dok-menu-item svg { width: 15px; height: 15px; flex-shrink: 0; }
.kg-dok-menu-item .kg-dok-item-count {
    margin-left: auto;
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    background: #f3f4f6;
    border-radius: 99px;
    padding: 1px 7px;
}
.kg-dok-menu-item .kg-dok-item-count.has-data { background: #dbeafe; color: #1d4ed8; }
.kg-dok-empty-note {
    padding: 10px 14px;
    font-size: 12px;
    color: #9ca3af;
    text-align: center;
}

/* Pagination */
.kg-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-top: 1px solid #f3f4f6;
    font-size: 13px;
    color: #6b7280;
}
.kg-page-btns { display: flex; align-items: center; gap: 3px; }
.kg-page-btn {
    min-width: 32px; height: 32px;
    padding: 0 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: white;
    font-size: 13px;
    color: #6b7280;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    transition: all 0.15s;
}
.kg-page-btn:hover { border-color: #2563eb; color: #2563eb; }
.kg-page-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; font-weight: 600; }
.kg-page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Semua Kegiatan</h1>
        <p>Kelola dan pantau seluruh jadwal kegiatan pimpinan daerah.</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <button type="button" onclick="openExportModal()" class="btn btn-outline" style="display:inline-flex;align-items:center;gap:7px;border:1.5px solid #16a34a;color:#16a34a;font-weight:600;padding:9px 16px;border-radius:8px;font-size:13px;background:white;cursor:pointer;transition:all 0.15s;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:15px;height:15px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Download Rekap Excel
        </button>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('kegiatan-pimpinan.create') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;text-decoration:none;padding:10px 20px;font-size:13.5px;font-weight:600;border-radius:8px;background:#1e3a5f;color:white;border:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kegiatan
        </a>
        @endif
    </div>
</div>

{{-- Toolbar --}}
<form method="GET" action="{{ route('kegiatan-pimpinan.index') }}" class="kg-toolbar">
    <div class="kg-search-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" class="kg-search-input" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Judul...">
    </div>
    {{-- Filter submit --}}
    <button type="submit" class="kg-icon-btn" title="Cari / Filter">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
    </button>
</form>

{{-- Bulk selection action bar --}}
@if(auth()->user()->isAdmin())
<form id="bulkDeleteForm" method="POST" action="{{ route('kegiatan-pimpinan.bulk-destroy') }}">
    @csrf
    <div id="selectionActionBar" class="selection-action-bar">
        <div class="selection-info">
            <span class="selection-badge" id="selectedCountBadge">0</span>
            <span>kegiatan terpilih</span>
            <button type="button" onclick="clearAllSelections()" style="background:none;border:none;color:#2563eb;cursor:pointer;font-size:13px;text-decoration:underline;margin-left:8px">Batal Pilih</button>
        </div>
        <button type="submit" class="btn-bulk-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh kegiatan yang dipilih secara bersamaan?')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            Hapus Terpilih
        </button>
    </div>
</form>
@endif

{{-- Table --}}
<div class="kg-table-wrap">
    <table class="kg-table">
        <thead>
            <tr>
                @if(auth()->user()->isAdmin())
                <th style="width:38px;text-align:center">
                    <input type="checkbox" id="selectAllKg" class="custom-checkbox" title="Pilih Semua">
                </th>
                @endif
                <th style="width:160px">ID Kegiatan</th>
                <th>Judul Kegiatan</th>
                <th style="width:160px">Tanggal &amp; Waktu</th>
                <th style="width:90px">Pimpinan</th>
                <th style="width:190px">Lokasi</th>
                <th class="th-center" style="width:130px">Dokumentasi</th>
                <th class="th-right" style="width:110px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kegiatan as $item)
            <tr id="row-{{ $item->id }}">
                @if(auth()->user()->isAdmin())
                <td style="text-align:center">
                    <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" form="bulkDeleteForm" class="custom-checkbox row-checkbox" onchange="handleRowSelect(this)">
                </td>
                @endif
                {{-- ID --}}
                <td>
                    <span class="kg-id">
                        {{ $item->nomor_agenda ? '#' . $item->nomor_agenda : '#KG-' . str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                    </span>
                </td>

                {{-- Judul --}}
                <td>
                    <div class="kg-judul">{{ Str::limit($item->judul, 40) }}</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-top:3px;flex-wrap:wrap">
                        @if($item->kategori)
                            <span class="kg-judul-sub">{{ ucfirst($item->kategori) }}</span>
                        @endif
                        @if($item->leading_sektor)
                            <span class="kg-leading-tag" title="Leading Sektor: {{ $item->leading_sektor }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.243 48.243 0 0012 9.75c-2.551 0-5.056.2-7.5.583V21" /></svg>
                                {{ Str::limit($item->leading_sektor, 28) }}
                            </span>
                        @endif
                    </div>
                </td>

                {{-- Tanggal & Waktu --}}
                <td>
                    <div class="kg-tanggal-date">{{ $item->tanggal_mulai ? $item->tanggal_mulai->translatedFormat('d M Y') : '—' }}</div>
                    <div class="kg-tanggal-time">
                        @if($item->tanggal_mulai)
                            {{ $item->tanggal_mulai->format('H:i') }} WIB
                            @if($item->tanggal_selesai)
                                - {{ $item->tanggal_selesai->format('H:i') }} WIB
                            @else
                                s/d Selesai
                            @endif
                        @else
                            —
                        @endif
                    </div>
                </td>

                {{-- Pimpinan Avatars --}}
                <td>
                    <div class="kg-avatars">
                        @php $badges = $item->pimpinan_badges; @endphp
                        @foreach($badges as $idx => $b)
                            @if($idx < 3)
                            <div class="kg-avatar" title="{{ $b['name'] }}" style="z-index:{{ 10 - $idx }}">{{ $b['initial'] }}</div>
                            @endif
                        @endforeach
                        @if(count($badges) > 3)
                            <div class="kg-avatar kg-avatar-more" style="z-index:0">+{{ count($badges) - 3 }}</div>
                        @endif
                        @if(empty($badges))
                            <span style="color:#d1d5db;font-size:13px">—</span>
                        @endif
                    </div>
                </td>

                {{-- Lokasi --}}
                <td>
                    <div class="kg-lokasi">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        {{ Str::limit($item->lokasi ?? '—', 28) }}
                    </div>
                </td>

                {{-- Dokumentasi Dropdown --}}
                @php
                    $fotoCount     = $item->foto_count ?? 0;
                    $videoCount    = $item->video_count ?? 0;
                    $notulCount    = $item->notulensi_count ?? 0;
                    $totalDok      = $fotoCount + $videoCount + $notulCount;
                @endphp
                <td style="text-align:center;">
                    <div class="kg-dok-wrap" id="dok-wrap-{{ $item->id }}">
                        <button type="button"
                            class="kg-dok-btn"
                            onclick="toggleDokMenu({{ $item->id }}, event)"
                            title="Lihat Dokumentasi Kegiatan">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="kg-dok-badge {{ $totalDok === 0 ? 'empty' : '' }}">{{ $totalDok }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:10px;height:10px;opacity:0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="kg-dok-menu" id="dok-menu-{{ $item->id }}">
                            <div class="kg-dok-menu-header">Dokumentasi Kegiatan</div>
                            {{-- Foto --}}
                            <a href="{{ route('galeri-arsip.index') }}?tab=foto&kegiatan={{ $item->id }}"
                               class="kg-dok-menu-item" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#f59e0b">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                </svg>
                                Foto
                                <span class="kg-dok-item-count {{ $fotoCount > 0 ? 'has-data' : '' }}">{{ $fotoCount }}</span>
                            </a>
                            {{-- Video --}}
                            <a href="{{ route('galeri-arsip.index') }}?tab=video&kegiatan={{ $item->id }}"
                               class="kg-dok-menu-item" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366f1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9A2.25 2.25 0 0013.5 5.25h-9A2.25 2.25 0 002.25 7.5v9A2.25 2.25 0 004.5 18.75z" />
                                </svg>
                                Video
                                <span class="kg-dok-item-count {{ $videoCount > 0 ? 'has-data' : '' }}">{{ $videoCount }}</span>
                            </a>
                            {{-- Notulensi --}}
                            <a href="{{ route('galeri-arsip.index') }}?tab=notulensi&kegiatan={{ $item->id }}"
                               class="kg-dok-menu-item" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Notulensi
                                <span class="kg-dok-item-count {{ $notulCount > 0 ? 'has-data' : '' }}">{{ $notulCount }}</span>
                            </a>
                            @if($totalDok === 0)
                            <div class="kg-dok-empty-note">Belum ada dokumentasi</div>
                            @endif
                            <div style="border-top:1px solid #f1f5f9;margin-top:4px;padding-top:4px;">
                                <a href="{{ route('galeri-arsip.index') }}?kegiatan={{ $item->id }}&action=upload"
                                   class="kg-dok-menu-item" style="color:#2563eb;font-weight:600;font-size:11.5px;" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    + Unggah Dokumentasi
                                </a>
                            </div>
                        </div>
                    </div>
                </td>

                {{-- Aksi --}}
                <td>
                    <div class="kg-aksi">
                        {{-- WhatsApp --}}
                        @php
                            $waText = "Kegiatan: " . $item->judul;
                            $pimpinan = $item->pimpinan_label;
                            if ($pimpinan && $pimpinan !== '—' && $pimpinan !== '-') {
                                $waText .= "\nPimpinan: " . $pimpinan;
                            }
                            if ($item->leading_sektor) {
                                $waText .= "\nLeading Sektor: " . $item->leading_sektor;
                            }
                            $waText .= "\nTanggal: " . ($item->tanggal_mulai ? $item->tanggal_mulai->translatedFormat('d M Y H:i') . ' WIB' : '—');
                            $waText .= "\nLokasi: " . ($item->lokasi ?? '—');
                            if ($item->deskripsi) {
                                $waText .= "\nKeterangan: " . $item->deskripsi;
                            }
                        @endphp
                        <a href="https://wa.me/?text={{ urlencode($waText) }}"
                           target="_blank" class="kg-aksi-btn" title="Kirim ke WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:#25d366">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        @if(auth()->user()->isAdmin())
                        {{-- Edit --}}
                        <a href="{{ route('kegiatan-pimpinan.edit', $item) }}" class="kg-aksi-btn" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                        </a>
                        {{-- Delete --}}
                        <form method="POST" action="{{ route('kegiatan-pimpinan.destroy', $item) }}" onsubmit="return confirm('Hapus kegiatan ini?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="kg-aksi-btn danger" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" style="text-align:center;padding:48px;color:#9ca3af">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:44px;height:44px;margin:0 auto 12px;display:block;opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <p style="font-weight:500;margin-bottom:8px">Belum ada data kegiatan</p>
                    <a href="{{ route('kegiatan-pimpinan.create') }}" style="color:#2563eb;font-size:13px">+ Tambah kegiatan sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="kg-pagination">
        <span>
            @if($kegiatan->total() > 0)
                Menampilkan {{ $kegiatan->firstItem() }} sampai {{ $kegiatan->lastItem() }} dari {{ $kegiatan->total() }} hasil
            @else
                Tidak ada hasil
            @endif
        </span>
        <div class="kg-page-btns">
            {{-- Prev --}}
            @if($kegiatan->onFirstPage())
                <span class="kg-page-btn disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </span>
            @else
                <a href="{{ $kegiatan->previousPageUrl() }}" class="kg-page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            @php
                $currentPage = $kegiatan->currentPage();
                $lastPage    = $kegiatan->lastPage();
                $pages = [];
                if ($lastPage <= 7) {
                    $pages = range(1, $lastPage);
                } else {
                    $pages[] = 1;
                    if ($currentPage > 3) $pages[] = '...';
                    $start = max(2, $currentPage - 1);
                    $end   = min($lastPage - 1, $currentPage + 1);
                    for ($i = $start; $i <= $end; $i++) $pages[] = $i;
                    if ($currentPage < $lastPage - 2) $pages[] = '...';
                    $pages[] = $lastPage;
                }
            @endphp
            @foreach($pages as $page)
                @if($page === '...')
                    <span class="kg-page-btn disabled" style="border:none;background:none">…</span>
                @elseif($page == $currentPage)
                    <span class="kg-page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $kegiatan->url($page) }}" class="kg-page-btn">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($kegiatan->hasMorePages())
                <a href="{{ $kegiatan->nextPageUrl() }}" class="kg-page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="kg-page-btn disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </div>
    </div>
</div>

{{-- Modal Pilih Tahun Export --}}
<div id="exportModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; width:380px; max-width:92vw; box-shadow:0 20px 60px -10px rgba(0,0,0,0.25); overflow:hidden;">
        <div style="background:#1e3a5f; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                <span style="font-size:15px;font-weight:700;color:white;">Download Rekap Kegiatan</span>
            </div>
            <button onclick="document.getElementById('exportModal').style.display='none'" style="background:none;border:none;color:white;cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div style="padding:24px;">
            <p style="font-size:13px;color:#6b7280;margin-bottom:16px;line-height:1.6;">
                File Excel akan berisi <strong>Rekapitulasi Bulanan</strong> dan <strong>Detail Seluruh Kegiatan</strong> (agenda, tanggal, waktu, pimpinan, lokasi, dan keterangan) untuk tahun yang dipilih.
            </p>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Pilih Tahun</label>
            <select id="exportTahunSelect" style="width:100%;padding:10px 14px;border:1.5px solid #d1d5db;border-radius:8px;font-size:14px;font-weight:600;color:#1e3a5f;background:#f8fafc;outline:none;">
                @foreach($availableYears ?? [now()->year] as $yr)
                    <option value="{{ $yr }}" {{ ($selectedTahun ?? now()->year) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
            <div style="margin-top:8px;font-sizre:11.5px;color:#9ca3af;">Format: Microsoft Excel (.xls)</div>
        </div>
        <div style="padding:0 24px 20px;display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="document.getElementById('exportModal').style.display='none'" style="padding:9px 18px;border:1.5px solid #e5e7eb;border-radius:8px;background:white;font-size:13px;color:#374151;cursor:pointer;font-weight:500;">Batal</button>
            <a href="javascript:void(0)" onclick="doExportKegiatan()" style="padding:9px 22px;background:#16a34a;color:white;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;cursor:pointer;border:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Download
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openExportModal() {
    document.getElementById('exportModal').style.display = 'flex';
}
function doExportKegiatan() {
    const tahun = document.getElementById('exportTahunSelect').value;
    window.location.href = "{{ route('kegiatan-pimpinan.export-rekap') }}?tahun=" + tahun;
    document.getElementById('exportModal').style.display = 'none';
}

// Dokumentasi dropdown toggle
function toggleDokMenu(id, e) {
    e.stopPropagation();
    const menu = document.getElementById('dok-menu-' + id);
    const isOpen = menu.classList.contains('open');
    // Close all open menus
    document.querySelectorAll('.kg-dok-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) {
        menu.classList.add('open');
    }
}
// Close dropdown when clicking outside
document.addEventListener('click', function() {
    document.querySelectorAll('.kg-dok-menu.open').forEach(m => m.classList.remove('open'));
});

// Bulk selection handling
const selectAllKg = document.getElementById('selectAllKg');
const rowCheckboxes = document.querySelectorAll('.row-checkbox');
const selectionActionBar = document.getElementById('selectionActionBar');
const selectedCountBadge = document.getElementById('selectedCountBadge');

if (selectAllKg) {
    selectAllKg.addEventListener('change', function() {
        const checked = this.checked;
        rowCheckboxes.forEach(cb => {
            cb.checked = checked;
            const tr = document.getElementById('row-' + cb.value);
            if (tr) tr.classList.toggle('row-selected', checked);
        });
        updateSelectionState();
    });
}

function handleRowSelect(cb) {
    const tr = document.getElementById('row-' + cb.value);
    if (tr) tr.classList.toggle('row-selected', cb.checked);
    updateSelectionState();
}

function updateSelectionState() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkedBoxes.length;
    if (selectionActionBar) {
        selectionActionBar.style.display = count > 0 ? 'flex' : 'none';
    }
    if (selectedCountBadge) {
        selectedCountBadge.textContent = count;
    }
    if (selectAllKg) {
        selectAllKg.checked = count > 0 && count === rowCheckboxes.length;
    }
}

function clearAllSelections() {
    rowCheckboxes.forEach(cb => {
        cb.checked = false;
        const tr = document.getElementById('row-' + cb.value);
        if (tr) tr.classList.remove('row-selected');
    });
    if (selectAllKg) selectAllKg.checked = false;
    updateSelectionState();
}
</script>
@endpush
