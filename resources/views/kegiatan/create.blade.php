@extends('layouts.app')
@section('title', 'Tambah Kegiatan — SIKOPIM')
@section('topbar-title', 'Kegiatan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Kegiatan Baru</h1>
    <p class="page-subtitle">Buat agenda kegiatan pimpinan baru</p>
</div>

<div class="card" style="max-width:860px;">
    <div class="card-body">
        <form method="POST" action="{{ route('kegiatan.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Kegiatan *</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Masukkan judul kegiatan">
                @error('judul') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat kegiatan">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="form-row cols-2">
                <div class="form-group">
                    <label class="form-label">Tanggal & Waktu Mulai *</label>
                    <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal & Waktu Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Nama tempat/lokasi kegiatan">
            </div>
            <div class="form-row cols-3">
                <div class="form-group">
                    <label class="form-label">Pimpinan *</label>
                    <select name="pimpinan" class="form-control" required>
                        <option value="">Pilih Pimpinan</option>
                        <option value="wali_kota" {{ old('pimpinan') === 'wali_kota' ? 'selected' : '' }}>Wali Kota</option>
                        <option value="wakil_wali_kota" {{ old('pimpinan') === 'wakil_wali_kota' ? 'selected' : '' }}>Wakil Wali Kota</option>
                        <option value="sekda" {{ old('pimpinan') === 'sekda' ? 'selected' : '' }}>Sekda</option>
                        <option value="asisten" {{ old('pimpinan') === 'asisten' ? 'selected' : '' }}>Asisten</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach(['rapat'=>'Rapat','kunjungan'=>'Kunjungan','acara'=>'Acara','audiensi'=>'Audiensi','peresmian'=>'Peresmian','lainnya'=>'Lainnya'] as $v => $l)
                            <option value="{{ $v }}" {{ old('kategori') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ old('status', 'terjadwal') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="terjadwal" {{ old('status', 'terjadwal') === 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="berlangsung" {{ old('status') === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
            </div>
        </form>
    </div>
</div>
@endsection
