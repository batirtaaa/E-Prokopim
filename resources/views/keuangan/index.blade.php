@extends('layouts.app')
@section('title', 'Daftar Keuangan — E-PROKOPIM')

@push('styles')
<style>
/* Base Container */
.keu-container {
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.keu-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.keu-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0;
}
.keu-btn-add {
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
.keu-btn-add:hover {
    background: #081d30;
    color: #ffffff;
}

/* Card Container */
.keu-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}

/* Toolbar */
.keu-toolbar {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.keu-search-box {
    position: relative;
    flex: 1;
    max-width: 340px;
}
.keu-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    width: 15px;
    height: 15px;
    pointer-events: none;
}
.keu-search-input {
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
.keu-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.keu-search-input::placeholder {
    color: #94a3b8;
}

.keu-actions-group {
    display: flex;
    align-items: center;
    gap: 8px;
}
.keu-btn-filter {
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
.keu-btn-filter:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}
.keu-btn-icon-export {
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
.keu-btn-icon-export:hover {
    border-color: #94a3b8;
    background: #f8fafc;
}

/* Filter Dropdown Modal */
.keu-filter-dropdown {
    display: none;
    position: absolute;
    right: 20px;
    top: 75px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 16px;
    z-index: 50;
    width: 260px;
}
.keu-filter-dropdown.show {
    display: block;
}

/* Table Style */
.keu-table-wrap {
    overflow-x: auto;
}
.keu-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.keu-table thead th {
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
.keu-table thead th:last-child {
    text-align: right;
}
.keu-table tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.keu-table tbody tr:last-child td {
    border-bottom: none;
}
.keu-table tbody tr:hover {
    background: #fafcff;
}

/* Status Pill Badges */
.keu-status-pill {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 500;
    white-space: nowrap;
    text-align: center;
}
.keu-status-pill.status-pns {
    background: #dbeafe;
    color: #1e40af;
}
.keu-status-pill.status-pppk-penuh {
    background: #e0e7ff;
    color: #3730a3;
}
.keu-status-pill.status-pppk-paruh {
    background: #e2e8f0;
    color: #334155;
}
.keu-status-pill.status-outsourcing {
    background: #f1f5f9;
    color: #475569;
}
.keu-status-pill.status-default {
    background: #f1f5f9;
    color: #475569;
}

/* Action Icons */
.keu-row-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}
.keu-icon-btn {
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
.keu-icon-btn:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.keu-icon-btn.whatsapp-btn:hover {
    color: #16a34a;
    background: #f0fdf4;
}

/* Pagination Footer */
.keu-pagination-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
}
.keu-page-btns {
    display: flex;
    align-items: center;
    gap: 4px;
}
.keu-p-btn {
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
.keu-p-btn:hover {
    border-color: #cbd5e1;
    color: #0f172a;
}
.keu-p-btn.active {
    background: #0f2942;
    border-color: #0f2942;
    color: #ffffff;
    font-weight: 600;
}
.keu-p-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endpush

@section('content')
<div class="keu-container">

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
    <div class="keu-header-row">
        <h1 class="keu-title">Daftar Keuangan</h1>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('keuangan.create') }}" class="keu-btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Transaksi</span>
        </a>
        @endif
    </div>

    {{-- Main Card --}}
    <div class="keu-card" style="position: relative;">
        {{-- Toolbar --}}
        <div class="keu-toolbar">
            <form method="GET" action="{{ route('keuangan.index') }}" id="keuSearchForm" style="display:flex; align-items:center; gap:10px; width:100%; justify-content:space-between; flex-wrap:wrap;">
                <div class="keu-search-box">
                    <svg class="keu-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" name="search" class="keu-search-input" placeholder="Cari transaksi, no bukti, atau uraian..." value="{{ request('search') }}">
                </div>

                <div class="keu-actions-group">
                    <button type="button" class="keu-btn-filter" onclick="toggleKeuFilterMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('keuangan.export') }}" class="keu-btn-icon-export" title="Unduh CSV">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        {{-- Filter Popup Menu --}}
        <div id="keuFilterDropdown" class="keu-filter-dropdown">
            <form method="GET" action="{{ route('keuangan.index') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div style="font-weight:600; font-size:13px; margin-bottom:10px; color:#0f172a;">Filter Kategori</div>
                <div style="margin-bottom:12px;">
                    <select name="kategori" style="width:100%; padding:7px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:12.5px;">
                        <option value="">Semua Kategori</option>
                        <option value="Jamuan Tamu" {{ request('kategori') == 'Jamuan Tamu' ? 'selected' : '' }}>Jamuan Tamu</option>
                        <option value="Perjalanan Dinas" {{ request('kategori') == 'Perjalanan Dinas' ? 'selected' : '' }}>Perjalanan Dinas</option>
                        <option value="Honorarium" {{ request('kategori') == 'Honorarium' ? 'selected' : '' }}>Honorarium</option>
                        <option value="Operasional" {{ request('kategori') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="Pemeliharaan" {{ request('kategori') == 'Pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
                        <option value="Publikasi" {{ request('kategori') == 'Publikasi' ? 'selected' : '' }}>Publikasi</option>
                    </select>
                </div>

                <div style="font-weight:600; font-size:13px; margin-bottom:6px; color:#0f172a;">Status</div>
                <div style="margin-bottom:12px;">
                    <select name="status" style="width:100%; padding:7px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:12.5px;">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <a href="{{ route('keuangan.index') }}" style="padding:5px 10px; font-size:12px; color:#64748b; text-decoration:none;">Reset</a>
                    <button type="submit" style="padding:5px 12px; font-size:12px; background:#0f2942; color:#fff; border:none; border-radius:6px; cursor:pointer;">Terapkan</button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="keu-table-wrap">
            <table class="keu-table">
                <thead>
                    <tr>
                        <th>NO BUKTI</th>
                        <th>TANGGAL</th>
                        <th>URAIAN TRANSAKSI</th>
                        <th>KATEGORI</th>
                        <th>NOMINAL</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $trx)
                    <tr>
                        <td style="font-weight: 600; color: #0f172a;">{{ $trx->no_bukti }}</td>
                        <td style="color: #64748b; white-space: nowrap;">{{ $trx->tanggal ? $trx->tanggal->format('d M Y') : '—' }}</td>
                        <td>
                            <div style="display:flex; flex-direction:column; gap:2px;">
                                <span style="font-weight:600; color:#0f172a;">{{ $trx->uraian }}</span>
                                @if($trx->penanggung_jawab)
                                    <span style="font-size:12px; color:#64748b;">PJ: {{ $trx->penanggung_jawab }}</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $trx->kategori }}</td>
                        <td style="font-weight: 600; color: #0f172a; white-space: nowrap;">{{ $trx->formatted_nominal }}</td>
                        <td>
                            <span class="keu-status-pill {{ $trx->status_badge_class }}">
                                {{ $trx->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="keu-row-actions">
                                {{-- File bukti download or data export --}}
                                @if($trx->file_bukti)
                                    <a href="{{ asset('storage/' . $trx->file_bukti) }}" target="_blank" class="keu-icon-btn" title="Unduh Bukti">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('keuangan.export') }}" class="keu-icon-btn" title="Unduh Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                @endif

                                {{-- WhatsApp share --}}
                                <a href="https://wa.me/?text={{ urlencode('Informasi Keuangan: ' . $trx->no_bukti . ' - ' . $trx->uraian . ' (' . $trx->formatted_nominal . '). Status: ' . $trx->status_label) }}" target="_blank" class="keu-icon-btn whatsapp-btn" title="Bagikan via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                    </svg>
                                </a>

                                @if(auth()->user()->isAdmin())
                                {{-- Edit --}}
                                <a href="{{ route('keuangan.edit', $trx) }}" class="keu-icon-btn" title="Edit Transaksi">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('keuangan.destroy', $trx) }}" onsubmit="return confirm('Hapus data transaksi {{ $trx->no_bukti }}?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="keu-icon-btn" style="color:#ef4444;" title="Hapus Transaksi">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 48px 20px; color: #94a3b8;">
                            <p style="font-weight: 500; margin: 0 0 8px 0;">Belum ada data transaksi keuangan yang sesuai</p>
                            <a href="{{ route('keuangan.create') }}" style="color:#2563eb; text-decoration:none; font-size:12.5px; font-weight:600;">+ Tambah Transaksi Baru</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        <div class="keu-pagination-footer">
            <span>Menampilkan {{ $transaksi->firstItem() ?? 0 }} sampai {{ $transaksi->lastItem() ?? 0 }} dari {{ $transaksi->total() }} data transaksi</span>
            <div class="keu-page-btns">
                @if($transaksi->onFirstPage())
                    <span class="keu-p-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </span>
                @else
                    <a href="{{ $transaksi->previousPageUrl() }}" class="keu-p-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </a>
                @endif

                @php
                    $cur = $transaksi->currentPage();
                    $last = $transaksi->lastPage();
                @endphp
                @for($p = 1; $p <= min(3, $last); $p++)
                    @if($p == $cur)
                        <span class="keu-p-btn active">{{ $p }}</span>
                    @else
                        <a href="{{ $transaksi->url($p) }}" class="keu-p-btn">{{ $p }}</a>
                    @endif
                @endfor
                @if($last > 3)
                    <span class="keu-p-btn disabled" style="border:none;">…</span>
                @endif

                @if($transaksi->hasMorePages())
                    <a href="{{ $transaksi->nextPageUrl() }}" class="keu-p-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span class="keu-p-btn disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleKeuFilterMenu() {
    const el = document.getElementById('keuFilterDropdown');
    el.classList.toggle('show');
}

// Close when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('keuFilterDropdown');
    const filterBtn = document.querySelector('.keu-btn-filter');
    if (dropdown && !dropdown.contains(e.target) && filterBtn && !filterBtn.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});
</script>
@endpush
