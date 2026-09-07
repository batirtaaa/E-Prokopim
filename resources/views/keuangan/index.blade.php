@extends('layouts.app')
@section('title', 'Surat Masuk — Bagian Protokol dan Komunikasi Pimpinan')

@push('styles')
<style>
/* Page Header */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 22px;
    gap: 16px;
    flex-wrap: wrap;
}
.page-header-left h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.page-header-left p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}
.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.btn-primary-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 600;
    border-radius: 8px;
    background: #1e3a5f;
    color: #ffffff;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s ease;
    box-shadow: 0 2px 4px rgba(30, 58, 95, 0.15);
}
.btn-primary-action:hover {
    background: #162f4f;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(30, 58, 95, 0.2);
}
.btn-primary-action svg { width: 16px; height: 16px; }

.btn-secondary-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 15px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s ease;
}
.btn-secondary-action:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}
.btn-secondary-action svg { width: 15px; height: 15px; }

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
@media (max-width: 900px) {
    .stats-grid { grid-template-columns: 1fr; }
}

.stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.stat-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-icon-wrap svg { width: 24px; height: 24px; }
.stat-icon-total   { background: #eff6ff; color: #2563eb; }
.stat-icon-printed { background: #ecfdf5; color: #059669; }
.stat-icon-unprinted { background: #fff1f2; color: #e11d48; }

.stat-info { display: flex; flex-direction: column; }
.stat-value { font-size: 24px; font-weight: 700; color: #0f172a; line-height: 1.2; }
.stat-label { font-size: 12.5px; color: #64748b; font-weight: 500; margin-top: 2px; }
.stat-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

/* Filter & Toolbar Card */
.filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.search-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
}
.search-wrap svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 15px;
    color: #94a3b8;
}
.search-input {
    width: 100%;
    padding: 8px 12px 8px 36px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.15s ease;
}
.search-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
.filter-select {
    padding: 8px 28px 8px 12px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 14px;
}
.filter-select:focus { border-color: #2563eb; }
.btn-filter-submit {
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.15s;
}
.btn-filter-submit:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.btn-reset-filter {
    padding: 8px 12px;
    font-size: 12.5px;
    color: #64748b;
    text-decoration: none;
    border-radius: 8px;
    transition: color 0.15s;
}
.btn-reset-filter:hover { color: #dc2626; }

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
}

/* Table Spreadsheet Card */
.table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.spreadsheet-table {
    width: 100%;
    border-collapse: collapse;
}
.spreadsheet-table thead th {
    padding: 12px 14px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: #1e3a5f;
    border-right: 1px solid rgba(255,255,255,0.1);
    white-space: nowrap;
}
.spreadsheet-table thead th:last-child { border-right: none; }
.spreadsheet-table thead th.th-center { text-align: center; }

.spreadsheet-table tbody td {
    padding: 13px 14px;
    font-size: 12.5px;
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
    border-right: 1px solid #f1f5f9;
    vertical-align: top;
}
.spreadsheet-table tbody td:last-child { border-right: none; }
.spreadsheet-table tbody tr:last-child td { border-bottom: none; }
.spreadsheet-table tbody tr:hover { background: #f8fafc; }
.spreadsheet-table tbody tr.row-selected { background: #eff6ff; }
.spreadsheet-table tbody tr.row-printed { background: #fcfdfd; }

/* Table Columns Specific */
.td-no { text-align: center; color: #64748b; font-weight: 600; font-size: 12px; }
.td-date { white-space: nowrap; font-weight: 600; color: #1e293b; font-size: 12px; }
.td-nomor { font-weight: 600; color: #1e3a5f; font-size: 12.5px; }
.td-pengirim { font-weight: 500; color: #0f172a; line-height: 1.35; }
.td-perihal { line-height: 1.45; color: #334155; }
.td-disposisi { font-size: 12px; color: #475569; }

/* Print Toggle Box */
.print-toggle-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.print-checkbox {
    width: 22px;
    height: 22px;
    accent-color: #16a34a;
    cursor: pointer;
    border-radius: 6px;
    transition: transform 0.15s;
}
.print-checkbox:hover {
    transform: scale(1.15);
}
.print-label {
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    cursor: pointer;
    user-select: none;
    transition: all 0.15s;
}
.print-label.printed {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
}
.print-label.unprinted {
    background: #f1f5f9;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
}
.print-label:hover {
    opacity: 0.85;
}

/* Link / Document Pill */
.link-doc-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    font-size: 11.5px;
    font-weight: 600;
    color: #2563eb;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.15s;
    max-width: 190px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.link-doc-btn:hover {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #93c5fd;
}
.link-doc-btn svg { width: 13px; height: 13px; flex-shrink: 0; }

.link-empty {
    color: #cbd5e1;
    font-size: 12px;
    font-style: italic;
}

/* Action buttons */
.action-btn-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.icon-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #64748b;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
}
.icon-action-btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #0f172a;
}
.icon-action-btn.delete:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #dc2626;
}
.icon-action-btn svg { width: 13px; height: 13px; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 50px 20px;
}
.empty-state-icon {
    width: 52px;
    height: 52px;
    margin: 0 auto 14px;
    background: #f1f5f9;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.empty-state-icon svg { width: 26px; height: 26px; color: #94a3b8; }
.empty-state-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}
.empty-state-text {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 18px;
}

/* Pagination */
.sb-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-top: 1px solid #e2e8f0;
    font-size: 12.5px;
    color: #64748b;
    flex-wrap: wrap;
    gap: 10px;
}
.sb-page-btns { display: flex; gap: 4px; }
.sb-page-btn {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #334155;
    transition: all 0.15s;
}
.sb-page-btn:hover { background: #f1f5f9; }
.sb-page-btn.active {
    background: #1e3a5f;
    color: #fff;
    border-color: #1e3a5f;
    font-weight: 700;
}
.sb-page-btn.disabled { color: #cbd5e1; cursor: not-allowed; }
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
        <h1>Buku Surat Masuk</h1>
        <p>Pencatatan, pengelolaan berkas disposisi, dan pemantauan status cetak surat masuk Bagian Protokol dan Komunikasi Pimpinan.</p>
    </div>
    <div class="header-actions">
        <a href="javascript:void(0)" onclick="openExportModal()" class="btn-secondary-action" title="Unduh Rekap Spreadsheet Excel (.xls)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Download Rekap Excel
        </a>
        <a href="{{ route('keuangan.create') }}" class="btn-primary-action">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Surat Masuk
        </a>
    </div>
</div>

{{-- Modal Export Pilih Periode & Filter --}}
<div id="exportModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(2px);">
    <div style="background:#fff;border-radius:16px;width:420px;max-width:92vw;box-shadow:0 20px 60px -10px rgba(0,0,0,0.25);overflow:hidden;">
        <div style="background:#1e3a5f;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;color:#fff"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                <span style="font-size:15px;font-weight:700;color:#fff;">Unduh Rekap Excel Surat Masuk</span>
            </div>
            <button onclick="document.getElementById('exportModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:22px;line-height:1;">&times;</button>
        </div>
        <div style="padding:22px 24px;">
            <p style="font-size:13px;color:#64748b;margin-bottom:16px;line-height:1.5;">
                Pilih rentang tahun dan bulan untuk menghasilkan file Excel dengan format rapi (berisi <strong>Sheet Rekap Bulanan</strong> dan <strong>Sheet Detail</strong>).
            </p>

            {{-- Pilih Tahun --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:12.5px;font-weight:700;color:#334155;display:block;margin-bottom:6px;">Tahun</label>
                <select id="exportTahunSelect" style="width:100%;padding:9px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13.5px;font-weight:600;color:#1e3a5f;background:#f8fafc;outline:none;">
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedTahun == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Bulan --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:12.5px;font-weight:700;color:#334155;display:block;margin-bottom:6px;">Periode Bulan</label>
                <select id="exportBulanSelect" style="width:100%;padding:9px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13.5px;color:#334155;background:#f8fafc;outline:none;">
                    <option value="">Semua Bulan (Rekap 1 Tahun Penuh + Detail)</option>
                    @php
                        $bulanExportList = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($bulanExportList as $k => $b)
                        <option value="{{ $k }}" {{ request('bulan') == $k ? 'selected' : '' }}>Bulan {{ $b }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Status Print --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:12.5px;font-weight:700;color:#334155;display:block;margin-bottom:6px;">Status Pencetakan</label>
                <select id="exportStatusPrintSelect" style="width:100%;padding:9px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13.5px;color:#334155;background:#f8fafc;outline:none;">
                    <option value="">Semua Status (Sudah & Belum Diprint)</option>
                    <option value="1" {{ request('status_print') === '1' ? 'selected' : '' }}>Sudah Diprint Saja</option>
                    <option value="0" {{ request('status_print') === '0' ? 'selected' : '' }}>Belum Diprint Saja</option>
                </select>
            </div>

            <div style="font-size:11.5px;color:#94a3b8;background:#f8fafc;padding:8px 10px;border-radius:6px;border:1px solid #e2e8f0;">
                Format: Microsoft Excel (.xls) dengan tabel bergaris dan status print tanda V.
            </div>
        </div>
        <div style="padding:0 24px 20px;display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="document.getElementById('exportModal').style.display='none'" style="padding:9px 16px;border:1px solid #cbd5e1;border-radius:8px;background:#fff;font-size:13px;color:#475569;cursor:pointer;font-weight:500;">Batal</button>
            <button onclick="doExportSuratMasuk()" style="padding:9px 22px;background:#16a34a;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Download Excel
            </button>
        </div>
    </div>
</div>

{{-- KPI Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-total">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" id="statTotalSurat">{{ $totalSurat }}</span>
            <span class="stat-label">Total Surat Masuk</span>
            <span class="stat-sub">Tahun {{ $selectedTahun }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-printed">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.04-.47-2.11-.67-3.21m0 0A18.03 18.03 0 0112 10.5c2.11 0 4.14.36 6.01 1.019m-12.02 0l-1.02-5.1A2.25 2.25 0 017.18 3.75h9.64a2.25 2.25 0 012.21 2.669l-1.02 5.1m-12.02 0a24.49 24.49 0 000 7.421m12.02-7.421a24.49 24.49 0 010 7.421m-12.02 0h12.02M9 17.25v2.25A1.5 1.5 0 0010.5 21h3a1.5 1.5 0 001.5-1.5v-2.25"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" id="statTotalPrinted" style="color:#059669">{{ $totalPrinted }}</span>
            <span class="stat-label">Sudah Diprint</span>
            <span class="stat-sub" id="statPercentagePrinted">{{ $totalSurat > 0 ? round(($totalPrinted / $totalSurat) * 100) : 0 }}% selesai dicetak</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-unprinted">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" id="statTotalUnprinted" style="color:#e11d48">{{ $totalUnprinted }}</span>
            <span class="stat-label">Belum Diprint</span>
            <span class="stat-sub">Perlu dicetak / ditindaklanjuti</span>
        </div>
    </div>
</div>

{{-- Filter Toolbar --}}
<div class="filter-card">
    <form method="GET" action="{{ route('keuangan.index') }}" class="filter-form">
        <div class="search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" class="search-input" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat, asal instansi, perihal, disposisi...">
        </div>

        <select name="bulan" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Bulan</option>
            @php
                $bulanList = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            @endphp
            @foreach($bulanList as $k => $b)
                <option value="{{ $k }}" {{ request('bulan') == $k ? 'selected' : '' }}>{{ $b }}</option>
            @endforeach
        </select>

        <select name="status_print" class="filter-select" onchange="this.form.submit()">
            <option value="">Status Pencetakan (Semua)</option>
            <option value="1" {{ request('status_print') === '1' ? 'selected' : '' }}>✓ Sudah Diprint</option>
            <option value="0" {{ request('status_print') === '0' ? 'selected' : '' }}>— Belum Diprint</option>
        </select>

        <select name="tahun" class="filter-select" onchange="this.form.submit()">
            @foreach($availableYears as $yr)
                <option value="{{ $yr }}" {{ $selectedTahun == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-filter-submit">Filter</button>

        @if(request()->hasAny(['search', 'bulan', 'status_print']) || request('tahun') != now()->year)
            <a href="{{ route('keuangan.index') }}" class="btn-reset-filter">Reset Filter</a>
        @endif
    </form>
</div>

{{-- Bulk Selection Bar --}}
<form id="bulkDeleteForm" method="POST" action="{{ route('keuangan.bulk-destroy') }}">
    @csrf
    <div id="selectionActionBar" class="selection-action-bar">
        <div class="selection-info">
            <span class="selection-badge" id="selectedCountBadge">0</span>
            <span>surat masuk terpilih</span>
            <button type="button" onclick="clearAllSelections()" style="background:none;border:none;color:#2563eb;cursor:pointer;font-size:13px;text-decoration:underline;margin-left:8px">Batal Pilih</button>
        </div>
        <button type="submit" class="btn-bulk-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh surat masuk terpilih?')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            Hapus Terpilih
        </button>
    </div>
</form>

{{-- Table Spreadsheet --}}
<div class="table-card">
    <div style="background: #1e3a5f; color: #fff; padding: 12px 18px; font-weight: 700; font-size: 14px; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: space-between;">
        <span>SURAT MASUK &bull; TAHUN {{ $selectedTahun }}</span>
        <span style="font-size: 11.5px; font-weight: 500; opacity: 0.85;">Total: {{ $suratList->total() }} Data</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="spreadsheet-table">
            <thead>
                <tr>
                    <th style="width: 36px; text-align: center;">
                        <input type="checkbox" id="selectAll" class="custom-checkbox" title="Pilih Semua">
                    </th>
                    <th style="width: 42px;" class="th-center">No</th>
                    <th style="width: 140px;">TANGGAL DITERIMA</th>
                    <th style="width: 170px;">NOMOR</th>
                    <th style="width: 200px;">ASAL INSTANSI</th>
                    <th style="min-width: 240px;">PERIHAL</th>
                    <th style="width: 190px;">DISPOSISI</th>
                    <th style="width: 150px;">DOKUMEN</th>
                    <th style="width: 90px;" class="th-center">PRINT</th>
                    <th style="width: 75px;" class="th-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratList as $i => $item)
                <tr id="row-{{ $item->id }}" class="{{ $item->is_printed ? 'row-printed' : '' }}">
                    <td style="text-align: center;">
                        <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" form="bulkDeleteForm" class="custom-checkbox row-checkbox" onchange="handleRowSelect(this)">
                    </td>
                    <td class="td-no">{{ $suratList->firstItem() + $i }}</td>
                    <td class="td-date">{{ $item->formatted_tanggal_diterima }}</td>
                    <td class="td-nomor">{{ $item->nomor_surat ?? $item->no_bukti ?? '-' }}</td>
                    <td class="td-pengirim">{{ $item->pengirim ?? $item->penanggung_jawab ?? '-' }}</td>
                    <td class="td-perihal">{{ $item->perihal ?? $item->uraian ?? '-' }}</td>
                    <td class="td-disposisi">
                        @if($item->disposisi)
                            <span>{{ $item->disposisi }}</span>
                        @else
                            <span style="color:#94a3b8;font-style:italic">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->file_url)
                            <a href="{{ $item->file_url }}" target="_blank" class="link-doc-btn" title="Buka Dokumen PDF/Lampiran">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <span>Lihat Berkas</span>
                            </a>
                        @elseif($item->link_dokumen)
                            <a href="{{ $item->link_dokumen }}" target="_blank" class="link-doc-btn" title="{{ $item->link_dokumen }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                                <span>Tautan Dokumen</span>
                            </a>
                        @else
                            <span class="link-empty">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="print-toggle-wrap">
                            <input type="checkbox"
                                   class="print-checkbox"
                                   id="print-cb-{{ $item->id }}"
                                   data-id="{{ $item->id }}"
                                   {{ $item->is_printed ? 'checked' : '' }}
                                   onchange="togglePrintStatus({{ $item->id }}, this)"
                                   title="Klik untuk ubah status Print">
                            <span class="print-label {{ $item->is_printed ? 'printed' : 'unprinted' }}"
                                  id="print-label-{{ $item->id }}"
                                  onclick="document.getElementById('print-cb-{{ $item->id }}').click()">
                                {{ $item->is_printed ? '✓ Print' : 'Belum' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="action-btn-group">
                            <a href="{{ route('keuangan.edit', $item->id) }}" class="icon-action-btn" title="Edit Surat">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            <form method="POST" action="{{ route('keuangan.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Hapus surat masuk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-action-btn delete" title="Hapus Surat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <div class="empty-state-title">Belum Ada Data Surat Masuk</div>
                            <p class="empty-state-text">Mulai catat buku surat masuk, disposisi, dan status pencetakan sekarang.</p>
                            <a href="{{ route('keuangan.create') }}" class="btn-primary-action">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                Tambah Surat Masuk
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suratList->hasPages())
    <div class="sb-pagination">
        <div>Menampilkan {{ $suratList->firstItem() }} - {{ $suratList->lastItem() }} dari {{ $suratList->total() }} surat masuk</div>
        <div class="sb-page-btns">
            @if($suratList->onFirstPage())
                <span class="sb-page-btn disabled">&laquo;</span>
            @else
                <a href="{{ $suratList->previousPageUrl() }}" class="sb-page-btn">&laquo;</a>
            @endif
            @foreach($suratList->getUrlRange(1, $suratList->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="sb-page-btn {{ $page == $suratList->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($suratList->hasMorePages())
                <a href="{{ $suratList->nextPageUrl() }}" class="sb-page-btn">&raquo;</a>
            @else
                <span class="sb-page-btn disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
// Bulk Selection
const selectAllCheckbox = document.getElementById('selectAll');
const rowCheckboxes = document.querySelectorAll('.row-checkbox');
const selectionActionBar = document.getElementById('selectionActionBar');
const selectedCountBadge = document.getElementById('selectedCountBadge');

if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
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
    const count = document.querySelectorAll('.row-checkbox:checked').length;
    if (selectionActionBar) {
        selectionActionBar.style.display = count > 0 ? 'flex' : 'none';
        if (selectedCountBadge) selectedCountBadge.textContent = count;
    }
    if (!count && selectAllCheckbox) selectAllCheckbox.checked = false;
}
function clearAllSelections() {
    rowCheckboxes.forEach(cb => {
        cb.checked = false;
        const tr = document.getElementById('row-' + cb.value);
        if (tr) tr.classList.remove('row-selected');
    });
    if (selectAllCheckbox) selectAllCheckbox.checked = false;
    updateSelectionState();
}

// Instant AJAX Toggle Print with Real-Time KPI Stats Update
function togglePrintStatus(id, checkboxEl) {
    const labelEl = document.getElementById('print-label-' + id);
    const rowEl = document.getElementById('row-' + id);
    const originalChecked = !checkboxEl.checked;

    fetch(`/administrasi/keuangan/${id}/toggle-print`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            checkboxEl.checked = data.is_printed;
            if (labelEl) {
                labelEl.textContent = data.is_printed ? '✓ Print' : 'Belum';
                labelEl.className = 'print-label ' + (data.is_printed ? 'printed' : 'unprinted');
            }
            if (rowEl) {
                rowEl.classList.toggle('row-printed', data.is_printed);
            }

            // Real-time update for KPI Stats Cards on top
            if (data.total_printed !== undefined) {
                const elPrinted = document.getElementById('statTotalPrinted');
                const elUnprinted = document.getElementById('statTotalUnprinted');
                const elPercent = document.getElementById('statPercentagePrinted');
                const elTotal = document.getElementById('statTotalSurat');

                if (elPrinted) elPrinted.textContent = data.total_printed;
                if (elUnprinted) elUnprinted.textContent = data.total_unprinted;
                if (elPercent) elPercent.textContent = data.percentage + '% selesai dicetak';
                if (elTotal && data.total_surat !== undefined) elTotal.textContent = data.total_surat;
            }
        } else {
            checkboxEl.checked = originalChecked;
            alert('Gagal memperbarui status print.');
        }
    })
    .catch(err => {
        console.error(err);
        checkboxEl.checked = originalChecked;
        alert('Terjadi kesalahan koneksi saat mengubah status print.');
    });
}

// Export Modal Functions
function openExportModal() {
    const m = document.getElementById('exportModal');
    if (m) m.style.display = 'flex';
}

function doExportSuratMasuk() {
    const tahun = document.getElementById('exportTahunSelect').value;
    const bulan = document.getElementById('exportBulanSelect').value;
    const statusPrint = document.getElementById('exportStatusPrintSelect').value;

    let url = '{{ route("keuangan.export") }}?tahun=' + encodeURIComponent(tahun);
    if (bulan) {
        url += '&bulan=' + encodeURIComponent(bulan);
    }
    if (statusPrint !== '') {
        url += '&status_print=' + encodeURIComponent(statusPrint);
    }

    const currentSearch = '{{ request("search") }}';
    if (currentSearch) {
        url += '&search=' + encodeURIComponent(currentSearch);
    }

    window.location.href = url;
    document.getElementById('exportModal').style.display = 'none';
}

const exportModalEl = document.getElementById('exportModal');
if (exportModalEl) {
    exportModalEl.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
}
</script>
@endpush
