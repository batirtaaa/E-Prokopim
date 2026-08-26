@extends('layouts.auth')
@section('title', 'Daftar Akun Baru — SIKOPIM')

@section('content')
<div class="login-page">
    <div class="login-card" style="max-width: 480px; padding: 32px 36px 28px;">
        {{-- Logo --}}
        <div class="login-logo" style="margin-bottom: 20px;">
            <div class="login-logo-icon" style="width: 52px; height: 52px; margin-bottom: 12px;">
                <svg width="28" height="28" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="12" height="12" rx="2" fill="#0d2137"/>
                    <rect x="18" y="2" width="12" height="12" rx="2" fill="#1565c0"/>
                    <rect x="2" y="18" width="12" height="12" rx="2" fill="#1565c0"/>
                    <rect x="18" y="18" width="12" height="12" rx="2" fill="#0d2137"/>
                </svg>
            </div>
            <h1 style="font-size: 22px;">Registrasi Akun</h1>
            <p>SIKOPIM Kota Bandung</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom: 16px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('register.post') }}" class="login-form">
            @csrf

            <div class="form-group" style="margin-bottom: 12px;">
                <label class="form-label-normal">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                <div class="form-control-wrapper">
                    <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    <input
                        type="text"
                        name="name"
                        class="form-control with-icon"
                        placeholder="Contoh: Budi Santoso, S.STP."
                        value="{{ old('name') }}"
                        required
                        autofocus>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">Username <span style="color:#ef4444;">*</span></label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <input
                            type="text"
                            name="username"
                            class="form-control with-icon"
                            placeholder="username_anda"
                            value="{{ old('username') }}"
                            required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">NIP (Opsional)</label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>
                        <input
                            type="text"
                            name="nip"
                            class="form-control with-icon"
                            placeholder="18 digit NIP"
                            value="{{ old('nip') }}">
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label class="form-label-normal">Email <span style="color:#ef4444;">*</span></label>
                <div class="form-control-wrapper">
                    <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    <input
                        type="email"
                        name="email"
                        class="form-control with-icon"
                        placeholder="email@bandung.go.id"
                        value="{{ old('email') }}"
                        required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">No. Telepon / WA</label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                        <input
                            type="text"
                            name="phone"
                            class="form-control with-icon"
                            placeholder="08123456789"
                            value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">Jabatan / Bagian</label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" /></svg>
                        <input
                            type="text"
                            name="jabatan"
                            class="form-control with-icon"
                            placeholder="Staff Prokopim"
                            value="{{ old('jabatan') }}">
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">Password <span style="color:#ef4444;">*</span></label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        <input
                            type="password"
                            id="reg_password"
                            name="password"
                            class="form-control with-icon with-suffix"
                            placeholder="Min. 8 karakter"
                            required>
                        <button type="button" class="form-control-suffix" data-toggle-password="#reg_password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label-normal">Ulangi Password <span style="color:#ef4444;">*</span></label>
                    <div class="form-control-wrapper">
                        <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                        <input
                            type="password"
                            id="reg_password_confirmation"
                            name="password_confirmation"
                            class="form-control with-icon with-suffix"
                            placeholder="Konfirmasi"
                            required>
                        <button type="button" class="form-control-suffix" data-toggle-password="#reg_password_confirmation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-login" style="margin-bottom: 16px;">
                Daftar Akun Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
            </button>
        </form>

        <div style="text-align: center; padding-top: 14px; border-top: 1px solid #e2e8f0; font-size: 13px; color: #64748b;">
            Sudah memiliki akun? <a href="{{ route('login') }}" style="color: #1565c0; font-weight: 700; text-decoration: none;">Masuk di sini</a>
        </div>

        <div class="login-footer" style="margin-top: 20px;">
            &copy; {{ date('Y') }} Bagian Protokol dan Komunikasi Pimpinan<br>
            Pemerintah Kota Bandung
        </div>
    </div>
</div>
@endsection
