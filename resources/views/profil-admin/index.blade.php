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
                            <td>{{ $history->login_at->format('d M Y, H:i') }} WIB</td>
                            <td>{{ $history->perangkat ?? $history->user_agent }}</td>
                            <td style="font-family:monospace;font-size:13px;color:var(--text-muted);">{{ $history->ip_address }}</td>
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
