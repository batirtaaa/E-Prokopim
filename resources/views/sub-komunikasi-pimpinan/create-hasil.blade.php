@extends('layouts.app')
@section('title', 'Upload Hasil Sambutan — E-PROKOPIM')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }
.form-2col { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.form-card { background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; }
.form-card-title { display:flex; align-items:center; gap:9px; font-size:14px; font-weight:600; color:#111827; padding:18px 22px 16px; border-bottom:1px solid #f3f4f6; }
.form-card-title svg { width:16px; height:16px; color:#6b7280; }
.form-card-body { padding:22px; }
.form-group { margin-bottom:18px; }
.form-group:last-child { margin-bottom:0; }

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
.form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.form-input, .form-textarea {
    width:100%; padding:9px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:13.5px; color:#374151; background:white;
    outline:none; transition:border-color 0.15s; font-family:inherit;
}
.form-input:focus, .form-textarea:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.08); }
.form-input::placeholder, .form-textarea::placeholder { color:#9ca3af; }
.form-textarea { resize:vertical; min-height:100px; }
.upload-area { border:2px dashed #d1d5db; border-radius:10px; padding:32px 20px; text-align:center; cursor:pointer; transition:all 0.15s; background:#fafafa; }
.upload-area:hover { border-color:#2563eb; background:#eff6ff; }
.upload-area input[type="file"] { display:none; }
.upload-main { font-size:14px; font-weight:600; color:#111827; margin-bottom:4px; }
.upload-sub  { font-size:12.5px; color:#6b7280; margin-bottom:6px; }
.upload-hint { font-size:11.5px; color:#9ca3af; display:flex; align-items:center; gap:5px; justify-content:center; }
.upload-hint svg { width:13px; height:13px; }
.form-footer { display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #e5e7eb; }
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
        <h1>Upload Hasil Sambutan</h1>
        <p>Lengkapi form di bawah ini untuk mendaftarkan hasil draf atau naskah sambutan pimpinan.</p>
    </div>
</div>

<form method="POST" action="{{ route('sambutan.store') }}" enctype="multipart/form-data" onsubmit="return validateForm2()">
@csrf
<input type="hidden" name="jenis" value="hasil">
<input type="hidden" name="status_urgensi" value="biasa">

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
                    <input type="text" class="form-input" name="nomor_surat" placeholder="Contoh: 005/123/Prokopim" required>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                    <input type="date" class="form-input" name="tanggal_surat" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Asal Instansi / Pengirim <span class="req">*</span></label>
                <input type="text" class="form-input" name="asal_instansi" placeholder="Masukkan nama instansi pengirim" required>
            </div>
            <div class="form-group">
                <label class="form-label">Perihal / Topik Sambutan <span class="req">*</span></label>
                <textarea class="form-textarea" name="perihal" placeholder="Jelaskan secara singkat topik sambutan..." required></textarea>
            </div>
        </div>
    </div>

    {{-- 2. Upload Dokumen --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            2. Upload Dokumen
        </div>
        <div class="form-card-body">
            <div class="form-group">
                <label class="form-label">Dokumen Pendukung <span class="req">*</span></label>
                <label class="upload-area" for="input-dokumen2" id="upload-label2">
                    <input type="file" id="input-dokumen2" name="dokumen" accept=".pdf,.jpg,.jpeg,.png" required onchange="handleFile2(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px;height:36px;color:#2563eb;margin:0 auto 12px;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                    <div class="upload-main" id="upload-main-text2">Drag & Drop file di sini</div>
                    <div class="upload-sub" id="upload-sub-text2">atau klik untuk menelusuri dari perangkat</div>
                    <div class="upload-hint">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        Format: PDF, JPG, PNG. Maks: 10MB
                    </div>
                </label>
                <div id="file-error-msg2" style="display:none;color:#dc2626;font-size:12.5px;margin-top:6px;font-weight:500">
                    ⚠️ Dokumen pendukung wajib diunggah sebelum menyimpan!
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Warning Modal --}}
<div id="uploadWarningModal2" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(17,24,39,0.5);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(2px);">
    <div style="background:white;border-radius:16px;width:100%;max-width:440px;padding:32px 28px 24px;text-align:center;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);animation:scaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <div style="width:64px;height:64px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#d97706">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:32px;height:32px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:8px">Dokumen Surat Wajib Diupload!</h3>
        <p style="font-size:13.5px;color:#6b7280;line-height:1.5;margin-bottom:24px">
            Mohon upload file dokumen hasil sambutan terlebih dahulu sebelum menyimpan.
        </p>
        <div style="display:flex;gap:10px;justify-content:center">
            <button type="button" onclick="closeWarningModal2()" style="padding:9px 18px;border:1px solid #e5e7eb;border-radius:8px;background:white;color:#374151;font-size:13.5px;font-weight:500;cursor:pointer">
                Tutup
            </button>
            <button type="button" onclick="triggerUploadFromModal2()" style="padding:9px 20px;border:1px solid #1e3a5f;border-radius:8px;background:#1e3a5f;color:white;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                Upload Surat Sekarang
            </button>
        </div>
    </div>
</div>

<style>
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<div class="form-footer">
    <a href="{{ route('sambutan.index', ['tab' => 'hasil']) }}" class="btn-cancel">Batal</a>
    <button type="button" class="btn-submit" onclick="submitHasilForm()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3"/></svg>
        Simpan
    </button>
</div>

</form>
@endsection

@push('scripts')
<script>
function handleFile2(input) {
    const errorMsg = document.getElementById('file-error-msg2');
    const uploadLabel = document.getElementById('upload-label2');

    if (input.files && input.files[0]) {
        document.getElementById('upload-main-text2').textContent = input.files[0].name;
        document.getElementById('upload-sub-text2').textContent = 'File siap diupload (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
        uploadLabel.style.borderColor = '#2563eb';
        uploadLabel.style.background = '#eff6ff';
        if (errorMsg) errorMsg.style.display = 'none';
    } else {
        document.getElementById('upload-main-text2').textContent = 'Drag & Drop file di sini';
        document.getElementById('upload-sub-text2').textContent = 'atau klik untuk menelusuri dari perangkat';
        uploadLabel.style.borderColor = '#d1d5db';
        uploadLabel.style.background = '#fafafa';
    }
}

function showWarningModal2() {
    const modal = document.getElementById('uploadWarningModal2');
    if (modal) modal.style.display = 'flex';
}

function closeWarningModal2() {
    const modal = document.getElementById('uploadWarningModal2');
    if (modal) modal.style.display = 'none';
}

function triggerUploadFromModal2() {
    closeWarningModal2();
    const uploadLabel = document.getElementById('upload-label2');
    const fileInput = document.getElementById('input-dokumen2');
    uploadLabel.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        fileInput.click();
    }, 250);
}

function submitHasilForm() {
    const form = document.querySelector('form');
    const fileInput = document.getElementById('input-dokumen2');
    const uploadLabel = document.getElementById('upload-label2');
    const errorMsg = document.getElementById('file-error-msg2');

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    if (!fileInput.files || fileInput.files.length === 0) {
        uploadLabel.style.borderColor = '#ef4444';
        uploadLabel.style.background = '#fef2f2';
        if (errorMsg) errorMsg.style.display = 'block';
        showWarningModal2();
        return;
    }

    form.submit();
}
</script>
@endpush
