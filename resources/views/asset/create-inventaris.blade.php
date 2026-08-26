@extends('layouts.app')
@section('title', 'Tambah Inventaris Barang Baru — E-PROKOPIM')

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
.ast-badge-auto {
    background: #3b82f6;
    color: #ffffff;
    padding: 1px 6px;
    border-radius: 4px;
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.ast-input-text, .ast-select, .ast-input-date {
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
.ast-input-text:focus, .ast-select:focus, .ast-input-date:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.ast-input-text.readonly-auto {
    background: #f1f5f9;
    color: #64748b;
    border-color: #cbd5e1;
    cursor: not-allowed;
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
        <a href="{{ route('asset.index', ['tab' => 'inventaris']) }}" class="ast-back-btn" title="Kembali ke Daftar Aset">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div>
            <h1 class="ast-create-title">Tambah Inventaris Barang Baru</h1>
            <p class="ast-create-subtitle">Lengkapi formulir di bawah ini untuk mendaftarkan aset baru ke dalam sistem.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('asset.store-inventaris') }}" enctype="multipart/form-data">
        @csrf

        {{-- CARD 1: Informasi Barang --}}
        <div class="ast-form-card">
            <div class="ast-section-header">
                {{-- Box / Database icon --}}
                <svg class="ast-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
                <span>Informasi Barang</span>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Kode Aset</label>
                        <span class="ast-badge-auto">OTOMATIS</span>
                    </div>
                    <input type="text" name="kode_aset" class="ast-input-text readonly-auto" value="{{ old('kode_aset', $kodeOtomatis . ' (Auto-generated)') }}" readonly>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Nama Barang <span class="req">*</span></label>
                    </div>
                    <input type="text" name="nama_barang" class="ast-input-text" placeholder="e.g., Laptop Dell Latitude" value="{{ old('nama_barang') }}" required>
                </div>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Kategori <span class="req">*</span></label>
                    </div>
                    <select name="kategori" class="ast-select" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Furnitur" {{ old('kategori') == 'Furnitur' ? 'selected' : '' }}>Furnitur</option>
                        <option value="Peralatan Kantor" {{ old('kategori') == 'Peralatan Kantor' ? 'selected' : '' }}>Peralatan Kantor</option>
                        <option value="Dokumentasi" {{ old('kategori') == 'Dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Tanggal Perolehan <span class="req">*</span></label>
                    </div>
                    <input type="date" name="tanggal_perolehan" class="ast-input-date" value="{{ old('tanggal_perolehan', date('Y-m-d')) }}" required>
                </div>
            </div>
        </div>

        {{-- CARD 2: Detail Penempatan & Status --}}
        <div class="ast-form-card">
            <div class="ast-section-header">
                {{-- Location Pin Icon --}}
                <svg class="ast-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <span>Detail Penempatan &amp; Status</span>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Lokasi / Ruangan <span class="req">*</span></label>
                    </div>
                    <input type="text" name="lokasi" class="ast-input-text" placeholder="e.g., Ruang Rapat Utama" value="{{ old('lokasi') }}" required>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Penanggung Jawab</label>
                    </div>
                    <input type="text" name="penanggung_jawab" list="pegawaiSuggestions" class="ast-input-text" placeholder="Cari nama pegawai..." value="{{ old('penanggung_jawab') }}">
                    <datalist id="pegawaiSuggestions">
                        @foreach($pegawaiList as $pgw)
                            <option value="{{ $pgw->nama_lengkap }}">{{ $pgw->jabatan }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="ast-form-grid-2">
                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Kondisi Barang <span class="req">*</span></label>
                    </div>
                    <select name="kondisi" class="ast-select" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="baik" {{ old('kondisi', 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="ast-form-group">
                    <div class="ast-label-row">
                        <label class="ast-label">Status Aset <span class="req">*</span></label>
                    </div>
                    <select name="status" class="ast-select" required>
                        <option value="">Pilih Status</option>
                        <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="digunakan" {{ old('status') == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dalam_perbaikan" {{ old('status') == 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                        <option value="dihapuskan" {{ old('status') == 'dihapuskan' ? 'selected' : '' }}>Dihapuskan</option>
                    </select>
                </div>
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
                {{-- Foto Barang Upload --}}
                <div class="ast-upload-box-wrap">
                    <label class="ast-upload-box-title">Foto Barang</label>
                    <div class="ast-drop-box" onclick="document.getElementById('fotoBarangInput').click()">
                        <input type="file" id="fotoBarangInput" name="foto_barang" accept="image/*" onchange="previewUploadName(this, 'fotoLabel')">
                        <svg class="ast-drop-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <div class="ast-drop-text-primary" id="fotoLabel">
                            <span class="link-text">Unggah foto</span> atau tarik dan lepas
                        </div>
                        <div class="ast-drop-text-sub">PNG, JPG up to 5MB</div>
                    </div>
                </div>

                {{-- Scan Faktur / Dokumen Pendukung Upload --}}
                <div class="ast-upload-box-wrap">
                    <label class="ast-upload-box-title">Scan Faktur/Dokumen Pendukung</label>
                    <div class="ast-drop-box" onclick="document.getElementById('dokumenInput').click()">
                        <input type="file" id="dokumenInput" name="dokumen_pendukung" accept=".pdf,.jpg,.jpeg,.png,.docx" onchange="previewUploadName(this, 'docLabel')">
                        <svg class="ast-drop-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <div class="ast-drop-text-primary" id="docLabel">
                            <span class="link-text">Unggah dokumen</span> atau tarik dan lepas
                        </div>
                        <div class="ast-drop-text-sub">PDF, JPG up to 10MB</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="ast-create-actions">
            <a href="{{ route('asset.index', ['tab' => 'inventaris']) }}" class="ast-btn-cancel">Batal</a>
            <button type="submit" class="ast-btn-save">Simpan Aset</button>
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
