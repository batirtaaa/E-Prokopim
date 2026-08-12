@extends('layouts.app')
@section('title', 'Edit Kegiatan — SIKOPIM')
@section('topbar-title', 'Kegiatan')
@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Kegiatan</h1>
    <p class="page-subtitle">Perbarui data kegiatan pimpinan</p>
</div>
<div class="card" style="max-width:860px;">
    <div class="card-body">
        <form method="POST" action="{{ route('kegiatan.update', $kegiatan) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Kegiatan *</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $kegiatan->judul) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>
            <div class="form-row cols-2">
                <div class="form-group">
                    <label class="form-label">Tanggal & Waktu Mulai *</label>
                    <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal & Waktu Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $kegiatan->lokasi) }}">
            </div>
            <div class="form-row cols-3">
                <div class="form-group">
                    <label class="form-label">Pimpinan *</label>
                    <select name="pimpinan" class="form-control" required>
                        @foreach(['wali_kota'=>'Wali Kota','wakil_wali_kota'=>'Wakil Wali Kota','sekda'=>'Sekda','asisten'=>'Asisten'] as $v => $l)
                            <option value="{{ $v }}" {{ old('pimpinan', $kegiatan->pimpinan) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="kategori" class="form-control" required>
                        @foreach(['rapat'=>'Rapat','kunjungan'=>'Kunjungan','acara'=>'Acara','audiensi'=>'Audiensi','peresmian'=>'Peresmian','lainnya'=>'Lainnya'] as $v => $l)
                            <option value="{{ $v }}" {{ old('kategori', $kegiatan->kategori) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        @foreach(['draft'=>'Draft','terjadwal'=>'Terjadwal','berlangsung'=>'Berlangsung','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $v => $l)
                            <option value="{{ $v }}" {{ old('status', $kegiatan->status) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
