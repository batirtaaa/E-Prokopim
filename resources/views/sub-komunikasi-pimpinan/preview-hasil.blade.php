@extends('layouts.app')
@section('title', 'Naskah Sambutan — ' . ($sambutan->nomor_surat ?? 'E-PROKOPIM'))

@push('styles')
<style>
.ph-container {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 40px;
}
.ph-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 14px;
}
.ph-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 500;
    color: #4b5563;
    text-decoration: none;
    padding: 8px 14px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.15s;
}
.ph-back-btn:hover {
    background: #f9fafb;
    color: #111827;
    border-color: #d1d5db;
}
.ph-actions-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.ph-btn-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    border: 1px solid transparent;
}
.ph-btn-action.primary {
    background: #1e3a5f;
    color: white;
}
.ph-btn-action.primary:hover {
    background: #152943;
    box-shadow: 0 2px 6px rgba(30, 58, 95, 0.25);
}
.ph-btn-action.secondary {
    background: #0284c7;
    color: white;
}
.ph-btn-action.secondary:hover {
    background: #0369a1;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
}
.ph-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.ph-card-header {
    padding: 16px 22px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ph-card-header h2 {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.ph-meta-grid {
    padding: 20px 22px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
    background: white;
}
.ph-meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.ph-meta-label {
    font-size: 11.5px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.ph-meta-value {
    font-size: 13.5px;
    font-weight: 600;
    color: #0f172a;
}
.ph-viewer-container {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.ph-viewer-topbar {
    padding: 12px 20px;
    background: #f1f5f9;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: #334155;
    font-weight: 500;
}
.ph-viewer-frame {
    width: 100%;
    height: 780px;
    border: none;
    display: block;
    background: #525659;
}
.ph-viewer-fallback {
    padding: 48px 24px;
    text-align: center;
    background: #fafafa;
}
.ph-viewer-fallback svg {
    width: 48px;
    height: 48px;
    color: #94a3b8;
    margin-bottom: 14px;
}
.ph-viewer-fallback h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 6px;
}
.ph-viewer-fallback p {
    font-size: 13.5px;
    color: #64748b;
    max-width: 460px;
    margin: 0 auto 20px;
}
</style>
@endpush

@section('content')
<div class="ph-container">
    {{-- Header --}}
    <div class="ph-header">
        <a href="{{ route('sambutan.index') }}" class="ph-back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Daftar Sambutan
        </a>

        {{-- Dua Tombol Aksi Utama --}}
        <div class="ph-actions-group">
            <a href="{{ route('sambutan.stream-hasil', $sambutan->id) }}" target="_blank" class="ph-btn-action secondary" title="Buka dan baca naskah langsung di browser">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Buka Dokumen</span>
            </a>
            <a href="{{ route('sambutan.download-hasil', $sambutan->id) }}" class="ph-btn-action primary" title="Unduh file dokumen asli ke komputer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                <span>Unduh File</span>
            </a>
        </div>
    </div>

    {{-- Detail Informasi Surat Sambutan --}}
    <div class="ph-card">
        <div class="ph-card-header">
            <h2>Informasi Naskah Sambutan</h2>
            <span class="sb-status-badge {{ $sambutan->status_badge_class }}">
                {{ $sambutan->status_label }}
            </span>
        </div>
        <div class="ph-meta-grid">
            <div class="ph-meta-item">
                <span class="ph-meta-label">Nomor Surat</span>
                <span class="ph-meta-value">{{ $sambutan->nomor_surat ?? '-' }}</span>
            </div>
            <div class="ph-meta-item">
                <span class="ph-meta-label">Asal Instansi</span>
                <span class="ph-meta-value">{{ $sambutan->asal_instansi ?? '-' }}</span>
            </div>
            <div class="ph-meta-item">
                <span class="ph-meta-label">Tujuan</span>
                <span class="ph-meta-value">{{ $sambutan->tujuan ?? '-' }}</span>
            </div>
            <div class="ph-meta-item">
                <span class="ph-meta-label">Tanggal Acara</span>
                <span class="ph-meta-value">
                    {{ $sambutan->tanggal_acara ? $sambutan->tanggal_acara->translatedFormat('d F Y') : '-' }}
                    @if($sambutan->waktu_acara)
                        — {{ $sambutan->waktu_acara }} WIB
                    @endif
                </span>
            </div>
            <div class="ph-meta-item">
                <span class="ph-meta-label">Petugas Disposisi</span>
                <span class="ph-meta-value">{{ $sambutan->petugas ? $sambutan->petugas->nama_lengkap : '-' }}</span>
            </div>
            <div class="ph-meta-item">
                <span class="ph-meta-label">Nama File Dokumen</span>
                <span class="ph-meta-value" style="color:#0284c7;word-break:break-all;">{{ $fileName }}</span>
            </div>
        </div>
        @if($sambutan->perihal)
            <div style="padding:0 22px 18px 22px;font-size:13px;color:#475569;">
                <strong style="color:#0f172a">Perihal:</strong> {{ $sambutan->perihal }}
            </div>
        @endif
    </div>

    {{-- Viewer Container --}}
    <div class="ph-viewer-container">
        <div class="ph-viewer-topbar">
            <div style="display:flex;align-items:center;gap:8px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16" style="color:#0284c7"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <span>Pratinjau: <strong>{{ $fileName }}</strong> ({{ strtoupper($ext) }})</span>
            </div>
            <div>
                @if($fileSize > 0)
                    <span style="color:#64748b;font-size:12px">Ukuran: {{ round($fileSize / 1024, 1) }} KB</span>
                @endif
            </div>
        </div>

        @if($ext === 'pdf')
            {{-- PDF Viewer Inline --}}
            <iframe src="{{ route('sambutan.stream-hasil', $sambutan->id) }}#toolbar=1" class="ph-viewer-frame"></iframe>
        @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
            {{-- Image Viewer --}}
            <div style="padding:24px;text-align:center;background:#f8fafc;max-height:800px;overflow:auto;">
                <img src="{{ route('sambutan.stream-hasil', $sambutan->id) }}" alt="{{ $fileName }}" style="max-width:100%;height:auto;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
            </div>
        @else
            {{-- Fallback untuk format DOC / DOCX --}}
            <div class="ph-viewer-fallback">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <h3>Dokumen Naskah Sambutan ({{ strtoupper($ext) }})</h3>
                <p>Dokumen format <strong>{{ strtoupper($ext) }}</strong> dapat langsung dibuka di browser atau diunduh ke komputer Anda melalui dua pilihan di bawah ini:</p>
                <div style="display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;">
                    <a href="{{ route('sambutan.stream-hasil', $sambutan->id) }}" target="_blank" class="ph-btn-action secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        <span>Buka di Browser</span>
                    </a>
                    <a href="{{ route('sambutan.download-hasil', $sambutan->id) }}" class="ph-btn-action primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        <span>Unduh Dokumen</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
