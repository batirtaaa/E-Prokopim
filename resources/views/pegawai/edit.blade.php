@extends('layouts.app')
@section('title', 'Edit Data Pegawai — E-PROKOPIM')

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
            <h1 class="pgw-form-title">Edit Data Pegawai</h1>
            <p class="pgw-form-subtitle">Perbarui data pegawai {{ $pegawai->nama_lengkap }} di bawah ini.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('pegawai.update', $pegawai) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                    <input type="text" name="nama_lengkap" class="pgw-input-text" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Email Kedinasan</label>
                    <input type="email" name="email" class="pgw-input-text" value="{{ old('email', $pegawai->display_email) }}">
                </div>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" class="pgw-input-text" value="{{ old('nip', $pegawai->nip) }}">
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="pgw-input-text" value="{{ old('phone', $pegawai->phone) }}">
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
                    <input type="text" name="jabatan" class="pgw-input-text" value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                </div>

                <div class="pgw-form-group">
                    <label class="pgw-label">Status Kepegawaian <span class="req">*</span></label>
                    <select name="status_kepegawaian" class="pgw-select" required>
                        <option value="PNS" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK Penuh Waktu" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PPPK Penuh Waktu' ? 'selected' : '' }}>PPPK Penuh Waktu</option>
                        <option value="PPPK Paruh Waktu" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PPPK Paruh Waktu' ? 'selected' : '' }}>PPPK Paruh Waktu</option>
                        <option value="Outsourcing" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Outsourcing' ? 'selected' : '' }}>Outsourcing</option>
                    </select>
                </div>
            </div>

            <div class="pgw-form-grid-2">
                <div class="pgw-form-group">
                    <label class="pgw-label">Bidang Tugas / Keahlian</label>
                    <select name="bidang" class="pgw-select">
                        <option value="protokol" {{ old('bidang', $pegawai->bidang) == 'protokol' ? 'selected' : '' }}>Protokol</option>
                        <option value="mc" {{ old('bidang', $pegawai->bidang) == 'mc' ? 'selected' : '' }}>MC (Master of Ceremony)</option>
                        <option value="fotografer" {{ old('bidang', $pegawai->bidang) == 'fotografer' ? 'selected' : '' }}>Fotografer</option>
                        <option value="videografer" {{ old('bidang', $pegawai->bidang) == 'videografer' ? 'selected' : '' }}>Videografer</option>
                        <option value="notulis" {{ old('bidang', $pegawai->bidang) == 'notulis' ? 'selected' : '' }}>Notulis</option>
                        <option value="dokumentasi" {{ old('bidang', $pegawai->bidang) == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="lainnya" {{ old('bidang', $pegawai->bidang) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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

            <div style="margin-bottom: 12px; display:flex; align-items:center; gap:12px;">
                @if($pegawai->photo)
                    <img src="{{ asset('storage/' . $pegawai->photo) }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;" alt="">
                @else
                    <div style="width:48px;height:48px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-weight:600;color:#475569;">
                        {{ $pegawai->initials }}
                    </div>
                @endif
                <span style="font-size:12.5px; color:#64748b;">Unggah foto baru untuk mengganti foto profil saat ini.</span>
            </div>

            <input type="file" name="photo" accept="image/*" class="pgw-input-text">
        </div>

        {{-- Actions --}}
        <div class="pgw-form-actions">
            <a href="{{ route('pegawai.index') }}" class="pgw-btn-cancel">Batal</a>
            <button type="submit" class="pgw-btn-save">Perbarui Pegawai</button>
        </div>
    </form>
</div>
@endsection
