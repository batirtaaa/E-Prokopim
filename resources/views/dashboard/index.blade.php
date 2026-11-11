@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Dashboard Header Banner ── */
.dash-welcome {
    background: linear-gradient(135deg, #1e3a5f 0%, #2b5687 60%, #173b64 100%);
    border-radius: 14px;
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(30, 58, 95, 0.12);
}
.dash-welcome::before {
    content: '';
    position: absolute;
    right: -40px; top: -50px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
.dash-welcome::after {
    content: '';
    position: absolute;
    right: 140px; bottom: -60px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}
.dash-welcome-text h2 {
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 6px;
    letter-spacing: -0.02em;
}
.dash-welcome-text p {
    font-size: 13.5px;
    color: rgba(255,255,255,0.8);
    max-width: 580px;
    line-height: 1.55;
    margin: 0;
}
.dash-welcome-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}
.btn-welcome-dark {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #0f172a;
    color: #ffffff;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.15);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.btn-welcome-dark:hover {
    background: #1e293b;
    color: #ffffff;
    transform: translateY(-1px);
}
.btn-welcome-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ffffff;
    color: #0f172a;
    font-weight: 600;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.btn-welcome-outline:hover {
    background: #f8fafc;
    color: #0f172a;
    transform: translateY(-1px);
}

/* ── Period Filter ── */
.period-filter {
    display: inline-flex;
    gap: 4px;
    margin-bottom: 20px;
    background: #e2e8f0;
    border-radius: 8px;
    padding: 3px;
}
.period-btn {
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.18s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.period-btn:hover {
    color: #0f172a;
    background: rgba(255,255,255,0.6);
}
.period-btn.active {
    background: #0f172a;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

/* ── Stat Cards ── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}
.dash-stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 22px;
    border: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    transform: translateY(-2px);
    border-color: #cbd5e1;
}
.dash-stat-label {
    font-size: 12.5px;
    color: #64748b;
    margin-bottom: 8px;
    font-weight: 500;
}
.dash-stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: 6px;
}
.dash-stat-sub {
    font-size: 11.5px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 4px;
}
.dash-stat-sub.success { color: #16a34a; font-weight: 500; }
.dash-stat-sub.danger  { color: #dc2626; font-weight: 500; }
.dash-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dash-stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
.dash-stat-icon.green  { background: #f0fdf4; color: #22c55e; }
.dash-stat-icon.orange { background: #fffbeb; color: #f59e0b; }
.dash-stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }

/* ── Main Grid ── */
.dash-main-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 1024px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-main-grid { grid-template-columns: 1fr; }
}

/* ── Chart Card ── */
.dash-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.dash-card-body { padding: 18px 20px 22px; }

/* Bar chart */
.chart-bars {
    display: flex;
    align-items: flex-end;
    gap: 14px;
    height: 190px;
    padding: 10px 6px 0;
}
.chart-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    justify-content: flex-end;
    gap: 8px;
    position: relative;
}
.chart-bar-tooltip {
    position: absolute;
    top: -24px;
    background: #0f172a;
    color: #ffffff;
    font-size: 10.5px;
    padding: 2px 6px;
    border-radius: 4px;
    opacity: 0;
    transform: translateY(4px);
    transition: all 0.15s ease;
    pointer-events: none;
    white-space: nowrap;
    z-index: 10;
}
.chart-bar-wrap:hover .chart-bar-tooltip {
    opacity: 1;
    transform: translateY(0);
}
.chart-bar {
    width: 100%;
    max-width: 42px;
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 4px 4px 0 0;
    min-height: 0;
    transition: height 0.3s ease, opacity 0.18s;
    cursor: pointer;
}
.chart-bar.empty {
    height: 0 !important;
    min-height: 0 !important;
    opacity: 0;
    pointer-events: none;
}
.chart-bar:hover { opacity: 0.85; filter: brightness(1.1); }
.chart-bar-label {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}

/* Filter select */
.filter-select {
    font-size: 12.5px;
    padding: 6px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    color: #334155;
    background: #ffffff;
    cursor: pointer;
    outline: none;
    font-weight: 500;
}

/* ── Agenda Timeline ── */
.agenda-timeline { display: flex; flex-direction: column; max-height: 250px; overflow-y: auto; }
.agenda-item {
    display: flex;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
    transition: background 0.15s;
}
.agenda-item:last-child { border-bottom: none; }
.agenda-item:hover { background: #f8fafc; }
.agenda-time {
    font-size: 12.5px;
    font-weight: 700;
    color: #0f172a;
    width: 44px;
    flex-shrink: 0;
    padding-top: 1px;
}
.agenda-line {
    width: 3px;
    border-radius: 2px;
    flex-shrink: 0;
    background: #cbd5e1;
}
.agenda-line.berlangsung { background: #3b82f6; }
.agenda-line.selesai     { background: #10b981; }
.agenda-line.terjadwal   { background: #f59e0b; }
.agenda-info { flex: 1; min-width: 0; }
.agenda-judul {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.agenda-meta {
    font-size: 11.5px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 4px;
}
.agenda-meta span { display: flex; align-items: center; gap: 3px; }
.agenda-badge {
    display: inline-block;
    font-size: 10.5px;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
}
.agenda-badge.berlangsung { background: #eff6ff; color: #2563eb; }
.agenda-badge.selesai     { background: #f0fdf4; color: #16a34a; }
.agenda-badge.terjadwal   { background: #fefce8; color: #ca8a04; }

/* ── Data Pegawai Table ── */
.dash-table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.dash-table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-table-header-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.dash-search-mini {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    background: #ffffff;
    width: 240px;
    transition: border-color 0.18s;
}
.dash-search-mini:focus-within { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
.dash-search-mini input {
    border: none;
    outline: none;
    font-size: 12.5px;
    color: #0f172a;
    width: 100%;
    background: transparent;
}
.dash-table {
    width: 100%;
    border-collapse: collapse;
}
.dash-table th {
    background: #f8fafc;
    padding: 11px 16px;
    font-size: 11.5px;
    font-weight: 600;
    color: #64748b;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.dash-table td {
    padding: 12px 16px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #f8fafc; }
.pegawai-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    flex-shrink: 0;
}
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
.action-icons { display: flex; gap: 6px; align-items: center; }
.action-icon {
    width: 28px; height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    text-decoration: none;
}
.action-icon:hover { background: #f1f5f9; color: #0f172a; border-color: #cbd5e1; }

.dash-see-all {
    text-align: center;
    padding: 14px;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
}
.dash-see-all a {
    font-size: 13px;
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity 0.15s;
}
.dash-see-all a:hover { opacity: 0.8; text-decoration: underline; }

/* ── Modal Universal Overlay ── */
.custom-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(3px);
    z-index: 1050;
    align-items: center;
    justify-content: center;
}
.custom-modal-overlay.open { display: flex; }
.custom-modal-content {
    background: #ffffff;
    border-radius: 14px;
    width: 100%;
    max-width: 480px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: modal-slide 0.2s ease-out;
}
@keyframes modal-slide {
    from { transform: translateY(15px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}
.custom-modal-header {
    background: #1e3a5f;
    padding: 18px 22px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.custom-modal-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}
.custom-modal-close-btn {
    background: none;
    border: none;
    color: #ffffff;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.8;
    transition: opacity 0.15s;
}
.custom-modal-close-btn:hover { opacity: 1; }
.custom-modal-body { padding: 22px; }

/* Date Range Picker Modal Specifics */
.date-preset-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 18px;
}
.date-preset-btn {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    padding: 6px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s ease;
}
.date-preset-btn:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.date-input-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
}
.date-input-wrap label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.date-input-wrap input[type="date"] {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    color: #0f172a;
    outline: none;
    transition: border-color 0.18s;
}
.date-input-wrap input[type="date"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.custom-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
}
.btn-modal-cancel {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-modal-cancel:hover { background: #f8fafc; color: #0f172a; }
.btn-modal-submit {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    background: #0f172a;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-modal-submit:hover { background: #1e293b; }

/* Pegawai Modal Detail */
.pegawai-modal-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    background: #3b82f6;
    color: #ffffff;
    font-size: 24px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.pegawai-modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-top: 14px;
}
.pegawai-modal-item {
    background: #f8fafc;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}
.pegawai-modal-item label { font-size: 11px; color: #64748b; display: block; margin-bottom: 2px; }
.pegawai-modal-item span { font-size: 13px; font-weight: 600; color: #0f172a; }

/* ── Sambutan Charts Grid ── */
.sambutan-charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 768px) {
    .sambutan-charts-grid { grid-template-columns: 1fr; }
}

/* Chart wrapper */
.sambutan-chart-wrap {
    display: flex;
    gap: 8px;
    height: 200px;
    padding: 8px 0 0;
}

/* Y-axis */
.sambutan-y-axis {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-end;
    width: 28px;
    padding-bottom: 22px;
    flex-shrink: 0;
}
.sambutan-y-axis span {
    font-size: 10px;
    color: #94a3b8;
    line-height: 1;
}

/* Bar area */
.sambutan-bars-area {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
}
.sambutan-grid-lines {
    position: absolute;
    inset: 0 0 22px 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    pointer-events: none;
}
.sambutan-grid-line {
    border-top: 1px dashed #e2e8f0;
    width: 100%;
}

/* Bars container */
.sambutan-bars {
    flex: 1;
    display: flex;
    align-items: flex-end;
    gap: 6px;
    padding-bottom: 22px;
    position: relative;
    z-index: 1;
}

/* Each bar column */
.sambutan-bar-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    justify-content: flex-end;
    gap: 3px;
}
.sambutan-bar-value {
    font-size: 10px;
    font-weight: 700;
    color: #475569;
    min-height: 14px;
    line-height: 1;
}
.sambutan-bar-value--zero { color: transparent; }
.sambutan-bar-outer {
    width: 100%;
    flex: 1;
    display: flex;
    align-items: flex-end;
}
.sambutan-bar {
    width: 100%;
    border-radius: 5px 5px 2px 2px;
    transition: height 0.6s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s;
    cursor: default;
    position: relative;
}
.sambutan-bar:hover { filter: brightness(1.12); }

/* Bar colours */
.sambutan-bar--tahun {
    background: linear-gradient(180deg, #818cf8 0%, #6366f1 100%);
    box-shadow: 0 2px 8px rgba(99,102,241,0.25);
}
.sambutan-bar--bulan {
    background: linear-gradient(180deg, #38bdf8 0%, #0ea5e9 100%);
    box-shadow: 0 2px 8px rgba(14,165,233,0.2);
}
.sambutan-bar--current {
    background: linear-gradient(180deg, #34d399 0%, #10b981 100%);
    box-shadow: 0 2px 10px rgba(16,185,129,0.35);
}

.sambutan-bar-label {
    font-size: 10px;
    color: #64748b;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    line-height: 1.2;
}
.sambutan-bar-label--current {
    color: #10b981;
    font-weight: 700;
}

/* Badges */
.sambutan-total-badge {
    font-size: 12px;
    font-weight: 600;
    color: #6366f1;
    background: #eef2ff;
    border: 1px solid #c7d2fe;
    border-radius: 20px;
    padding: 3px 10px;
}
.sambutan-year-badge {
    font-size: 12px;
    font-weight: 700;
    color: #0ea5e9;
    background: #e0f2fe;
    border: 1px solid #bae6fd;
    border-radius: 20px;
    padding: 3px 10px;
}

/* Empty state */
.sambutan-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    color: #94a3b8;
    gap: 10px;
}
.sambutan-empty p { font-size: 13px; margin: 0; }

.sambutan-single-card {
    margin-bottom: 20px;
}
.sambutan-filters {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.sambutan-filters .filter-select {
    padding: 6px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 12.5px;
    color: #1e293b;
    background-color: #f8fafc;
    font-weight: 500;
    outline: none;
    cursor: pointer;
    transition: all 0.15s ease;
}
.sambutan-filters .filter-select:hover {
    background-color: #ffffff;
    border-color: #94a3b8;
}
.sambutan-filters .filter-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
    background-color: #ffffff;
}
.sambutan-bar--dimmed {
    opacity: 0.25 !important;
}
.sambutan-bar--highlighted {
    background: linear-gradient(180deg, #6366f1 0%, #4338ca 100%) !important;
    box-shadow: 0 3px 12px rgba(99, 102, 241, 0.45) !important;
}

/* ── Dokumentasi (Foto/Video/Notulensi) Chart ── */
.dok-single-card {
    margin-bottom: 20px;
}
.dok-legend {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 11.5px;
    color: #475569;
    font-weight: 600;
}
.dok-legend-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    user-select: none;
    transition: opacity 0.15s;
}
.dok-legend-item:hover {
    opacity: 0.8;
}
.dok-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}
.dok-dot.foto      { background: #3b82f6; box-shadow: 0 0 4px rgba(59,130,246,0.4); }
.dok-dot.video     { background: #8b5cf6; box-shadow: 0 0 4px rgba(139,92,246,0.4); }
.dok-dot.notulensi { background: #f59e0b; box-shadow: 0 0 4px rgba(245,158,11,0.4); }

.dok-bar-stacked {
    width: 100%;
    border-radius: 5px 5px 2px 2px;
    overflow: hidden;
    display: flex;
    flex-direction: column-reverse;
    transition: height 0.5s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s;
    cursor: pointer;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.dok-bar-stacked:hover {
    filter: brightness(1.1);
}
.dok-segment {
    width: 100%;
    transition: height 0.3s ease;
}
.dok-segment--foto {
    background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
}
.dok-segment--video {
    background: linear-gradient(180deg, #a78bfa 0%, #7c3aed 100%);
}
.dok-segment--notulensi {
    background: linear-gradient(180deg, #fcd34d 0%, #d97706 100%);
}

.dok-bar--single-foto {
    background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
    box-shadow: 0 2px 8px rgba(37,99,235,0.25);
}
.dok-bar--single-video {
    background: linear-gradient(180deg, #a78bfa 0%, #7c3aed 100%);
    box-shadow: 0 2px 8px rgba(124,58,237,0.25);
}
.dok-bar--single-notulensi {
    background: linear-gradient(180deg, #fcd34d 0%, #d97706 100%);
    box-shadow: 0 2px 8px rgba(217,119,6,0.25);
}

.dok-tooltip {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-6px);
    background: #0f172a;
    color: #ffffff;
    font-size: 11px;
    padding: 6px 10px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.15s ease;
    z-index: 20;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.dok-bar-col:hover .dok-tooltip {
    opacity: 1;
    transform: translateX(-50%) translateY(-10px);
}
</style>
@endpush

@section('content')

{{-- 1. Welcome Banner --}}
<div class="dash-welcome">
    <div class="dash-welcome-text">
        <h2>Selamat datang di E-PROKOPIM</h2>
        <p>Pantau kegiatan, agenda pimpinan, serta informasi internal Prokopim Kota Bandung dalam satu sistem terintegrasi.</p>
    </div>

    {{-- Role Condition: Admin & Super Admin punya tombol aksi tambah --}}
    @if(auth()->user()->isAdmin())
    <div class="dash-welcome-actions">
        <a href="{{ route('kegiatan-pimpinan.create') }}" class="btn-welcome-dark">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kegiatan
        </a>
        <a href="{{ route('pegawai.create') }}" class="btn-welcome-outline">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Tambah Pegawai
        </a>
    </div>
    @endif
</div>

{{-- 2. Period Filter --}}
<div class="period-filter">
    <a href="{{ route('dashboard', ['periode' => 1]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 1) ? 'active' : '' }}">1 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 3]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 3) ? 'active' : '' }}">3 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 6]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 6) ? 'active' : '' }}">6 Bulan</a>
    <a href="{{ route('dashboard', ['periode' => 12]) }}" class="period-btn {{ (!$isCustom && ($periode ?? 1) == 12) ? 'active' : '' }}">1 Tahun</a>
    
    {{-- Custom Date Button --}}
    <button type="button" class="period-btn {{ $isCustom ? 'active' : '' }}" onclick="openCustomDateModal()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        @if($isCustom && $startDateStr && $endDateStr)
            {{ \Carbon\Carbon::parse($startDateStr)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($endDateStr)->translatedFormat('d M') }}
        @else
            Custom
        @endif
    </button>
</div>

{{-- 3. Stat Cards --}}
<div class="dash-stats">
    {{-- Total Pegawai --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Total Pegawai</div>
            <div class="dash-stat-value">{{ $totalPegawai }}</div>
            <div class="dash-stat-sub">Pegawai aktif</div>
        </div>
        <div class="dash-stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
    </div>

    {{-- Kegiatan Periode Ini --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Kegiatan Periode Ini</div>
            <div class="dash-stat-value">{{ $kegiatanBulanIni }}</div>
        </div>
        <div class="dash-stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008z"/></svg>
        </div>
    </div>

    {{-- Agenda Hari Ini --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Agenda Hari Ini</div>
            <div class="dash-stat-value">{{ $agendaCount }}</div>
            <div class="dash-stat-sub">
                @if($agendaCount > 0) Memerlukan perhatian @else Tidak ada agenda @endif
            </div>
        </div>
        <div class="dash-stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        </div>
    </div>

    {{-- Agenda Mendatang --}}
    <div class="dash-stat-card">
        <div>
            <div class="dash-stat-label">Agenda Mendatang</div>
            <div class="dash-stat-value">{{ $agendaMendatang }}</div>
            <div class="dash-stat-sub">Dalam 7 hari ke depan</div>
        </div>
        <div class="dash-stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
        </div>
    </div>
</div>

{{-- 4. Main Grid: Statistik Kegiatan & Agenda Pimpinan --}}
<div class="dash-main-grid">

    {{-- Statistik Kegiatan (Bar Chart) --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Statistik Kegiatan</span>
            <select class="filter-select" id="bidang-filter" onchange="filterChart(this.value)">
                <option value="semua">Semua Bidang</option>
                <option value="rapat">Rapat</option>
                <option value="kunjungan">Kunjungan</option>
                <option value="acara">Acara</option>
                <option value="audiensi">Audiensi</option>
            </select>
        </div>
        <div class="dash-card-body">
            @php
                $maxCount = collect($statistikBulanan)->max('count');
                $maxCount = $maxCount > 0 ? $maxCount : 1;
            @endphp
            <div class="chart-bars" id="chart-bars-container">
                @foreach($statistikBulanan as $stat)
                    @php 
                        $val = $stat['count'];
                        $pct = $val > 0 ? max(round(($val / $maxCount) * 100), 6) : 0; 
                    @endphp
                    <div class="chart-bar-wrap" 
                         data-bulan-nama="{{ $stat['bulan_nama'] ?? $stat['label'] }}"
                         data-semua="{{ $stat['count'] }}" 
                         data-rapat="{{ $stat['rapat'] }}" 
                         data-kunjungan="{{ $stat['kunjungan'] }}" 
                         data-acara="{{ $stat['acara'] }}" 
                         data-audiensi="{{ $stat['audiensi'] }}">
                        <div class="chart-bar-tooltip">{{ $stat['bulan_nama'] ?? $stat['label'] }}: {{ $stat['count'] }} kegiatan</div>
                        <div class="chart-bar {{ $val === 0 ? 'empty' : '' }}" style="height: {{ $pct }}%"></div>
                        <div class="chart-bar-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Agenda Pimpinan Hari Ini --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Agenda Pimpinan Hari Ini</span>
        </div>
        @if($agendaHariIni->count() > 0)
            <div class="agenda-timeline">
                @foreach($agendaHariIni as $agenda)
                    <div class="agenda-item">
                        <div class="agenda-time">{{ $agenda->tanggal_mulai ? $agenda->tanggal_mulai->format('H.i') : '—' }}</div>
                        <div class="agenda-line {{ $agenda->status }}"></div>
                        <div class="agenda-info">
                            <div class="agenda-judul" title="{{ $agenda->judul }}">{{ $agenda->judul }}</div>
                            <div class="agenda-meta">
                                @if($agenda->lokasi)
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                        {{ $agenda->lokasi }}
                                    </span>
                                @endif
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    {{ $agenda->pimpinan_label ?? ucfirst(str_replace('_', ' ', $agenda->pimpinan)) }}
                                </span>
                            </div>
                            <div>
                                <span class="agenda-badge {{ $agenda->status }}">{{ $agenda->status_label ?? ucfirst($agenda->status) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" width="40" height="40" style="margin:0 auto 10px;display:block;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <p style="font-size:13px;margin:0;">Tidak ada agenda hari ini</p>
            </div>
        @endif
    </div>
</div>

{{-- 5. Grafik Sambutan (1 grafik + filter) --}}
<div class="dash-card sambutan-single-card">
    <div class="dash-card-header" style="flex-wrap:wrap;gap:10px;">
        <span class="dash-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16" style="vertical-align:middle;margin-right:6px;color:#6366f1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
            </svg>
            Statistik Sambutan
        </span>
        <div class="sambutan-filters">
            <select class="filter-select" id="sambutan-filter-tahun" onchange="handleSambutanYearChange(this)">
            </select>
            <select class="filter-select" id="sambutan-filter-bulan" onchange="renderSambutanChart()">
                <option value="0">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <span class="sambutan-total-badge" id="sambutan-total-label">Total: 0</span>
        </div>
    </div>
    <div class="dash-card-body">
        <div class="sambutan-chart-wrap" id="sambutan-chart-wrap">
            <div class="sambutan-y-axis" id="sambutan-y-axis"></div>
            <div class="sambutan-bars-area">
                <div class="sambutan-grid-lines" id="sambutan-grid-lines">
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                </div>
                <div class="sambutan-bars" id="sambutan-bars-container"></div>
            </div>
        </div>
    </div>
{{-- 5b. Grafik Dokumentasi (Foto, Video & Notulensi) --}}
<div class="dash-card dok-single-card">
    <div class="dash-card-header" style="flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
            <span class="dash-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16" style="vertical-align:middle;margin-right:6px;color:#0ea5e9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                Statistik Foto, Video & Notulensi
            </span>
            <div class="dok-legend">
                <span class="dok-legend-item" onclick="setDokTipeFilter('foto')" title="Filter Foto">
                    <span class="dok-dot foto"></span> Foto
                </span>
                <span class="dok-legend-item" onclick="setDokTipeFilter('video')" title="Filter Video">
                    <span class="dok-dot video"></span> Video
                </span>
                <span class="dok-legend-item" onclick="setDokTipeFilter('notulensi')" title="Filter Notulensi">
                    <span class="dok-dot notulensi"></span> Notulensi
                </span>
            </div>
        </div>
        <div class="sambutan-filters">
            <select class="filter-select" id="dok-filter-tipe" onchange="renderDokumentasiChart()">
                <option value="semua">Semua Tipe</option>
                <option value="foto">Foto</option>
                <option value="video">Video</option>
                <option value="notulensi">Notulensi</option>
            </select>
            <select class="filter-select" id="dok-filter-tahun" onchange="handleDokYearChange(this)">
            </select>
            <select class="filter-select" id="dok-filter-bulan" onchange="renderDokumentasiChart()">
                <option value="0">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <span class="sambutan-total-badge" id="dok-total-label" style="background:#f0fdf4;color:#16a34a;border-color:#bbf7d0;">Total: 0</span>
        </div>
    </div>
    <div class="dash-card-body">
        <div class="sambutan-chart-wrap" id="dok-chart-wrap">
            <div class="sambutan-y-axis" id="dok-y-axis"></div>
            <div class="sambutan-bars-area">
                <div class="sambutan-grid-lines" id="dok-grid-lines">
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                    <div class="sambutan-grid-line"></div>
                </div>
                <div class="sambutan-bars" id="dok-bars-container"></div>
            </div>
        </div>
    </div>
</div>

{{-- 6. Data Pegawai --}}
<div class="dash-table-card">
    <div class="dash-table-header">
        <span class="dash-table-header-title">Data Pegawai</span>
        <div class="dash-search-mini">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="color:#64748b"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" id="pegawai-search-input" placeholder="Cari pegawai..." onkeyup="searchPegawai(this.value)">
        </div>
    </div>
    <div style="overflow-x:auto">
        <table class="dash-table" id="pegawai-table">
            <thead>
                <tr>
                    <th style="width:60px">FOTO</th>
                    <th>NAMA PEGAWAI</th>
                    <th>NIP</th>
                    <th>JABATAN</th>
                    <th>STATUS</th>
                    <th style="text-align:right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personelList as $personel)
                <tr class="pegawai-row" 
                    data-nama="{{ strtolower($personel->nama_lengkap) }}" 
                    data-nip="{{ strtolower($personel->nip) }}" 
                    data-jabatan="{{ strtolower($personel->jabatan) }}" 
                    data-bagian="{{ strtolower($personel->bidang_label ?? $personel->bidang) }}">
                    <td>
                        @if($personel->photo)
                            <img src="{{ asset('storage/' . $personel->photo) }}" alt="{{ $personel->nama_lengkap }}" class="pegawai-avatar">
                        @else
                            <div class="pegawai-avatar">{{ $personel->initials }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-weight:600;color:#0f172a;font-size:13px">{{ $personel->nama_lengkap }}</span>
                            <span style="font-size:12px;color:#64748b;">{{ $personel->display_email }}</span>
                        </div>
                    </td>
                    <td style="font-size:12.5px;color:#334155;font-weight:500;">{{ $personel->nip ?: '-' }}</td>
                    <td style="color:#334155;font-size:13px">{{ $personel->jabatan }}</td>
                    <td>
                        <span class="pgw-status-pill {{ $personel->status_kepegawaian_badge_class }}">
                            {{ $personel->status_kepegawaian_label }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons" style="justify-content:flex-end">
                            {{-- Tombol Lihat (Mata) --}}
                            <a href="javascript:void(0)" class="action-icon" title="Lihat Detail" 
                               onclick="openPegawaiModal('{{ addslashes($personel->nama_lengkap) }}', '{{ $personel->nip ?: '-' }}', '{{ addslashes($personel->jabatan) }}', '{{ $personel->bidang_label }}', '{{ $personel->display_email }}', '{{ $personel->phone ?: '-' }}', '{{ $personel->photo ? asset('storage/' . $personel->photo) : '' }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>

                            {{-- Role Condition: Admin / Super Admin punya aksi Edit & Opsi Lain --}}
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('pegawai.edit', $personel->id) }}" class="action-icon" title="Edit Pegawai">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </a>
                            <a href="{{ route('pegawai.index', ['search' => $personel->nama_lengkap]) }}" class="action-icon" title="Opsi lain">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="empty-pegawai-row">
                    <td colspan="6" style="text-align:center;padding:32px;color:#94a3b8">Belum ada data pegawai</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="dash-see-all">
        <a href="{{ route('pegawai.index') }}">
            Lihat Semua Pegawai
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</div>

{{-- ── MODAL 1: Date Range Picker (Custom Kalender) ── --}}
<div class="custom-modal-overlay" id="date-range-modal" onclick="closeDateRangeModal(event)">
    <div class="custom-modal-content" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Pilih Rentang Waktu
            </h3>
            <button type="button" class="custom-modal-close-btn" onclick="document.getElementById('date-range-modal').classList.remove('open')">✕</button>
        </div>
        <form method="GET" action="{{ route('dashboard') }}" class="custom-modal-body">
            <input type="hidden" name="periode" value="custom">

            {{-- Quick Presets --}}
            <div style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:8px">Pilihan Cepat:</div>
            <div class="date-preset-grid">
                <button type="button" class="date-preset-btn" onclick="setPreset('today')">Hari Ini</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('last7')">7 Hari Lalu</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('thisMonth')">Bulan Ini</button>
                <button type="button" class="date-preset-btn" onclick="setPreset('lastMonth')">Bulan Lalu</button>
            </div>

            {{-- Date Inputs --}}
            <div class="date-input-group">
                <div class="date-input-wrap">
                    <label for="custom-start-date">Tanggal Mulai</label>
                    <input type="date" id="custom-start-date" name="start_date" 
                           value="{{ $startDateStr ?? \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}" required>
                </div>
                <div class="date-input-wrap">
                    <label for="custom-end-date">Tanggal Selesai</label>
                    <input type="date" id="custom-end-date" name="end_date" 
                           value="{{ $endDateStr ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="custom-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="document.getElementById('date-range-modal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn-modal-submit">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL 2: Detail Pegawai ── --}}
<div class="custom-modal-overlay" id="pegawai-modal" onclick="closePegawaiModal(event)">
    <div class="custom-modal-content" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <h3>Detail Pegawai</h3>
            <button type="button" class="custom-modal-close-btn" onclick="document.getElementById('pegawai-modal').classList.remove('open')">✕</button>
        </div>
        <div class="custom-modal-body">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px">
                <div id="modal-avatar-container"></div>
                <div>
                    <h3 id="modal-nama" style="margin:0 0 4px;font-size:16px;font-weight:700;color:#0f172a"></h3>
                    <div id="modal-nip" style="font-size:12.5px;color:#64748b;font-family:monospace"></div>
                </div>
            </div>
            <div class="pegawai-modal-grid">
                <div class="pegawai-modal-item">
                    <label>Jabatan</label>
                    <span id="modal-jabatan"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>Bagian</label>
                    <span id="modal-bagian"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>Email</label>
                    <span id="modal-email" style="font-size:12px;word-break:break-all"></span>
                </div>
                <div class="pegawai-modal-item">
                    <label>No. Telepon</label>
                    <span id="modal-phone"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Date Range Modal Logic ──
function openCustomDateModal() {
    document.getElementById('date-range-modal').classList.add('open');
}

function closeDateRangeModal(e) {
    if (e.target.id === 'date-range-modal') {
        document.getElementById('date-range-modal').classList.remove('open');
    }
}

function setPreset(type) {
    const today = new Date();
    const formatDate = (d) => d.toISOString().split('T')[0];

    const startInput = document.getElementById('custom-start-date');
    const endInput   = document.getElementById('custom-end-date');

    if (type === 'today') {
        startInput.value = formatDate(today);
        endInput.value   = formatDate(today);
    } else if (type === 'last7') {
        const past = new Date();
        past.setDate(today.getDate() - 7);
        startInput.value = formatDate(past);
        endInput.value   = formatDate(today);
    } else if (type === 'thisMonth') {
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        startInput.value = formatDate(firstDay);
        endInput.value   = formatDate(today);
    } else if (type === 'lastMonth') {
        const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
        const lastDayLastMonth  = new Date(today.getFullYear(), today.getMonth(), 0);
        startInput.value = formatDate(firstDayLastMonth);
        endInput.value   = formatDate(lastDayLastMonth);
    }
}

// ── Filter Chart Berdasarkan Kategori/Bidang ──
function filterChart(category) {
    const wraps = document.querySelectorAll('#chart-bars-container .chart-bar-wrap');
    let maxVal = 1;

    wraps.forEach(wrap => {
        const val = parseInt(wrap.getAttribute('data-' + category) || wrap.getAttribute('data-semua') || 0);
        if (val > maxVal) maxVal = val;
    });

    wraps.forEach(wrap => {
        const val = parseInt(wrap.getAttribute('data-' + category) || wrap.getAttribute('data-semua') || 0);
        const bar = wrap.querySelector('.chart-bar');
        const tooltip = wrap.querySelector('.chart-bar-tooltip');
        const label = wrap.getAttribute('data-bulan-nama') || wrap.querySelector('.chart-bar-label').textContent;

        if (val > 0) {
            const pct = Math.max(Math.round((val / maxVal) * 100), 6);
            bar.style.height = pct + '%';
            bar.classList.remove('empty');
        } else {
            bar.style.height = '0%';
            bar.classList.add('empty');
        }
        tooltip.textContent = label + ': ' + val + ' kegiatan';
    });
}

// ── Live Search Data Pegawai ──
function searchPegawai(keyword) {
    keyword = keyword.toLowerCase().trim();
    const rows = document.querySelectorAll('#pegawai-table tbody tr.pegawai-row');

    rows.forEach(row => {
        const nama = row.getAttribute('data-nama') || '';
        const nip = row.getAttribute('data-nip') || '';
        const jabatan = row.getAttribute('data-jabatan') || '';
        const bagian = row.getAttribute('data-bagian') || '';

        if (nama.includes(keyword) || nip.includes(keyword) || jabatan.includes(keyword) || bagian.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// ── Modal Detail Pegawai ──
function openPegawaiModal(nama, nip, jabatan, bagian, email, phone, photo) {
    document.getElementById('modal-nama').textContent = nama;
    document.getElementById('modal-nip').textContent = 'NIP: ' + nip;
    document.getElementById('modal-jabatan').textContent = jabatan;
    document.getElementById('modal-bagian').textContent = bagian;
    document.getElementById('modal-email').textContent = email;
    document.getElementById('modal-phone').textContent = phone;

    const avatarContainer = document.getElementById('modal-avatar-container');
    if (photo) {
        avatarContainer.innerHTML = `<img src="${photo}" alt="${nama}" class="pegawai-modal-avatar">`;
    } else {
        const initial = (nama && nama.length > 0) ? nama.charAt(0).toUpperCase() : 'P';
        avatarContainer.innerHTML = `<div class="pegawai-modal-avatar">${initial}</div>`;
    }

    document.getElementById('pegawai-modal').classList.add('open');
}

function closePegawaiModal(e) {
    if (e.target.id === 'pegawai-modal') {
        document.getElementById('pegawai-modal').classList.remove('open');
    }
}

// ── Sambutan Chart Interactive Filter ──
const sambutanData = {!! $sambutanChartJson !!};

function initSambutanFilters() {
    const yearSelect = document.getElementById('sambutan-filter-tahun');
    if (!yearSelect) return;

    yearSelect.innerHTML = '';

    const years = sambutanData.years || [];
    const currentYear = sambutanData.currentYear || new Date().getFullYear();

    years.forEach(yr => {
        const opt = document.createElement('option');
        opt.value = yr;
        opt.textContent = 'Tahun ' + yr;
        if (yr === currentYear) {
            opt.selected = true;
        }
        yearSelect.appendChild(opt);
    });

    const customOpt = document.createElement('option');
    customOpt.value = 'custom_prompt';
    customOpt.textContent = '+ Pilih Tahun Lain...';
    yearSelect.appendChild(customOpt);

    renderSambutanChart();
}

function handleSambutanYearChange(select) {
    if (select.value === 'custom_prompt') {
        const enteredYear = prompt('Masukkan tahun yang ingin ditampilkan (contoh: 2022):');
        const parsed = parseInt(enteredYear);
        if (parsed && parsed >= 1990 && parsed <= 2100) {
            let existing = Array.from(select.options).find(o => o.value == parsed);
            if (!existing) {
                existing = document.createElement('option');
                existing.value = parsed;
                existing.textContent = 'Tahun ' + parsed;
                select.insertBefore(existing, select.lastElementChild);
            }
            select.value = parsed;
        } else {
            select.value = sambutanData.currentYear || new Date().getFullYear();
            if (enteredYear !== null && enteredYear.trim() !== '') {
                alert('Tahun tidak valid. Silakan masukkan angka tahun antara 1990 - 2100.');
            }
        }
    }
    renderSambutanChart();
}

function renderSambutanChart() {
    const yearSelect = document.getElementById('sambutan-filter-tahun');
    const monthSelect = document.getElementById('sambutan-filter-bulan');
    const totalBadge = document.getElementById('sambutan-total-label');
    const yAxisContainer = document.getElementById('sambutan-y-axis');
    const barsContainer = document.getElementById('sambutan-bars-container');

    if (!yearSelect || !monthSelect || !barsContainer) return;

    const currentYear = sambutanData.currentYear || new Date().getFullYear();
    const selectedYear = yearSelect.value === 'custom_prompt' ? currentYear : (parseInt(yearSelect.value) || currentYear);
    const selectedMonth = parseInt(monthSelect.value) || 0;

    const matrix = sambutanData.matrix || {};
    const bulanLabels = sambutanData.bulanLabels || ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    let chartItems = [];
    let totalCount = 0;

    const yr = selectedYear;
    const yrMatrix = matrix[yr] || {};

    if (selectedMonth === 0) {
        for (let m = 1; m <= 12; m++) {
            const val = yrMatrix[m] || 0;
            totalCount += val;
            const isNow = (yr === currentYear && (new Date().getMonth() + 1) === m);
            chartItems.push({
                label: bulanLabels[m - 1],
                value: val,
                isCurrent: isNow,
                isHighlighted: true
            });
        }
        totalBadge.textContent = 'Total Tahun ' + yr + ': ' + totalCount + ' Sambutan';
    } else {
        const namaBulan = bulanLabels[selectedMonth - 1] || ('Bulan ' + selectedMonth);
        const valBulan = yrMatrix[selectedMonth] || 0;
        totalCount = valBulan;

        for (let m = 1; m <= 12; m++) {
            const val = yrMatrix[m] || 0;
            const isSelected = (m === selectedMonth);
            const isNow = (yr === currentYear && (new Date().getMonth() + 1) === m);
            chartItems.push({
                label: bulanLabels[m - 1],
                value: val,
                isCurrent: isNow,
                isHighlighted: isSelected,
                dimmed: !isSelected
            });
        }
        totalBadge.textContent = namaBulan + ' ' + yr + ': ' + valBulan + ' Sambutan';
    }

    const maxVal = Math.max(...chartItems.map(i => i.value), 1);

    if (yAxisContainer) {
        yAxisContainer.innerHTML = `
            <span>${maxVal}</span>
            <span>${Math.round(maxVal * 0.66)}</span>
            <span>${Math.round(maxVal * 0.33)}</span>
            <span>0</span>
        `;
    }

    barsContainer.innerHTML = '';

    chartItems.forEach(item => {
        const pct = maxVal > 0 ? Math.round((item.value / maxVal) * 100) : 0;
        const barHeight = item.value > 0 ? Math.max(pct, 8) : 3;

        let barClass = 'sambutan-bar sambutan-bar--bulan';

        if (item.isCurrent) {
            barClass += ' sambutan-bar--current';
        }
        if (item.dimmed) {
            barClass += ' sambutan-bar--dimmed';
        }
        if (item.isHighlighted && selectedMonth > 0) {
            barClass += ' sambutan-bar--highlighted';
        }

        const col = document.createElement('div');
        col.className = 'sambutan-bar-col';
        col.innerHTML = `
            <div class="sambutan-bar-value ${item.value === 0 ? 'sambutan-bar-value--zero' : ''}">${item.value}</div>
            <div class="sambutan-bar-outer">
                <div class="${barClass}" style="height: ${barHeight}%;" title="${item.label}: ${item.value} sambutan"></div>
            </div>
            <div class="sambutan-bar-label ${item.isCurrent ? 'sambutan-bar-label--current' : ''}">${item.label}</div>
        `;
        barsContainer.appendChild(col);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initSambutanFilters();
        initDokumentasiFilters();
    });
} else {
    initSambutanFilters();
    initDokumentasiFilters();
}

// ── Dokumentasi (Foto, Video, Notulensi) Chart Interactive Filter ──
const dokumentasiData = {!! $dokumentasiChartJson !!};

function initDokumentasiFilters() {
    const yearSelect = document.getElementById('dok-filter-tahun');
    if (!yearSelect) return;

    yearSelect.innerHTML = '';

    const years = dokumentasiData.years || [];
    const currentYear = dokumentasiData.currentYear || new Date().getFullYear();

    years.forEach(yr => {
        const opt = document.createElement('option');
        opt.value = yr;
        opt.textContent = 'Tahun ' + yr;
        if (yr === currentYear) {
            opt.selected = true;
        }
        yearSelect.appendChild(opt);
    });

    const customOpt = document.createElement('option');
    customOpt.value = 'custom_prompt';
    customOpt.textContent = '+ Pilih Tahun Lain...';
    yearSelect.appendChild(customOpt);

    renderDokumentasiChart();
}

function handleDokYearChange(select) {
    if (select.value === 'custom_prompt') {
        const enteredYear = prompt('Masukkan tahun yang ingin ditampilkan (contoh: 2022):');
        const parsed = parseInt(enteredYear);
        if (parsed && parsed >= 1990 && parsed <= 2100) {
            let existing = Array.from(select.options).find(o => o.value == parsed);
            if (!existing) {
                existing = document.createElement('option');
                existing.value = parsed;
                existing.textContent = 'Tahun ' + parsed;
                select.insertBefore(existing, select.lastElementChild);
            }
            select.value = parsed;
        } else {
            select.value = dokumentasiData.currentYear || new Date().getFullYear();
            if (enteredYear !== null && enteredYear.trim() !== '') {
                alert('Tahun tidak valid. Silakan masukkan angka tahun antara 1990 - 2100.');
            }
        }
    }
    renderDokumentasiChart();
}

function setDokTipeFilter(tipe) {
    const tipeSelect = document.getElementById('dok-filter-tipe');
    if (tipeSelect) {
        tipeSelect.value = tipe;
        renderDokumentasiChart();
    }
}

function renderDokumentasiChart() {
    const tipeSelect = document.getElementById('dok-filter-tipe');
    const yearSelect = document.getElementById('dok-filter-tahun');
    const monthSelect = document.getElementById('dok-filter-bulan');
    const totalBadge = document.getElementById('dok-total-label');
    const yAxisContainer = document.getElementById('dok-y-axis');
    const barsContainer = document.getElementById('dok-bars-container');

    if (!yearSelect || !monthSelect || !barsContainer) return;

    const selectedTipe = tipeSelect ? tipeSelect.value : 'semua';
    const currentYear = dokumentasiData.currentYear || new Date().getFullYear();
    const selectedYear = (yearSelect.value === 'custom_prompt') ? currentYear : (parseInt(yearSelect.value) || currentYear);
    const selectedMonth = parseInt(monthSelect.value) || 0;

    const matrix = dokumentasiData.matrix || {};
    const bulanLabels = dokumentasiData.bulanLabels || ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    let chartItems = [];
    let grandFoto = 0, grandVideo = 0, grandNotulensi = 0, grandTotal = 0;

    // Tampilkan per tahun terpilih
    const yr = selectedYear;
    const yrMatrix = matrix[yr] || {};

    if (selectedMonth === 0) {
        // 12 Bulan dalam tahun terpilih
        for (let m = 1; m <= 12; m++) {
            const cell = yrMatrix[m] || { foto: 0, video: 0, notulensi: 0, total: 0 };
            const f = cell.foto || 0;
            const v = cell.video || 0;
            const n = cell.notulensi || 0;
            const t = cell.total || 0;

            grandFoto += f; grandVideo += v; grandNotulensi += n; grandTotal += t;

            let val = t;
            if (selectedTipe === 'foto') val = f;
            else if (selectedTipe === 'video') val = v;
            else if (selectedTipe === 'notulensi') val = n;

            const isNow = (yr === currentYear && (new Date().getMonth() + 1) === m);
            chartItems.push({
                label: bulanLabels[m - 1],
                value: val,
                foto: f, video: v, notulensi: n, total: t,
                isCurrent: isNow,
                isHighlighted: true
            });
        }
    } else {
        // 12 Bulan, dengan highlight bulan tertentu
        const namaBulan = bulanLabels[selectedMonth - 1] || ('Bulan ' + selectedMonth);
        for (let m = 1; m <= 12; m++) {
            const cell = yrMatrix[m] || { foto: 0, video: 0, notulensi: 0, total: 0 };
            const f = cell.foto || 0;
            const v = cell.video || 0;
            const n = cell.notulensi || 0;
            const t = cell.total || 0;

            if (m === selectedMonth) {
                grandFoto = f; grandVideo = v; grandNotulensi = n; grandTotal = t;
            }

            let val = t;
            if (selectedTipe === 'foto') val = f;
            else if (selectedTipe === 'video') val = v;
            else if (selectedTipe === 'notulensi') val = n;

            const isSelected = (m === selectedMonth);
            const isNow = (yr === currentYear && (new Date().getMonth() + 1) === m);
            chartItems.push({
                label: bulanLabels[m - 1],
                value: val,
                foto: f, video: v, notulensi: n, total: t,
                isCurrent: isNow,
                isHighlighted: isSelected,
                dimmed: !isSelected
            });
        }
    }

    // Set Total Badge
    let activeTotal = grandTotal;
    if (selectedTipe === 'foto') activeTotal = grandFoto;
    else if (selectedTipe === 'video') activeTotal = grandVideo;
    else if (selectedTipe === 'notulensi') activeTotal = grandNotulensi;

    let badgeText = '';
    const prefix = selectedMonth > 0
        ? (bulanLabels[selectedMonth - 1] + ' ' + selectedYear)
        : ('Tahun ' + selectedYear);

    if (selectedTipe === 'semua') {
        badgeText = `${prefix}: ${grandTotal} Arsip (${grandFoto} Foto, ${grandVideo} Video, ${grandNotulensi} Notulensi)`;
    } else {
        const tipeLabel = selectedTipe.charAt(0).toUpperCase() + selectedTipe.slice(1);
        badgeText = `${prefix}: ${activeTotal} ${tipeLabel}`;
    }
    if (totalBadge) totalBadge.textContent = badgeText;

    // Y-Axis scale
    const maxVal = Math.max(...chartItems.map(i => i.value), 1);
    if (yAxisContainer) {
        yAxisContainer.innerHTML = `
            <span>${maxVal}</span>
            <span>${Math.round(maxVal * 0.66)}</span>
            <span>${Math.round(maxVal * 0.33)}</span>
            <span>0</span>
        `;
    }

    barsContainer.innerHTML = '';

    if (chartItems.length === 0) {
        barsContainer.innerHTML = '<div style="flex:1;text-align:center;padding:40px 10px;color:#94a3b8;font-size:13px;">Tidak ada data foto/video/notulensi untuk periode ini</div>';
        return;
    }

    chartItems.forEach(item => {
        const pct = maxVal > 0 ? Math.round((item.value / maxVal) * 100) : 0;
        const barHeight = item.value > 0 ? Math.max(pct, 8) : 3;

        const col = document.createElement('div');
        col.className = 'sambutan-bar-col dok-bar-col';
        if (item.dimmed) {
            col.style.opacity = '0.25';
        }

        let tooltipText = '';
        if (selectedTipe === 'semua') {
            tooltipText = `${item.label}: ${item.total} Arsip (${item.foto} Foto, ${item.video} Video, ${item.notulensi} Notulensi)`;
        } else {
            const tipeLabel = selectedTipe.charAt(0).toUpperCase() + selectedTipe.slice(1);
            tooltipText = `${item.label}: ${item.value} ${tipeLabel}`;
        }

        let barInnerHtml = '';
        if (selectedTipe === 'semua') {
            // Stacked bar
            if (item.value === 0) {
                barInnerHtml = `<div class="dok-bar-stacked" style="height: ${barHeight}%; background: #e2e8f0;"></div>`;
            } else {
                const totalVal = item.total || 1;
                const pctFoto = Math.round((item.foto / totalVal) * 100);
                const pctVideo = Math.round((item.video / totalVal) * 100);
                const pctNotulensi = 100 - pctFoto - pctVideo;

                barInnerHtml = `
                    <div class="dok-bar-stacked" style="height: ${barHeight}%;">
                        ${item.foto > 0 ? `<div class="dok-segment dok-segment--foto" style="height:${pctFoto}%"></div>` : ''}
                        ${item.video > 0 ? `<div class="dok-segment dok-segment--video" style="height:${pctVideo}%"></div>` : ''}
                        ${item.notulensi > 0 ? `<div class="dok-segment dok-segment--notulensi" style="height:${pctNotulensi}%"></div>` : ''}
                    </div>
                `;
            }
        } else {
            // Single category bar
            let singleClass = `dok-bar--single-${selectedTipe}`;
            barInnerHtml = `
                <div class="sambutan-bar ${singleClass}" style="height: ${barHeight}%;"></div>
            `;
        }

        col.innerHTML = `
            <div class="dok-tooltip">${tooltipText}</div>
            <div class="sambutan-bar-value ${item.value === 0 ? 'sambutan-bar-value--zero' : ''}">${item.value}</div>
            <div class="sambutan-bar-outer" style="position:relative;">
                ${barInnerHtml}
            </div>
            <div class="sambutan-bar-label ${item.isCurrent ? 'sambutan-bar-label--current' : ''}">${item.label}</div>
        `;
        barsContainer.appendChild(col);
    });
}
</script>
@endpush
