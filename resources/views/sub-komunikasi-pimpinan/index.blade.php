@extends('layouts.app')
@section('title', 'Sambutan — Komunikasi Pimpinan')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:20px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }

/* Tabs + Toolbar */
.sb-toolbar-wrap {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 12px;
}
.sb-tabs {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
    padding: 0 16px;
}
.sb-tab {
    padding: 12px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
    text-decoration: none;
    transition: color 0.15s;
}
.sb-tab:hover { color: #374151; }
.sb-tab.active { color: #111827; font-weight: 600; border-bottom-color: #1e3a5f; }
.sb-toolbar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
}
.sb-search-wrap { position:relative; flex:1; max-width:260px; }
.sb-search-wrap svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:#9ca3af; }
.sb-search-input {
    width:100%; padding:7px 12px 7px 32px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:13px; color:#374151; background:#f9fafb; outline:none;
}
.sb-search-input:focus { border-color:#2563eb; background:white; }
.sb-search-input::placeholder { color:#9ca3af; }
.sb-filter-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:7px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    background:white; font-size:12.5px; color:#374151;
    cursor:pointer; transition:all 0.15s; text-decoration:none;
}
.sb-filter-btn:hover { border-color:#2563eb; color:#2563eb; }
.sb-filter-btn svg { width:14px; height:14px; }
.sb-filter-select {
    padding:7px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    background:white; font-size:12.5px; color:#374151;
    cursor:pointer; outline:none; transition:all 0.15s;
    font-family:inherit; min-width:120px;
}
.sb-filter-select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.08); }
.sb-filter-select:hover { border-color:#2563eb; color:#2563eb; }

/* Selection Action Bar */
.selection-action-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 16px;
    margin-bottom: 12px;
    animation: fadeIn 0.15s ease;
}
@keyframes fadeIn { from { opacity:0; transform: translateY(-4px); } to { opacity:1; transform: translateY(0); } }
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
.btn-bulk-delete:hover { background: #dc2626; }
.btn-bulk-delete svg { width: 15px; height: 15px; }

/* Custom Checkbox */
.custom-checkbox {
    width: 17px;
    height: 17px;
    accent-color: #1e3a5f;
    cursor: pointer;
    border-radius: 4px;
    vertical-align: middle;
}

/* Flash message */
.flash-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}/* Table */
.sb-table-wrap { background:white; border:1px solid #e5e7eb; border-radius:10px; overflow:hidden; }
.sb-table { width:100%; border-collapse:collapse; }
.sb-table thead th {
    padding:12px 16px; text-align:left;
    font-size:12px; font-weight:600; color:#6b7280;
    border-bottom:1px solid #f3f4f6; background:white;
    text-transform:uppercase; letter-spacing:0.05em;
}
.sb-table tbody td {
    padding:15px 16px; font-size:13px; color:#374151;
    border-bottom:1px solid #f9fafb; vertical-align:middle;
}
.sb-table tbody tr:last-child td { border-bottom:none; }
.sb-table tbody tr:hover { background:#fafbff; }
.sb-table tbody tr.row-selected { background:#f0f7ff; }
.sb-nomor { font-weight:600; color:#2563eb; font-size:13px; }
.sb-perihal-main { font-weight:500; font-size:13px; color:#111827; line-height: 1.4; }
.sb-perihal-sub  { font-size:11.5px; color:#9ca3af; margin-top:2px; }
.sb-tujuan-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 600;
    background: #e0f2fe;
    color: #0369a1;
    margin-top: 4px;
}
.sb-status-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.sb-status-badge.sb-status-progres {
    background: #fef3c7;
    color: #b45309;
}
.sb-status-badge.sb-status-selesai {
    background: #dcfce7;
    color: #15803d;
}
.sb-status-badge.sb-status-draft {
    background: #f1f5f9;
    color: #475569;
}
.sb-deadline-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    font-weight: 500;
    color: #475569;
    margin-top: 3px;
}
.sb-deadline-badge.overdue {
    color: #dc2626;
    font-weight: 600;
}

/* Pagination */
.sb-pagination { display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid #f3f4f6; font-size:13px; color:#6b7280; }
.sb-page-btns { display:flex; align-items:center; gap:3px; }
.sb-page-btn { min-width:32px; height:32px; padding:0 8px; border:1px solid #e5e7eb; border-radius:6px; background:white; font-size:13px; color:#6b7280; cursor:pointer; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.15s; }
.sb-page-btn:hover { border-color:#2563eb; color:#2563eb; }
/* Document Pills */
.sb-file-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s;
    margin-top: 4px;
}
.sb-file-pill.permohonan {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.sb-file-pill.permohonan:hover {
    background: #e2e8f0;
    color: #1e293b;
}
.sb-file-pill.hasil {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.sb-file-pill.hasil:hover {
    background: #d1fae5;
    color: #047857;
}
.btn-quick-upload-hasil {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: #f8fafc;
    border: 1px dashed #94a3b8;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    color: #2563eb;
    cursor: pointer;
    transition: all 0.15s;
}
.btn-quick-upload-hasil:hover {
    background: #eff6ff;
    border-color: #2563eb;
    border-style: solid;
    color: #1d4ed8;
}

/* Modal styles */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-card {
    background: white;
    border-radius: 14px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    overflow: hidden;
    animation: modalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.96) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.modal-title { font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 4px; }
.modal-desc { font-size: 12.5px; color: #64748b; margin: 0; }
.modal-close { background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1; padding: 0 4px; }
.modal-close:hover { color: #334155; }
.modal-body { padding: 20px 24px; max-height: 70vh; overflow-y: auto; }
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
}
.btn-modal-cancel {
    padding: 8px 16px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: white;
    color: #374151;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}
.btn-modal-cancel:hover { background: #f3f4f6; }
.btn-modal-submit {
    padding: 8px 18px;
    border: 1px solid #1e3a5f;
    border-radius: 7px;
    background: #1e3a5f;
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modal-submit:hover { background: #162f4f; }
.upload-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 22px 16px;
    text-align: center;
    cursor: pointer;
    background: #f8fafc;
    display: block;
    transition: all 0.15s;
}
.upload-dropzone:hover { border-color: #2563eb; background: #eff6ff; }
.upload-dropzone input[type="file"] { display: none; }
.modal-form-group { margin-bottom: 16px; }
.modal-form-group:last-child { margin-bottom: 0; }
.modal-form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.modal-form-label .req { color: #ef4444; }
.modal-form-select, .modal-form-textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
    color: #1e293b;
    outline: none;
    font-family: inherit;
}
.modal-form-select:focus, .modal-form-textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
</style>
@endpush

@section('content')

@if(session('success'))
<div class="flash-success">
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
        <h1>Sambutan</h1>
        <p>Kelola dan pantau seluruh permohonan disposisi dan naskah hasil sambutan pimpinan</p>
    </div>
    @if(auth()->user()->isAdmin())
        <div style="display:flex;gap:10px;align-items:center;">
            @if($jenis === 'hasil')
                <button type="button" onclick="openUploadHasilModal()" style="display:inline-flex;align-items:center;gap:7px;padding:10px 18px;font-size:13.5px;font-weight:600;border-radius:8px;background:#1e3a5f;color:white;border:none;cursor:pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Upload Hasil Sambutan
                </button>
            @else
                <button type="button" onclick="openUploadHasilModal()" style="display:inline-flex;align-items:center;gap:7px;padding:10px 16px;font-size:13.5px;font-weight:600;border-radius:8px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Upload Hasil Sambutan
                </button>
                <a href="{{ route('sambutan.create-permohonan') }}" style="display:inline-flex;align-items:center;gap:7px;text-decoration:none;padding:10px 18px;font-size:13.5px;font-weight:600;border-radius:8px;background:#1e3a5f;color:white;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Upload Surat dan Disposisi
                </a>
            @endif
        </div>
    @endif
</div>

@if(auth()->user()->isAdmin())
{{-- Bulk Selection Action Bar --}}
<form id="bulkDeleteForm" method="POST" action="{{ route('sambutan.bulk-destroy') }}">
    @csrf
    <input type="hidden" name="tab" value="{{ $jenis }}">
    <div id="selectionActionBar" class="selection-action-bar">
        <div class="selection-info">
            <span class="selection-badge" id="selectedCountBadge">0</span>
            <span>surat terpilih</span>
            <button type="button" onclick="clearAllSelections()" style="background:none;border:none;color:#2563eb;cursor:pointer;font-size:13px;text-decoration:underline;margin-left:8px">Batal Pilih</button>
        </div>
        <button type="submit" class="btn-bulk-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus semua surat yang dipilih?')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            Hapus Surat Terpilih
        </button>
    </div>
</form>
@endif

{{-- Tabs + Toolbar --}}
<div class="sb-toolbar-wrap">
    <div class="sb-tabs">
        <a href="{{ route('sambutan.index', ['tab' => 'permohonan']) }}" class="sb-tab {{ $jenis === 'permohonan' ? 'active' : '' }}">Sambutan</a>
        <a href="{{ route('sambutan.index', ['tab' => 'hasil']) }}" class="sb-tab {{ $jenis === 'hasil' ? 'active' : '' }}">Hasil</a>
    </div>
    <form method="GET" action="{{ route('sambutan.index') }}" class="sb-toolbar" id="filterForm">
        <input type="hidden" name="tab" value="{{ $jenis }}">
        <div class="sb-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" class="sb-search-input" name="search" value="{{ request('search') }}" placeholder="Cari judul, tujuan, atau nomor surat...">
        </div>
        <select name="filter_tahun" class="sb-filter-select" onchange="document.getElementById('filterForm').submit()" title="Filter Tahun">
            <option value="">Semua Tahun</option>
            @for($y = now()->year + 1; $y >= 2024; $y--)
                <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <select name="filter_bulan" class="sb-filter-select" onchange="document.getElementById('filterForm').submit()" title="Filter Bulan">
            <option value="">Semua Bulan</option>
            @php
                $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            @endphp
            @foreach($namaBulan as $num => $nama)
                <option value="{{ $num }}" {{ $filterBulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>
        @if($filterTahun || $filterBulan || request('search'))
            <a href="{{ route('sambutan.index', ['tab' => $jenis]) }}" class="sb-filter-btn" title="Reset Filter" style="color:#ef4444;border-color:#fca5a5;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Reset
            </a>
        @endif
        <button type="submit" class="sb-filter-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Filter
        </button>
        @php
            $exportParams = ['tahun' => $filterTahun ?: now()->year];
            if ($filterBulan) $exportParams['bulan'] = $filterBulan;
        @endphp
        <a href="{{ route('sambutan.export-rekap', $exportParams) }}" class="sb-filter-btn" style="background:#1e3a5f;color:white;border-color:#1e3a5f;" title="Export ke Excel">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Export Excel
        </a>
    </form>
</div>

{{-- Table --}}
<div class="sb-table-wrap">
    <table class="sb-table">
        <thead>
            <tr>
                @if(auth()->user()->isAdmin())
                <th style="width:36px;text-align:center">
                    <input type="checkbox" id="selectAll" class="custom-checkbox" title="Pilih Semua">
                </th>
                @endif
                <th style="width:40px">No</th>
                <th>Nomor Surat</th>
                <th>Perihal &amp; Tujuan</th>
                <th>Tanggal Acara</th>
                <th>Deadline &amp; Disposisi</th>
                <th>Naskah Hasil</th>
                <th>Status</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sambutan as $i => $item)
            <tr id="row-{{ $item->id }}">
                @if(auth()->user()->isAdmin())
                <td style="text-align:center">
                    <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" form="bulkDeleteForm" class="custom-checkbox row-checkbox" onchange="updateSelectionUI()">
                </td>
                @endif
                <td style="color:#9ca3af;font-size:13px">{{ $sambutan->firstItem() + $i }}</td>
                <td>
                    <span class="sb-nomor">{{ $item->nomor_surat }}</span>
                    <div style="font-size:11.5px;color:#64748b;margin-top:2px;">{{ $item->asal_instansi }}</div>
                    @if($item->file_path)
                        <div>
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="sb-file-pill permohonan" title="Lihat Surat Permohonan Masuk">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <span>Surat Masuk</span>
                            </a>
                        </div>
                    @endif
                </td>
                <td>
                    <div class="sb-perihal-main">{{ $item->perihal }}</div>
                    @if($item->tujuan)
                        <div class="sb-tujuan-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:11px;height:11px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            <span>{{ $item->tujuan }}</span>
                        </div>
                    @endif
                    @if($item->deskripsi_singkat)
                        <div class="sb-perihal-sub">{{ Str::limit($item->deskripsi_singkat, 40) }}</div>
                    @endif
                </td>
                <td>
                    @if($item->tanggal_acara)
                        <div style="font-weight:600;color:#0f172a;font-size:12.5px">{{ $item->tanggal_acara->translatedFormat('d M Y') }}</div>
                        @if($item->waktu_acara)
                            <div style="font-size:11.5px;color:#64748b;margin-top:2px;">{{ $item->waktu_acara }} WIB</div>
                        @endif
                    @elseif($item->tanggal_terima)
                        <div style="color:#64748b;font-size:12px">{{ $item->tanggal_terima->translatedFormat('d M Y') }}</div>
                    @else
                        <span style="color:#9ca3af">—</span>
                    @endif
                </td>
                <td>
                    <div style="font-weight:500;color:#1e293b">{{ $item->petugas ? $item->petugas->nama_lengkap : '—' }}</div>
                    @if($item->deadline_at)
                        @php
                            $isOverdue = $item->deadline_at->isPast() && $item->status !== 'selesai';
                        @endphp
                        <div class="sb-deadline-badge {{ $isOverdue ? 'overdue' : '' }}" title="Batas waktu disposisi: maks. 2 jam">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $item->deadline_at->format('d M Y, H:i') }}</span>
                            @if($isOverdue)
                                <span style="font-size:10px;background:#fef2f2;color:#ef4444;padding:1px 4px;border-radius:4px;border:1px solid #fca5a5">Terlewat</span>
                            @endif
                        </div>
                    @elseif($item->tenggat_waktu)
                        <div class="sb-deadline-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $item->tenggat_waktu->format('d M Y') }}</span>
                        </div>
                    @endif
                </td>
                <td>
                    @if($item->file_hasil_path)
                        <div style="display:flex;flex-direction:column;gap:3px">
                            <div style="display:flex;align-items:center;gap:5px">
                                <a href="{{ route('sambutan.preview-hasil', $item->id) }}" class="sb-file-pill hasil" title="Lihat Pratinjau Naskah Sambutan">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>Lihat Naskah</span>
                                </a>
                                <a href="{{ route('sambutan.download-hasil', $item->id) }}" title="Unduh File Dokumen ({{ $item->file_hasil_name }})" style="display:inline-flex;align-items:center;justify-content:center;padding:5px 7px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;color:#16a34a;text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='#dcfce7'" onmouseout="this.style.background='#f0fdf4'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                </a>
                            </div>
                            @if($item->tgl_upload_hasil)
                                <span style="font-size:10.5px;color:#059669;font-weight:500;">
                                    {{ $item->tgl_upload_hasil->format('d M Y, H:i') }}
                                </span>
                            @endif
                        </div>
                    @else
                        @if(auth()->user()->isAdmin())
                            <button type="button" class="btn-quick-upload-hasil" onclick="openUploadHasilModal({{ $item->id }}, '{{ addslashes($item->nomor_surat) }}', '{{ addslashes($item->perihal) }}')" title="Unggah Naskah Hasil Sambutan untuk Surat Ini">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                <span>Upload Hasil</span>
                            </button>
                        @else
                            <span style="font-size:11.5px;color:#9ca3af;font-style:italic">Belum ada</span>
                        @endif
                    @endif
                </td>
                <td>
                    <span class="sb-status-badge {{ $item->status_badge_class }}">
                        {{ $item->status_label }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;justify-content:flex-end">
                        {{-- WhatsApp --}}
                        @php
                            $rowDocUrl = $item->file_path ? url('storage/' . $item->file_path) : null;
                            $rowHasilUrl = $item->file_hasil_path ? url('storage/' . $item->file_hasil_path) : null;
                            $rowAcara = $item->tanggal_acara ? $item->tanggal_acara->translatedFormat('d F Y') : '-';
                            $rowDeadline = $item->deadline_at ? $item->deadline_at->format('d F Y, H:i') : ($item->tenggat_waktu ? $item->tenggat_waktu->translatedFormat('d F Y') : '-');

                            $rowWaLines = [
                                "📄 *DISPOSISI SURAT SAMBUTAN*",
                                "Nomor Surat: " . $item->nomor_surat,
                                "Instansi: " . $item->asal_instansi,
                                "Tujuan: " . ($item->tujuan ?: '-'),
                                "Tanggal Acara: " . $rowAcara,
                                "Perihal: " . $item->perihal,
                                "Petugas: " . ($item->petugas ? $item->petugas->nama_lengkap : '-'),
                                "Deadline: " . $rowDeadline . " (Maks. 2 Jam)",
                                "Status: " . $item->status_label,
                            ];

                            if ($rowDocUrl) {
                                $rowWaLines[] = "Dokumen Surat Masuk: " . $rowDocUrl;
                            }
                            if ($rowHasilUrl) {
                                $rowWaLines[] = "Naskah Hasil Sambutan: " . $rowHasilUrl;
                            }

                            $rowWaText = implode("\n", $rowWaLines);
                            $rowWaHref = "https://api.whatsapp.com/send?text=" . urlencode($rowWaText);
                        @endphp
                        <a href="{{ $rowWaHref }}" target="_blank" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#25d366;text-decoration:none;transition:background 0.15s" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='transparent'" title="Kirim WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>

                        @if(auth()->user()->isAdmin())
                        {{-- Quick Upload / Ganti Hasil Button in Actions --}}
                        <button type="button" onclick="openUploadHasilModal({{ $item->id }}, '{{ addslashes($item->nomor_surat) }}', '{{ addslashes($item->perihal) }}')" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:{{ $item->file_hasil_path ? '#059669' : '#2563eb' }};background:none;border:none;cursor:pointer;transition:all 0.15s" onmouseover="this.style.background='{{ $item->file_hasil_path ? '#ecfdf5' : '#eff6ff' }}'" onmouseout="this.style.background='transparent'" title="{{ $item->file_hasil_path ? 'Perbarui / Ganti Naskah Hasil' : 'Unggah Naskah Hasil' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </button>

                        {{-- Edit --}}
                        <a href="{{ route('sambutan.edit', $item) }}" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#6b7280;text-decoration:none;transition:all 0.15s" onmouseover="this.style.background='#f3f4f6';this.style.color='#1e40af'" onmouseout="this.style.background='transparent';this.style.color='#6b7280'" title="Edit Surat">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                        </a>
                        {{-- Delete --}}
                        <form method="POST" action="{{ route('sambutan.destroy', $item) }}" onsubmit="return confirm('Hapus surat ini?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#9ca3af;background:none;border:none;cursor:pointer;transition:all 0.15s" onmouseover="this.style.background='#fee2e2';this.style.color='#dc2626'" onmouseout="this.style.background='transparent';this.style.color='#9ca3af'" title="Hapus Surat">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:48px;color:#9ca3af">
                    @if($jenis === 'hasil')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" style="width:48px;height:48px;margin:0 auto 12px;display:block;color:#059669;opacity:0.6;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p style="font-weight:700;font-size:15px;color:#111827;margin-bottom:4px">Belum Ada Naskah Hasil Sambutan</p>
                        <p style="font-size:13px;color:#6b7280;margin-bottom:16px;max-width:440px;margin-left:auto;margin-right:auto;line-height:1.5;">
                            Naskah hasil sambutan yang diunggah akan otomatis tampil di sini dan tetap menyatu dengan data surat permohonan &amp; disposisi terkait.
                        </p>
                        @if(auth()->user()->isAdmin())
                            <button type="button" onclick="openUploadHasilModal()" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:#1e3a5f;color:white;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                Upload Naskah Hasil Sambutan Sekarang
                            </button>
                        @endif
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:44px;height:44px;margin:0 auto 12px;display:block;opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <p style="font-weight:500;margin-bottom:8px">Belum ada data surat</p>
                        <a href="{{ route('sambutan.create-permohonan') }}" style="color:#2563eb;font-size:13px">+ Upload surat sekarang</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    {{-- Pagination --}}
    <div class="sb-pagination">
        <span>
            @if($sambutan->total() > 0)
                Menampilkan {{ $sambutan->firstItem() }} sampai {{ $sambutan->lastItem() }} dari {{ $sambutan->total() }} hasil
            @else
                Tidak ada hasil
            @endif
        </span>
        <div class="sb-page-btns">
            @if($sambutan->onFirstPage())
                <span class="sb-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg></span>
            @else
                <a href="{{ $sambutan->previousPageUrl() }}" class="sb-page-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg></a>
            @endif
            @php
                $cur = $sambutan->currentPage(); $last = $sambutan->lastPage();
                $pages = $last <= 7 ? range(1, $last) : array_unique(array_filter([1, $cur > 3 ? '...' : null, ...range(max(2,$cur-1), min($last-1,$cur+1)), $cur < $last-2 ? '...' : null, $last]));
            @endphp
            @foreach($pages as $page)
                @if($page === '...')
                    <span class="sb-page-btn disabled" style="border:none;background:none">…</span>
                @elseif($page == $cur)
                    <span class="sb-page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $sambutan->url($page) }}" class="sb-page-btn">{{ $page }}</a>
                @endif
            @endforeach
            @if($sambutan->hasMorePages())
                <a href="{{ $sambutan->nextPageUrl() }}" class="sb-page-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg></a>
            @else
                <span class="sb-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg></span>
            @endif
        </div>
    </div>
</div>

{{-- Modal Upload Hasil Sambutan --}}
<div id="modalUploadHasil" class="modal-overlay" style="display:none">
    <div class="modal-card">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Upload Naskah Hasil Sambutan</h3>
                <p class="modal-desc">Naskah hasil akan langsung menyatu dengan surat permohonan &amp; disposisi ini.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeUploadHasilModal()">&times;</button>
        </div>
        <form method="POST" action="{{ route('sambutan.upload-hasil-global') }}" enctype="multipart/form-data" id="formUploadHasil" onsubmit="return validateUploadHasil()">
            @csrf
            <div class="modal-body">
                <div class="modal-form-group" id="groupSelectSambutan">
                    <label class="modal-form-label">Pilih Surat Permohonan Sambutan <span class="req">*</span></label>
                    <select class="modal-form-select" name="sambutan_id" id="modalSelectSambutan" required>
                        <option value="" disabled selected>Pilih surat sambutan tujuan...</option>
                        @foreach($pendingSambutan as $ps)
                            <option value="{{ $ps->id }}">
                                {{ $ps->nomor_surat }} — {{ Str::limit($ps->perihal, 35) }} ({{ $ps->asal_instansi }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Info box when locked to a specific surat from table row --}}
                <div id="modalSuratInfoBox" style="display:none;background:#f0f7ff;border:1px solid #bfdbfe;border-radius:8px;padding:12px 14px;margin-bottom:16px;">
                    <div style="font-size:11px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:3px;">Menyatu dengan Surat:</div>
                    <div id="modalInfoNomor" style="font-size:13.5px;font-weight:700;color:#1e3a5f;"></div>
                    <div id="modalInfoPerihal" style="font-size:12px;color:#475569;margin-top:2px;"></div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Dokumen Naskah Hasil Sambutan (.docx, .doc, .pdf) <span class="req">*</span></label>
                    <label class="upload-dropzone" for="modalFileHasil" id="modalDropzone">
                        <input type="file" id="modalFileHasil" name="dokumen_hasil" accept=".docx,.doc,.pdf" required onchange="handleModalFile(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" style="width:34px;height:34px;color:#2563eb;margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <div id="modalDropTitle" style="font-size:13px;font-weight:600;color:#111827;">Klik atau Drag &amp; Drop file naskah di sini</div>
                        <div id="modalDropSub" style="font-size:11.5px;color:#6b7280;margin-top:3px;">Format Word (.docx, .doc) atau PDF, maks. 15MB</div>
                    </label>
                    <div id="modalFileError" style="display:none;color:#dc2626;font-size:12px;margin-top:6px;font-weight:500;">
                        ⚠️ File naskah hasil sambutan wajib dipilih!
                    </div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Catatan Tambahan (Opsional)</label>
                    <textarea class="modal-form-textarea" name="catatan_hasil" rows="2" placeholder="Catatan revisi atau instruksi khusus naskah sambutan..."></textarea>
                </div>

                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 14px;display:flex;align-items:center;gap:10px;margin-top:8px;">
                    <input type="checkbox" name="status" value="selesai" id="cbSelesai" checked style="width:16px;height:16px;accent-color:#1e3a5f;cursor:pointer;">
                    <label for="cbSelesai" style="font-size:12.5px;color:#334155;font-weight:500;cursor:pointer;margin:0;">
                        Tandai status surat permohonan langsung menjadi <span style="color:#15803d;font-weight:700">Selesai</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeUploadHasilModal()">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmitModalHasil">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Simpan &amp; Satukan Naskah
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const selectAll = document.getElementById('selectAll');
const checkboxes = document.querySelectorAll('.row-checkbox');
const selectionActionBar = document.getElementById('selectionActionBar');
const selectedCountBadge = document.getElementById('selectedCountBadge');

if (selectAll) {
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => {
            cb.checked = selectAll.checked;
            highlightRow(cb);
        });
        updateSelectionUI();
    });
}

function highlightRow(cb) {
    const row = document.getElementById('row-' + cb.value);
    if (row) {
        if (cb.checked) {
            row.classList.add('row-selected');
        } else {
            row.classList.remove('row-selected');
        }
    }
}

function updateSelectionUI() {
    let count = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) count++;
        highlightRow(cb);
    });

    if (count > 0) {
        selectionActionBar.style.display = 'flex';
        selectedCountBadge.textContent = count;
    } else {
        selectionActionBar.style.display = 'none';
        if (selectAll) selectAll.checked = false;
    }

    if (selectAll && checkboxes.length > 0) {
        selectAll.checked = (count === checkboxes.length);
    }
}

function clearAllSelections() {
    checkboxes.forEach(cb => {
        cb.checked = false;
        highlightRow(cb);
    });
    if (selectAll) selectAll.checked = false;
    updateSelectionUI();
}

// Modal Upload Hasil Sambutan Logic
function openUploadHasilModal(sambutanId = null, nomorSurat = '', perihal = '') {
    const modal = document.getElementById('modalUploadHasil');
    const selectGroup = document.getElementById('groupSelectSambutan');
    const selectElement = document.getElementById('modalSelectSambutan');
    const infoBox = document.getElementById('modalSuratInfoBox');
    const infoNomor = document.getElementById('modalInfoNomor');
    const infoPerihal = document.getElementById('modalInfoPerihal');
    const dropTitle = document.getElementById('modalDropTitle');
    const dropSub = document.getElementById('modalDropSub');
    const dropzone = document.getElementById('modalDropzone');
    const fileInput = document.getElementById('modalFileHasil');
    const fileError = document.getElementById('modalFileError');
    const form = document.getElementById('formUploadHasil');

    // Reset file input state
    fileInput.value = '';
    dropTitle.textContent = 'Klik atau Drag & Drop file naskah di sini';
    dropSub.textContent = 'Format Word (.docx, .doc) atau PDF, maks. 15MB';
    dropzone.style.borderColor = '#cbd5e1';
    dropzone.style.background = '#f8fafc';
    if (fileError) fileError.style.display = 'none';

    if (sambutanId) {
        // Specific row clicked
        selectGroup.style.display = 'none';
        selectElement.removeAttribute('required');
        
        infoBox.style.display = 'block';
        infoNomor.textContent = 'Nomor: ' + nomorSurat;
        infoPerihal.textContent = 'Perihal: ' + perihal;

        // Set action to specific row route
        form.action = '/komunikasi-pimpinan/sambutan/' + sambutanId + '/upload-hasil';
    } else {
        // Global header button clicked
        selectGroup.style.display = 'block';
        selectElement.setAttribute('required', 'required');
        selectElement.value = '';
        
        infoBox.style.display = 'none';

        // Set action to global upload route
        form.action = '{{ route("sambutan.upload-hasil-global") }}';
    }

    modal.style.display = 'flex';
}

function closeUploadHasilModal() {
    const modal = document.getElementById('modalUploadHasil');
    modal.style.display = 'none';
}

function handleModalFile(input) {
    const dropTitle = document.getElementById('modalDropTitle');
    const dropSub = document.getElementById('modalDropSub');
    const dropzone = document.getElementById('modalDropzone');
    const fileError = document.getElementById('modalFileError');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        dropTitle.textContent = file.name;
        dropSub.textContent = 'Siap diunggah (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        dropzone.style.borderColor = '#2563eb';
        dropzone.style.background = '#eff6ff';
        if (fileError) fileError.style.display = 'none';
    } else {
        dropTitle.textContent = 'Klik atau Drag & Drop file naskah di sini';
        dropSub.textContent = 'Format Word (.docx, .doc) atau PDF, maks. 15MB';
        dropzone.style.borderColor = '#cbd5e1';
        dropzone.style.background = '#f8fafc';
    }
}

function validateUploadHasil() {
    const fileInput = document.getElementById('modalFileHasil');
    const fileError = document.getElementById('modalFileError');
    const dropzone = document.getElementById('modalDropzone');
    const selectGroup = document.getElementById('groupSelectSambutan');
    const selectElement = document.getElementById('modalSelectSambutan');

    if (selectGroup.style.display !== 'none' && !selectElement.value) {
        alert('Silakan pilih surat permohonan sambutan terlebih dahulu.');
        selectElement.focus();
        return false;
    }

    if (!fileInput.files || fileInput.files.length === 0) {
        if (fileError) fileError.style.display = 'block';
        dropzone.style.borderColor = '#ef4444';
        dropzone.style.background = '#fef2f2';
        return false;
    }

    const submitBtn = document.getElementById('btnSubmitModalHasil');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Menyimpan...';
    }
    return true;
}

// Close modal when clicking outside of card
window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalUploadHasil');
    if (e.target === modal) {
        closeUploadHasilModal();
    }
});
</script>
@endpush
