@extends('layouts.app')
@section('title', 'Edit Notulensi')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Notulensi</h1>
    <p class="page-subtitle">Perbarui data notulensi rapat</p>
</div>
<div class="card" style="max-width:900px;">
    <div class="card-body">
        <form method="POST" action="{{ route('notulensi.update', $notulensi) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Judul *</label>
                <input type="text" name="judul" class="form-control" value="{{ $notulensi->judul }}" required>
            </div>

            <div class="form-row cols-2">
                <div class="form-group">
                    <label class="form-label">Kegiatan Terkait</label>
                    <select name="kegiatan_id" class="form-control">
                        <option value="">Tidak ada</option>
                        @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}" {{ $notulensi->kegiatan_id == $k->id ? 'selected' : '' }}>{{ $k->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notulis</label>
                    <select name="notulis_id" class="form-control">
                        <option value="">Pilih Notulis</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ $notulensi->notulis_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row cols-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Rapat *</label>
                    <input type="datetime-local" name="tanggal_rapat" class="form-control" value="{{ $notulensi->tanggal_rapat->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tempat *</label>
                    <input type="text" name="tempat" class="form-control" value="{{ $notulensi->tempat }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Isi Notulensi *</label>
                <textarea name="isi_notulensi" class="form-control" rows="7" required>{{ $notulensi->isi_notulensi }}</textarea>
            </div>

            <div class="form-row cols-2">
                <div class="form-group">
                    <label class="form-label">Kesimpulan</label>
                    <textarea name="kesimpulan" class="form-control" rows="3">{{ $notulensi->kesimpulan }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control" rows="3">{{ $notulensi->tindak_lanjut }}</textarea>
                </div>
            </div>

            {{-- Keywords --}}
            <div class="form-group">
                <label class="form-label">Keywords <span style="color:var(--text-muted);font-weight:400;">(pisahkan dengan koma)</span></label>
                <input type="text" name="keywords" class="form-control" value="{{ $notulensi->keywords }}" placeholder="contoh: APBD, anggaran, rencana kerja, 2025">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:4px;">Kata kunci untuk mempermudah pencarian notulensi ini.</div>
            </div>

            {{-- File Notulensi --}}
            <div class="form-group">
                <label class="form-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:4px;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    File Notulensi
                    <span style="color:var(--text-muted);font-weight:400;">(PDF, DOC, PPT — maks. 20MB)</span>
                </label>
                @if($notulensi->file_notulensi)
                <div style="display:flex;align-items:center;gap:10px;padding:10px;background:var(--info-bg,rgba(99,102,241,0.07));border-radius:var(--radius-sm);margin-bottom:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--accent)" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.85rem;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ basename($notulensi->file_notulensi) }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">File notulensi saat ini</div>
                    </div>
                    <a href="{{ route('notulensi.download', [$notulensi, 'notulensi']) }}" class="btn btn-xs btn-outline">Unduh</a>
                    <label style="display:flex;align-items:center;gap:5px;font-size:0.8rem;color:var(--danger,#ef4444);cursor:pointer;flex-shrink:0;">
                        <input type="checkbox" name="hapus_file_notulensi" value="1"> Hapus file
                    </label>
                </div>
                @endif
                <input type="file" name="file_notulensi" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                @if($notulensi->file_notulensi)
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:4px;">Upload file baru untuk mengganti file yang ada.</div>
                @endif
            </div>

            {{-- File Paparan --}}
            <div class="form-group">
                <label class="form-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display:inline;margin-right:4px;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" /></svg>
                    File Paparan Dinas
                    <span style="color:var(--text-muted);font-weight:400;">(PDF, PPT — maks. 20MB)</span>
                </label>
                @if($notulensi->file_paparan)
                <div style="display:flex;align-items:center;gap:10px;padding:10px;background:rgba(245,158,11,0.08);border-radius:var(--radius-sm);margin-bottom:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" /></svg>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.85rem;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ basename($notulensi->file_paparan) }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">File paparan saat ini</div>
                    </div>
                    <a href="{{ route('notulensi.download', [$notulensi, 'paparan']) }}" class="btn btn-xs btn-outline">Unduh</a>
                    <label style="display:flex;align-items:center;gap:5px;font-size:0.8rem;color:var(--danger,#ef4444);cursor:pointer;flex-shrink:0;">
                        <input type="checkbox" name="hapus_file_paparan" value="1"> Hapus file
                    </label>
                </div>
                @endif
                <input type="file" name="file_paparan" class="form-control" accept=".pdf,.ppt,.pptx">
                @if($notulensi->file_paparan)
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:4px;">Upload file baru untuk mengganti file yang ada.</div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="draft" {{ $notulensi->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="final" {{ $notulensi->status === 'final' ? 'selected' : '' }}>Final</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('notulensi.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
