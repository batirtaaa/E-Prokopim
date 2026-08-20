@extends('layouts.app')
@section('title', 'Kegiatan Berhasil Disimpan — E-PROKOPIM')

@push('styles')
<style>
/* Override page-content padding agar background grey penuh */
.page-content {
    background: #f1f3f5 !important;
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 24px;
}

.success-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    width: 100%;
    max-width: 480px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

/* Top section: icon + title */
.success-top {
    padding: 52px 40px 40px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}
.success-icon-circle {
    width: 68px;
    height: 68px;
    background: #dcfce7;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 22px;
}
.success-icon-circle svg {
    width: 32px;
    height: 32px;
    color: #22c55e;
}
.success-title {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
}

/* Bottom section: 3 action buttons */
.success-actions {
    display: flex;
    border-top: none;
}
.success-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 20px 10px;
    font-size: 12.5px;
    font-weight: 600;
    text-align: center;
    line-height: 1.35;
    text-decoration: none;
    cursor: pointer;
    border: none;
    font-family: inherit;
    transition: background 0.15s;
    color: #374151;
    background: white;
}
.success-btn:not(:last-child) {
    border-right: 1px solid #e5e7eb;
}
.success-btn.primary {
    background: #1e3a5f;
    color: white;
}
.success-btn.primary:hover { background: #162f4f; }
.success-btn.secondary:hover { background: #f9fafb; }
.success-btn svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}
</style>
@endpush

@section('content')
<div class="success-card">

    {{-- Top: Icon + Title --}}
    <div class="success-top">
        <div class="success-icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
        <div class="success-title">Kegiatan Berhasil Disimpan</div>
    </div>

    {{-- Bottom: 3 Buttons --}}
    <div class="success-actions">

        {{-- Lihat Daftar Kegiatan --}}
        <a href="{{ route('kegiatan-pimpinan.index') }}" class="success-btn primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            Lihat Daftar<br>Kegiatan
        </a>

        {{-- Kirim ke WhatsApp --}}
        @php
            $waText = isset($kegiatan)
                ? "Kegiatan: {$kegiatan->judul}\nTanggal: " . ($kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('d M Y H:i') : '-') . " WIB\nLokasi: " . ($kegiatan->lokasi ?? '-')
                : 'Kegiatan baru telah ditambahkan di E-PROKOPIM';
        @endphp
        <a href="https://wa.me/?text={{ urlencode($waText) }}" target="_blank" class="success-btn secondary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="color:#25d366">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Kirim Kegiatan ke<br>Whatsapp
        </a>

        {{-- Unggah Kegiatan Baru --}}
        <a href="{{ route('kegiatan-pimpinan.create') }}" class="success-btn secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Unggah Kegiatan<br>Baru
        </a>

    </div>
</div>
@endsection
