@extends('layouts.app')
@section('title', 'Analisis Isu & Media — Komunikasi Pimpinan')

@push('styles')
<style>
/* ============================================================
   BASE LAYOUT
   ============================================================ */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 22px; gap: 16px; flex-wrap: wrap;
}
.page-header-left h1 { font-size: 24px; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; margin-bottom: 4px; }
.page-header-left p  { font-size: 13.5px; color: #64748b; margin: 0; }
.header-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.btn-primary-action {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; font-size: 13.5px; font-weight: 600;
    border-radius: 8px; background: #1e3a5f; color: #ffffff;
    border: none; cursor: pointer; text-decoration: none; transition: all 0.15s ease;
    box-shadow: 0 2px 4px rgba(30,58,95,0.15);
}
.btn-primary-action:hover { background: #162f4f; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 8px rgba(30,58,95,0.2); }
.btn-primary-action svg { width: 16px; height: 16px; }

.btn-secondary-action {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 15px; font-size: 13px; font-weight: 500; border-radius: 8px;
    background: #ffffff; color: #334155; border: 1px solid #cbd5e1;
    cursor: pointer; text-decoration: none; transition: all 0.15s ease;
}
.btn-secondary-action:hover { background: #f8fafc; border-color: #94a3b8; color: #0f172a; }
.btn-secondary-action svg { width: 15px; height: 15px; }

/* ============================================================
   STATS CARDS
   ============================================================ */
.stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px;
}
@media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 18px 20px; display: flex; align-items: center; gap: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s, box-shadow 0.15s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
.stat-icon-wrap {
    width: 48px; height: 48px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-icon-wrap svg { width: 24px; height: 24px; }
.stat-icon-total   { background: #eff6ff; color: #2563eb; }
.stat-icon-positif { background: #ecfdf5; color: #059669; }
.stat-icon-negatif { background: #fef2f2; color: #dc2626; }
.stat-icon-netral  { background: #f1f5f9; color: #475569; }
.stat-info { display: flex; flex-direction: column; }
.stat-value { font-size: 24px; font-weight: 700; color: #0f172a; line-height: 1.2; }
.stat-label { font-size: 12.5px; color: #64748b; font-weight: 500; margin-top: 2px; }
.stat-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

/* ============================================================
   TOOLBAR (Tahun + Breadcrumb strip)
   ============================================================ */
.an-toolbar-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 12px 18px; margin-bottom: 18px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 10px;
}
.an-toolbar-left { display: flex; align-items: center; gap: 10px; }
.an-toolbar-right { display: flex; align-items: center; gap: 8px; }
.an-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748b; }
.an-breadcrumb a { color: #1e3a5f; text-decoration: none; font-weight: 600; }
.an-breadcrumb a:hover { text-decoration: underline; }
.an-breadcrumb span { color: #94a3b8; }
.an-year-select {
    padding: 6px 14px; font-size: 13px; font-weight: 700; border-radius: 8px;
    border: 1.5px solid #cbd5e1; background: #f8fafc; color: #1e3a5f;
    cursor: pointer; outline: none; transition: all 0.15s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 8px center; background-size: 14px;
    padding-right: 28px;
}

/* ============================================================
   FOLDER GRID (12-month calendar style)
   ============================================================ */
.folder-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px;
}
@media (max-width: 1100px) { .folder-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .folder-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .folder-grid { grid-template-columns: 1fr; } }

.folder-card {
    background: #fff; border: 1.5px solid #e5e7eb; border-radius: 14px;
    padding: 24px 18px 20px; display: flex; flex-direction: column; align-items: center;
    text-align: center; cursor: pointer; text-decoration: none;
    transition: all 0.18s cubic-bezier(.4,0,.2,1); position: relative; overflow: hidden;
}
.folder-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, #1e3a5f, #3b82f6); opacity: 0; transition: opacity 0.18s;
}
.folder-card:hover { border-color: #3b82f6; box-shadow: 0 8px 24px -4px rgba(30,58,95,0.12); transform: translateY(-3px); }
.folder-card:hover::before { opacity: 1; }

.folder-cal-icon {
    width: 52px; height: 52px; border: 2px solid; border-radius: 10px;
    overflow: hidden; display: flex; flex-direction: column; margin-bottom: 14px;
}
.folder-cal-top {
    color: #fff; font-size: 10.5px; font-weight: 800; letter-spacing: 0.05em;
    text-align: center; padding: 4px 0 3px; text-transform: uppercase; flex-shrink: 0;
}
.folder-cal-year {
    flex: 1; display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; background: #fff;
}

.folder-name { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.3; }
.folder-count-badge {
    font-size: 12px; padding: 2px 10px; border-radius: 20px;
    font-weight: 600; margin-bottom: 6px;
}
.folder-count-zero  { background: #f1f5f9; color: #94a3b8; }
.folder-count-has   { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }

.folder-sentimen-pills {
    display: flex; gap: 5px; justify-content: center; flex-wrap: wrap; margin-top: 4px;
}
.sp-pill {
    font-size: 10.5px; font-weight: 600; padding: 2px 7px; border-radius: 999px;
}
.sp-pos { background: #dcfce7; color: #166534; }
.sp-neg { background: #fee2e2; color: #991b1b; }
.sp-net { background: #f1f5f9; color: #475569; }

/* Flash message */
.flash-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
    padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;
    font-size: 13.5px; display: flex; align-items: center; justify-content: space-between;
}

/* ============================================================
   LIST MODE — Filter Toolbar
   ============================================================ */
.an-filter-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 14px 18px; margin-bottom: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.an-filter-form { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.an-search-wrap { position: relative; flex: 1; min-width: 220px; }
.an-search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px; height: 15px; color: #94a3b8;
}
.an-search-input {
    width: 100%; padding: 8px 12px 8px 36px; font-size: 13px;
    border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; color: #1e293b; outline: none;
}
.an-search-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
.an-select {
    padding: 8px 28px 8px 12px; font-size: 13px; border: 1px solid #cbd5e1;
    border-radius: 8px; background: #fff; color: #334155; outline: none; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 8px center; background-size: 14px;
}
.btn-filter-submit {
    padding: 8px 14px; font-size: 13px; font-weight: 500; border-radius: 8px;
    background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px; transition: all 0.15s;
}
.btn-filter-submit:hover { background: #e2e8f0; color: #0f172a; }
.btn-reset-filter { padding: 8px 12px; font-size: 12.5px; color: #64748b; text-decoration: none; border-radius: 8px; }
.btn-reset-filter:hover { color: #dc2626; }

/* ============================================================
   SELECTION ACTION BAR
   ============================================================ */
.selection-action-bar {
    display: none; align-items: center; justify-content: space-between;
    background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px;
    padding: 10px 16px; margin-bottom: 12px;
    animation: fadeIn 0.15s ease;
}
@keyframes fadeIn { from { opacity:0; transform: translateY(-4px); } to { opacity:1; transform: translateY(0); } }
.selection-info { font-size: 13.5px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px; }
.selection-badge { background: #1e3a5f; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
.btn-bulk-delete {
    display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px;
    background: #ef4444; color: white; border: none; border-radius: 6px;
    font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.15s;
}
.btn-bulk-delete:hover { background: #dc2626; }
.custom-checkbox { width: 17px; height: 17px; accent-color: #1e3a5f; cursor: pointer; vertical-align: middle; }

/* ============================================================
   TABLE CARD (List Mode)
   ============================================================ */
.an-table-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.an-table { width: 100%; border-collapse: collapse; }
.an-table thead th {
    padding: 13px 16px; text-align: left; font-size: 11.5px; font-weight: 700;
    color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;
    background: #f8fafc; border-bottom: 1px solid #e2e8f0; white-space: nowrap;
}
.an-table tbody td { padding: 15px 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
.an-table tbody tr:last-child td { border-bottom: none; }
.an-table tbody tr:hover { background: #f8fafc; }
.an-table tbody tr.row-selected { background: #eff6ff; }

/* Row elements */
.an-judul-link { font-size: 13.5px; font-weight: 600; color: #0f172a; text-decoration: none; line-height: 1.4; display: block; margin-bottom: 4px; transition: color 0.15s; }
.an-judul-link:hover { color: #2563eb; }
.an-source-tag { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; color: #64748b; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; }
.an-source-tag svg { width: 11px; height: 11px; }
.an-date-badge { font-size: 12px; font-weight: 500; color: #475569; display: flex; align-items: center; gap: 5px; white-space: nowrap; }
.an-date-badge svg { width: 13px; height: 13px; color: #94a3b8; }
.an-preview-text { font-size: 12.5px; color: #64748b; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* Sentimen Badges */
.badge-sentimen { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
.badge-positif { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
.badge-negatif { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.badge-netral  { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

/* Media Badges */
.badge-media { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px; font-size: 11.5px; font-weight: 700; }
.badge-media-sosial { background: #ede9fe; color: #6d28d9; }
.badge-media-online { background: #dbeafe; color: #1d4ed8; }
.badge-media-cetak  { background: #fef9c3; color: #854d0e; }
.badge-media-default { background: #f1f5f9; color: #475569; }

/* Sector badge */
.badge-sector { font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; display: inline-block; margin-top: 4px; }

/* Actions */
.an-actions-wrap { display: flex; align-items: center; gap: 6px; justify-content: flex-end; }
.btn-output-modal {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 10px; font-size: 12px; font-weight: 600;
    background: #1e3a5f; color: #fff; border: none; border-radius: 6px; cursor: pointer;
    text-decoration: none; transition: background 0.15s;
}
.btn-output-modal:hover { background: #162f4f; }
.btn-output-modal svg { width: 13px; height: 13px; }
.an-icon-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 6px; border: 1px solid #e2e8f0;
    background: #fff; color: #64748b; text-decoration: none; transition: all 0.15s; cursor: pointer;
}
.an-icon-btn svg { width: 14px; height: 14px; }
.an-icon-btn:hover { background: #f1f5f9; border-color: #94a3b8; color: #334155; }
.an-icon-btn.delete:hover { background: #fef2f2; border-color: #fecaca; color: #dc2626; }

/* Empty State */
.empty-state { text-align: center; padding: 60px 24px; }
.empty-state-icon { width: 56px; height: 56px; margin: 0 auto 16px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.empty-state-icon svg { width: 28px; height: 28px; color: #94a3b8; }
.empty-state-title { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.empty-state-text  { font-size: 13.5px; color: #64748b; margin-bottom: 20px; }

/* Pagination */
.sb-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-top: 1px solid #f1f5f9; font-size: 13px; color: #64748b; flex-wrap: wrap; gap: 10px; }
.sb-page-btns { display: flex; gap: 4px; }
.sb-page-btn {
    padding: 5px 10px; border-radius: 6px; font-size: 13px; text-decoration: none;
    border: 1px solid #e2e8f0; background: #fff; color: #334155; transition: all 0.15s;
}
.sb-page-btn:hover { background: #f1f5f9; }
.sb-page-btn.active { background: #1e3a5f; color: #fff; border-color: #1e3a5f; font-weight: 700; }
.sb-page-btn.disabled { color: #cbd5e1; cursor: not-allowed; }

/* ============================================================
   OUTPUT MODAL (list mode)
   ============================================================ */
.modal-backdrop {
    position: fixed; inset: 0; background: rgba(15,23,42,0.6);
    z-index: 9000; display: flex; align-items: center; justify-content: center;
    padding: 24px; opacity: 0; pointer-events: none; transition: opacity 0.2s;
}
.modal-backdrop.show { opacity: 1; pointer-events: all; }
.modal-container {
    background: #fff; border-radius: 16px; width: 100%; max-width: 740px;
    max-height: 90vh; display: flex; flex-direction: column;
    box-shadow: 0 20px 60px -10px rgba(0,0,0,0.3); transform: translateY(16px); transition: transform 0.2s;
}
.modal-backdrop.show .modal-container { transform: translateY(0); }
.modal-header {
    padding: 20px 24px 16px; border-bottom: 1px solid #e2e8f0;
    display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-shrink: 0;
}
.modal-title-area { flex: 1; min-width: 0; }
.modal-title-area h2 { font-size: 17px; font-weight: 700; color: #0f172a; line-height: 1.4; margin: 0; word-break: break-word; }
.modal-meta-pills { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.modal-close-btn { background: #f1f5f9; border: none; border-radius: 8px; padding: 6px; cursor: pointer; flex-shrink: 0; color: #64748b; transition: all 0.15s; }
.modal-close-btn:hover { background: #fee2e2; color: #dc2626; }
.modal-body { padding: 20px 24px; overflow-y: auto; flex: 1; display: flex; flex-direction: column; gap: 14px; }
.output-info-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
    background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px;
}
@media (max-width: 640px) { .output-info-grid { grid-template-columns: 1fr 1fr; } }
.info-field-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 2px; }
.info-field-val   { font-size: 13.5px; font-weight: 600; color: #0f172a; }
.output-section-card { border-radius: 10px; border: 1px solid #e2e8f0; background: #fff; overflow: hidden; }
.output-section-header { padding: 12px 18px; display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 700; border-bottom: 1px solid #e2e8f0; }
.output-section-header.analisis-hdr  { background: #f8fafc; color: #1e293b; }
.output-section-header.kebijakan-hdr { background: #eff6ff; color: #1e40af; }
.output-section-header.publikasi-hdr { background: #fdf2f8; color: #9d174d; }
.output-section-body { padding: 16px 18px; font-size: 13.5px; line-height: 1.6; color: #334155; white-space: pre-line; }
.modal-footer { padding: 16px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; flex-shrink: 0; }
.modal-footer-left { display: flex; gap: 8px; flex-wrap: wrap; }
.modal-footer-right { display: flex; gap: 8px; }
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
        <h1>Analisis Isu &amp; Media</h1>
        <p>Pemetaan isu publik, analisis sentimen media, serta perumusan rekomendasi kebijakan dan publikasi pimpinan.</p>
    </div>
    <div class="header-actions">
        <a href="javascript:void(0)" onclick="openExportModal()" class="btn-secondary-action" title="Unduh Rekap Data Excel (.xls)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Unduh Rekap Excel
        </a>
        <a href="{{ route('analisis.create') }}" class="btn-primary-action">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Analisis Isu
        </a>
    </div>
</div>

{{-- Modal Export Pilih Tahun --}}
<div id="exportModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:360px;max-width:92vw;box-shadow:0 20px 60px -10px rgba(0,0,0,0.25);overflow:hidden;">
        <div style="background:#1e3a5f;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:15px;font-weight:700;color:#fff;">Unduh Rekap Excel</span>
            <button onclick="document.getElementById('exportModal').style.display='none'" style="background:none;border:none;color:#fff;cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div style="padding:24px;">
            <p style="font-size:13px;color:#6b7280;margin-bottom:16px;line-height:1.6;">
                File Excel berisi <strong>Rekap Per Bulan</strong> (ringkasan sentimen & jenis media) dan <strong>Detail</strong> seluruh data analisis isu untuk tahun yang dipilih.
            </p>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Pilih Tahun</label>
            <select id="exportTahunSelect" style="width:100%;padding:10px 14px;border:1.5px solid #d1d5db;border-radius:8px;font-size:14px;font-weight:600;color:#1e3a5f;background:#f8fafc;outline:none;">
                @foreach($availableYears as $yr)
                    <option value="{{ $yr }}" {{ $selectedTahun == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
            <div style="margin-top:8px;font-size:11.5px;color:#9ca3af;">Format: Microsoft Excel (.xls) — dibuka di Excel, LibreOffice, Google Sheets</div>
        </div>
        <div style="padding:0 24px 20px;display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="document.getElementById('exportModal').style.display='none'" style="padding:9px 18px;border:1.5px solid #e5e7eb;border-radius:8px;background:#fff;font-size:13px;color:#374151;cursor:pointer;font-weight:500;">Batal</button>
            <button onclick="doExport()" style="padding:9px 22px;background:#16a34a;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">Download</button>
        </div>
    </div>
</div>

{{-- KPI Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-total">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $totalCount }}</span>
            <span class="stat-label">Total Analisis Isu</span>
            <span class="stat-sub">Tahun {{ $selectedTahun }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-positif">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="color:#059669">{{ $positifCount }}</span>
            <span class="stat-label">Sentimen Positif</span>
            <span class="stat-sub">{{ $totalCount > 0 ? round(($positifCount / $totalCount) * 100) : 0 }}% dari total isu</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-negatif">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="color:#dc2626">{{ $negatifCount }}</span>
            <span class="stat-label">Sentimen Negatif</span>
            <span class="stat-sub">Perlu respon & rekomendasi cepat</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-netral">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="color:#475569">{{ $netralCount }}</span>
            <span class="stat-label">Sentimen Netral</span>
            <span class="stat-sub">Informasi pemberitaan reguler</span>
        </div>
    </div>
</div>

{{-- Toolbar (Tahun Selector + Breadcrumb) --}}
<div class="an-toolbar-card">
    <div class="an-toolbar-left">
        @if($viewMode === 'list')
        <div class="an-breadcrumb">
            <a href="{{ route('analisis.index', ['tahun' => $selectedTahun]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;vertical-align:middle;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                Analisis Isu {{ $selectedTahun }}
            </a>
            <span>/</span>
            <span style="color:#0f172a;font-weight:600;">{{ $namaBulan[$selectedBulan] ?? '' }} {{ $selectedTahun }}</span>
        </div>
        @else
        <div style="display:flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#1e293b;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:#1e3a5f"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Pilih Bulan untuk Lihat Data
        </div>
        @endif
    </div>
    <div class="an-toolbar-right">
        <span style="font-size:12.5px;font-weight:600;color:#64748b;">Tahun:</span>
        <select class="an-year-select" onchange="window.location.href='{{ route('analisis.index') }}?tahun=' + this.value">
            @foreach($availableYears as $yr)
                <option value="{{ $yr }}" {{ $selectedTahun == $yr ? 'selected' : '' }}>{{ $yr }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- ============================================================
     MODE 1: FOLDER GRID 12 BULAN
     ============================================================ --}}
@if($viewMode === 'grid')
@php
$colorSchemes = [
    ['bg'=>'#eff6ff','accent'=>'#2563eb','top'=>'#3b82f6'],
    ['bg'=>'#f0fdf4','accent'=>'#16a34a','top'=>'#22c55e'],
    ['bg'=>'#fef3c7','accent'=>'#d97706','top'=>'#f59e0b'],
    ['bg'=>'#fdf4ff','accent'=>'#9333ea','top'=>'#a855f7'],
    ['bg'=>'#fff1f2','accent'=>'#e11d48','top'=>'#f43f5e'],
    ['bg'=>'#ecfdf5','accent'=>'#059669','top'=>'#10b981'],
    ['bg'=>'#f0f9ff','accent'=>'#0284c7','top'=>'#38bdf8'],
    ['bg'=>'#fff7ed','accent'=>'#c2410c','top'=>'#f97316'],
    ['bg'=>'#fdf2f8','accent'=>'#be185d','top'=>'#ec4899'],
    ['bg'=>'#f1f5f9','accent'=>'#475569','top'=>'#64748b'],
    ['bg'=>'#f8fafc','accent'=>'#1e3a5f','top'=>'#334155'],
    ['bg'=>'#fef9c3','accent'=>'#854d0e','top'=>'#ca8a04'],
];
$namaBulanShort = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agt',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
@endphp

<div class="folder-grid">
    @foreach($monthlyFolders as $folder)
    @php
        $cs = $colorSchemes[($folder['bulan'] - 1) % count($colorSchemes)];
        $padBulan = str_pad($folder['bulan'], 2, '0', STR_PAD_LEFT);
        $folderUrl = route('analisis.index', ['tahun' => $folder['tahun'], 'bulan' => $folder['bulan']]);
    @endphp
    <a href="{{ $folderUrl }}" class="folder-card">
        <div class="folder-cal-icon" style="border-color:{{ $cs['accent'] }}">
            <div class="folder-cal-top" style="background:{{ $cs['top'] }}">{{ $namaBulanShort[$folder['bulan']] }}</div>
            <div class="folder-cal-year" style="color:{{ $cs['accent'] }}">{{ $folder['tahun'] }}</div>
        </div>
        <div class="folder-name">{{ $folder['label'] }}</div>
        @if($folder['total'] > 0)
        <div class="folder-count-badge folder-count-has">{{ $folder['total'] }} isu</div>
        <div class="folder-sentimen-pills">
            @if($folder['positif'] > 0)<span class="sp-pill sp-pos">+{{ $folder['positif'] }}</span>@endif
            @if($folder['negatif'] > 0)<span class="sp-pill sp-neg">-{{ $folder['negatif'] }}</span>@endif
            @if($folder['netral']  > 0)<span class="sp-pill sp-net">•{{ $folder['netral'] }}</span>@endif
        </div>
        @else
        <div class="folder-count-badge folder-count-zero">0 isu</div>
        @endif
    </a>
    @endforeach
</div>
@endif

{{-- ============================================================
     MODE 2: TABLE / LIST PER BULAN
     ============================================================ --}}
@if($viewMode === 'list')

{{-- Filter bar --}}
<div class="an-filter-card">
    <form method="GET" action="{{ route('analisis.index') }}" class="an-filter-form">
        <input type="hidden" name="tahun" value="{{ $selectedTahun }}">
        <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
        <div class="an-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" class="an-search-input" name="search" value="{{ request('search') }}" placeholder="Cari judul, sumber isu, leading sector...">
        </div>

        <select name="jenis_media" class="an-select" onchange="this.form.submit()">
            <option value="">Semua Jenis Media</option>
            <option value="Sosial" {{ request('jenis_media') === 'Sosial' ? 'selected' : '' }}>Media Sosial</option>
            <option value="Online" {{ request('jenis_media') === 'Online' ? 'selected' : '' }}>Media Online</option>
            <option value="Cetak"  {{ request('jenis_media') === 'Cetak'  ? 'selected' : '' }}>Media Cetak</option>
        </select>

        <select name="sentimen" class="an-select" onchange="this.form.submit()">
            <option value="">Semua Sentimen</option>
            <option value="Positif" {{ request('sentimen') === 'Positif' ? 'selected' : '' }}>Positif</option>
            <option value="Negatif" {{ request('sentimen') === 'Negatif' ? 'selected' : '' }}>Negatif</option>
            <option value="Netral"  {{ request('sentimen') === 'Netral'  ? 'selected' : '' }}>Netral</option>
        </select>

        <button type="submit" class="btn-filter-submit">Filter</button>

        @if(request()->hasAny(['search', 'jenis_media', 'sentimen']))
        <a href="{{ route('analisis.index', ['tahun' => $selectedTahun, 'bulan' => $selectedBulan]) }}" class="btn-reset-filter">Reset</a>
        @endif
    </form>
</div>

{{-- Bulk selection bar --}}
<form id="bulkDeleteForm" method="POST" action="{{ route('analisis.bulk-destroy') }}">
    @csrf
    <div id="selectionActionBar" class="selection-action-bar">
        <div class="selection-info">
            <span class="selection-badge" id="selectedCountBadge">0</span>
            <span>data analisis terpilih</span>
            <button type="button" onclick="clearAllSelections()" style="background:none;border:none;color:#2563eb;cursor:pointer;font-size:13px;text-decoration:underline;margin-left:8px">Batal Pilih</button>
        </div>
        <button type="submit" class="btn-bulk-delete" onclick="return confirm('Hapus seluruh data analisis isu yang dipilih?')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            Hapus Terpilih
        </button>
    </div>
</form>

{{-- Table --}}
<div class="an-table-card">
    <table class="an-table">
        <thead>
            <tr>
                <th style="width:36px;text-align:center"><input type="checkbox" id="selectAll" class="custom-checkbox" title="Pilih Semua"></th>
                <th style="width:40px">No</th>
                <th style="width:160px">Hari / Tanggal</th>
                <th>Judul &amp; Sumber Isu</th>
                <th style="width:160px">Media &amp; Leading Sector</th>
                <th style="width:110px">Sentimen</th>
                <th style="width:260px">Telaahan Analisis</th>
                <th style="text-align:right;width:140px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($analisisList as $i => $item)
            <tr id="row-{{ $item->id }}">
                <td style="text-align:center">
                    <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" form="bulkDeleteForm" class="custom-checkbox row-checkbox" onchange="handleRowSelect(this)">
                </td>
                <td style="color:#94a3b8;font-weight:500">{{ $analisisList->firstItem() + $i }}</td>
                <td>
                    <div class="an-date-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span>{{ $item->hari_tanggal }}</span>
                    </div>
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="openOutputModal({{ $item->id }})" class="an-judul-link">{{ $item->judul }}</a>
                    <div class="an-source-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                        <span>Sumber: {{ $item->sumber_isu }}</span>
                    </div>
                </td>
                <td>
                    <span class="badge-media {{ $item->jenis_media_badge_class }}">{{ $item->jenis_media }}</span>
                    <span class="badge-sector">{{ $item->leading_sector }}</span>
                </td>
                <td>
                    <span class="badge-sentimen {{ $item->sentimen_badge_class }}">
                        @if($item->sentimen === 'Positif') &uarr; @elseif($item->sentimen === 'Negatif') &darr; @else &bull; @endif
                        {{ $item->sentimen }}
                    </span>
                </td>
                <td><div class="an-preview-text" title="{{ $item->analisis }}">{{ $item->analisis }}</div></td>
                <td>
                    <div class="an-actions-wrap">
                        <button type="button" onclick="openOutputModal({{ $item->id }})" class="btn-output-modal" title="Lihat Output">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Output
                        </button>
                        <a href="{{ route('analisis.edit', $item->id) }}" class="an-icon-btn" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </a>
                        <form method="POST" action="{{ route('analisis.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Hapus data analisis isu ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="an-icon-btn delete" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <div class="empty-state-title">Belum Ada Analisis Isu — {{ $namaBulan[$selectedBulan] ?? '' }} {{ $selectedTahun }}</div>
                        <p class="empty-state-text">Belum ada data analisis isu yang tercatat untuk bulan ini.</p>
                        <a href="{{ route('analisis.create') }}" class="btn-primary-action">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Tambah Analisis Isu
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($analisisList->hasPages())
    <div class="sb-pagination">
        <div>Menampilkan {{ $analisisList->firstItem() }} - {{ $analisisList->lastItem() }} dari {{ $analisisList->total() }} data</div>
        <div class="sb-page-btns">
            @if($analisisList->onFirstPage())
                <span class="sb-page-btn disabled">&laquo;</span>
            @else
                <a href="{{ $analisisList->previousPageUrl() }}" class="sb-page-btn">&laquo;</a>
            @endif
            @foreach($analisisList->getUrlRange(1, $analisisList->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="sb-page-btn {{ $page == $analisisList->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($analisisList->hasMorePages())
                <a href="{{ $analisisList->nextPageUrl() }}" class="sb-page-btn">&raquo;</a>
            @else
                <span class="sb-page-btn disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- OUTPUT MODAL --}}
<div id="outputModalBackdrop" class="modal-backdrop" onclick="closeModalOnBackdrop(event)">
    <div class="modal-container" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div class="modal-title-area">
                <div class="modal-meta-pills" style="margin-bottom:8px">
                    <span id="modalSentimenBadge" class="badge-sentimen badge-positif">Positif</span>
                    <span id="modalMediaBadge" class="badge-media badge-media-sosial">Media Sosial</span>
                    <span id="modalDateBadge" class="an-date-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span id="modalHariTanggal">-</span>
                    </span>
                </div>
                <h2 id="modalJudul">Judul Analisis Isu</h2>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeOutputModal()" title="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="output-info-grid">
                <div><div class="info-field-label">Sumber Isu</div><div id="modalSumberIsu" class="info-field-val">-</div></div>
                <div><div class="info-field-label">Leading Sector</div><div id="modalLeadingSector" class="info-field-val">-</div></div>
                <div><div class="info-field-label">Link Sumber Berita</div><div id="modalLampiranArea" class="info-field-val">-</div></div>
            </div>
            <div class="output-section-card">
                <div class="output-section-header analisis-hdr">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:#2563eb"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 6"/></svg>
                    <span>1. Uraian Analisis Isu</span>
                </div>
                <div id="modalAnalisis" class="output-section-body">-</div>
            </div>
            <div class="output-section-card">
                <div class="output-section-header kebijakan-hdr">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:#1d4ed8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    <span>2. Rekomendasi Kebijakan</span>
                </div>
                <div id="modalKebijakan" class="output-section-body" style="background:#f8faff">-</div>
            </div>
            <div class="output-section-card">
                <div class="output-section-header publikasi-hdr">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:#be185d"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                    <span>3. Rekomendasi Publikasi</span>
                </div>
                <div id="modalPublikasi" class="output-section-body" style="background:#fdf4f8">-</div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="modal-footer-left">
                <a id="modalCetakBtn" href="#" target="_blank" class="btn-secondary-action">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.04-.47-2.11-.67-3.21m0 0A18.03 18.03 0 0112 10.5c2.11 0 4.14.36 6.01 1.019m-12.02 0l-1.02-5.1A2.25 2.25 0 017.18 3.75h9.64a2.25 2.25 0 012.21 2.669l-1.02 5.1m-12.02 0a24.49 24.49 0 000 7.421m12.02-7.421a24.49 24.49 0 010 7.421m-12.02 0h12.02M9 17.25v2.25A1.5 1.5 0 0010.5 21h3a1.5 1.5 0 001.5-1.5v-2.25"/></svg>
                    Cetak Telaahan
                </a>
                <a id="modalShowBtn" href="#" class="btn-secondary-action">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Buka Halaman Penuh
                </a>
            </div>
            <div class="modal-footer-right">
                <a id="modalEditBtn" href="#" class="btn-secondary-action">Edit Data</a>
                <button type="button" class="btn-primary-action" onclick="closeOutputModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endif {{-- end list mode --}}

@endsection

@push('scripts')
<script>
// Export Modal
function openExportModal() {
    const m = document.getElementById('exportModal');
    m.style.display = 'flex';
}
function doExport() {
    const tahun = document.getElementById('exportTahunSelect').value;
    window.location.href = '{{ route('analisis.export-rekap') }}?tahun=' + tahun;
    document.getElementById('exportModal').style.display = 'none';
}
document.getElementById('exportModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});

@if($viewMode === 'list')
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
    selectionActionBar.style.display = count > 0 ? 'flex' : 'none';
    selectedCountBadge.textContent = count;
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

// Output Modal
const modalBackdrop = document.getElementById('outputModalBackdrop');
function openOutputModal(id) {
    modalBackdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
    document.getElementById('modalJudul').textContent = 'Memuat data telaahan...';
    ['modalHariTanggal','modalSumberIsu','modalLeadingSector','modalAnalisis','modalKebijakan','modalPublikasi'].forEach(el => {
        document.getElementById(el).textContent = '...';
    });
    fetch(`/komunikasi-pimpinan/analisis/${id}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('modalJudul').textContent = data.judul;
        document.getElementById('modalHariTanggal').textContent = data.hari_tanggal;
        document.getElementById('modalSumberIsu').textContent = data.sumber_isu;
        document.getElementById('modalLeadingSector').textContent = data.leading_sector;
        document.getElementById('modalAnalisis').textContent = data.analisis;
        document.getElementById('modalKebijakan').textContent = data.rekomendasi_kebijakan;
        document.getElementById('modalPublikasi').textContent = data.rekomendasi_publikasi;

        const sentimenBadge = document.getElementById('modalSentimenBadge');
        sentimenBadge.textContent = (data.sentimen === 'Positif' ? '↑ ' : data.sentimen === 'Negatif' ? '↓ ' : '• ') + data.sentimen;
        sentimenBadge.className = 'badge-sentimen ' + data.sentimen_badge;

        const mediaBadge = document.getElementById('modalMediaBadge');
        mediaBadge.textContent = 'Media ' + data.jenis_media;
        mediaBadge.className = 'badge-media ' + data.jenis_media_badge;

        const lampiranEl = document.getElementById('modalLampiranArea');
        if (data.link_sumber) {
            lampiranEl.innerHTML = `<a href="${data.link_sumber}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;color:#0369a1;text-decoration:none;font-weight:600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                Buka Berita
            </a>`;
        } else {
            lampiranEl.innerHTML = '<span style="color:#94a3b8;font-weight:normal">Tidak ada</span>';
        }

        document.getElementById('modalCetakBtn').href = data.cetak_url;
        document.getElementById('modalShowBtn').href = data.show_url;
        document.getElementById('modalEditBtn').href = data.edit_url;
    })
    .catch(() => {
        document.getElementById('modalJudul').textContent = 'Gagal memuat data.';
    });
}
function closeOutputModal() {
    modalBackdrop.classList.remove('show');
    document.body.style.overflow = '';
}
function closeModalOnBackdrop(e) {
    if (e.target === modalBackdrop) closeOutputModal();
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && modalBackdrop.classList.contains('show')) closeOutputModal();
});
@endif
</script>
@endpush
