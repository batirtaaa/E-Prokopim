@extends('layouts.app')
@section('title', 'Penugasan Personel — SIKOPIM')
@section('topbar-title', 'Penugasan')
@section('topbar-search', true)

@section('content')
<div class="page-header">
    <h1 class="page-title">Penugasan Personel</h1>
    <p class="page-subtitle">Kelola pembagian tugas tim Protokol, Komunikasi Pimpinan, dan Dokumentasi untuk setiap agenda pimpinan secara real-time.</p>
</div>

<div class="penugasan-layout">
    {{-- Main Area --}}
    <div>
        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:16px;">
            <div class="card">
                <div class="card-body" style="padding:18px 20px;">
                    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--text-secondary);margin-bottom:8px;">Total Penugasan</div>
                    <div style="display:flex;align-items:flex-end;gap:10px;">
                        <div>
                            <div style="font-size:28px;font-weight:700;color:var(--text-primary);line-height:1;">{{ $totalPenugasan }}</div>
                            <div style="font-size:12px;color:var(--text-muted);">Personel Hari Ini</div>
                        </div>
                        <div style="margin-left:auto;width:40px;height:40px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2563eb" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="padding:18px 20px;">
                    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--text-secondary);margin-bottom:8px;">Personel Siaga</div>
                    <div style="display:flex;align-items:flex-end;gap:10px;">
                        <div>
                            <div style="font-size:28px;font-weight:700;color:var(--text-primary);line-height:1;">{{ $personelSiaga }}</div>
                            <div style="font-size:12px;color:var(--text-muted);">Personel</div>
                        </div>
                        <div style="margin-left:auto;width:40px;height:40px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#dc2626" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="padding:18px 20px;">
                    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--text-secondary);margin-bottom:8px;">Belum Dikonfirmasi</div>
                    <div style="display:flex;align-items:flex-end;gap:10px;">
                        <div>
                            <div style="font-size:28px;font-weight:700;color:var(--text-primary);line-height:1;">{{ $belumDikonfirmasi }}</div>
                            <div style="font-size:12px;color:var(--text-muted);">Tugas</div>
                        </div>
                        <div style="margin-left:auto;width:40px;height:40px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#dc2626" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" /></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Table --}}
        <div class="card">
            <div class="card-body" style="padding-bottom:0;">
                <form method="GET" action="{{ route('penugasan.index') }}" class="filter-bar">
                    <div class="search-bar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                        <input type="text" name="search" placeholder="Cari agenda atau kegiatan..." value="{{ request('search') }}">
                    </div>
                    <select name="role" class="form-control" id="role-filter">
                        <option value="">Semua Role</option>
                        <option value="Protokol" {{ request('role') === 'Protokol' ? 'selected' : '' }}>Protokol</option>
                        <option value="MC" {{ request('role') === 'MC' ? 'selected' : '' }}>MC</option>
                        <option value="Fotografer" {{ request('role') === 'Fotografer' ? 'selected' : '' }}>Fotografer</option>
                        <option value="Videografer" {{ request('role') === 'Videografer' ? 'selected' : '' }}>Videografer</option>
                        <option value="Notulis" {{ request('role') === 'Notulis' ? 'selected' : '' }}>Notulis</option>
                    </select>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    <button type="button" class="btn btn-primary" data-modal-open="#modal-tugas-baru">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tugas Baru
                    </button>
                </form>
            </div>

            <div class="table-wrapper" style="border:none;border-radius:0;margin-top:0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kegiatan & Waktu</th>
                            <th>Lokasi & Pimpinan</th>
                            <th>Tim Bertugas</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasan as $tugas)
                        <tr>
                            <td>
                                <div class="font-semibold" style="font-size:13.5px;">{{ $tugas->kegiatan->judul }}</div>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $tugas->kegiatan->tanggal_mulai->format('d M Y, H:i') }} WIB
                                </div>
                            </td>
                            <td>
                                <div style="font-size:13px;">{{ $tugas->kegiatan->lokasi ?? '—' }}</div>
                                <span class="badge badge-blue" style="margin-top:4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="10" height="10"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                    {{ $tugas->kegiatan->pimpinan_label }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $initial = $tugas->personel ? $tugas->personel->initials : '??';
                                    $colors = ['blue', 'green', 'orange', 'purple', 'pink', 'teal'];
                                    $color = $colors[$tugas->personel_id % count($colors)];
                                @endphp
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <div class="avatar {{ $color }}" style="width:28px;height:28px;font-size:10px;">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <div style="font-size:12.5px;font-weight:500;">{{ $tugas->personel?->nama_lengkap ?? '—' }}</div>
                                        <div style="font-size:11px;color:var(--text-muted);">({{ $tugas->peran }})</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $tugas->status_color }}">
                                    <span class="badge-dot"></span>
                                    {{ $tugas->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown-wrapper">
                                    <button class="btn btn-icon btn-outline" data-dropdown="#dropdown-penugasan-{{ $tugas->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                    </button>
                                    <div class="dropdown-menu" id="dropdown-penugasan-{{ $tugas->id }}" style="right:0;min-width:160px;">
                                        <form method="POST" action="{{ route('penugasan.update', $tugas) }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="dikonfirmasi">
                                            <button type="submit" class="dropdown-item" style="width:100%;background:none;border:none;cursor:pointer;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                Konfirmasi
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('penugasan.destroy', $tugas) }}" data-confirm="Hapus penugasan ini?">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item danger" style="width:100%;background:none;border:none;cursor:pointer;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">
                                Belum ada data penugasan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <span>Menampilkan {{ $penugasan->firstItem() ?? 0 }}–{{ $penugasan->lastItem() ?? 0 }} dari {{ $penugasan->total() }} tugas</span>
                {{ $penugasan->links() }}
            </div>
        </div>
    </div>

    {{-- Status Sidebar --}}
    <div class="status-sidebar">
        <h3>Status Personel</h3>
        @foreach($personelStatus as $p)
        @php
            $colors = ['blue', 'green', 'orange', 'purple', 'pink', 'teal'];
            $color = $colors[$p->id % count($colors)];
        @endphp
        <div class="personel-status-item">
            <div class="avatar {{ $color }}" style="width:36px;height:36px;font-size:12px;overflow:hidden;">
                @if($p->photo)
                    <img src="{{ asset('storage/' . $p->photo) }}" alt="{{ $p->nama_lengkap }}">
                @else
                    {{ $p->initials }}
                @endif
            </div>
            <div class="personel-status-info">
                <div class="personel-status-name">{{ Str::words($p->nama_lengkap, 2, '') }}</div>
                <div class="personel-status-role">{{ $p->jabatan }}</div>
            </div>
            <span class="badge badge-{{ match($p->status_ketersediaan) {
                'bertugas' => 'green',
                'standby' => 'blue',
                'cuti' => 'gray',
                default => 'red'
            } }}" style="font-size:9px;padding:2px 7px;">
                {{ $p->status_label }}
            </span>
        </div>
        @endforeach

        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline w-full" style="margin-top:14px;justify-content:center;">
            Lihat Jadwal Lengkap
        </a>
    </div>
</div>

{{-- Modal Tugas Baru --}}
<div class="modal-overlay" id="modal-tugas-baru">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Tugas Baru</h2>
            <button class="modal-close" data-modal-close>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('penugasan.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Kegiatan *</label>
                    <select name="kegiatan_id" class="form-control" required>
                        <option value="">Pilih Kegiatan...</option>
                        @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}">{{ $k->judul }} ({{ $k->tanggal_mulai->format('d/m/Y') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Personel *</label>
                    <select name="personel_id" class="form-control" required>
                        <option value="">Pilih Personel...</option>
                        @foreach($personelList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Peran *</label>
                        <select name="peran" class="form-control" required>
                            <option value="Protokol">Protokol</option>
                            <option value="MC">MC</option>
                            <option value="Fotografer">Fotografer</option>
                            <option value="Videografer">Videografer</option>
                            <option value="Notulis">Notulis</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="ditugaskan">Ditugaskan</option>
                            <option value="dikonfirmasi">Dikonfirmasi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Penugasan</button>
            </div>
        </form>
    </div>
</div>

{{-- FAB Button --}}
<button class="fab" data-modal-open="#modal-tugas-baru" title="Tambah Penugasan">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
</button>

@endsection
