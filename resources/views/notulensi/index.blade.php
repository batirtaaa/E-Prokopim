@extends('layouts.app')
@section('title', 'Notulensi')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-title">Notulensi Rapat</h1>
        <p class="page-subtitle">Kelola notulensi dan catatan hasil rapat pimpinan</p>
    </div>
    @if(auth()->user()->isAdmin())
    <button class="btn btn-primary" data-modal-open="#modal-notulensi-baru">+ Tambah Notulensi</button>
    @endif
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" class="filter-bar" style="gap:10px;flex-wrap:wrap;">
            <div class="search-bar" style="flex:1;min-width:220px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="search" id="search-notulensi" placeholder="Cari judul, keyword, atau isi notulensi..." value="{{ request('search') }}">
            </div>
            <select name="status" class="form-control" style="width:auto;">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final</option>
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
            @if(request('search') || request('status'))
            <a href="{{ route('notulensi.index') }}" class="btn btn-outline" style="color:var(--text-muted);">Reset</a>
            @endif
        </form>

        @if(request('search'))
        <div style="padding:8px 0 4px; font-size:0.85rem; color:var(--text-muted);">
            Menampilkan hasil untuk: <strong style="color:var(--accent);">"{{ request('search') }}"</strong>
            — ditemukan {{ $notulensi->total() }} notulensi
        </div>
        @endif
    </div>

    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul & Keywords</th>
                    <th>Tanggal Rapat</th>
                    <th>Tempat</th>
                    <th>Notulis</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notulensi as $n)
                <tr>
                    <td>
                        <div class="font-semibold">{{ $n->judul }}</div>
                        <div class="text-sm text-muted">{{ $n->kegiatan?->judul ?? 'Tanpa kegiatan' }}</div>
                        @if($n->keywords)
                        <div style="margin-top:5px;display:flex;flex-wrap:wrap;gap:4px;">
                            @foreach(explode(',', $n->keywords) as $kw)
                            @if(trim($kw))
                            <span style="display:inline-block;padding:2px 8px;background:var(--accent-light,rgba(99,102,241,0.1));color:var(--accent);border-radius:20px;font-size:0.72rem;font-weight:500;">#{{ trim($kw) }}</span>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </td>
                    <td>{{ $n->tanggal_rapat->translatedFormat('d M Y') }}</td>
                    <td class="text-muted">{{ $n->tempat }}</td>
                    <td>{{ $n->notulis?->name ?? '—' }}</td>
                    <td>
                        <div style="display:flex;flex-direction:column;gap:4px;">
                            @if($n->file_notulensi)
                            <a href="{{ route('notulensi.download', [$n, 'notulensi']) }}" class="btn btn-xs btn-outline" style="font-size:0.72rem;" title="Unduh File Notulensi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:3px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>Notulensi
                            </a>
                            @endif
                            @if($n->file_paparan)
                            <a href="{{ route('notulensi.download', [$n, 'paparan']) }}" class="btn btn-xs btn-outline" style="font-size:0.72rem;color:var(--warning,#d97706);" title="Unduh File Paparan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:3px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>Paparan
                            </a>
                            @endif
                            @if(!$n->file_notulensi && !$n->file_paparan)
                            <span class="text-muted" style="font-size:0.75rem;">—</span>
                            @endif
                        </div>
                    </td>
                    <td><span class="badge {{ $n->status === 'final' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($n->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('notulensi.show', $n) }}" class="btn btn-xs btn-outline">Lihat</a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('notulensi.edit', $n) }}" class="btn btn-xs btn-outline">Edit</a>
                            <form method="POST" action="{{ route('notulensi.destroy', $n) }}" data-confirm="Hapus notulensi ini?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">
                    @if(request('search'))
                    Tidak ada notulensi yang sesuai dengan pencarian "<strong>{{ request('search') }}</strong>"
                    @else
                    Belum ada notulensi
                    @endif
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <span>{{ $notulensi->firstItem() ?? 0 }}–{{ $notulensi->lastItem() ?? 0 }} dari {{ $notulensi->total() }} notulensi</span>
        {{ $notulensi->links() }}
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-notulensi-baru">
    <div class="modal" style="max-width:760px;">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Notulensi</h2>
            <button class="modal-close" data-modal-close><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <form method="POST" action="{{ route('notulensi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="judul" id="judul-notulensi" class="form-control" required></div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Kegiatan Terkait</label>
                        <select name="kegiatan_id" class="form-control">
                            <option value="">Tidak ada</option>
                            @foreach($kegiatan as $k) <option value="{{ $k->id }}">{{ $k->judul }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notulis</label>
                        <select name="notulis_id" class="form-control">
                            <option value="">Pilih Notulis</option>
                            @foreach($users as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Tanggal Rapat *</label><input type="datetime-local" name="tanggal_rapat" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Tempat *</label><input type="text" name="tempat" class="form-control" required></div>
                </div>
                <div class="form-group"><label class="form-label">Isi Notulensi *</label><textarea name="isi_notulensi" class="form-control" rows="5" required></textarea></div>
                <div class="form-row cols-2">
                    <div class="form-group"><label class="form-label">Kesimpulan</label><textarea name="kesimpulan" class="form-control" rows="2"></textarea></div>
                    <div class="form-group"><label class="form-label">Tindak Lanjut</label><textarea name="tindak_lanjut" class="form-control" rows="2"></textarea></div>
                </div>

                {{-- Keywords --}}
                <div class="form-group">
                    <label class="form-label">Keywords <span style="color:var(--text-muted);font-weight:400;">(pisahkan dengan koma)</span></label>
                    <input type="text" name="keywords" id="keywords-notulensi" class="form-control" placeholder="contoh: APBD, anggaran, rencana kerja, 2025">
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:4px;">Kata kunci untuk mempermudah pencarian notulensi ini.</div>
                </div>

                {{-- Upload File Notulensi --}}
                <div class="form-group">
                    <label class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:4px;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        File Notulensi
                        <span style="color:var(--text-muted);font-weight:400;">(PDF, DOC, PPT — maks. 20MB)</span>
                    </label>
                    <input type="file" name="file_notulensi" id="file-notulensi" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                </div>

                {{-- Upload File Paparan --}}
                <div class="form-group">
                    <label class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:4px;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" /></svg>
                        File Paparan Dinas
                        <span style="color:var(--text-muted);font-weight:400;">(PDF, PPT — maks. 20MB)</span>
                    </label>
                    <input type="file" name="file_paparan" id="file-paparan" class="form-control" accept=".pdf,.ppt,.pptx">
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control"><option value="draft">Draft</option><option value="final">Final</option></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Notulensi</button>
            </div>
        </form>
    </div>
</div>
@endsection
