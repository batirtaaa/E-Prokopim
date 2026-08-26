@extends('layouts.app')
@section('title', 'Tambah Kendaraan Baru — E-PROKOPIM')

@push('styles')
<style>
.ast-create-container {
    max-width: 920px;
    margin: 0 auto;
    color: #1e293b;
    font-family: inherit;
}

/* Page Header with Back Button */
.ast-create-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}
.ast-back-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #334155;
    text-decoration: none;
    transition: all 0.15s ease;
    flex-shrink: 0;
}
.ast-back-btn:hover {
    border-color: #0f172a;
    color: #0f172a;
    background: #f8fafc;
}
.ast-create-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 3px 0;
}
.ast-create-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Form Cards */
.ast-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    padding: 24px 28px;
    margin-bottom: 20px;
}
.ast-section-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 18px;
}
.ast-section-icon {
    width: 17px;
    height: 17px;
    color: #0f172a;
    flex-shrink: 0;
}

/* Grid Layout */
.ast-form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 16px;
}
.ast-form-grid-2:last-child {
    margin-bottom: 0;
}
@media (max-width: 640px) {
    .ast-form-grid-2 {
        grid-template-columns: 1fr;
    }
}
.ast-form-group {
    display: flex;
    flex-direction: column;
}

/* Labels and Inputs */
.ast-label-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}
.ast-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}
.ast-label .req {
    color: #ef4444;
}
.ast-input-text, .ast-select, .ast-textarea {
    width: 100%;
    padding: 9px 12px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.15s ease;
    box-sizing: border-box;
    font-family: inherit;
}
.ast-input-text:focus, .ast-select:focus, .ast-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ast-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 13px;
    appearance: none;
    cursor: pointer;
}

/* Upload Drop Boxes */
.ast-upload-boxes-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
@media (max-width: 640px) {
    .ast-upload-boxes-grid {
        grid-template-columns: 1fr;
    }
}
.ast-upload-box-wrap {
    display: flex;
    flex-direction: column;
}
.ast-upload-box-title {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}
.ast-drop-box {
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    padding: 24px 16px;
    text-align: center;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.15s ease;
    position: relative;
}
.ast-drop-box:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}
.ast-drop-box input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.ast-drop-icon {
    width: 32px;
    height: 32px;
    color: #94a3b8;
    margin: 0 auto 8px auto;
    display: block;
}
.ast-drop-text-primary {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 3px;
}
.ast-drop-text-primary .link-text {
    color: #2563eb;
    font-weight: 600;
}
.ast-drop-text-sub {
    font-size: 11.5px;
    color: #94a3b8;
}

/* Form Actions */
.ast-create-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 10px;
    margin-bottom: 40px;
}
.ast-btn-cancel {
    padding: 9px 22px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s ease;
}
.ast-btn-cancel:hover {
    border-color: #94a3b8;
    color: #0f172a;
}
.ast-btn-save {
    padding: 9px 24px;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s ease;
}
.ast-btn-save:hover {
    background: #081d30;
}
</style>
@endpush

