@extends('layouts.app')
@section('title', 'Daftar Pegawai — E-PROKOPIM')

@push('styles')
<style>
/* Base Container */
.pgw-container {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.pgw-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.pgw-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0;
}
.pgw-btn-add {
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
.pgw-btn-add:hover {
    background: #081d30;
    color: #ffffff;
}

/* Card Container */
.pgw-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}

/* Toolbar */
.pgw-toolbar {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.pgw-search-box {
    position: relative;
    flex: 1;
    max-width: 320px;
}
.pgw-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    width: 15px;
    height: 15px;
    pointer-events: none;
}
.pgw-search-input {
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
.pgw-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pgw-search-input::placeholder {
    color: #94a3b8;
}

.pgw-actions-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* Per Page Selector */
.pgw-perpage-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #475569;
}
.pgw-perpage-select {
    padding: 7px 12px;
    font-size: 12.5px;
    font-weight: 500;
    color: #334155;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    outline: none;
    transition: all 0.15s ease;
}
.pgw-perpage-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

.pgw-btn-filter {
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
.pgw-btn-filter:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.pgw-btn-icon-export {
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
.pgw-btn-icon-export:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}

/* Filter Dropdown Modal/Box */
.pgw-filter-dropdown {
    display: none;
    position: absolute;
    right: 20px;
    top: 75px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    padding: 16px;
    z-index: 50;
    width: 270px;
}
.pgw-filter-dropdown.show {
    display: block;
}

/* Modal Custom Per Page */
.pgw-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(2px);
    z-index: 1050;
    align-items: center;
    justify-content: center;
}
.pgw-modal-overlay.open { display: flex; }
.pgw-modal-box {
    background: #ffffff;
    border-radius: 12px;
    width: 100%;
    max-width: 380px;
    padding: 22px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
    animation: modal-fade 0.18s ease-out;
}
@keyframes modal-fade {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* Table Style */
.pgw-table-wrap {
    overflow-x: auto;
}
.pgw-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.pgw-table thead th {
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
.pgw-table thead th:last-child {
    text-align: right;
}
.pgw-table tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.pgw-table tbody tr:last-child td {
    border-bottom: none;
}
.pgw-table tbody tr:hover {
    background: #fafcff;
}

/* Avatar Photo */
.pgw-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
    color: #475569;
    flex-shrink: 0;
}

/* Name & Email Stack */
.pgw-name-block {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.pgw-name-text {
    font-weight: 600;
    color: #0f172a;
    font-size: 13px;
}
.pgw-email-text {
    font-size: 12px;
    color: #64748b;
}

/* Status Pill Badges */
.pgw-status-pill {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 500;
    white-space: nowrap;
    text-align: center;
}
.pgw-status-pill.status-pns {
    background: #dbeafe;
    color: #1e40af;
}
.pgw-status-pill.status-pppk-penuh {
    background: #e0e7ff;
    color: #3730a3;
}
.pgw-status-pill.status-pppk-paruh {
    background: #e2e8f0;
    color: #334155;
}
.pgw-status-pill.status-outsourcing {
    background: #f1f5f9;
    color: #475569;
}
.pgw-status-pill.status-default {
    background: #f1f5f9;
    color: #475569;
}

/* Action Icons */
.pgw-row-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}
.pgw-icon-btn {
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
.pgw-icon-btn:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.pgw-icon-btn.whatsapp-btn:hover {
    color: #16a34a;
    background: #f0fdf4;
}

/* Pagination Footer */
.pgw-pagination-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
    flex-wrap: wrap;
    gap: 10px;
}
.pgw-page-btns {
    display: flex;
    align-items: center;
    gap: 4px;
}
.pgw-p-btn {
    min-width: 28px;
    height: 28px;
    padding: 0 8px;
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
.pgw-p-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.pgw-p-btn.active {
    background: #0f2942;
    border-color: #0f2942;
    color: #ffffff;
    font-weight: 600;
}
.pgw-p-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endpush

@section('content')
<div class="pgw-container">

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
    <div class="pgw-header-row">
        <h1 class="pgw-title">Daftar Pegawai</h1>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('pegawai.create') }}" class="pgw-btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Pegawai</span>
        </a>
        @endif
    </div>

    {{-- Main Card --}}
    <div class="pgw-card" style="position: relative;">
        {{-- Toolbar --}}
        <div class="pgw-toolbar">
            <form method="GET" action="{{ route('pegawai.index') }}" id="pgwSearchForm" style="display:flex; align-items:center; gap:10px; width:100%; justify-content:space-between; flex-wrap:wrap;">
                {{-- Preserve other query params --}}
                @if(request('status_kepegawaian'))
                    <input type="hidden" name="status_kepegawaian" value="{{ request('status_kepegawaian') }}">
                @endif
                <input type="hidden" name="per_page" id="search_per_page" value="{{ $perPageParam }}">

                {{-- Search Box --}}
                <div class="pgw-search-box">
                    <svg class="pgw-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" name="search" class="pgw-search-input" placeholder="Cari pegawai..." value="{{ request('search') }}">
                </div>

                {{-- Right Actions --}}
                <div class="pgw-actions-group">
                    {{-- Per-Page Selector (10, 25, 50, Semua, Custom) --}}
                    <div class="pgw-perpage-wrap">
                        <label for="per_page_select">Tampilkan:</label>
                        <select id="per_page_select" class="pgw-perpage-select" onchange="handlePerPageChange(this.value)">
                            <option value="10" {{ $perPageParam === '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPageParam === '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPageParam === '50' ? 'selected' : '' }}>50</option>
                            <option value="all" {{ $perPageParam === 'all' ? 'selected' : '' }}>Semua ({{ $totalPegawai }})</option>
                            <option value="custom" {{ (!in_array($perPageParam, ['10', '25', '50', 'all'])) ? 'selected' : '' }}>
                                {{ (!in_array($perPageParam, ['10', '25', '50', 'all'])) ? $perPageParam . ' (Custom)' : 'Custom...' }}
                            </option>
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <button type="button" class="pgw-btn-filter" onclick="toggleFilterMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Filter</span>
                    </button>

                    {{-- Export Button --}}
                    <a href="{{ route('pegawai.export') }}" class="pgw-btn-icon-export" title="Unduh CSV">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        {{-- Filter Popup Menu --}}
        <div id="pgwFilterDropdown" class="pgw-filter-dropdown">
            <form method="GET" action="{{ route('pegawai.index') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <input type="hidden" name="per_page" value="{{ $perPageParam }}">

                <div style="font-weight:600; font-size:13px; margin-bottom:10px; color:#0f172a;">Filter Status Kepegawaian</div>
                <div style="margin-bottom:12px;">
                    <select name="status_kepegawaian" style="width:100%; padding:7px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:12.5px;">
                        <option value="">Semua Status</option>
                        <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="PPPK Paruh Waktu" {{ request('status_kepegawaian') == 'PPPK Paruh Waktu' ? 'selected' : '' }}>PPPK Paruh Waktu</option>
                        <option value="Outsourching" {{ in_array(request('status_kepegawaian'), ['Outsourching', 'Outsourcing']) ? 'selected' : '' }}>Outsourching</option>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <a href="{{ route('pegawai.index', ['per_page' => $perPageParam]) }}" style="padding:5px 10px; font-size:12px; color:#64748b; text-decoration:none;">Reset</a>
                    <button type="submit" style="padding:5px 12px; font-size:12px; background:#0f2942; color:#fff; border:none; border-radius:6px; cursor:pointer;">Terapkan</button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="pgw-table-wrap">
            <table class="pgw-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">FOTO</th>
                        <th>NAMA PEGAWAI</th>
                        <th>NIP</th>
                        <th>JABATAN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawai as $p)
                    <tr>
                        <td>
                            @if($p->photo)
                                <img src="{{ asset('storage/' . $p->photo) }}" alt="{{ $p->nama_lengkap }}" class="pgw-avatar">
                            @else
                                <div class="pgw-avatar">
                                    {{ $p->initials }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="pgw-name-block">
                                <span class="pgw-name-text">{{ $p->nama_lengkap }}</span>
                                <span class="pgw-email-text">{{ $p->display_email }}</span>
                            </div>
                        </td>
                        <td style="font-weight: 500; color: #334155;">{{ $p->nip ?? '-' }}</td>
                        <td style="color: #334155;">{{ $p->jabatan }}</td>
                        <td>
                            <span class="pgw-status-pill {{ $p->status_kepegawaian_badge_class }}">
                                {{ $p->status_kepegawaian_label }}
                            </span>
                        </td>
                        <td>
                            <div class="pgw-row-actions">
                                {{-- Download / Email details --}}
                                <a href="mailto:{{ $p->display_email }}" class="pgw-icon-btn" title="Kirim Email">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>

                                {{-- WhatsApp button --}}
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->phone ?: '6281234567890') }}?text={{ urlencode('Halo ' . $p->nama_lengkap . ', terkait koordinasi Prokopim Kota Bandung:') }}" target="_blank" class="pgw-icon-btn whatsapp-btn" title="Hubungi via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                    </svg>
                                </a>

                                @if(auth()->user()->isAdmin())
                                {{-- Edit Link --}}
                                <a href="{{ route('pegawai.edit', $p) }}" class="pgw-icon-btn" title="Edit Pegawai">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('pegawai.destroy', $p) }}" onsubmit="return confirm('Hapus data pegawai {{ $p->nama_lengkap }}?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="pgw-icon-btn" style="color:#ef4444;" title="Hapus Pegawai">
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
                            <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data pegawai yang sesuai</p>
                            <a href="{{ route('pegawai.create') }}" style="color:#2563eb; text-decoration:none; font-size:12.5px; font-weight:600;">+ Tambah Pegawai Baru</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        <div class="pgw-pagination-footer">
            @if($perPageParam === 'all' || $pegawai->total() <= $pegawai->perPage())
                <span>Menampilkan semua <strong>{{ $pegawai->total() }}</strong> pegawai</span>
            @else
                <span>Menampilkan <strong>{{ $pegawai->firstItem() ?? 0 }}</strong> sampai <strong>{{ $pegawai->lastItem() ?? 0 }}</strong> dari <strong>{{ $pegawai->total() }}</strong> pegawai</span>
            @endif

            @if($pegawai->lastPage() > 1)
            <div class="pgw-page-btns">
                @if($pegawai->onFirstPage())
                    <span class="pgw-p-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </span>
                @else
                    <a href="{{ $pegawai->previousPageUrl() }}" class="pgw-p-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </a>
                @endif

                @php
                    $cur = $pegawai->currentPage();
                    $last = $pegawai->lastPage();
                @endphp
                @for($p = 1; $p <= $last; $p++)
                    @if($p == 1 || $p == $last || ($p >= $cur - 1 && $p <= $cur + 1))
                        @if($p == $cur)
                            <span class="pgw-p-btn active">{{ $p }}</span>
                        @else
                            <a href="{{ $pegawai->url($p) }}" class="pgw-p-btn">{{ $p }}</a>
                        @endif
                    @elseif($p == $cur - 2 || $p == $cur + 2)
                        <span class="pgw-p-btn disabled" style="border:none;">…</span>
                    @endif
                @endfor

                @if($pegawai->hasMorePages())
                    <a href="{{ $pegawai->nextPageUrl() }}" class="pgw-p-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span class="pgw-p-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Custom Per Page --}}
