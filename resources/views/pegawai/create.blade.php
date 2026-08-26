@extends('layouts.app')
@section('title', 'Tambah Pegawai Baru — E-PROKOPIM')

@push('styles')
<style>
.pgw-form-container {
    max-width: 820px;
    margin: 0 auto;
    color: #1e293b;
    font-family: inherit;
}

/* Page Header with Back Button */
.pgw-form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}
.pgw-back-btn {
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
.pgw-back-btn:hover {
    border-color: #0f172a;
    color: #0f172a;
    background: #f8fafc;
}
.pgw-form-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 3px 0;
}
.pgw-form-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Card */
.pgw-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    padding: 24px 28px;
    margin-bottom: 20px;
}
.pgw-section-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 18px;
}
.pgw-section-icon {
    width: 17px;
    height: 17px;
    color: #0f172a;
    flex-shrink: 0;
}

/* Grid */
.pgw-form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 16px;
}
.pgw-form-grid-2:last-child {
    margin-bottom: 0;
}
@media (max-width: 640px) {
    .pgw-form-grid-2 {
        grid-template-columns: 1fr;
    }
}
.pgw-form-group {
    display: flex;
    flex-direction: column;
}

/* Labels and Inputs */
.pgw-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.pgw-label .req {
    color: #ef4444;
}
.pgw-input-text, .pgw-select {
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
.pgw-input-text:focus, .pgw-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pgw-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 13px;
    appearance: none;
    cursor: pointer;
}

/* Upload Avatar Drop Box */
.pgw-drop-box {
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    padding: 24px 16px;
    text-align: center;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.15s ease;
    position: relative;
}
.pgw-drop-box:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}
.pgw-drop-box input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.pgw-drop-icon {
    width: 32px;
    height: 32px;
    color: #94a3b8;
    margin: 0 auto 8px auto;
    display: block;
}

/* Actions */
.pgw-form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 10px;
    margin-bottom: 40px;
}
.pgw-btn-cancel {
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
.pgw-btn-cancel:hover {
    border-color: #94a3b8;
    color: #0f172a;
}
.pgw-btn-save {
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
.pgw-btn-save:hover {
    background: #081d30;
}
</style>
@endpush

@section('content')
<div class="pgw-form-container">

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

    {{-- Header --}}
    <div class="pgw-form-header">
        <a href="{{ route('pegawai.index') }}" class="pgw-back-btn" title="Kembali ke Daftar Pegawai">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div>
            <h1 class="pgw-form-title">Tambah Pegawai Baru</h1>
            <p class="pgw-form-subtitle">Lengkapi data di bawah ini untuk mendaftarkan pegawai ke dalam sistem Prokopim.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Card 1: Data Pribadi & Kontak --}}
        <div class="pgw-form-card">
            <div class="pgw-section-header">
                <svg class="pgw-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Informasi Data Diri</span>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">Nama Lengkap &amp; Gelar <span class="req">*</span></label>
                    <input type="text" name="nama_lengkap" class="pgw-input-text" placeholder="e.g., Budi Santoso, S.IP., M.Si." value="{{ old('nama_lengkap') }}" required>
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Email Kedinasan</label>
                    <input type="email" name="email" class="pgw-input-text" placeholder="e.g., budisantoso@bandung.go.id" value="{{ old('email') }}">
                </div>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" class="pgw-input-text" placeholder="e.g., 19800101 200501 1 001 atau -" value="{{ old('nip') }}">
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="pgw-input-text" placeholder="e.g., 0812-3456-7890" value="{{ old('phone') }}">
                </div>
            </div>
        </div>

        {{-- Card 2: Kepegawaian & Posisi --}}
        <div class="pgw-form-card">
            <div class="pgw-section-header">
                <svg class="pgw-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
                <span>Jabatan &amp; Status Kepegawaian</span>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">Jabatan <span class="req">*</span></label>
                    <input type="text" name="jabatan" class="pgw-input-text" placeholder="e.g., Kepala Bagian / Kasubbag / Staf" value="{{ old('jabatan') }}" required>
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Status Kepegawaian <span class="req">*</span></label>
                    <select name="status_kepegawaian" class="pgw-select" required>
                        <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK Penuh Waktu" {{ old('status_kepegawaian') == 'PPPK Penuh Waktu' ? 'selected' : '' }}>PPPK Penuh Waktu</option>
                        <option value="PPPK Paruh Waktu" {{ old('status_kepegawaian') == 'PPPK Paruh Waktu' ? 'selected' : '' }}>PPPK Paruh Waktu</option>
                        <option value="Outsourcing" {{ old('status_kepegawaian') == 'Outsourcing' ? 'selected' : '' }}>Outsourcing</option>
                    </select>
                </div>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">Bidang Tugas / Keahlian</label>
                    <select name="bidang" class="pgw-select">
                        <option value="protokol" {{ old('bidang') == 'protokol' ? 'selected' : '' }}>Protokol</option>
                        <option value="mc" {{ old('bidang') == 'mc' ? 'selected' : '' }}>MC (Master of Ceremony)</option>
                        <option value="fotografer" {{ old('bidang') == 'fotografer' ? 'selected' : '' }}>Fotografer</option>
                        <option value="videografer" {{ old('bidang') == 'videografer' ? 'selected' : '' }}>Videografer</option>
                        <option value="notulis" {{ old('bidang') == 'notulis' ? 'selected' : '' }}>Notulis</option>
                        <option value="dokumentasi" {{ old('bidang') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="lainnya" {{ old('bidang') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Card 3: Foto Profil --}}
        <div class="pgw-form-card">
            <div class="pgw-section-header">
                <svg class="pgw-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <span>Foto Profil</span>
            </div>

            <div class="pgw-drop-box" onclick="document.getElementById('fotoPegawaiInput').click()">
                <input type="file" id="fotoPegawaiInput" name="photo" accept="image/*" onchange="previewUpload(this)">
                <svg class="pgw-drop-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
                <div style="font-size: 13px; font-weight: 500; color: #475569;" id="fotoUploadLabel">
                    <span style="color:#2563eb; font-weight:600;">Unggah foto</span> atau tarik dan lepas
                </div>
                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 3px;">PNG, JPG up to 5MB</div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pgw-form-actions">
            <a href="{{ route('pegawai.index') }}" class="pgw-btn-cancel">Batal</a>
            <button type="submit" class="pgw-btn-save">Simpan Pegawai</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('fotoUploadLabel').innerHTML = `<span style="color:#0f172a; font-weight:600;">✓ ${file.name}</span> (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
    }
}
</script>
@endpush
