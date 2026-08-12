@extends('layouts.app')
@section('title', 'Kegiatan Pimpinan — E-PROKOPIM')

@push('styles')
<style>
/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.breadcrumb a { color: var(--text-secondary); }
.breadcrumb a:hover { color: var(--accent); }
.breadcrumb-sep { color: var(--text-muted); font-size: 11px; }
.breadcrumb-current { color: var(--text-primary); font-weight: 500; }

/* Page Header */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
}
.page-header-left h1 { font-size: 22px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
.page-header-left p { font-size: 13px; color: var(--text-secondary); }

/* Toolbar */
.kg-toolbar {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.kg-search-wrap {
    position: relative;
    flex: 1;
    max-width: 320px;
}
.kg-search-wrap svg {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 15px; height: 15px;
    color: var(--text-muted);
}
.kg-search-input {
    width: 100%;
    padding: 7px 12px 7px 34px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
    color: var(--text-primary);
    background: var(--bg-main);
    outline: none;
}
.kg-search-input:focus { border-color: var(--accent); background: white; }
.kg-search-input::placeholder { color: var(--text-muted); }
.kg-icon-btn {
    width: 34px; height: 34px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.15s;
}
.kg-icon-btn:hover { border-color: var(--accent); color: var(--accent); }
.kg-icon-btn svg { width: 15px; height: 15px; }

/* Table */
.kg-table-wrap {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}
.kg-table {
    width: 100%;
    border-collapse: collapse;
}
.kg-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid var(--border);
    background: #fafafa;
}
.kg-table tbody td {
    padding: 14px 16px;
    font-size: 13px;
    color: var(--text-primary);
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.kg-table tbody tr:last-child td { border-bottom: none; }
.kg-table tbody tr:hover { background: #fafbff; }

/* ID Badge */
.kg-id {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--accent);
    font-family: monospace;
}

/* Judul */
.kg-judul { font-weight: 500; font-size: 13px; }

/* Tanggal & Waktu */
.kg-tanggal-date { font-weight: 500; font-size: 13px; }
.kg-tanggal-time { font-size: 12px; color: var(--text-secondary); margin-top: 1px; }

/* Pimpinan Avatars */
.kg-avatars { display: flex; align-items: center; gap: -4px; }
.kg-avatar {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: #1565c0;
    color: white;
    font-size: 11px;
    font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid white;
    margin-right: -6px;
    cursor: default;
}
.kg-avatar:nth-child(2) { background: #0d47a1; }
.kg-avatar:nth-child(3) { background: #1b5e20; }
.kg-avatar-more {
    background: #e5e7eb;
    color: var(--text-secondary);
    font-size: 10px;
}

/* Lokasi */
.kg-lokasi {
    display: flex; align-items: flex-start; gap: 5px;
    font-size: 13px;
}
.kg-lokasi svg { width: 13px; height: 13px; color: var(--text-muted); flex-shrink: 0; margin-top: 2px; }

/* Aksi */
.kg-aksi { display: flex; align-items: center; gap: 6px; }
.kg-aksi-btn {
    width: 30px; height: 30px;
    border: none; background: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-secondary);
    transition: all 0.15s;
}
.kg-aksi-btn:hover { background: #f3f4f6; color: var(--text-primary); }
.kg-aksi-btn.danger:hover { background: #fee2e2; color: var(--danger); }
.kg-aksi-btn svg { width: 15px; height: 15px; }

/* Pagination */
.kg-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-top: 1px solid var(--border);
    font-size: 13px;
    color: var(--text-secondary);
}
.kg-page-btns { display: flex; align-items: center; gap: 4px; }
.kg-page-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background: white;
    font-size: 13px;
    color: var(--text-secondary);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.kg-page-btn:hover { border-color: var(--accent); color: var(--accent); }
.kg-page-btn.active { background: var(--primary); border-color: var(--primary); color: white; font-weight: 600; }
.kg-page-btn.arrow { color: var(--text-muted); }
.kg-page-btn.arrow:hover { color: var(--accent); }
</style>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">›</span>
    <a href="{{ route('kegiatan-pimpinan.index') }}">Kegiatan Pimpinan</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current">Semua Kegiatan</span>
</div>

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Semua Kegiatan</h1>
        <p>Kelola dan pantau seluruh jadwal kegiatan pimpinan daerah.</p>
    </div>
    <a href="{{ route('kegiatan-pimpinan.create') }}" class="btn btn-primary" style="display:flex;align-items:center;gap:6px;text-decoration:none;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Tambah Kegiatan
    </a>
</div>

{{-- Toolbar --}}
<div class="kg-toolbar">
    <div class="kg-search-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        <input type="text" class="kg-search-input" placeholder="Cari ID atau Judul..." id="searchInput">
    </div>
    <button class="kg-icon-btn" title="Filter">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" /></svg>
    </button>
    <button class="kg-icon-btn" title="Unduh">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
    </button>
</div>

{{-- Table --}}
<div class="kg-table-wrap">
    <table class="kg-table">
        <thead>
            <tr>
                <th>ID Kegiatan</th>
                <th>Judul Kegiatan</th>
                <th>Tanggal &amp; Waktu</th>
                <th>Pimpinan</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $dummyData = [
                ['id' => '#KG-231001', 'judul' => 'Rapat Paripurna DPRD Kota Bandung', 'tanggal' => '15 Okt 2023', 'waktu' => '09:00 - 12:00 WIB', 'pimpinan' => ['WK', 'VW'], 'lokasi' => 'Gedung DPRD Kota Bandung,'],
                ['id' => '#KG-231002', 'judul' => 'Peresmian Taman Kota Sekeloa dan...', 'tanggal' => '15 Okt 2023', 'waktu' => '14:00 - 16:30 WIB', 'pimpinan' => ['WK'], 'lokasi' => 'Taman Sekeloa,...'],
                ['id' => '#KG-230998', 'judul' => 'Audiensi dengan Forum Komunikasi', 'tanggal' => '14 Okt 2023', 'waktu' => '10:00 - 11:30 WIB', 'pimpinan' => ['WK', 'VW', '5D'], 'lokasi' => 'Ruang Rapat Tengah, Balai'],
                ['id' => '#KG-230995', 'judul' => 'Tinjauan Lapangan Proyek...', 'tanggal' => '13 Okt 2023', 'waktu' => '08:00 - 10:00 WIB', 'pimpinan' => ['WW'], 'lokasi' => 'Kolam Retensi Gedebage,...'],
            ];
            @endphp

            @foreach($dummyData as $item)
            <tr>
                <td><span class="kg-id">{{ $item['id'] }}</span></td>
                <td><span class="kg-judul">{{ $item['judul'] }}</span></td>
                <td>
                    <div class="kg-tanggal-date">{{ $item['tanggal'] }}</div>
                    <div class="kg-tanggal-time">{{ $item['waktu'] }}</div>
                </td>
                <td>
                    <div class="kg-avatars">
                        @foreach($item['pimpinan'] as $idx => $initial)
                            @if($idx < 3)
                            <div class="kg-avatar" title="{{ $initial }}" style="z-index: {{ 10 - $idx }}">{{ $initial }}</div>
                            @endif
                        @endforeach
                        @if(count($item['pimpinan']) > 3)
                            <div class="kg-avatar kg-avatar-more">+{{ count($item['pimpinan']) - 3 }}</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="kg-lokasi">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        {{ $item['lokasi'] }}
                    </div>
                </td>
                <td>
                    <div class="kg-aksi">
                        <button class="kg-aksi-btn" title="Lihat Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </button>
                        <button class="kg-aksi-btn" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                        </button>
                        <button class="kg-aksi-btn danger" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="kg-pagination">
        <span>Menampilkan 1 sampai 4 dari 97 hasil</span>
        <div class="kg-page-btns">
            <button class="kg-page-btn arrow" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <button class="kg-page-btn active">1</button>
            <button class="kg-page-btn">2</button>
            <button class="kg-page-btn">3</button>
            <button class="kg-page-btn" style="pointer-events:none;color:var(--text-muted)">...</button>
            <button class="kg-page-btn">10</button>
            <button class="kg-page-btn arrow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>
        </div>
    </div>
</div>
@endsection
