@extends('layouts.app')
@section('title', 'Profil Administrator — SIKOPIM')
@section('topbar-title', 'Profil Admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Profil Administrator</h1>
    <p class="page-subtitle">Kelola informasi data diri, foto profil, dan kredensial keamanan akun Anda.</p>
</div>

<div class="profile-layout">
    {{-- Profile Photo Card --}}
    <div class="profile-card">
        <div style="position:relative;display:inline-block;margin-bottom:16px;">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="profile-photo">
            @else
                <div class="profile-photo" style="background:var(--primary);display:flex;align-items:center;justify-content:center;color:white;font-size:32px;font-weight:700;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-role-badge">{{ $user->getRoleLabel() }}</div>

        <form method="POST" action="{{ route('profil-admin.foto.update') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:8px;">
                <label for="photo-input" class="btn btn-outline w-full" style="cursor:pointer;justify-content:center;display:flex;align-items:center;gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                    Ubah Foto Profil
                </label>
                <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none;" onchange="this.form.submit()">
            </div>
            <p class="text-sm text-muted">Maksimal ukuran file: 2MB (JPG, PNG)</p>
        </form>
    </div>

    {{-- Right Content --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Informasi Data Diri --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" style="vertical-align:middle;margin-right:6px;color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Informasi Data Diri
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil-admin.profil.update') }}">
                    @csrf @method('PUT')
                    @if(session('success'))
                        <div class="alert alert-success" data-auto-dismiss>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ $user->nip }}">
                        </div>
                    </div>
                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-error">{{ $errors->first() }}</div>
                    @endif
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Keamanan Akun --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" style="vertical-align:middle;margin-right:6px;color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                    Keamanan Akun
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil-admin.password.update') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                        @error('current_password') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-outline">Perbarui Password</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Riwayat Login --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" style="vertical-align:middle;margin-right:6px;color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Riwayat Login Terakhir
                </h3>
            </div>
            <div class="table-wrapper" style="border:none;border-radius:0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Perangkat / Browser</th>
                            <th>IP Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loginHistories as $history)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--text-primary);">
                                    {{ $history->login_at ? \Carbon\Carbon::parse($history->login_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i:s') . ' WIB' : '-' }}
                                </div>
                                <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">
                                    {{ $history->login_at ? \Carbon\Carbon::parse($history->login_at)->timezone('Asia/Jakarta')->diffForHumans() : '' }}
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    @if(str_contains(strtolower($history->perangkat ?? ''), 'windows'))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="color:#0078d4; flex-shrink:0;">
                                            <path d="M6.555 1.375 0 2.237v5.45h6.555V1.375zM0 13.795l6.555.933V8.313H0v5.482zm7.278-12.33v6.222h8.722V0L7.278 1.465zm8.722 6.848H7.278v6.222L16 16V8.313z"/>
                                        </svg>
                                    @elseif(str_contains(strtolower($history->perangkat ?? ''), 'mac') || str_contains(strtolower($history->perangkat ?? ''), 'iphone') || str_contains(strtolower($history->perangkat ?? ''), 'ipad'))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="color:#64748b; flex-shrink:0;">
                                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83.6 5.536.607 1.136 1.42 2.302 2.378 2.316.958.014 1.342-.612 2.457-.612 1.115 0 1.46.612 2.43.598.97-.014 1.763-1.054 2.368-2.19.458-.859.638-1.334.646-1.378-.008-.044-.224-.084-.224-.084z"/>
                                        </svg>
                                    @elseif(str_contains(strtolower($history->perangkat ?? ''), 'android'))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="color:#10b981; flex-shrink:0;">
                                            <path d="M2.76 3.061a.5.5 0 0 1 .679.2l1.283 2.332a6.97 6.97 0 0 1 6.556 0l1.283-2.332a.5.5 0 1 1 .878.483l-1.255 2.28a7.03 7.03 0 0 1 2.824 4.976H1a7.03 7.03 0 0 1 2.824-4.976L2.57 3.744a.5.5 0 0 1 .19-.683zM4.5 8.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5zm7 0a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16" style="color:var(--text-muted); flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" /></svg>
                                    @endif
                                    <span>{{ $history->perangkat ?? $history->user_agent }}</span>
                                </div>
                            </td>
                            <td style="font-family:monospace;font-size:13px;color:var(--text-muted);">
                                {{ $history->ip_address === '127.0.0.1' || $history->ip_address === '::1' ? '127.0.0.1 (Localhost)' : $history->ip_address }}
                            </td>
                            <td>
                                <span class="badge {{ $history->status === 'berhasil' ? 'badge-green' : 'badge-red' }}">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px;">
                                Belum ada riwayat login
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
