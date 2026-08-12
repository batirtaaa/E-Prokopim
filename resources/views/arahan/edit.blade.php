@extends('layouts.app')
@section('title', 'Edit Arahan — SIKOPIM')
@section('topbar-title', 'Arahan Pimpinan')
@section('content')
<div class="page-header"><h1 class="page-title">Edit Arahan Pimpinan</h1></div>
<div class="card" style="max-width:860px;">
    <div class="card-body">
        <form method="POST" action="{{ route('arahan.update', $arahan) }}">
            @csrf @method('PUT')
            <div class="form-row cols-2">
                <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="judul" class="form-control" value="{{ $arahan->judul }}" required></div>
                <div class="form-group"><label class="form-label">Pimpinan *</label><select name="pimpinan" class="form-control" required>@foreach(['wali_kota'=>'Wali Kota','wakil_wali_kota'=>'Wakil Wali Kota','sekda'=>'Sekda','asisten'=>'Asisten'] as $v=>$l)<option value="{{ $v }}" {{ $arahan->pimpinan===$v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
            </div>
            <div class="form-group"><label class="form-label">Isi Arahan *</label><textarea name="isi_arahan" class="form-control" rows="5" required>{{ $arahan->isi_arahan }}</textarea></div>
            <div class="form-group"><label class="form-label">Ditujukan Kepada</label><input type="text" name="ditujukan_kepada" class="form-control" value="{{ $arahan->ditujukan_kepada }}"></div>
            <div class="form-row cols-3">
                <div class="form-group"><label class="form-label">Tanggal *</label><input type="date" name="tanggal_arahan" class="form-control" value="{{ $arahan->tanggal_arahan->format('Y-m-d') }}" required></div>
                <div class="form-group"><label class="form-label">Deadline</label><input type="date" name="deadline" class="form-control" value="{{ $arahan->deadline?->format('Y-m-d') }}"></div>
                <div class="form-group"><label class="form-label">Prioritas</label><select name="prioritas" class="form-control">@foreach(['rendah'=>'Rendah','sedang'=>'Sedang','tinggi'=>'Tinggi','urgent'=>'Urgent'] as $v=>$l)<option value="{{ $v }}" {{ $arahan->prioritas===$v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
            </div>
            <div class="form-group"><label class="form-label">Status</label><select name="status" class="form-control">@foreach(['belum_selesai'=>'Belum Selesai','sedang_berjalan'=>'Sedang Berjalan','selesai'=>'Selesai','melewati_deadline'=>'Melewati Deadline'] as $v=>$l)<option value="{{ $v }}" {{ $arahan->status===$v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
            <div class="form-actions"><a href="{{ route('arahan.index') }}" class="btn btn-outline">Batal</a><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
        </form>
    </div>
</div>
@endsection