@section('content')
<div class="ast-create-container">

    {{-- Error messages --}}
    @if(isset($errors) && $errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px;">
        <div style="font-weight:600; margin-bottom:4px;">Terdapat kesalahan pada isian formulir:</div>
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Header with Back Button --}}
    <div class="ast-create-header">
        <a href="{{ route('asset.index', ['tab' => 'kendaraan']) }}" class="ast-back-btn" title="Kembali ke Daftar Kendaraan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div>
            <h1 class="ast-create-title">Tambah Kendaraan Baru</h1>
            <p class="ast-create-subtitle">Lengkapi formulir di bawah ini untuk mendaftarkan kendaraan operasional ke dalam sistem.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('asset.store-kendaraan') }}" enctype="multipart/form-data">
        @csrf

        {{-- CARD 1: Informasi Kendaraan --}}
        <div class="ast-form-card">
            <div class="ast-section-header">
                {{-- Truck/Car Icon --}}
                <svg class="ast-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75" />
                </svg>
                <span>Informasi Kendaraan</span>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Plat Nomor <span class="req">*</span></label>
                    </div>
                    <input type="text" name="plat_nomor" class="ast-input-text" placeholder="e.g., D 1234 ABC" value="{{ old('plat_nomor') }}" required style="text-transform: uppercase;">
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Nama Kendaraan <span class="req">*</span></label>
                    </div>
                    <input type="text" name="nama_kendaraan" class="ast-input-text" placeholder="e.g., Toyota Innova Zenix" value="{{ old('nama_kendaraan') }}" required>
                </div>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Jenis Kendaraan <span class="req">*</span></label>
                    </div>
                    <select name="jenis" class="ast-select" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Minibus" {{ old('jenis') == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                        <option value="Microbus" {{ old('jenis') == 'Microbus' ? 'selected' : '' }}>Microbus</option>
                        <option value="SUV" {{ old('jenis') == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Sedan" {{ old('jenis') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="Motor" {{ old('jenis') == 'Motor' ? 'selected' : '' }}>Motor</option>
                        <option value="Lainnya" {{ old('jenis') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Tahun Pembuatan/Perolehan <span class="req">*</span></label>
                    </div>
                    <input type="number" name="tahun" class="ast-input-text" placeholder="e.g., 2023" min="1990" max="2035" value="{{ old('tahun', date('Y')) }}" required>
                </div>
            </div>
        </div>

        {{-- CARD 2: Pengguna & Status Operasional --}}
        <div class="ast-form-card">
            <div class="ast-section-header">
                {{-- User / Status Icon --}}
                <svg class="ast-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Pengguna &amp; Status Operasional</span>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Pemegang / Pengguna</label>
                    </div>
                    <input type="text" name="pemegang_pengguna" list="pegawaiKendaraanSuggestions" class="ast-input-text" placeholder="e.g., Kabag Protokol / Nama Pegawai" value="{{ old('pemegang_pengguna') }}">
                    <datalist id="pegawaiKendaraanSuggestions">
                        <option value="Kabag Protokol">Kepala Bagian Protokol</option>
                        <option value="Tim Dokumentasi">Tim Dokumentasi</option>
                        <option value="Asisten Pemerintahan">Asisten Pemerintahan</option>
                        <option value="Wali Kota">Wali Kota</option>
                        <option value="Wakil Wali Kota">Wakil Wali Kota</option>
                        <option value="Sekretaris Daerah">Sekretaris Daerah</option>
                        @foreach($pegawaiList as $pgw)
                            <option value="{{ $pgw->nama_lengkap }}">{{ $pgw->jabatan }}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Status Kendaraan <span class="req">*</span></label>
                    </div>
                    <select name="status" class="ast-select" required>
                        <option value="">Pilih Status</option>
                        <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="sedang_digunakan" {{ old('status') == 'sedang_digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                        <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                </div>
            </div>

            <div class="ast-form-group" style="margin-top: 14px;">
                <div class="ast-label-row">
                    <label class="ast-label">Catatan / Keterangan</label>
                </div>
                <textarea name="catatan" class="ast-textarea" rows="3" placeholder="Catatan kondisi spesifik kendaraan, jadwal servis, dll...">{{ old('catatan') }}</textarea>
            </div>
        </div>

        {{-- CARD 3: Dokumentasi --}}
        <div class="ast-form-card">
            <div class="ast-section-header">
                {{-- Paperclip Icon --}}
                <svg class="ast-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.373L8.552 18.32a1.5 1.5 0 01-2.122-2.122l9.88-9.878" />
                </svg>
                <span>Dokumentasi</span>
            </div>

            <div class="ast-upload-boxes-grid">
                {{-- Foto Kendaraan --}}
                <div class="ast-upload-box-wrap">
                    <label class="ast-upload-box-title">Foto Kendaraan</label>
                    <div class="ast-drop-box" onclick="document.getElementById('fotoKendaraanInput').click()">
                        <input type="file" id="fotoKendaraanInput" name="foto" accept="image/*" onchange="previewUploadName(this, 'fotoKendaraanLabel')">
                        <svg class="ast-drop-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <div class="ast-drop-text-primary" id="fotoKendaraanLabel">
                            <span class="link-text">Unggah foto</span> atau tarik dan lepas
                        </div>
                        <div class="ast-drop-text-sub">PNG, JPG up to 5MB</div>
                    </div>
                </div>

                {{-- Dokumen STNK / BPKB --}}
                <div class="ast-upload-box-wrap">
                    <label class="ast-upload-box-title">Scan STNK / Dokumen Pendukung</label>
                    <div class="ast-drop-box" onclick="document.getElementById('dokumenKendaraanInput').click()">
                        <input type="file" id="dokumenKendaraanInput" name="dokumen" accept=".pdf,.jpg,.jpeg,.png,.docx" onchange="previewUploadName(this, 'docKendaraanLabel')">
                        <svg class="ast-drop-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <div class="ast-drop-text-primary" id="docKendaraanLabel">
                            <span class="link-text">Unggah dokumen</span> atau tarik dan lepas
                        </div>
                        <div class="ast-drop-text-sub">PDF, JPG up to 10MB</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="ast-create-actions">
            <a href="{{ route('asset.index', ['tab' => 'kendaraan']) }}" class="ast-btn-cancel">Batal</a>
            <button type="submit" class="ast-btn-save">Simpan Kendaraan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewUploadName(input, labelId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById(labelId).innerHTML = `<span style="color:#0f172a; font-weight:600;">✓ ${file.name}</span> (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
    }
}
</script>
@endpush
