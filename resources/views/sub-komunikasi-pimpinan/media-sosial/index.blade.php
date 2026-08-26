@extends('layouts.app')
@section('title', 'Arsip Media Sosial — Komunikasi Pimpinan')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:20px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }

.btn-upload-top {
    display:inline-flex; align-items:center; gap:7px;
    padding:10px 18px; font-size:13.5px; font-weight:600;
    border-radius:8px; background:#1e3a5f; color:white;
    border:none; cursor:pointer; text-decoration:none;
    transition:background 0.15s;
}
.btn-upload-top:hover { background:#162f4f; }
.btn-upload-top svg { width:15px; height:15px; }

/* Toolbar & Tabs */
.ms-toolbar-wrap {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px 0 0;
}
.ms-tabs {
    display: flex;
    gap: 8px;
    padding-left: 16px;
}
.ms-tab {
    padding: 14px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 2.5px solid transparent;
    transition: all 0.15s;
    margin-bottom: -1px;
}
.ms-tab:hover { color: #111827; }
.ms-tab.active {
    color: #111827;
    font-weight: 600;
    border-bottom-color: #1e3a5f;
}

.ms-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
}
.ms-search-wrap { position:relative; width:220px; }
.ms-search-wrap svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:#9ca3af; }
.ms-search-input {
    width:100%; padding:7px 12px 7px 32px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:12.5px; color:#374151; background:#f9fafb; outline:none;
}
.ms-search-input:focus { border-color:#2563eb; background:white; }
.ms-btn-filter {
    display:inline-flex; align-items:center; gap:6px;
    padding:7px 12px; border:1px solid #e5e7eb; border-radius:8px;
    background:white; font-size:12.5px; color:#374151;
    cursor:pointer; text-decoration:none; transition:all 0.15s;
}
.ms-btn-filter:hover { border-color:#2563eb; color:#2563eb; }
.ms-btn-filter svg { width:14px; height:14px; }

/* Grid Cards */
.ms-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}
@media (max-width: 1200px) { .ms-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .ms-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .ms-grid { grid-template-columns: 1fr; } }

/* Media Card */
.ms-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.15s, box-shadow 0.15s;
}
.ms-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px -4px rgba(0,0,0,0.06);
}
.ms-card-thumb {
    position: relative;
    height: 160px;
    background: #f1f5f9;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #f1f5f9;
}
.ms-card-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ms-mock-preview {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px;
    position: relative;
}
.ms-platform-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #1e293b;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.ms-card-body {
    padding: 16px 18px 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ms-card-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 8px;
}
.ms-card-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ms-menu-btn {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 2px 4px;
    border-radius: 4px;
    position: relative;
}
.ms-menu-btn:hover { color: #374151; background: #f3f4f6; }
.ms-card-desc {
    font-size: 12.5px;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 14px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.ms-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f3f4f6;
    font-size: 12px;
}
.ms-date {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #6b7280;
    font-size: 12px;
}
.ms-date svg { width: 13px; height: 13px; color: #9ca3af; }

.ms-status-badge {
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
}
.ms-status-dipublikasi {
    background: #e0f2fe;
    color: #0284c7;
}
.ms-status-draft {
    background: #e2e8f0;
    color: #475569;
}
.ms-status-dijadwalkan {
    background: #fef3c7;
    color: #d97706;
}

/* "Tambah Desain Baru" Card */
.ms-card-add {
    background: #f0f7ff;
    border: 2px dashed #bfdbfe;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 32px 24px;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    min-height: 290px;
}
.ms-card-add:hover {
    border-color: #2563eb;
    background: #eff6ff;
    transform: translateY(-2px);
}
.ms-add-icon-wrap {
    width: 48px;
    height: 48px;
    background: #dbeafe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e3a5f;
    margin-bottom: 16px;
}
.ms-add-icon-wrap svg { width: 22px; height: 22px; }
.ms-add-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 6px;
}
.ms-add-sub {
    font-size: 12px;
    color: #64748b;
    line-height: 1.45;
    max-width: 180px;
}

/* Dropdown Menu */
.dropdown-menu-card {
    position: absolute;
    right: 0;
    top: 100%;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    z-index: 50;
    min-width: 130px;
    display: none;
    padding: 4px;
}
.dropdown-menu-card.show { display: block; }
.dropdown-menu-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 10px;
    font-size: 12.5px;
    color: #374151;
    text-decoration: none;
    border-radius: 6px;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}
