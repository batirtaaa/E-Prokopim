@extends('layouts.app')
@section('title', 'Kegiatan — SIKOPIM')
@section('topbar-title', 'Kegiatan')

@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-title">Kegiatan & Agenda</h1>
        <p class="page-subtitle">Kelola seluruh agenda dan kegiatan pimpinan Kota Bandung</p>
    </div>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Tambah Kegiatan
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="search" placeholder="Cari kegiatan..." value="{{ request('search') }}">
            </div>
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                @foreach(['draft'=>'Draft','terjadwal'=>'Terjadwal','berlangsung'=>'Berlangsung','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $v => $l)
                    <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="pimpinan" class="form-control">
                <option value="">Semua Pimpinan</option>
                @foreach(['wali_kota'=>'Wali Kota','wakil_wali_kota'=>'Wakil Wali Kota','sekda'=>'Sekda','asisten'=>'Asisten'] as $v => $l)
                    <option value="{{ $v }}" {{ request('pimpinan') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Lokasi</th>
                    <th>Pimpinan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatan as $k)
                <tr>
                    <td>
                        <div class="font-semibold">{{ $k->judul }}</div>
                        <div class="text-sm text-muted">{{ ucfirst($k->kategori) }}</div>
                    </td>
                    <td>
                        <div>{{ $k->tanggal_mulai->format('d M Y') }}</div>
                        <div class="text-sm text-muted">{{ $k->tanggal_mulai->format('H:i') }} WIB</div>
                    </td>
                    <td class="text-muted">{{ $k->lokasi ?? '—' }}</td>
                    <td><span class="badge badge-blue">{{ $k->pimpinan_label }}</span></td>
                    <td>
                        <span class="badge badge-{{ $k->status_color }}">
                            <span class="badge-dot"></span> {{ $k->status_label }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('kegiatan.show', $k) }}" class="btn btn-xs btn-outline">Detail</a>
                            <a href="{{ route('kegiatan.edit', $k) }}" class="btn btn-xs btn-outline">Edit</a>
                            <form method="POST" action="{{ route('kegiatan.destroy', $k) }}" data-confirm="Hapus kegiatan ini?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">
                        Belum ada data kegiatan. <a href="{{ route('kegiatan.create') }}" style="color:var(--accent);">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <span>{{ $kegiatan->firstItem() ?? 0 }}–{{ $kegiatan->lastItem() ?? 0 }} dari {{ $kegiatan->total() }} kegiatan</span>
        {{ $kegiatan->links() }}
    </div>
</div>
@endsection
