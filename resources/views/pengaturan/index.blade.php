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
        <div class="settings-tab-item {{ request('tab') === 'gemini-ai' ? 'active' : '' }}" data-tab="gemini-ai">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
            Integrasi Gemini AI
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
                            @if(auth()->user()->isAdmin())
                            <button type="reset" class="btn btn-outline">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            @else
                            <span class="text-sm text-muted">Hanya Administrator yang dapat mengubah profil instansi.</span>
                            @endif
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
                    @if(auth()->user()->isAdmin())
                    <button class="btn btn-primary btn-sm" data-modal-open="#modal-tambah-user">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Pengguna
                    </button>
                    @endif
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
                                    @if(auth()->user()->isAdmin())
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
                                    @else
                                    <span class="text-muted text-xs">—</span>
                                    @endif
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
                    <p class="text-muted" style="margin-bottom:16px;">Atur preferensi notifikasi sistem. Notifikasi bekerja secara real-time dan muncul di ikon lonceng.</p>

                    @php
                        $prefs = auth()->user()->notification_preferences ?? [];
                        $pKegiatan  = $prefs['kegiatan']  ?? true;
                        $pPenugasan = $prefs['penugasan'] ?? true;
                        $pArahan    = $prefs['arahan']    ?? true;
                        $pDeadline  = $prefs['deadline']  ?? true;
                    @endphp

                    <form id="notif-pref-form">
                        @csrf
                        <div style="display:flex;flex-direction:column;gap:14px;">
                            @foreach([
                                ['notif_kegiatan',  'Notifikasi Kegiatan Baru',  'Terima notifikasi saat kegiatan baru ditambahkan', $pKegiatan,  '📅'],
                                ['notif_penugasan', 'Notifikasi Penugasan',      'Terima notifikasi saat ada penugasan personel baru', $pPenugasan, '📋'],
                                ['notif_arahan',    'Notifikasi Arahan',         'Terima notifikasi saat ada arahan pimpinan baru',    $pArahan,    '📌'],
                                ['notif_deadline',  'Notifikasi Deadline',       'Terima pengingat H-3 dan H-1 sebelum deadline arahan', $pDeadline, '⚠️'],
                            ] as [$name, $label, $desc, $checked, $icon])
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;background:var(--bg-main);border-radius:var(--radius-sm);">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:var(--bg-card);display:flex;align-items:center;justify-content:center;font-size:16px;border:1px solid var(--border);">{{ $icon }}</div>
                                    <div>
                                        <div class="font-semibold">{{ $label }}</div>
                                        <div class="text-sm text-muted" style="margin-top:2px;">{{ $desc }}</div>
                                    </div>
                                </div>
                                <label class="notif-toggle-label" style="position:relative;display:inline-block;width:44px;height:24px;flex-shrink:0;">
                                    <input type="checkbox" name="{{ $name }}" value="1"
                                           {{ $checked ? 'checked' : '' }}
                                           class="notif-toggle-input"
                                           style="opacity:0;width:0;height:0;position:absolute;">
                                    <span class="notif-toggle-track" style="position:absolute;cursor:pointer;inset:0;border-radius:24px;transition:.3s;background:{{ $checked ? '#10b981' : '#d1d5db' }};"></span>
                                    <span class="notif-toggle-thumb" style="position:absolute;content:'';height:18px;width:18px;left:{{ $checked ? '23px' : '3px' }};bottom:3px;background:white;border-radius:50%;transition:.3s;"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-actions" style="margin-top:20px;">
                            <button type="button" class="btn btn-primary" id="save-notif-prefs-btn" onclick="saveNotifPreferences()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Integrasi Gemini AI --}}
        <div class="settings-panel {{ request('tab') === 'gemini-ai' ? 'active' : '' }}" id="panel-gemini-ai">
            <div class="card">
                <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="card-title">Konfigurasi Google Gemini AI</h3>
                    @if($geminiApiKey)
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#f0fdf4; color:#166534; padding:4px 12px; border-radius:9999px; font-size:12px; font-weight:600; border:1px solid #bbf7d0;">
                            <span style="width:7px; height:7px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                            Tersambung &amp; Permanen (.env)
                        </span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#fffbeb; color:#92400e; padding:4px 12px; border-radius:9999px; font-size:12px; font-weight:600; border:1px solid #fde68a;">
                            Engine Database Aktif (Kunci Kosong)
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:14px 16px; margin-bottom:20px; font-size:13px; color:#334155; line-height:1.6;">
                        <strong style="color:#0f2942;">🔒 Informasi Penyimpanan Permanen:</strong><br>
                        Kunci API yang Anda simpan di sini akan langsung disimpan secara permanen ke file konfigurasi <code>.env</code> aplikasi. Kunci <strong>tidak akan pernah ter-reset</strong> saat laptop dimatikan, ditutup, atau di-restart. Asisten AI akan selalu siap sedia menjawab pertanyaan umum maupun data Prokopim.
                    </div>

                    <form method="POST" action="{{ route('asisten-ai.api-key') }}">
                        @csrf
                        <div class="form-group" style="margin-bottom:16px;">
                            <label class="form-label-normal" style="font-weight:600;">Google Gemini API Key</label>
                            <div style="position:relative;">
                                <input type="password" name="gemini_api_key" id="settingsGeminiKey" class="form-control" placeholder="Masukkan Google Gemini API Key (contoh: AIzaSy...)" value="{{ $geminiApiKey }}">
                                <button type="button" onclick="const el=document.getElementById('settingsGeminiKey'); el.type=el.type==='password'?'text':'password';" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer; font-size:13px;">
                                    👁️
                                </button>
                            </div>
                            <small class="text-muted" style="display:block; margin-top:6px;">
                                Dapatkan API Key gratis di <a href="https://aistudio.google.com/app/apikey" target="_blank" style="color:var(--primary); font-weight:600; text-decoration:none;">Google AI Studio ↗</a>.
                            </small>
                        </div>

                        <div class="form-group" style="margin-bottom:20px;">
                            <label class="form-label-normal" style="font-weight:600;">Model Gemini Utama</label>
                            <select name="gemini_model" class="form-control">
                                <option value="gemini-1.5-flash" {{ ($geminiModel ?? '') == 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash (Sangat Cepat &amp; Direkomendasikan)</option>
                                <option value="gemini-2.0-flash" {{ ($geminiModel ?? '') == 'gemini-2.0-flash' ? 'selected' : '' }}>Gemini 2.0 Flash (Generasi Terbaru)</option>
                                <option value="gemini-1.5-pro" {{ ($geminiModel ?? '') == 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro (Penalaran Kompleks)</option>
                                <option value="gemini-3.1-flash-lite-preview" {{ ($geminiModel ?? '') == 'gemini-3.1-flash-lite-preview' ? 'selected' : '' }}>Gemini 3.1 Flash Lite (Preview)</option>
                            </select>
                        </div>

                        <div class="form-actions" style="display:flex; justify-content:flex-end; gap:8px;">
                            @if(auth()->user()->isAdmin())
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Simpan Kunci Permanen
                            </button>
                            @else
                            <span class="text-sm text-muted">Hanya Administrator yang dapat mengubah konfigurasi AI.</span>
                            @endif
                        </div>
                    </form>
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
                        @if(auth()->user()->isAdmin())
                        <div style="padding:16px;background:var(--danger-bg);border-radius:var(--radius-sm);">
                            <div class="font-semibold" style="color:var(--danger);margin-bottom:4px;">Hapus Semua Sesi</div>
                            <div class="text-sm text-muted" style="margin-bottom:10px;">Ini akan mengeluarkan semua pengguna yang sedang login.</div>
                            <button class="btn btn-danger btn-sm">Hapus Semua Sesi Aktif</button>
                        </div>
                        @endif
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

@push('scripts')
<script>
// ── Notification Preference Toggles ──────────────────────────────
document.querySelectorAll('.notif-toggle-input').forEach(function(input) {
    const label = input.closest('.notif-toggle-label');
    const track = label.querySelector('.notif-toggle-track');
    const thumb = label.querySelector('.notif-toggle-thumb');

    function updateToggle(checked) {
        track.style.background = checked ? '#10b981' : '#d1d5db';
        thumb.style.left = checked ? '23px' : '3px';
    }

    input.addEventListener('change', function() {
        updateToggle(this.checked);
    });

    label.addEventListener('click', function(e) {
        e.preventDefault();
        input.checked = !input.checked;
        updateToggle(input.checked);
    });
});

// ── Save Preferences via AJAX ─────────────────────────────────────
function saveNotifPreferences() {
    const btn = document.getElementById('save-notif-prefs-btn');
    const form = document.getElementById('notif-pref-form');
    const csrf = form.querySelector('[name="_token"]').value;

    const inputs = form.querySelectorAll('.notif-toggle-input');
    const body = new URLSearchParams();
    body.append('_token', csrf);
    inputs.forEach(function(inp) {
        body.append(inp.name, inp.checked ? '1' : '0');
    });

    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    fetch('{{ route("notifikasi.preferences") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body.toString()
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showInlineToast('✅ ' + (data.message || 'Pengaturan notifikasi berhasil disimpan.'), 'success');
        } else {
            showInlineToast('❌ Gagal menyimpan pengaturan.', 'error');
        }
    })
    .catch(() => showInlineToast('❌ Terjadi kesalahan jaringan.', 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg> Simpan Pengaturan`;
    });
}

function showInlineToast(msg, type) {
    let toast = document.getElementById('notif-pref-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'notif-pref-toast';
        toast.style.cssText = 'position:fixed;bottom:24px;right:24px;padding:12px 20px;border-radius:10px;font-size:13.5px;font-weight:500;z-index:9999;transition:opacity 0.3s;box-shadow:0 4px 20px rgba(0,0,0,0.15);';
        document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.background = type === 'success' ? '#10b981' : '#ef4444';
    toast.style.color = '#fff';
    toast.style.opacity = '1';
    setTimeout(() => { toast.style.opacity = '0'; }, 3000);
}
</script>
@endpush