.dropdown-menu-item:hover { background: #f3f4f6; }
.dropdown-menu-item.danger { color: #dc2626; }
.dropdown-menu-item.danger:hover { background: #fee2e2; }

/* Pagination */
.ms-pagination-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
    margin-top: 10px;
}
.ms-page-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: white;
    font-size: 13px;
    color: #6b7280;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.15s;
}
.ms-page-btn:hover { border-color: #2563eb; color: #2563eb; }
.ms-page-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: white; font-weight: 600; }
.ms-page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
    padding: 20px;
}
.modal-content {
    background: white;
    border-radius: 14px;
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
    animation: scaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid #e5e7eb;
}
.modal-header h3 { font-size: 16px; font-weight: 700; color: #111827; }
.modal-close { background: none; border: none; font-size: 20px; color: #9ca3af; cursor: pointer; }
.modal-close:hover { color: #111827; }
.modal-body { padding: 22px 24px; }
.form-group-m { margin-bottom: 16px; }
.form-label-m { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
.form-label-m .req { color: #ef4444; }
.form-input-m, .form-select-m, .form-textarea-m {
    width: 100%; padding: 8px 12px;
    border: 1px solid #e5e7eb; border-radius: 8px;
    font-size: 13px; color: #111827; background: white;
    outline: none; font-family: inherit;
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

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Arsip Media Sosial</h1>
        <p>Kelola dan pantau publikasi infografis, videografis, dan media luar ruang.</p>
    </div>
    @if(auth()->user()->isAdmin())
    <button type="button" onclick="openUploadModal('{{ $tab }}')" class="btn-upload-top">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Upload Media
    </button>
    @endif
</div>

{{-- Tabs & Toolbar --}}
<div class="ms-toolbar-wrap">
    <div class="ms-tabs">
        <a href="{{ route('media-sosial.index', ['tab' => 'infografis']) }}" class="ms-tab {{ $tab === 'infografis' ? 'active' : '' }}">Infografis</a>
        <a href="{{ route('media-sosial.index', ['tab' => 'videografis']) }}" class="ms-tab {{ $tab === 'videografis' ? 'active' : '' }}">Videografis</a>
        <a href="{{ route('media-sosial.index', ['tab' => 'media_luar_ruang']) }}" class="ms-tab {{ $tab === 'media_luar_ruang' ? 'active' : '' }}">Media Luar Ruang</a>
    </div>
    <form method="GET" action="{{ route('media-sosial.index') }}" class="ms-toolbar-right">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="ms-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" class="ms-search-input" name="search" value="{{ request('search') }}" placeholder="Cari judul atau tag...">
        </div>
        <button type="submit" name="bulan" value="1" class="ms-btn-filter">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Bulan Ini
        </button>
        <button type="submit" class="ms-btn-filter">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Filter
        </button>
    </form>
</div>

{{-- Grid Cards --}}
<div class="ms-grid">
    @forelse($items as $item)
    <div class="ms-card">
        {{-- Thumbnail --}}
        <div class="ms-card-thumb">
            @if($item->file_path)
                @if(Str::endsWith($item->file_path, ['.mp4', '.mov']))
                    <video src="{{ asset('storage/' . $item->file_path) }}" style="width:100%;height:100%;object-fit:cover" muted></video>
                @else
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->judul }}">
                @endif
            @else
                <div class="ms-mock-preview">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:44px;height:44px;color:#94a3b8;margin-bottom:6px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    <span style="font-size:11px;font-weight:600;color:#64748b">{{ strtoupper($item->kategori) }}</span>
                </div>
            @endif
            <span class="ms-platform-badge">{{ $item->platform_label }}</span>
        </div>

        {{-- Body --}}
        <div class="ms-card-body">
            <div class="ms-card-header-row">
                <div class="ms-card-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                <div style="position:relative">
                    <button type="button" class="ms-menu-btn" onclick="toggleCardMenu(event, 'menu-{{ $item->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg>
                    </button>
                    <div id="menu-{{ $item->id }}" class="dropdown-menu-card">
                        @if(auth()->user()->isAdmin())
                        <button type="button" class="dropdown-menu-item" onclick="editMedia({{ json_encode($item) }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Edit
                        </button>
                        @endif
                        @if($item->file_path)
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="dropdown-menu-item" download>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                Unduh File
                            </a>
                        @endif
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('media-sosial.destroy', $item) }}" onsubmit="return confirm('Hapus media ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-menu-item danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ms-card-desc">
                {{ $item->deskripsi ?: 'Tidak ada deskripsi singkat.' }}
            </div>
            <div class="ms-card-footer">
                <div class="ms-date">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span>{{ $item->tanggal_publikasi ? $item->tanggal_publikasi->format('d M Y') : '—' }}</span>
                </div>
                <span class="ms-status-badge ms-status-{{ $item->status }}">
                    {{ $item->status_label }}
                </span>
            </div>
        </div>
    </div>
    @empty
    @endforelse

    @if(auth()->user()->isAdmin())
    {{-- "Tambah Desain Baru" Card --}}
    <a href="javascript:void(0)" onclick="openUploadModal('{{ $tab }}')" class="ms-card-add">
        <div class="ms-add-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
        </div>
        <div class="ms-add-title">Tambah Desain Baru</div>
        <div class="ms-add-sub">
            @if($tab === 'infografis')
                Unggah file infografis (.jpg, .png, .pdf) untuk diarsipkan.
            @elseif($tab === 'videografis')
                Unggah video grafis (.mp4, .mov) untuk diarsipkan.
            @else
                Unggah desain billboard, baliho atau materi media luar ruang.
            @endif
        </div>
    </a>
    @endif
</div>

{{-- Pagination --}}
@if($items->hasPages() || $items->total() > 0)
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

{{-- Upload / Create Modal --}}
<div id="uploadModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Upload Media Baru</h3>
            <button type="button" class="modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <form id="mediaForm" method="POST" action="{{ route('media-sosial.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            <div class="modal-body">
                <div class="form-group-m">
                    <label class="form-label-m">Judul Media <span class="req">*</span></label>
                    <input type="text" class="form-input-m" name="judul" id="inputJudul" placeholder="Contoh: Capaian Kinerja Triwulan III..." required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group-m">
                        <label class="form-label-m">Kategori <span class="req">*</span></label>
                        <select class="form-select-m" name="kategori" id="inputKategori" required>
                            <option value="infografis" {{ $tab === 'infografis' ? 'selected' : '' }}>Infografis</option>
                            <option value="videografis" {{ $tab === 'videografis' ? 'selected' : '' }}>Videografis</option>
                            <option value="media_luar_ruang" {{ $tab === 'media_luar_ruang' ? 'selected' : '' }}>Media Luar Ruang</option>
                        </select>
                    </div>
                    <div class="form-group-m">
                        <label class="form-label-m">Platform / Media <span class="req">*</span></label>
                        <select class="form-select-m" name="platform" id="inputPlatform" required>
                            <option value="instagram">Instagram</option>
                            <option value="facebook">Facebook</option>
                            <option value="website">Website</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                            <option value="billboard">Billboard</option>
                            <option value="videotron">Videotron</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="form-group-m">
                        <label class="form-label-m">Tanggal Publikasi <span class="req">*</span></label>
                        <input type="date" class="form-input-m" name="tanggal_publikasi" id="inputTanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group-m">
                        <label class="form-label-m">Status <span class="req">*</span></label>
                        <select class="form-select-m" name="status" id="inputStatus" required>
                            <option value="dipublikasi">Dipublikasi</option>
                            <option value="draft">Draft</option>
                            <option value="dijadwalkan">Dijadwalkan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">Deskripsi Singkat</label>
                    <textarea class="form-textarea-m" name="deskripsi" id="inputDeskripsi" placeholder="Ringkasan singkat mengenai konten media..."></textarea>
                </div>
                <div class="form-group-m">
                    <label class="form-label-m">File Media (.jpg, .png, .pdf, .mp4)</label>
                    <input type="file" class="form-input-m" name="file_media" id="inputFileMedia" accept=".jpg,.jpeg,.png,.webp,.pdf,.mp4">
                    <div id="fileHelpText" style="font-size:11.5px;color:#9ca3af;margin-top:4px">Maksimal ukuran file: 25MB</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ms-btn-filter" onclick="closeModal('uploadModal')">Batal</button>
                <button type="submit" class="btn-upload-top" id="btnSubmitModal">Simpan Media</button>
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

document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown-menu-card').forEach(m => m.classList.remove('show'));
});

function openUploadModal(defaultKategori) {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "{{ route('media-sosial.store') }}";
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('modalTitle').textContent = 'Upload Media Baru';
    document.getElementById('btnSubmitModal').textContent = 'Simpan Media';
    if (defaultKategori) {
        document.getElementById('inputKategori').value = defaultKategori;
    }
    document.getElementById('uploadModal').style.display = 'flex';
}

function editMedia(item) {
    const form = document.getElementById('mediaForm');
    form.reset();
    form.action = "/komunikasi-pimpinan/media-sosial/" + item.id;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('modalTitle').textContent = 'Edit Data Media';
    document.getElementById('btnSubmitModal').textContent = 'Perbarui Media';

    document.getElementById('inputJudul').value = item.judul || '';
    document.getElementById('inputKategori').value = item.kategori || 'infografis';
    document.getElementById('inputPlatform').value = item.platform || 'instagram';
    document.getElementById('inputTanggal').value = item.tanggal_publikasi ? item.tanggal_publikasi.split('T')[0] : '';
    document.getElementById('inputStatus').value = item.status || 'dipublikasi';
    document.getElementById('inputDeskripsi').value = item.deskripsi || '';

    document.getElementById('uploadModal').style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}
</script>
@endpush