<div class="pgw-modal-overlay" id="customPerPageModal" onclick="closeCustomPerPageModal(event)">
    <div class="pgw-modal-box" onclick="event.stopPropagation()">
        <h3 style="margin:0 0 8px; font-size:16px; font-weight:700; color:#0f172a;">Custom Jumlah Tampilan Baris</h3>
        <p style="margin:0 0 16px; font-size:12.5px; color:#64748b;">Tentukan berapa banyak pegawai yang ingin ditampilkan per halaman (1 - 500 baris):</p>
        
        <form onsubmit="submitCustomPerPage(event)">
            <div style="margin-bottom:18px;">
                <input type="number" id="customPerPageInput" min="1" max="500" 
                       value="{{ is_numeric($perPageParam) ? $perPageParam : 10 }}" 
                       style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-weight:600; outline:none; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" onclick="document.getElementById('customPerPageModal').classList.remove('open')" 
                        style="padding:8px 14px; border:1px solid #cbd5e1; background:#fff; color:#475569; border-radius:6px; font-size:12.5px; font-weight:600; cursor:pointer;">
                    Batal
                </button>
                <button type="submit" 
                        style="padding:8px 16px; border:none; background:#0f2942; color:#fff; border-radius:6px; font-size:12.5px; font-weight:600; cursor:pointer;">
                    Terapkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFilterMenu() {
    const el = document.getElementById('pgwFilterDropdown');
    el.classList.toggle('show');
}

// Close when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('pgwFilterDropdown');
    const filterBtn = document.querySelector('.pgw-btn-filter');
    if (dropdown && !dropdown.contains(e.target) && filterBtn && !filterBtn.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});

// Handle per page change
function handlePerPageChange(val) {
    if (val === 'custom') {
        document.getElementById('customPerPageModal').classList.add('open');
        document.getElementById('customPerPageInput').focus();
        return;
    }

    applyPerPage(val);
}

function submitCustomPerPage(e) {
    e.preventDefault();
    const val = parseInt(document.getElementById('customPerPageInput').value) || 10;
    document.getElementById('customPerPageModal').classList.remove('open');
    applyPerPage(val);
}

function applyPerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.delete('page'); // Reset to page 1
    window.location.href = url.toString();
}

function closeCustomPerPageModal(e) {
    if (e.target.id === 'customPerPageModal') {
        document.getElementById('customPerPageModal').classList.remove('open');
    }
}
</script>
@endpush
