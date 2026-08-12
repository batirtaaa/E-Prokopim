@extends('layouts.app')
@section('title', 'Arahan Pimpinan — SIKOPIM')
@section('topbar-title', 'Arahan Pimpinan')
@section('content')
<div class="page-header flex justify-between items-center">
    <div><h1 class="page-title">Arahan Pimpinan</h1><p class="page-subtitle">Kelola dan pantau arahan serta instruksi pimpinan Kota Bandung</p></div>
    <button class="btn btn-primary" data-modal-open="#modal-arahan-baru">+ Tambah Arahan</button>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar">
            <div class="search-bar"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg><input type="text" name="search" placeholder="Cari arahan..." value="{{ request('search') }}"></div>
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                @foreach(['belum_selesai'=>'Belum Selesai','sedang_berjalan'=>'Sedang Berjalan','selesai'=>'Selesai','melewati_deadline'=>'Melewati Deadline'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="prioritas" class="form-control">
                <option value="">Semua Prioritas</option>
                @foreach(['rendah'=>'Rendah','sedang'=>'Sedang','tinggi'=>'Tinggi','urgent'=>'Urgent'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('prioritas')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </form>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead><tr><th>No. Arahan</th><th>Judul</th><th>Pimpinan</th><th>Deadline</th><th>Prioritas</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($arahan as $a)
                <tr>
                    <td class="text-muted" style="font-family:monospace;">{{ $a->nomor_arahan ?? '—' }}</td>
                    <td>
                        <div class="font-semibold">{{ $a->judul }}</div>
                        @if($a->ditujukan_kepada)<div class="text-sm text-muted">Kepada: {{ $a->ditujukan_kepada }}</div>@endif
                    </td>
                    <td><span class="badge badge-blue">{{ $a->pimpinan_label }}</span></td>
                    <td>
                        @if($a->deadline)
                            <div class="{{ $a->status === 'melewati_deadline' ? 'text-muted' : '' }}" style="{{ $a->status === 'melewati_deadline' ? 'color:var(--danger)' : '' }}">
                                {{ $a->deadline->format('d M Y') }}
                            </div>
                        @else<span class="text-muted">—</span>@endif
                    </td>
                    <td><span class="badge badge-{{ $a->prioritas_color }}">{{ ucfirst($a->prioritas) }}</span></td>
                    <td>
                        @php $statusMap = ['belum_selesai'=>'Belum Selesai','sedang_berjalan'=>'Berjalan','selesai'=>'Selesai','melewati_deadline'=>'Deadline']; @endphp
                        <span class="badge badge-{{ $a->status_color }}">{{ $statusMap[$a->status] ?? $a->status }}</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('arahan.edit', $a) }}" class="btn btn-xs btn-outline">Edit</a>
                            <form method="POST" action="{{ route('arahan.destroy', $a) }}" data-confirm="Hapus arahan ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">Belum ada arahan pimpinan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper"><span>{{ $arahan->firstItem() ?? 0 }}–{{ $arahan->lastItem() ?? 0 }} dari {{ $arahan->total() }} arahan</span>{{ $arahan->links() }}</div>
</div>

<div class="modal-overlay" id="modal-arahan-baru">
    <div class="modal" style="max-width:680px;">
        <div class="modal-header"><h2 class="modal-title">Tambah Arahan Pimpinan</h2><button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        <form method="POST" action="{{ route('arahan.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">No. Arahan</label><input type="text" name="nomor_arahan" class="form-control" placeholder="AR/001/2026"></div>
                    <div class="form-group"><label class="form-label">Pimpinan *</label><select name="pimpinan" class="form-control" required><option value="wali_kota">Wali Kota</option><option value="wakil_wali_kota">Wakil Wali Kota</option><option value="sekda">Sekda</option><option value="asisten">Asisten</option></select></div>
                </div>
                <div class="form-group"><label class="form-label">Judul Arahan *</label><input type="text" name="judul" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Isi Arahan *</label><textarea name="isi_arahan" class="form-control" rows="4" required></textarea></div>
                <div class="form-group"><label class="form-label">Ditujukan Kepada</label><input type="text" name="ditujukan_kepada" class="form-control"></div>
                <div class="form-row cols-3">
                    <div class="form-group"><label class="form-label">Tanggal Arahan *</label><input type="date" name="tanggal_arahan" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                    <div class="form-group"><label class="form-label">Deadline</label><input type="date" name="deadline" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Prioritas</label><select name="prioritas" class="form-control"><option value="rendah">Rendah</option><option value="sedang" selected>Sedang</option><option value="tinggi">Tinggi</option><option value="urgent">Urgent</option></select></div>
                </div>
                <div class="form-group"><label class="form-label">Status</label><select name="status" class="form-control"><option value="belum_selesai">Belum Selesai</option><option value="sedang_berjalan">Sedang Berjalan</option><option value="selesai">Selesai</option></select></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan Arahan</button></div>
        </form>
    </div>
</div>
@endsection
