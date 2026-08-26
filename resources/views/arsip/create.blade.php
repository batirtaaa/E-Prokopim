@extends('layouts.app')
@section('title', 'Unggah Arsip Surat Baru — E-PROKOPIM')

@push('styles')
<style>
/* Page Container */
.ar-create-page {
    color: #1e293b;
    font-family: inherit;
    max-width: 1200px;
    margin: 0 auto;
}

/* Breadcrumb Navigation */
.ar-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 12px;
}
.ar-breadcrumb a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.15s;
}
.ar-breadcrumb a:hover {
    color: #0f172a;
}
.ar-breadcrumb .separator {
    color: #cbd5e1;
    font-size: 12px;
}
.ar-breadcrumb .current {
    font-weight: 700;
    color: #0f172a;
}

/* Page Header Row */
.ar-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
}
.ar-header-left h1 {
    font-size: 26px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 4px 0;
}
.ar-header-left p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}
.ar-btn-riwayat {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
}
.ar-btn-riwayat:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}
.ar-btn-riwayat svg {
    width: 15px;
    height: 15px;
    color: #64748b;
}

/* 2-Column Grid Layout */
.ar-form-grid {
    display: grid;
    grid-template-columns: 1.55fr 1fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 900px) {
    .ar-form-grid {
        grid-template-columns: 1fr;
    }
}

/* Form Cards */
.ar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}
.ar-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 18px;
    margin-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
}
.ar-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ar-card-icon.doc {
    background: #f1f5f9;
    color: #334155;
}
.ar-card-icon.upload {
    background: #e0f2fe;
    color: #0284c7;
}
.ar-card-icon svg {
    width: 18px;
    height: 18px;
}
.ar-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

/* Form Controls */
.ar-fg {
    margin-bottom: 18px;
}
.ar-fg:last-child {
    margin-bottom: 0;
}
.ar-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 7px;
}
.ar-label .req {
    color: #ef4444;
    margin-left: 2px;
}
.ar-input, .ar-select {
    width: 100%;
    padding: 10px 14px;
    font-size: 13.5px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    box-sizing: border-box;
    font-family: inherit;
    transition: all 0.15s ease;
}
.ar-input::placeholder {
    color: #94a3b8;
}
.ar-input:focus, .ar-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
}
.ar-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 14px center / 13px;
    appearance: none;
    cursor: pointer;
    padding-right: 36px;
}

.ar-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 580px) {
    .ar-row-2 {
        grid-template-columns: 1fr;
    }
}

/* Upload Zone */
.ar-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 44px 20px;
    text-align: center;
    background: #fafcff;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.ar-dropzone:hover, .ar-dropzone.dragover {
    border-color: #3b82f6;
    background: #eff6ff;
}
.ar-drop-icon-wrap {
    width: 52px;
    height: 52px;
    background: #e0f2fe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    color: #0284c7;
    transition: transform 0.2s ease;
}
.ar-dropzone:hover .ar-drop-icon-wrap {
    transform: translateY(-2px);
}
.ar-drop-icon-wrap svg {
    width: 26px;
    height: 26px;
}
.ar-drop-title {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 4px 0;
}
.ar-drop-or {
    font-size: 12px;
    color: #94a3b8;
    margin: 4px 0 12px 0;
}
.ar-drop-btn {
    display: inline-block;
    padding: 7px 20px;
    font-size: 13px;
    font-weight: 600;
    color: #0284c7;
    background: #e0f2fe;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s;
}
.ar-drop-btn:hover {
    background: #bae6fd;
    color: #0369a1;
}
.ar-drop-hint {
    font-size: 11.5px;
    color: #94a3b8;
    margin: 18px 0 0 0;
    line-height: 1.4;
}

/* File Selected Preview Box */
.ar-file-selected {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    margin-top: 14px;
}
.ar-file-info {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}
.ar-file-name {
    font-size: 13px;
    font-weight: 600;
    color: #166534;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}
.ar-file-size {
    font-size: 11.5px;
    color: #15803d;
}
.ar-file-remove {
    background: none;
    border: none;
    color: #dc2626;
    cursor: pointer;
    font-size: 18px;
    padding: 2px 6px;
    border-radius: 4px;
}
.ar-file-remove:hover {
    background: #fee2e2;
}

/* Bottom Action Buttons */
.ar-actions-row {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 24px;
}
.ar-btn-cancel {
    padding: 10px 24px;
    font-size: 13.5px;
    font-weight: 500;
    color: #475569;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
}
.ar-btn-cancel:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #94a3b8;
}
.ar-btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 26px;
    font-size: 13.5px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
}
.ar-btn-submit:hover {
    background: #091c2f;
}
.ar-btn-submit svg {
    width: 16px;
    height: 16px;
}
</style>
@endpush

