@extends('layouts.app')
@section('title', 'Asset — E-PROKOPIM')

@push('styles')
<style>
/* Base Page Container */
.ast-container {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.ast-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.ast-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 2px 0;
}
.ast-subtitle {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}
.ast-btn-add {
    padding: 8px 18px;
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
.ast-btn-add:hover {
    background: #081d30;
    color: #ffffff;
}

/* Card Container with Tabs */
.ast-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}

/* Tab Navigation Header */
.ast-tabs-bar {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
    background: #ffffff;
    padding: 0 20px;
}
.ast-tab-link {
    padding: 16px 20px;
    font-size: 13.5px;
    font-weight: 500;
    color: #64748b;
    text-decoration: none;
    position: relative;
    transition: color 0.15s;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
}
.ast-tab-link:hover {
    color: #0f172a;
}
.ast-tab-link.active {
    color: #0f172a;
    font-weight: 700;
    border-bottom: 2.5px solid #0f172a;
}

/* Toolbar */
.ast-toolbar {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.ast-search-box {
    position: relative;
    flex: 1;
    max-width: 320px;
}
.ast-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    width: 15px;
    height: 15px;
    pointer-events: none;
}
.ast-search-input {
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
.ast-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ast-search-input::placeholder {
    color: #94a3b8;
}

.ast-actions-group {
    display: flex;
    align-items: center;
    gap: 8px;
}
.ast-btn-filter {
    padding: 7px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s;
    text-decoration: none;
}
.ast-btn-filter:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.ast-btn-icon-export {
    padding: 7px 10px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    text-decoration: none;
}
.ast-btn-icon-export:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}

/* Table Style */
.ast-table-wrap {
    overflow-x: auto;
}
.ast-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.ast-table thead th {
    padding: 12px 20px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #475569;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.ast-table thead th:last-child {
    text-align: right;
}
.ast-table tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.ast-table tbody tr:last-child td {
    border-bottom: none;
}
.ast-table tbody tr:hover {
    background: #fafcff;
}

/* Status Badges */
.ast-badge-solid-blue {
    display: inline-block;
    padding: 4px 12px;
    background: #3b82f6;
    color: #ffffff;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}
.ast-badge-solid-orange {
    display: inline-block;
    padding: 4px 12px;
    background: #f97316;
    color: #ffffff;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}
.ast-badge-solid-gray {
    display: inline-block;
    padding: 4px 12px;
    background: #64748b;
    color: #ffffff;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}

/* Status Pills (Kendaraan) */
.ast-pill-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 500;
    white-space: nowrap;
}
.ast-pill-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}
.ast-pill-status.sedang_digunakan {
    background: #dbeafe;
    color: #1e40af;
}
.ast-pill-status.sedang_digunakan .ast-pill-dot {
    background: #2563eb;
}
.ast-pill-status.tersedia {
    background: #f1f5f9;
    color: #475569;
}
.ast-pill-status.tersedia .ast-pill-dot {
    background: #64748b;
}
.ast-pill-status.perbaikan {
    background: #fee2e2;
    color: #dc2626;
}
.ast-pill-status.perbaikan .ast-pill-dot {
    background: #dc2626;
}

/* Action Icons */
.ast-row-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}
.ast-icon-action-btn {
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 5px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    text-decoration: none;
}
.ast-icon-action-btn:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.ast-icon-action-btn.whatsapp-btn:hover {
    color: #16a34a;
    background: #f0fdf4;
}

