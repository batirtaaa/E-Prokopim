@extends('layouts.auth')
@section('title', 'Masuk — SIKOPIM')

@section('content')
<div class="login-page">
    <div class="login-card">
        {{-- Logo --}}
        <div class="login-logo">
            <div class="login-logo-icon">
                <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="12" height="12" rx="2" fill="#0d2137"/>
                    <rect x="18" y="2" width="12" height="12" rx="2" fill="#1565c0"/>
                    <rect x="2" y="18" width="12" height="12" rx="2" fill="#1565c0"/>
                    <rect x="18" y="18" width="12" height="12" rx="2" fill="#0d2137"/>
                </svg>
            </div>
            <h1>SIKOPIM</h1>
            <p>Kota Bandung</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login.post') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label class="form-label-normal">Username</label>
                <div class="form-control-wrapper">
                    <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control with-icon"
                        placeholder="Masukkan NIP atau Username"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label-normal">Password</label>
                <div class="form-control-wrapper">
                    <svg class="form-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control with-icon with-suffix"
                        placeholder="Masukkan Password"
                        autocomplete="current-password">
                    <button type="button" class="form-control-suffix" data-toggle-password="#password">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                    </button>
                </div>
            </div>

            <div class="login-form-extra">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat Saya
                </label>
                <a href="{{ route('forgot-password') }}" class="forgot-link">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login">
                Masuk Aplikasi
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
            </button>
        </form>

        <div style="text-align: center; padding-top: 14px; margin-top: 14px; border-top: 1px solid #e2e8f0; font-size: 13px; color: #64748b;">
            Belum memiliki akun? <a href="{{ route('register') }}" style="color: #1565c0; font-weight: 700; text-decoration: none;">Daftar Sekarang</a>
        </div>

        <div class="login-footer">
            &copy; {{ date('Y') }} Bagian Protokol dan Komunikasi Pimpinan<br>
            Pemerintah Kota Bandung
        </div>
    </div>
</div>
@endsection
