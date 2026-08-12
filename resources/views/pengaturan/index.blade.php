@extends('layouts.app')
@section('title', 'Pengaturan Sistem — SIKOPIM')
@section('topbar-title', 'Pengaturan Sistem')

@section('content')
<div class="page-header">
    <h1 class="page-title">Pengaturan Sistem</h1>
</div>

<div class="settings-layout">
    {{-- Tabs --}}
    <div class="settings-tabs">
        <div class="settings-tab-item {{ request('tab', 'profil-instansi') === 'profil-instansi' ? 'active' : '' }}" data-tab="profil-instansi">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>
            Profil Instansi
        </div>
        <div class="settings-tab-item {{ request('tab') === 'manajemen-pengguna' ? 'active' : '' }}" data-tab="manajemen-pengguna">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            Manajemen Pengguna
        </div>
        <div class="settings-tab-item {{ request('tab') === 'notifikasi' ? 'active' : '' }}" data-tab="notifikasi">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
            Notifikasi
        </div>
        <div class="settings-tab-item {{ request('tab') === 'keamanan' ? 'active' : '' }}" data-tab="keamanan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
            Keamanan
        </div>
        <div class="settings-tab-item {{ request('tab') === 'backup-data' ? 'active' : '' }}" data-tab="backup-data">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 2.25v2.25m0 2.25v2.25" /></svg>
            Backup Data
        </div>
    </div>

    {{-- Panels --}}
    <div>
        {{-- Profil Instansi --}}
        <div class="settings-panel" id="panel-profil-instansi">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil Instansi</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pengaturan.instansi.update') }}">
                        @csrf @method('PUT')
                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label class="form-label-normal">Nama Instansi</label>
                                <input type="text" name="nama_instansi" class="form-control" value="{{ $instansi?->nama_instansi ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label-normal">Pemerintah Daerah</label>
                                <input type="text" name="pemerintah_daerah" class="form-control" value="{{ $instansi?->pemerintah_daerah ?? '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label-normal">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="3">{{ $instansi?->alamat_lengkap ?? '' }}</textarea>
                        </div>
                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label class="form-label-normal">Email Kontak</label>
                                <input type="email" name="email_kontak" class="form-control" value="{{ $instansi?->email_kontak ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label-normal">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon" class="form-control" value="{{ $instansi?->nomor_telepon ?? '' }}">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="reset" class="btn btn-outline">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Manajemen Pengguna --}}
        <div class="settings-panel" id="panel-manajemen-pengguna">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pengguna</h3>
                    <button class="btn btn-primary btn-sm" data-modal-open="#modal-tambah-user">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Pengguna
                    </button>
                </div>
                <div class="table-wrapper" style="border:none;border-radius:0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="avatar blue" style="width:34px;height:34px;font-size:12px;">
                                            @if($user->photo)
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt="">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $user->name }}</div>
                                            <div class="text-sm text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $user->nip ?? '—' }}</td>
                                <td><span class="badge badge-blue">{{ $user->getRoleLabel() }}</span></td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-gray' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <form method="POST" action="{{ route('pengaturan.users.toggle-status', $user) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-xs btn-outline" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('pengaturan.users.destroy', $user) }}" data-confirm="Hapus pengguna {{ $user->name }}?">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper">
                    <span>{{ $users->total() }} pengguna terdaftar</span>
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- Notifikasi --}}
        <div class="settings-panel" id="panel-notifikasi">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pengaturan Notifikasi</h3></div>
                <div class="card-body">
                    <p class="text-muted" style="margin-bottom:16px;">Atur preferensi notifikasi sistem.</p>
                    <div style="display:flex;flex-direction:column;gap:14px;">
                        @foreach([
                            ['Notifikasi Kegiatan Baru', 'Terima notifikasi saat kegiatan baru ditambahkan'],
                            ['Notifikasi Penugasan', 'Terima notifikasi saat Anda mendapat penugasan baru'],
                            ['Notifikasi Arahan', 'Terima notifikasi saat ada arahan pimpinan baru'],
                            ['Notifikasi Deadline', 'Terima pengingat saat deadline arahan mendekat'],
                        ] as [$label, $desc])
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;background:var(--bg-main);border-radius:var(--radius-sm);">
                            <div>
                                <div class="font-semibold">{{ $label }}</div>
                                <div class="text-sm text-muted" style="margin-top:2px;">{{ $desc }}</div>
                            </div>
                            <label style="position:relative;display:inline-block;width:44px;height:24px;">
                                <input type="checkbox" checked style="opacity:0;width:0;height:0;">
                                <span style="position:absolute;cursor:pointer;inset:0;background:#10b981;border-radius:24px;transition:.3s;"></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-actions" style="margin-top:20px;">
                        <button class="btn btn-primary">Simpan Pengaturan</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keamanan --}}
        <div class="settings-panel" id="panel-keamanan">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pengaturan Keamanan</h3></div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div style="padding:16px;background:var(--bg-main);border-radius:var(--radius-sm);">
                            <div class="font-semibold" style="margin-bottom:4px;">Sesi Login</div>
                            <div class="text-sm text-muted">Sesi akan otomatis berakhir setelah <strong>120 menit</strong> tidak aktif.</div>
                        </div>
                        <div style="padding:16px;background:var(--bg-main);border-radius:var(--radius-sm);">
                            <div class="font-semibold" style="margin-bottom:4px;">Riwayat Login</div>
                            <div class="text-sm text-muted">Riwayat login tersimpan untuk <strong>30 hari</strong> terakhir.</div>
                        </div>
                        <div style="padding:16px;background:var(--danger-bg);border-radius:var(--radius-sm);">
                            <div class="font-semibold" style="color:var(--danger);margin-bottom:4px;">Hapus Semua Sesi</div>
                            <div class="text-sm text-muted" style="margin-bottom:10px;">Ini akan mengeluarkan semua pengguna yang sedang login.</div>
                            <button class="btn btn-danger btn-sm">Hapus Semua Sesi Aktif</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Backup Data --}}
        <div class="settings-panel" id="panel-backup-data">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Backup Data</h3></div>
                <div class="card-body">
                    <p class="text-muted" style="margin-bottom:20px;">Backup data sistem secara berkala untuk menghindari kehilangan data.</p>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border:1px solid var(--border);border-radius:var(--radius-sm);">
                            <div>
                                <div class="font-semibold">Backup Database</div>
                                <div class="text-sm text-muted">Ekspor seluruh data database ke file SQL</div>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                Download Backup
                            </button>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border:1px solid var(--border);border-radius:var(--radius-sm);">
                            <div>
                                <div class="font-semibold">Backup File Arsip</div>
                                <div class="text-sm text-muted">Ekspor semua file arsip digital ke archive ZIP</div>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                Download Archive
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Pengguna --}}
<div class="modal-overlay" id="modal-tambah-user">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Pengguna Baru</h2>
            <button class="modal-close" data-modal-close>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('pengaturan.users.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control">
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Username *</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-control" required>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control">
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            </div>
        </form>
    </div>
</div>

@endsection
