@extends('layouts.auth')
@section('title', 'Lupa Password — SIKOPIM')

@section('content')
<div class="login-page">
    <div class="login-card">
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

        <div style="margin-bottom: 24px;">
            <h2 style="font-size:18px;font-weight:700;color:var(--primary);margin-bottom:6px;">Lupa Password</h2>
            <p style="font-size:13px;color:var(--text-secondary);">Hubungi administrator untuk mereset password Anda.</p>
        </div>

        <div class="alert alert-warning">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
            Silakan hubungi Administrator Prokopim untuk reset password.
        </div>

        <a href="{{ route('login') }}" class="btn btn-outline w-full" style="justify-content:center;margin-top:8px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali ke Login
        </a>

        <div class="login-footer">
            &copy; {{ date('Y') }} Bagian Protokol dan Komunikasi Pimpinan<br>
            Pemerintah Kota Bandung
        </div>
    </div>
</div>
@endsection
