@extends('layouts.app')
@section('title', 'Output Telaahan Analisis Isu — E-PROKOPIM')

@push('styles')
<style>
/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}
.breadcrumb a { color: #64748b; text-decoration: none; }
.breadcrumb a:hover { color: #2563eb; }
.breadcrumb-sep { color: #cbd5e1; font-size: 11px; }
.breadcrumb-current { color: #0f172a; font-weight: 600; }

/* Page Header */
.show-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 22px;
    gap: 16px;
    flex-wrap: wrap;
}
.show-header-left h1 {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.show-header-left p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}
.show-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-act {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s ease;
}
.btn-act.primary {
    background: #1e3a5f;
    color: white;
    border: 1px solid #1e3a5f;
}
.btn-act.primary:hover {
    background: #162f4f;
}
.btn-act.secondary {
    background: white;
    color: #334155;
    border: 1px solid #cbd5e1;
}
.btn-act.secondary:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}
.btn-act.danger {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.btn-act.danger:hover {
    background: #fee2e2;
}
.btn-act svg { width: 15px; height: 15px; }

/* Layout Grid */
.dossier-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
}
@media (max-width: 1024px) {
    .dossier-grid { grid-template-columns: 1fr; }
}

/* Dossier Main Card */
.dossier-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.dossier-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
    padding: 26px 28px;
    color: #ffffff;
    position: relative;
}
.dossier-badge-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    flex-wrap: wrap;
}
.dossier-title {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
    margin: 0 0 14px 0;
}
.dossier-meta-list {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 13px;
    color: #cbd5e1;
    flex-wrap: wrap;
}
.dossier-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
}
.dossier-meta-item svg { width: 14px; height: 14px; color: #94a3b8; }

/* Badges */
.badge-sentimen {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.02em;
}
.badge-sentimen.badge-positif { background: #ecfdf5; color: #047857; }
.badge-sentimen.badge-negatif { background: #fef2f2; color: #b91c1c; }
.badge-sentimen.badge-netral  { background: #f1f5f9; color: #334155; }

.badge-media {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}
.badge-media-sosial { background: #e0e7ff; color: #4338ca; }
.badge-media-online { background: #e0f2fe; color: #0369a1; }
.badge-media-cetak  { background: #fef3c7; color: #b45309; }

/* Sections */
.dossier-body {
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.output-box {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}
.output-box-header {
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 700;
    border-bottom: 1px solid #e2e8f0;
}
.output-box-header.hdr-analisis { background: #f8fafc; color: #0f172a; }
.output-box-header.hdr-kebijakan { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
.output-box-header.hdr-publikasi { background: #fdf2f8; color: #9d174d; border-color: #fbcfe8; }

.output-box-content {
    padding: 20px;
    font-size: 14px;
    line-height: 1.7;
    color: #334155;
    white-space: pre-line;
}
.output-box-content.bg-kebijakan { background: #f8faff; }
.output-box-content.bg-publikasi { background: #fdf4f8; }

/* Sidebar Cards */
.side-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}
.side-card-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.side-card-title svg { width: 16px; height: 16px; color: #1e3a5f; }

.side-item {
    margin-bottom: 14px;
}
.side-item:last-child { margin-bottom: 0; }
.side-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
}
.side-value {
    font-size: 13.5px;
    font-weight: 600;
    color: #0f172a;
}
.side-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #2563eb;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    word-break: break-all;
}
.side-link:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">&rsaquo;</span>
    <a href="{{ route('sambutan.index') }}">Komunikasi Pimpinan</a>
    <span class="breadcrumb-sep">&rsaquo;</span>
    <a href="{{ route('analisis.index') }}">Analisis Isu</a>
    <span class="breadcrumb-sep">&rsaquo;</span>
    <span class="breadcrumb-current">Output Telaahan #{{ $analisi->id }}</span>
</div>

{{-- Header Row --}}
<div class="show-header-row">
    <div class="show-header-left">
        <h1>Lembar Output Telaahan Analisis Isu</h1>
        <p>Laporan komprehensif analisis media, pemetaan dampak isu, serta rekomendasi kebijakan pimpinan.</p>
    </div>
    <div class="show-actions">
        <a href="{{ route('analisis.index') }}" class="btn-act secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali
        </a>
        <a href="{{ route('analisis.cetak', $analisi->id) }}" target="_blank" class="btn-act primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.04-.47-2.11-.67-3.21m0 0A18.03 18.03 0 0112 10.5c2.11 0 4.14.36 6.01 1.019m-12.02 0l-1.02-5.1A2.25 2.25 0 017.18 3.75h9.64a2.25 2.25 0 012.21 2.669l-1.02 5.1m-12.02 0a24.49 24.49 0 000 7.421m12.02-7.421a24.49 24.49 0 010 7.421m-12.02 0h12.02M9 17.25v2.25A1.5 1.5 0 0010.5 21h3a1.5 1.5 0 001.5-1.5v-2.25"/></svg>
            Cetak Telaahan (PDF)
        </a>
        <a href="{{ route('analisis.edit', $analisi->id) }}" class="btn-act secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
            Edit
        </a>
        <form method="POST" action="{{ route('analisis.destroy', $analisi->id) }}" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data analisis ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-act danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                Hapus
            </button>
        </form>
    </div>
</div>

{{-- Dossier Grid --}}
<div class="dossier-grid">
    {{-- Main Content Column --}}
    <div class="dossier-main-card">
        {{-- Banner --}}
        <div class="dossier-banner">
            <div class="dossier-badge-row">
                <span class="badge-sentimen {{ $analisi->sentimen_badge_class }}">
                    @if($analisi->sentimen === 'Positif') &uarr; @elseif($analisi->sentimen === 'Negatif') &darr; @else &bull; @endif
                    Sentimen {{ $analisi->sentimen }}
                </span>
                <span class="badge-media {{ $analisi->jenis_media_badge_class }}">
                    Media {{ $analisi->jenis_media }}
                </span>
            </div>
            <h1 class="dossier-title">{{ $analisi->judul }}</h1>
            <div class="dossier-meta-list">
                <div class="dossier-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span>{{ $analisi->hari_tanggal }}</span>
                </div>
                <div class="dossier-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                    <span>Sumber: {{ $analisi->sumber_isu }}</span>
                </div>
                <div class="dossier-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                    <span>{{ $analisi->leading_sector }}</span>
                </div>
            </div>
        </div>

        {{-- Sections --}}
        <div class="dossier-body">
            {{-- 1. Analisis Isu --}}
            <div class="output-box">
                <div class="output-box-header hdr-analisis">
                    <div style="display:flex;align-items:center;gap:8px">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#2563eb"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 6"/></svg>
                        <span>1. Uraian Telaahan &amp; Analisis Isu</span>
                    </div>
                </div>
                <div class="output-box-content">
                    {{ $analisi->analisis }}
                </div>
            </div>

            {{-- 2. Rekomendasi Kebijakan --}}
            <div class="output-box" style="border-color:#bfdbfe">
                <div class="output-box-header hdr-kebijakan">
                    <div style="display:flex;align-items:center;gap:8px">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#1d4ed8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        <span>2. Rekomendasi Kebijakan Strategis</span>
                    </div>
                </div>
                <div class="output-box-content bg-kebijakan">
                    {{ $analisi->rekomendasi_kebijakan }}
                </div>
            </div>

            {{-- 3. Rekomendasi Publikasi --}}
            <div class="output-box" style="border-color:#fbcfe8">
                <div class="output-box-header hdr-publikasi">
                    <div style="display:flex;align-items:center;gap:8px">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#be185d"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                        <span>3. Rekomendasi Publikasi &amp; Komunikasi Publik</span>
                    </div>
                </div>
                <div class="output-box-content bg-publikasi">
                    {{ $analisi->rekomendasi_publikasi }}
                </div>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div>
        {{-- Metadata Card --}}
        <div class="side-card">
            <div class="side-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                Detail Informasi Isu
            </div>

            <div class="side-item">
                <div class="side-label">Hari &amp; Tanggal</div>
                <div class="side-value">{{ $analisi->hari_tanggal }}</div>
            </div>

            <div class="side-item">
                <div class="side-label">Jenis Media</div>
                <div class="side-value">
                    <span class="badge-media {{ $analisi->jenis_media_badge_class }}">Media {{ $analisi->jenis_media }}</span>
                </div>
            </div>

            <div class="side-item">
                <div class="side-label">Sentimen Isu</div>
                <div class="side-value">
                    <span class="badge-sentimen {{ $analisi->sentimen_badge_class }}">
                        {{ $analisi->sentimen }}
                    </span>
                </div>
            </div>

            <div class="side-item">
                <div class="side-label">Sumber Isu</div>
                <div class="side-value">{{ $analisi->sumber_isu }}</div>
            </div>

            <div class="side-item">
                <div class="side-label">Leading Sector</div>
                <div class="side-value" style="color:#1e3a5f">{{ $analisi->leading_sector }}</div>
            </div>

            @if($analisi->link_sumber)
            <div class="side-item">
                <div class="side-label">Link Sumber Berita</div>
                <a href="{{ $analisi->link_sumber }}" target="_blank" class="side-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Buka Tautan Berita
                </a>
            </div>
            @endif

            <div class="side-item" style="border-top:1px solid #f1f5f9;padding-top:12px">
                <div class="side-label">Dibuat Oleh</div>
                <div class="side-value" style="font-size:12.5px;color:#475569">
                    {{ $analisi->user ? $analisi->user->name : 'Administrator' }} &bull; {{ $analisi->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
