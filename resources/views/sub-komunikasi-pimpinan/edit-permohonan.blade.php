@extends('layouts.app')
@section('title', 'Edit Surat Permohonan Sambutan — E-PROKOPIM')

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

.current-file-badge {
    margin-top: 10px;
    padding: 8px 12px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    font-size: 12px;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 6px;
}

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
        <h1>Edit Surat Permohonan</h1>
        <p>Perbarui informasi data surat atau disposisi sambutan pimpinan.</p>
    </div>
</div>

<form method="POST" action="{{ route('sambutan.update', $sambutan) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

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
                    <input type="text" class="form-input" name="nomor_surat" value="{{ old('nomor_surat', $sambutan->nomor_surat) }}" placeholder="Contoh: 005/123/Prokopim" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                    <input type="date" class="form-input" name="tanggal_surat" value="{{ old('tanggal_surat', $sambutan->tanggal_surat ? $sambutan->tanggal_surat->format('Y-m-d') : '') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Asal Instansi / Pengirim <span class="req">*</span></label>
                <input type="text" class="form-input" name="asal_instansi" value="{{ old('asal_instansi', $sambutan->asal_instansi) }}" placeholder="Masukkan nama instansi pengirim" required>
            </div>
            <div class="form-group">
                <label class="form-label">Perihal / Topik Sambutan <span class="req">*</span></label>
                <textarea class="form-textarea" name="perihal" placeholder="Jelaskan secara singkat topik sambutan..." required>{{ old('perihal', $sambutan->perihal) }}</textarea>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px;height:36px;color:#2563eb"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                <div class="upload-main" id="upload-main-text">Drag & Drop file di sini untuk mengganti</div>
                <div class="upload-sub" id="upload-sub-text">atau klik untuk menelusuri dari perangkat</div>
                <div class="upload-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    Format: PDF, JPG, PNG. Maks: 10MB
                </div>
            </label>
            @if($sambutan->file_name)
                <div class="current-file-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span>File saat ini: <strong>{{ $sambutan->file_name }}</strong></span>
                </div>
            @endif
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
        <div class="form-group">
            <label class="form-label">Pilih Petugas <span class="req">*</span></label>
            <select class="form-select" name="petugas_id">
                <option value="">Pilih petugas...</option>
                @foreach($personelList as $personel)
                    <option value="{{ $personel->id }}" {{ old('petugas_id', $sambutan->petugas_id) == $personel->id ? 'selected' : '' }}>
                        {{ $personel->nama_lengkap }} — {{ $personel->jabatan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Tenggat Waktu <span class="req">*</span></label>
            <input type="date" class="form-input" name="tenggat_waktu" value="{{ old('tenggat_waktu', $sambutan->tenggat_waktu ? $sambutan->tenggat_waktu->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Instruksi / Catatan Disposisi</label>
            <textarea class="form-textarea" name="instruksi" placeholder="Masukkan instruksi atau catatan khusus...">{{ old('instruksi', $sambutan->instruksi_disposisi) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Status Urgensi <span class="req">*</span></label>
            <div class="radio-group">
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="biasa" {{ old('status_urgensi', $sambutan->status_urgensi) === 'biasa' ? 'checked' : '' }}> Biasa
                </label>
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="segera" {{ old('status_urgensi', $sambutan->status_urgensi) === 'segera' ? 'checked' : '' }}> Segera
                </label>
                <label class="radio-item">
                    <input type="radio" name="status_urgensi" value="penting" {{ old('status_urgensi', $sambutan->status_urgensi) === 'penting' ? 'checked' : '' }}> Penting
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Footer --}}
<div class="form-footer">
    <a href="{{ route('sambutan.index') }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        Simpan Perubahan
    </button>
</div>

</form>
@endsection

@push('scripts')
<script>
function handleFile(input) {
    if (input.files && input.files[0]) {
        const name = input.files[0].name;
        document.getElementById('upload-main-text').textContent = name;
        document.getElementById('upload-sub-text').textContent = 'File baru siap diunggah';
        document.getElementById('upload-label').style.borderColor = '#2563eb';
        document.getElementById('upload-label').style.background = '#eff6ff';
    }
}
const uploadArea = document.getElementById('upload-label');
if(uploadArea){
    ['dragover', 'dragenter'].forEach(e => uploadArea.addEventListener(e, ev => { ev.preventDefault(); uploadArea.style.borderColor = '#2563eb'; uploadArea.style.background = '#eff6ff'; }));
    ['dragleave', 'dragend'].forEach(e => uploadArea.addEventListener(e, () => { uploadArea.style.borderColor = '#d1d5db'; uploadArea.style.background = '#fafafa'; }));
    uploadArea.addEventListener('drop', ev => {
        ev.preventDefault();
        const f = ev.dataTransfer.files[0];
        if (f) {
            document.getElementById('upload-main-text').textContent = f.name;
            document.getElementById('upload-sub-text').textContent = 'File baru siap diunggah';
        }
    });
}
</script>
@endpush
