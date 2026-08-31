@extends('layouts.app')
@section('title', 'Upload Surat Permohonan — E-PROKOPIM')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }

/* Two-column form grid */
.form-2col { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }

/* Form card */
.form-card {
    background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;
}
.form-card-title {
    display:flex; align-items:center; gap:9px;
    font-size:14px; font-weight:600; color:#111827;
    padding:18px 22px 16px; border-bottom:1px solid #f3f4f6;
}
.form-card-title svg { width:16px; height:16px; color:#6b7280; }
.form-card-body { padding:22px; }

/* Override global form-label uppercase */
.form-group .form-label,
.form-group label.form-label {
    text-transform: none !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #374151 !important;
    letter-spacing: 0 !important;
    margin-bottom: 6px;
    display: block;
}
.form-label .req { color:#ef4444; }

/* Inputs */
.form-group { margin-bottom:18px; }
.form-group:last-child { margin-bottom:0; }
.form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.form-input, .form-select, .form-textarea {
    width:100%; padding:9px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:13.5px; color:#374151; background:white;
    outline:none; transition:border-color 0.15s;
    font-family:inherit;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.08);
}
.form-input::placeholder, .form-textarea::placeholder { color:#9ca3af; }
.form-textarea { resize:vertical; min-height:100px; }
.form-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; background-size:16px; padding-right:36px; }

/* Upload area */
.upload-wrap {
    padding: 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.upload-label-text {
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #374151 !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    margin-bottom: 10px;
    display: block;
}
.upload-label-text .req { color: #ef4444; }
.upload-area {
    flex: 1;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    background: #fafafa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.upload-area:hover { border-color:#2563eb; background:#eff6ff; }
.upload-area input[type="file"] { display:none; }
.upload-main { font-size:14px; font-weight:600; color:#111827; margin-bottom:2px; }
.upload-sub  { font-size:12.5px; color:#6b7280; margin-bottom:4px; }
.upload-hint { font-size:11.5px; color:#9ca3af; display:flex; align-items:center; gap:5px; justify-content:center; }
.upload-hint svg { width:13px; height:13px; }

/* Disposisi section */
.disposisi-card { background:white; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:16px; }
.disposisi-title {
    display:flex; align-items:center; gap:9px;
    font-size:14px; font-weight:600; color:#111827;
    padding:18px 22px 16px; border-bottom:1px solid #f3f4f6;
}
.disposisi-title svg { width:16px; height:16px; color:#6b7280; }
.disposisi-body { padding:22px; }

/* Urgensi radio */
.radio-group { display:flex; gap:20px; margin-top:6px; }
.radio-item { display:flex; align-items:center; gap:7px; font-size:13px; color:#374151; cursor:pointer; }
.radio-item input[type="radio"] { width:16px; height:16px; accent-color:#1e3a5f; cursor:pointer; }

/* Footer buttons */
.form-footer {
    display:flex; justify-content:flex-end; gap:10px;
    padding-top:16px; border-top:1px solid #e5e7eb; margin-top:4px;
}
.btn-cancel { padding:9px 20px; border:1px solid #e5e7eb; border-radius:8px; background:white; font-size:13.5px; color:#374151; cursor:pointer; font-family:inherit; text-decoration:none; display:inline-flex; align-items:center; transition:background 0.15s; }
.btn-cancel:hover { background:#f3f4f6; }
.btn-submit { padding:9px 20px; border:1px solid #1e3a5f; border-radius:8px; background:#1e3a5f; font-size:13.5px; font-weight:600; color:white; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:7px; transition:background 0.15s; }
.btn-submit:hover { background:#162f4f; }
.btn-submit svg { width:15px; height:15px; }
</style>
@endpush

@section('content')

<div class="page-header-row">
    <div class="page-header-left">
        <h1>Upload Surat Permohonan</h1>
        <p>Lengkapi form di bawah ini untuk mendaftarkan draf atau naskah sambutan pimpinan.</p>
    </div>
</div>

<form id="permohonanForm" method="POST" action="{{ route('sambutan.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
@csrf
<input type="hidden" name="jenis" value="permohonan">

@if ($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13.5px">
        <ul style="margin:0;padding-left:18px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- 2 Column: Data Surat + Upload Dokumen --}}
<div class="form-2col">

    {{-- 1. Data Surat --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            1. Data Surat
        </div>
        <div class="form-card-body">
            <div class="form-row-2" style="margin-bottom:18px">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Nomor Surat <span class="req">*</span></label>
                    <input type="text" class="form-input" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 005/123/Prokopim" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                    <input type="date" class="form-input" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                </div>
            </div>

            <div class="form-row-2" style="margin-bottom:18px">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Tanggal Acara / Pelaksanaan <span class="req">*</span></label>
                    <input type="date" class="form-input" name="tanggal_acara" value="{{ old('tanggal_acara') }}" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Ditujukan Kepada (Tujuan Sambutan) <span class="req">*</span></label>
                    <select class="form-select" name="tujuan" id="selectTujuan" onchange="toggleTujuanCustom(this.value)" required>
                        <option value="">Pilih pimpinan tujuan...</option>
                        <option value="Wali Kota (B1)" {{ old('tujuan') === 'Wali Kota (B1)' ? 'selected' : '' }}>Wali Kota (B1)</option>
                        <option value="Wakil Wali Kota (B2)" {{ old('tujuan') === 'Wakil Wali Kota (B2)' ? 'selected' : '' }}>Wakil Wali Kota (B2)</option>
                        <option value="Sekretaris Daerah (B3)" {{ old('tujuan') === 'Sekretaris Daerah (B3)' ? 'selected' : '' }}>Sekretaris Daerah (B3)</option>
                        <option value="Ketua TP-PKK / Aryatri Benarto (PKK1)" {{ old('tujuan') === 'Ketua TP-PKK / Aryatri Benarto (PKK1)' ? 'selected' : '' }}>Ketua TP-PKK / Aryatri Benarto (PKK1)</option>
                        <option value="Wakil Ketua TP-PKK / Fitriana Dewi (PKK2)" {{ old('tujuan') === 'Wakil Ketua TP-PKK / Fitriana Dewi (PKK2)' ? 'selected' : '' }}>Wakil Ketua TP-PKK / Fitriana Dewi (PKK2)</option>
                        <option value="Ketua DWP / R. Dewi Pertiwi Zulkarnain (DWP)" {{ old('tujuan') === 'Ketua DWP / R. Dewi Pertiwi Zulkarnain (DWP)' ? 'selected' : '' }}>Ketua DWP / R. Dewi Pertiwi Zulkarnain (DWP)</option>
                        <option value="Asisten Pemerintahan dan Kesra (Asisten 1)" {{ old('tujuan') === 'Asisten Pemerintahan dan Kesra (Asisten 1)' ? 'selected' : '' }}>Asisten Pemerintahan dan Kesra (Asisten 1)</option>
                        <option value="Asisten Perekonomian dan Pembangunan (Asisten 2)" {{ old('tujuan') === 'Asisten Perekonomian dan Pembangunan (Asisten 2)' ? 'selected' : '' }}>Asisten Perekonomian dan Pembangunan (Asisten 2)</option>
                        <option value="Asisten Administrasi Umum (Asisten 3)" {{ old('tujuan') === 'Asisten Administrasi Umum (Asisten 3)' ? 'selected' : '' }}>Asisten Administrasi Umum (Asisten 3)</option>
                        <option value="lainnya" {{ old('tujuan') === 'lainnya' ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                    </select>
                    <div id="tujuanCustomWrap" style="display: {{ old('tujuan') === 'lainnya' ? 'block' : 'none' }}; margin-top: 8px;">
                        <input type="text" class="form-input" name="tujuan_custom" id="inputTujuanCustom" value="{{ old('tujuan_custom') }}" placeholder="Ketik tujuan / penerima naskah sambutan...">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Asal Instansi / Pengirim <span class="req">*</span></label>
                <input type="text" class="form-input" name="asal_instansi" value="{{ old('asal_instansi') }}" placeholder="Masukkan nama instansi pengirim" required>
            </div>
            <div class="form-group">
                <label class="form-label">Perihal / Topik Sambutan <span class="req">*</span></label>
                <textarea class="form-textarea" name="perihal" placeholder="Jelaskan secara singkat topik sambutan..." required>{{ old('perihal') }}</textarea>
            </div>
        </div>
    </div>

    {{-- 2. Upload Dokumen --}}
    <div class="form-card" style="display:flex;flex-direction:column">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            2. Upload Dokumen
        </div>
        <div class="upload-wrap">
            <span class="upload-label-text">Dokumen Pendukung <span class="req">*</span></span>
            <label class="upload-area" for="input-dokumen" id="upload-label">
                <input type="file" id="input-dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFile(this)">
                <svg id="upload-icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px;height:36px;color:#2563eb"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                <div class="upload-main" id="upload-main-text">Drag & Drop file di sini</div>
                <div class="upload-sub" id="upload-sub-text">atau klik untuk menelusuri dari perangkat</div>
                <div class="upload-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    Format: PDF, JPG, PNG. Maks: 10MB
                </div>
            </label>
            <div id="file-error-msg" style="display:none;color:#dc2626;font-size:12.5px;margin-top:8px;font-weight:600">
                ⚠️ Dokumen pendukung wajib diunggah sebelum menyimpan!
            </div>
        </div>
    </div>
</div>

{{-- Penugasan Disposisi --}}
<div class="disposisi-card">
    <div class="disposisi-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
        Penugasan Disposisi
    </div>
    <div class="disposisi-body">
        <div class="form-row-2" style="margin-bottom:18px">
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Pilih Petugas Disposisi <span class="req">*</span></label>
                <select class="form-select" name="petugas_id" id="input-petugas">
                    <option value="">Pilih petugas...</option>
                    @foreach($personelList as $personel)
                        <option value="{{ $personel->id }}" {{ old('petugas_id') == $personel->id ? 'selected' : '' }}>{{ $personel->nama_lengkap }} — {{ $personel->jabatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Status Permohonan <span class="req">*</span></label>
                <select class="form-select" name="status" id="input-status">
                    <option value="diproses" {{ old('status', 'diproses') === 'diproses' ? 'selected' : '' }}>Progres / Sedang Diproses</option>
                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>

        {{-- Deadline Disposisi --}}
        <div class="form-group" style="margin-bottom:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;flex-wrap:wrap;gap:6px">
                <label class="form-label" style="margin-bottom:0 !important">Batas Waktu / Deadline Pengerjaan <span class="req">*</span></label>
                <div style="display:flex;gap:6px;align-items:center;">
                    <span style="font-size:11.5px;color:#64748b;">Pintas:</span>
                    <button type="button" onclick="setQuickDeadline(2)" style="font-size:11.5px;padding:3px 9px;border:1px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;border-radius:6px;cursor:pointer;font-weight:600">⚡ +2 Jam (Standar Disposisi)</button>
                    <button type="button" onclick="setQuickTodayEnd()" style="font-size:11.5px;padding:3px 9px;border:1px solid #e2e8f0;background:#f8fafc;color:#475569;border-radius:6px;cursor:pointer">Hari Ini 16:00</button>
                    <button type="button" onclick="setQuickTomorrow()" style="font-size:11.5px;padding:3px 9px;border:1px solid #e2e8f0;background:#f8fafc;color:#475569;border-radius:6px;cursor:pointer">Besok 10:00</button>
                </div>
            </div>
            <div class="form-row-2">
                <div>
                    <input type="date" class="form-input" name="tenggat_waktu" id="input-tenggat" value="{{ old('tenggat_waktu') }}" required>
                </div>
                <div>
                    <input type="time" class="form-input" name="deadline_jam" id="input-deadline-jam" value="{{ old('deadline_jam', '16:00') }}" required>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#d97706;margin-top:6px;background:#fef3c7;padding:6px 12px;border-radius:6px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><strong>Pengingat Disposisi:</strong> Disposisi naskah sambutan diharapkan selesai dikerjakan maksimal <strong>2 jam</strong> setelah instruksi diberikan.</span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Instruksi / Catatan Disposisi</label>
            <textarea class="form-textarea" name="instruksi" placeholder="Masukkan instruksi atau catatan khusus...">{{ old('instruksi') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Status Urgensi <span class="req">*</span></label>
            <div class="radio-group">
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="biasa" {{ old('status_urgensi', 'biasa') === 'biasa' ? 'checked' : '' }}> Biasa
                </label>
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="segera" {{ old('status_urgensi') === 'segera' ? 'checked' : '' }}> Segera
                </label>
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="penting" {{ old('status_urgensi') === 'penting' ? 'checked' : '' }}> Penting
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Custom Warning Modal --}}
<div id="uploadWarningModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(15,23,42,0.6);z-index:99999;align-items:center;justify-content:center;backdrop-filter:blur(3px);">
    <div style="background:white;border-radius:18px;width:90%;max-width:440px;padding:32px 28px 24px;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:scaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <div style="width:68px;height:68px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#d97706">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:36px;height:36px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>
        <h3 style="font-size:19px;font-weight:700;color:#111827;margin-bottom:8px">Dokumen Surat Wajib Diupload!</h3>
        <p style="font-size:13.5px;color:#6b7280;line-height:1.55;margin-bottom:24px">
            Mohon upload file dokumen surat permohonan terlebih dahulu sebelum menyimpan dan melanjutkan ke proses disposisi.
        </p>
        <div style="display:flex;gap:10px;justify-content:center">
            <button type="button" onclick="closeWarningModal()" style="padding:10px 18px;border:1px solid #e5e7eb;border-radius:8px;background:white;color:#374151;font-size:13.5px;font-weight:500;cursor:pointer">
                Tutup
            </button>
            <button type="button" onclick="triggerUploadFromModal()" style="padding:10px 20px;border:1px solid #1e3a5f;border-radius:8px;background:#1e3a5f;color:white;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                Upload Surat Sekarang
            </button>
        </div>
    </div>
</div>

<style>
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.92); }
    to { opacity: 1; transform: scale(1); }
}
</style>

{{-- Footer --}}
<div class="form-footer">
    <a href="{{ route('sambutan.index') }}" class="btn-cancel">Batal</a>
    <button type="button" class="btn-submit" onclick="submitPermohonanForm()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3"/></svg>
        Simpan & Lanjutkan ke Disposisi
    </button>
</div>

</form>
@endsection

@push('scripts')
<script>
function handleFile(input) {
    const errorMsg = document.getElementById('file-error-msg');
    const uploadLabel = document.getElementById('upload-label');

    if (input.files && input.files[0]) {
        const name = input.files[0].name;
        document.getElementById('upload-main-text').textContent = name;
        document.getElementById('upload-sub-text').textContent = 'File siap diupload (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
        uploadLabel.style.borderColor = '#2563eb';
        uploadLabel.style.background = '#eff6ff';
        if (errorMsg) errorMsg.style.display = 'none';
    } else {
        document.getElementById('upload-main-text').textContent = 'Drag & Drop file di sini';
        document.getElementById('upload-sub-text').textContent = 'atau klik untuk menelusuri dari perangkat';
        uploadLabel.style.borderColor = '#d1d5db';
        uploadLabel.style.background = '#fafafa';
    }
}

function showWarningModal() {
    const modal = document.getElementById('uploadWarningModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeWarningModal() {
    const modal = document.getElementById('uploadWarningModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function triggerUploadFromModal() {
    closeWarningModal();
    const uploadLabel = document.getElementById('upload-label');
    const fileInput = document.getElementById('input-dokumen');
    uploadLabel.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        fileInput.click();
    }, 250);
}

function submitPermohonanForm() {
    const form = document.getElementById('permohonanForm');
    const fileInput = document.getElementById('input-dokumen');
    const uploadLabel = document.getElementById('upload-label');
    const errorMsg = document.getElementById('file-error-msg');

    // Check standard required inputs first
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Check if file is uploaded
    if (!fileInput.files || fileInput.files.length === 0) {
        uploadLabel.style.borderColor = '#ef4444';
        uploadLabel.style.background = '#fef2f2';
        if (errorMsg) errorMsg.style.display = 'block';
        showWarningModal();
        return;
    }

    form.submit();
}

// Drag & Drop
const uploadArea = document.getElementById('upload-label');
if (uploadArea) {
    ['dragover', 'dragenter'].forEach(e => uploadArea.addEventListener(e, ev => { 
        ev.preventDefault(); 
        uploadArea.style.borderColor = '#2563eb'; 
        uploadArea.style.background = '#eff6ff'; 
    }));
    ['dragleave', 'dragend'].forEach(e => uploadArea.addEventListener(e, () => {
        const fileInput = document.getElementById('input-dokumen');
        if (!fileInput.files || fileInput.files.length === 0) {
            uploadArea.style.borderColor = '#d1d5db'; 
            uploadArea.style.background = '#fafafa';
        }
    }));
    uploadArea.addEventListener('drop', ev => {
        ev.preventDefault();
        const f = ev.dataTransfer.files[0];
        if (f) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(f);
            const fileInput = document.getElementById('input-dokumen');
            fileInput.files = dataTransfer.files;
            handleFile(fileInput);
        }
    });
}

function toggleTujuanCustom(val) {
    const wrap = document.getElementById('tujuanCustomWrap');
    const input = document.getElementById('inputTujuanCustom');
    if (wrap && input) {
        if (val === 'lainnya') {
            wrap.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            wrap.style.display = 'none';
            input.required = false;
        }
    }
}

function setQuickDeadline(hours) {
    const now = new Date();
    now.setHours(now.getHours() + hours);
    
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, '0');
    const dd = String(now.getDate()).padStart(2, '0');
    const hh = String(now.getHours()).padStart(2, '0');
    const min = String(now.getMinutes()).padStart(2, '0');
    
    const dateInput = document.getElementById('input-tenggat');
    const timeInput = document.getElementById('input-deadline-jam');
    if (dateInput) dateInput.value = `${yyyy}-${mm}-${dd}`;
    if (timeInput) timeInput.value = `${hh}:${min}`;
}

function setQuickTodayEnd() {
    const now = new Date();
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, '0');
    const dd = String(now.getDate()).padStart(2, '0');
    
    const dateInput = document.getElementById('input-tenggat');
    const timeInput = document.getElementById('input-deadline-jam');
    if (dateInput) dateInput.value = `${yyyy}-${mm}-${dd}`;
    if (timeInput) timeInput.value = `16:00`;
}

function setQuickTomorrow() {
    const now = new Date();
    now.setDate(now.getDate() + 1);
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, '0');
    const dd = String(now.getDate()).padStart(2, '0');
    
    const dateInput = document.getElementById('input-tenggat');
    const timeInput = document.getElementById('input-deadline-jam');
    if (dateInput) dateInput.value = `${yyyy}-${mm}-${dd}`;
    if (timeInput) timeInput.value = `10:00`;
}
</script>
@endpush

