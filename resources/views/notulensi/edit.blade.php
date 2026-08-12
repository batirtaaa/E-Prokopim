@extends('layouts.app')
@section('title', 'Edit Notulensi — SIKOPIM')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header"><h1 class="page-title">Edit Notulensi</h1></div>
<div class="card" style="max-width:860px;">
    <div class="card-body">
        <form method="POST" action="{{ route('notulensi.update', $notulensi) }}">
            @csrf @method('PUT')
            <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="judul" class="form-control" value="{{ $notulensi->judul }}" required></div>
            <div class="form-row cols-2">
                <div class="form-group"><label class="form-label">Tanggal Rapat *</label><input type="datetime-local" name="tanggal_rapat" class="form-control" value="{{ $notulensi->tanggal_rapat->format('Y-m-d\TH:i') }}" required></div>
                <div class="form-group"><label class="form-label">Tempat *</label><input type="text" name="tempat" class="form-control" value="{{ $notulensi->tempat }}" required></div>
            </div>
            <div class="form-group"><label class="form-label">Isi Notulensi *</label><textarea name="isi_notulensi" class="form-control" rows="6" required>{{ $notulensi->isi_notulensi }}</textarea></div>
            <div class="form-row cols-2">
                <div class="form-group"><label class="form-label">Kesimpulan</label><textarea name="kesimpulan" class="form-control" rows="3">{{ $notulensi->kesimpulan }}</textarea></div>
                <div class="form-group"><label class="form-label">Tindak Lanjut</label><textarea name="tindak_lanjut" class="form-control" rows="3">{{ $notulensi->tindak_lanjut }}</textarea></div>
            </div>
            <div class="form-group"><label class="form-label">Status</label><select name="status" class="form-control"><option value="draft" {{ $notulensi->status === 'draft' ? 'selected' : '' }}>Draft</option><option value="final" {{ $notulensi->status === 'final' ? 'selected' : '' }}>Final</option></select></div>
            <div class="form-actions"><a href="{{ route('notulensi.index') }}" class="btn btn-outline">Batal</a><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
        </form>
    </div>
</div>
@endsection