@section('content')
<div class="ar-create-page">

    {{-- Breadcrumb --}}
    <div class="ar-breadcrumb">
        <a href="{{ route('arsip.index') }}">Administrasi</a>
        <span class="separator">&rsaquo;</span>
        <span class="current">Arsip Surat</span>
    </div>

    {{-- Page Header --}}
    <div class="ar-header-row">
        <div class="ar-header-left">
            <h1>Unggah Arsip Surat Baru</h1>
            <p>Digitalisasi dan penyimpanan dokumen administrasi E-PROKOPIM.</p>
        </div>
        <a href="{{ route('arsip.index') }}" class="ar-btn-riwayat">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Riwayat Arsip</span>
        </a>
    </div>

    {{-- Validation Error Alerts --}}
    @if ($errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:14px 18px; border-radius:10px; margin-bottom:24px; font-size:13px;">
        <div style="font-weight:600; margin-bottom:6px;">Terdapat kesalahan pada isian formulir:</div>
        <ul style="margin:0; padding-left:18px; list-style-type:disc;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Main Form --}}
    <form method="POST" action="{{ route('arsip.store') }}" enctype="multipart/form-data" id="formUnggahArsip">
        @csrf

        <div class="ar-form-grid">
            {{-- Left Card: Informasi Data Arsip --}}
            <div class="ar-card">
                <div class="ar-card-header">
                    <div class="ar-card-icon doc">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h2 class="ar-card-title">Informasi Data Arsip</h2>
                </div>

                {{-- 1. Nama Dokumen / Perihal --}}
                <div class="ar-fg">
                    <label class="ar-label">Nama Dokumen / Perihal</label>
                    <input type="text" name="judul" class="ar-input" placeholder="Tuliskan ringkasan perihal surat..." value="{{ old('judul') }}" required>
                </div>

                {{-- 2. Nomor Surat --}}
                <div class="ar-fg">
                    <label class="ar-label">Nomor Surat <span class="req">*</span></label>
                    <input type="text" name="nomor_arsip" class="ar-input" placeholder="Contoh: 005/123-Prokopim/2023" value="{{ old('nomor_arsip') }}" required>
                </div>

                {{-- 3. Row: Kategori Surat & Tanggal Arsip --}}
                <div class="ar-fg">
                    <div class="ar-row-2">
                        <div>
                            <label class="ar-label">Kategori Surat <span class="req">*</span></label>
                            <select name="kategori" id="selectKategori" class="ar-select" required onchange="handleKategoriChange(this)">
                                <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
                                <option value="surat_masuk" {{ old('kategori') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="surat_keluar" {{ old('kategori') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                <option value="sk" {{ old('kategori') == 'sk' ? 'selected' : '' }}>SK (Surat Keputusan)</option>
                                <option value="nota_dinas" {{ old('kategori') == 'nota_dinas' ? 'selected' : '' }}>Nota Dinas</option>
                                <option value="laporan" {{ old('kategori') == 'laporan' ? 'selected' : '' }}>Laporan</option>
                                <option value="peraturan" {{ old('kategori') == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>

                            {{-- Custom Kategori Input (muncul saat pilih 'Lainnya') --}}
                            <div id="customKategoriWrapper" style="display: {{ old('kategori') == 'lainnya' ? 'block' : 'none' }}; margin-top: 8px;">
                                <input type="text" name="kategori_custom" id="kategoriCustomInput" class="ar-input" placeholder="Tuliskan nama kategori khusus..." value="{{ old('kategori_custom') }}">
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Contoh: Rekomendasi, Berita Acara, MoA, dll.</div>
                            </div>
                        </div>
                        <div>
                            <label class="ar-label">Tanggal Arsip <span class="req">*</span></label>
                            <input type="date" name="tanggal_dokumen" class="ar-input" value="{{ old('tanggal_dokumen', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                {{-- 4. Row: Diunggah oleh & Sifat Surat --}}
                <div class="ar-fg">
                    <div class="ar-row-2">
                        <div>
                            <label class="ar-label">Diunggah oleh</label>
                            <select name="uploaded_by" class="ar-select">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('uploaded_by', auth()->id()) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="ar-label">Sifat Surat</label>
                            <select name="sifat_surat" class="ar-select">
                                <option value="biasa" {{ old('sifat_surat', 'biasa') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="penting" {{ old('sifat_surat') == 'penting' ? 'selected' : '' }}>Penting</option>
                                <option value="rahasia" {{ old('sifat_surat') == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                                <option value="sangat_rahasia" {{ old('sifat_surat') == 'sangat_rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
                                <option value="segera" {{ old('sifat_surat') == 'segera' ? 'selected' : '' }}>Segera</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Card: Upload Dokumen --}}
            <div>
                <div class="ar-card">
                    <div class="ar-card-header">
                        <div class="ar-card-icon upload">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                        </div>
                        <h2 class="ar-card-title">Upload Dokumen</h2>
                    </div>

                    {{-- Drag and Drop Area --}}
                    <div class="ar-dropzone" id="dropZone" onclick="document.getElementById('fileUploadInput').click()">
                        <input type="file" name="file" id="fileUploadInput" required accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" style="display:none;" onchange="handleFileSelected(this)">
                        
                        <div class="ar-drop-icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>

                        <p class="ar-drop-title">Tarik &amp; Lepas file di sini</p>
                        <p class="ar-drop-or">atau</p>
                        <button type="button" class="ar-drop-btn">Pilih File</button>
                        <p class="ar-drop-hint">Format yang didukung: PDF, JPG, PNG, DOCX.<br>Maksimal 10MB.</p>
                    </div>

                    {{-- Selected File Box --}}
                    <div class="ar-file-selected" id="fileSelectedBox">
                        <div class="ar-file-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" style="color:#16a34a; flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <div class="ar-file-name" id="fileNameText">document.pdf</div>
                                <div class="ar-file-size" id="fileSizeText">1.2 MB</div>
                            </div>
                        </div>
                        <button type="button" class="ar-file-remove" onclick="removeSelectedFile(event)" title="Hapus file">&times;</button>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="ar-actions-row">
                    <a href="{{ route('arsip.index') }}" class="ar-btn-cancel">Batal</a>
                    <button type="submit" class="ar-btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <span>Simpan Arsip</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// File drag & drop handling
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileUploadInput');
const fileBox = document.getElementById('fileSelectedBox');
const fileNameText = document.getElementById('fileNameText');
const fileSizeText = document.getElementById('fileSizeText');

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('dragover');
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('dragover');
    });
});

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelected(fileInput);
    }
});

function handleFileSelected(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        fileNameText.textContent = file.name;
        
        let sizeStr = '';
        if (file.size < 1024) sizeStr = file.size + ' B';
        else if (file.size < 1048576) sizeStr = (file.size / 1024).toFixed(1) + ' KB';
        else sizeStr = (file.size / 1048576).toFixed(1) + ' MB';
        
        fileSizeText.textContent = sizeStr;
        fileBox.style.display = 'flex';
        dropZone.style.display = 'none';
    }
}

function removeSelectedFile(e) {
    e.stopPropagation();
    fileInput.value = '';
    fileBox.style.display = 'none';
    dropZone.style.display = 'block';
}

// Custom Kategori Handler
function handleKategoriChange(select) {
    const wrapper = document.getElementById('customKategoriWrapper');
    const input = document.getElementById('kategoriCustomInput');
    if (select.value === 'lainnya') {
        wrapper.style.display = 'block';
        input.setAttribute('required', 'required');
        input.focus();
    } else {
        wrapper.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
    }
}

// Check initial state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('selectKategori');
    if (sel && sel.value === 'lainnya') {
        const wrapper = document.getElementById('customKategoriWrapper');
        const input = document.getElementById('kategoriCustomInput');
        wrapper.style.display = 'block';
        input.setAttribute('required', 'required');
    }
});
</script>
@endpush
