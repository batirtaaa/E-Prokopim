@extends('layouts.app')
@section('title', 'Surat Berhasil Disimpan — E-PROKOPIM')

@push('styles')
<style>
.page-content {
    background: #f1f3f5 !important;
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 24px;
}
.suc-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    width: 100%;
    max-width: 560px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
/* Top section */
.suc-top {
    padding: 48px 40px 36px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}
.suc-icon {
    width: 68px; height: 68px;
    background: #dcfce7; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.suc-icon svg { width: 32px; height: 32px; color: #22c55e; }
.suc-title { font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 8px; }
.suc-subtitle { font-size: 13px; color: #6b7280; line-height: 1.6; }

/* Ringkasan */
.suc-ringkasan { padding: 20px 22px; border-bottom: 1px solid #e5e7eb; }
.suc-ringkasan-title {
    font-size: 11px; font-weight: 700; color: #9ca3af;
    letter-spacing: 0.08em; text-transform: uppercase;
    margin-bottom: 14px;
}
.suc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.suc-field {
    background: #f9fafb; border: 1px solid #f3f4f6;
    border-radius: 8px; padding: 12px 14px;
}
.suc-field-label { font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
.suc-field-value { font-size: 13.5px; font-weight: 600; color: #111827; }
.suc-field-sub { font-size: 12px; color: #6b7280; }
.badge-penting { display:inline-block; padding:2px 10px; border-radius:20px; background:#fee2e2; color:#dc2626; font-size:12px; font-weight:600; }
.badge-segera  { display:inline-block; padding:2px 10px; border-radius:20px; background:#fef3c7; color:#d97706; font-size:12px; font-weight:600; }
.badge-biasa   { display:inline-block; padding:2px 10px; border-radius:20px; background:#f3f4f6; color:#6b7280; font-size:12px; font-weight:600; }

/* Action buttons */
.suc-actions { display: flex; border-top: none; }
.suc-btn {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 9px; padding: 20px 10px;
    font-size: 12.5px; font-weight: 600; text-align: center;
    line-height: 1.35; text-decoration: none; cursor: pointer;
    border: none; font-family: inherit;
    transition: background 0.15s; color: #374151; background: white;
}
.suc-btn:not(:last-child) { border-right: 1px solid #e5e7eb; }
.suc-btn.primary { background: #1e3a5f; color: white; }
.suc-btn.primary:hover { background: #162f4f; }
.suc-btn.secondary:hover { background: #f9fafb; }
.suc-btn svg { width: 20px; height: 20px; flex-shrink: 0; }
</style>
@endpush

@section('content')
<div class="suc-card">

    {{-- Top: Icon + Title --}}
    <div class="suc-top">
        <div class="suc-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
        <div class="suc-title">Surat Berhasil Disimpan & Didisposisikan</div>
        <div class="suc-subtitle">Surat permohonan telah terdaftar dan penugasan telah diteruskan<br>ke petugas terkait.</div>
    </div>

    {{-- Ringkasan Data --}}
    <div class="suc-ringkasan">
        <div class="suc-ringkasan-title">Ringkasan Data</div>
        <div class="suc-grid">
            <div class="suc-field">
                <div class="suc-field-label">Nomor Surat</div>
                <div class="suc-field-value">{{ $sambutan->nomor_surat }}</div>
            </div>
            <div class="suc-field">
                <div class="suc-field-label">Asal Instansi</div>
                <div class="suc-field-value">{{ $sambutan->asal_instansi }}</div>
            </div>
            <div class="suc-field">
                <div class="suc-field-label">Petugas/Pejabat</div>
                <div class="suc-field-value">
                    @if($sambutan->petugas)
                        <span style="font-size:13px">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;vertical-align:middle;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            {{ $sambutan->petugas->nama_lengkap }} ({{ $sambutan->petugas->jabatan ?? 'Petugas' }})
                        </span>
                    @else
                        <span style="color:#9ca3af">Tidak ditugaskan</span>
                    @endif
                </div>
            </div>
            <div class="suc-field" style="display:grid;grid-template-columns:1fr auto;gap:8px;align-items:start">
                <div>
                    <div class="suc-field-label">Tenggat Waktu</div>
                    <div class="suc-field-value">{{ $sambutan->tenggat_waktu ? $sambutan->tenggat_waktu->format('d M Y') : '—' }}</div>
                </div>
                <div>
                    <div class="suc-field-label">Status Urgensi</div>
                    @if($sambutan->status_urgensi === 'penting')
                        <span class="badge-penting">● Penting</span>
                    @elseif($sambutan->status_urgensi === 'segera')
                        <span class="badge-segera">● Segera</span>
                    @else
                        <span class="badge-biasa">Biasa</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="suc-actions">
        <a href="{{ route('sambutan.index') }}" class="suc-btn primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
            Lihat Daftar<br>Surat
        </a>
        @php
            $docUrl = $sambutan->file_path ? url('storage/' . $sambutan->file_path) : null;
            $tenggatStr = $sambutan->tenggat_waktu ? $sambutan->tenggat_waktu->format('d M Y') : '-';

            $waLines = [
                "Nomor Surat: " . $sambutan->nomor_surat,
                "Instansi: " . $sambutan->asal_instansi,
                "Perihal: " . $sambutan->perihal,
                "Tenggat: " . $tenggatStr,
            ];

            if ($docUrl) {
                $waLines[] = $docUrl;
            }

            $waText = implode("\n", $waLines);
            $waHref = "https://api.whatsapp.com/send?text=" . urlencode($waText);
        @endphp
        <a href="{{ $waHref }}" target="_blank" class="suc-btn secondary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="color:#25d366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Kirim Penugasan ke<br>Whatsapp
        </a>
        <a href="{{ route('sambutan.create-permohonan') }}" class="suc-btn secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Unggah Surat<br>Baru
        </a>
    </div>
</div>
@endsection