/* Pagination Footer */
.ast-pagination-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
}
.ast-page-btns {
    display: flex;
    align-items: center;
    gap: 4px;
}
.ast-p-btn {
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
.ast-p-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.ast-p-btn.active {
    background: #0f2942;
    border-color: #0f2942;
    color: #ffffff;
    font-weight: 600;
}
.ast-p-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endpush

@section('content')
<div class="ast-container">

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
    <div class="ast-header-row">
        <div>
            <h1 class="ast-title">Asset</h1>
            <p class="ast-subtitle">Manajemen asset</p>
        </div>

        @if(auth()->user()->isAdmin())
            @if($activeTab === 'kendaraan')
                <a href="{{ route('asset.create-kendaraan') }}" class="ast-btn-add">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Kendaraan Baru</span>
                </a>
            @else
                <a href="{{ route('asset.create-inventaris') }}" class="ast-btn-add">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Aset Baru</span>
                </a>
            @endif
        @endif
    </div>

    {{-- Main Card Container with Tabs --}}
    <div class="ast-card">
        {{-- Tabs Navigation --}}
        <div class="ast-tabs-bar">
            <a href="{{ route('asset.index', ['tab' => 'inventaris']) }}" class="ast-tab-link {{ $activeTab === 'inventaris' ? 'active' : '' }}">
                Daftar Inventaris Barang
            </a>
            <a href="{{ route('asset.index', ['tab' => 'kendaraan']) }}" class="ast-tab-link {{ $activeTab === 'kendaraan' ? 'active' : '' }}">
                Daftar Kendaraan Operasional
            </a>
        </div>

        {{-- TAB 1: Daftar Inventaris Barang --}}
        @if($activeTab === 'inventaris')
        <div>
            {{-- Toolbar --}}
            <div class="ast-toolbar">
                <form method="GET" action="{{ route('asset.index') }}" id="astInventarisForm" style="display:flex; align-items:center; gap:10px; width:100%; justify-content:space-between; flex-wrap:wrap;">
                    <input type="hidden" name="tab" value="inventaris">
                    <div class="ast-search-box">
                        <svg class="ast-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" name="search_aset" class="ast-search-input" placeholder="Cari aset..." value="{{ request('search_aset') }}">
                    </div>

                    <div class="ast-actions-group">
                        <button type="button" class="ast-btn-filter" onclick="toggleFilterModal('filterAsetModal')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <span>Filter</span>
                        </button>
                        <a href="{{ route('asset.export', ['type' => 'inventaris']) }}" class="ast-btn-icon-export" title="Unduh CSV">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="ast-table-wrap">
                <table class="ast-table">
                    <thead>
                        <tr>
                            <th>KODE ASET</th>
                            <th>NAMA BARANG</th>
                            <th>KATEGORI</th>
                            <th>LOKASI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $item)
                        <tr>
                            <td style="font-weight: 600; color: #0f172a;">{{ $item->kode_aset }}</td>
                            <td style="font-weight: 500; color: #0f172a;">{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->lokasi ?? '—' }}</td>
                            <td>
                                @if(strtolower($item->status) === 'tersedia')
                                    <span class="ast-badge-solid-blue">Tersedia</span>
                                @elseif(strtolower($item->status) === 'digunakan')
                                    <span class="ast-badge-solid-orange">Digunakan</span>
                                @else
                                    <span class="ast-badge-solid-gray">{{ $item->status_label }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="ast-row-actions">
                                    {{-- Download / Doc button --}}
                                    @if($item->dokumen_pendukung)
                                        <a href="{{ asset('storage/' . $item->dokumen_pendukung) }}" target="_blank" class="ast-icon-action-btn" title="Unduh Dokumen">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('asset.export', ['type' => 'inventaris']) }}" class="ast-icon-action-btn" title="Unduh Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- WhatsApp share button --}}
                                    <a href="https://wa.me/?text={{ urlencode('Informasi Aset: ' . $item->kode_aset . ' - ' . $item->nama_barang . ' (' . $item->kategori . ') di ' . $item->lokasi . '. Status: ' . $item->status_label) }}" target="_blank" class="ast-icon-action-btn whatsapp-btn" title="Bagikan via WhatsApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                    </a>

                                    {{-- Delete button --}}
                                    @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('asset.destroy-inventaris', $item) }}" onsubmit="return confirm('Hapus aset inventaris ini?')" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ast-icon-action-btn" style="color:#ef4444;" title="Hapus Aset">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                                <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data inventaris barang</p>
                                <a href="{{ route('asset.create-inventaris') }}" style="color:#2563eb; text-decoration:none; font-size:12.5px; font-weight:600;">+ Tambah Aset Baru</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            <div class="ast-pagination-footer">
                <span>Menampilkan {{ $inventaris->firstItem() ?? 0 }}–{{ $inventaris->lastItem() ?? 0 }} dari {{ $inventaris->total() }} aset</span>
                <div class="ast-page-btns">
                    @if($inventaris->onFirstPage())
                        <span class="ast-p-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $inventaris->previousPageUrl() }}" class="ast-p-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif

                    @php
                        $cur = $inventaris->currentPage();
                        $last = $inventaris->lastPage();
                    @endphp
                    @for($p = 1; $p <= min(5, $last); $p++)
                        @if($p == $cur)
                            <span class="ast-p-btn active">{{ $p }}</span>
                        @else
                            <a href="{{ $inventaris->url($p) }}" class="ast-p-btn">{{ $p }}</a>
                        @endif
                    @endfor

                    @if($inventaris->hasMorePages())
                        <a href="{{ $inventaris->nextPageUrl() }}" class="ast-p-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <span class="ast-p-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB 2: Daftar Kendaraan Operasional --}}
        @else
        <div>
            {{-- Toolbar --}}
            <div class="ast-toolbar">
                <form method="GET" action="{{ route('asset.index') }}" id="astKendaraanForm" style="display:flex; align-items:center; gap:10px; width:100%; justify-content:space-between; flex-wrap:wrap;">
                    <input type="hidden" name="tab" value="kendaraan">
                    <div class="ast-search-box">
                        <svg class="ast-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" name="search_kendaraan" class="ast-search-input" placeholder="Cari kendaraan, plat, atau pengguna..." value="{{ request('search_kendaraan') }}">
                    </div>

                    <div class="ast-actions-group">
                        <button type="button" class="ast-btn-filter" onclick="toggleFilterModal('filterKendaraanModal')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <span>Filter</span>
                        </button>
                        <a href="{{ route('asset.export', ['type' => 'kendaraan']) }}" class="ast-btn-icon-export" title="Unduh CSV">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table Kendaraan --}}
            <div class="ast-table-wrap">
                <table class="ast-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th>PLAT NOMOR</th>
                            <th>NAMA KENDARAAN</th>
                            <th>JENIS</th>
                            <th>PEMEGANG/PENGGUNA</th>
                            <th>TAHUN</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kendaraan as $index => $knd)
                        @php
                            $rowNo = ($kendaraan->currentPage() - 1) * $kendaraan->perPage() + $index + 1;
                            $stClass = strtolower(str_replace(' ', '_', $knd->status));
                        @endphp
                        <tr>
                            <td style="color: #64748b; font-weight: 500;">{{ $rowNo }}</td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $knd->plat_nomor }}</td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $knd->nama_kendaraan }}</td>
                            <td>{{ $knd->jenis }}</td>
                            <td>{{ $knd->pemegang_pengguna ?? '-' }}</td>
                            <td>{{ $knd->tahun }}</td>
                            <td>
                                <span class="ast-pill-status {{ $knd->status_color }}">
                                    <span class="ast-pill-dot"></span>
                                    {{ $knd->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="ast-row-actions">
                                    @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('asset.destroy-kendaraan', $knd) }}" onsubmit="return confirm('Hapus data kendaraan operasional ini?')" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ast-icon-action-btn" style="color:#ef4444;" title="Hapus Kendaraan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                                <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data kendaraan operasional</p>
                                <a href="{{ route('asset.create-kendaraan') }}" style="color:#2563eb; text-decoration:none; font-size:12.5px; font-weight:600;">+ Tambah Kendaraan Baru</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            <div class="ast-pagination-footer">
                <span>Menampilkan {{ $kendaraan->firstItem() ?? 0 }}–{{ $kendaraan->lastItem() ?? 0 }} dari {{ $kendaraan->total() }} data</span>
                <div class="ast-page-btns">
                    @if($kendaraan->onFirstPage())
                        <span class="ast-p-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $kendaraan->previousPageUrl() }}" class="ast-p-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif

                    @php
                        $curK = $kendaraan->currentPage();
                        $lastK = $kendaraan->lastPage();
                    @endphp
                    @for($p = 1; $p <= min(4, $lastK); $p++)
                        @if($p == $curK)
                            <span class="ast-p-btn active">{{ $p }}</span>
                        @else
                            <a href="{{ $kendaraan->url($p) }}" class="ast-p-btn">{{ $p }}</a>
                        @endif
                    @endfor
                    @if($lastK > 4)
                        <span class="ast-p-btn disabled" style="border:none;">…</span>
                    @endif

                    @if($kendaraan->hasMorePages())
                        <a href="{{ $kendaraan->nextPageUrl() }}" class="ast-p-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <span class="ast-p-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
