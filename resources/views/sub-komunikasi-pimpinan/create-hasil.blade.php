@extends('layouts.app')
@section('title', 'Upload Hasil Sambutan — E-PROKOPIM')

@push('styles')
<style>
.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.page-header-left h1 { font-size:26px; font-weight:700; color:#111827; margin-bottom:4px; }
.page-header-left p  { font-size:13.5px; color:#6b7280; }
.form-2col { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.form-card { background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; }
.form-card-title { display:flex; align-items:center; gap:9px; font-size:14px; font-weight:600; color:#111827; padding:18px 22px 16px; border-bottom:1px solid #f3f4f6; }
.form-card-title svg { width:16px; height:16px; color:#6b7280; }
.form-card-body { padding:22px; }
.form-group { margin-bottom:18px; }
.form-group:last-child { margin-bottom:0; }

.form-group .form-label,
.form-group label.form-label {
    text-transform: none !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #374151 !important;
    letter-spacing: 0 !important;
    margin-bottom: 6px;
    display: block;
}
.form-label .req { color:#ef4444; }
.form-input, .form-select, .form-textarea {
    width:100%; padding:9px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:13.5px; color:#374151; background:white;
    outline:none; transition:border-color 0.15s; font-family:inherit;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.08); }
.form-textarea { resize:vertical; min-height:90px; }
.upload-area { border:2px dashed #d1d5db; border-radius:10px; padding:32px 20px; text-align:center; cursor:pointer; transition:all 0.15s; background:#fafafa; display:block; }
.upload-area:hover { border-color:#2563eb; background:#eff6ff; }
.upload-area input[type="file"] { display:none; }
.upload-main { font-size:14px; font-weight:600; color:#111827; margin-bottom:4px; }
.upload-sub  { font-size:12.5px; color:#6b7280; margin-bottom:6px; }
.upload-hint { font-size:11.5px; color:#9ca3af; display:flex; align-items:center; gap:5px; justify-content:center; }
.form-footer { display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #e5e7eb; }
.btn-cancel { padding:9px 20px; border:1px solid #e5e7eb; border-radius:8px; background:white; font-size:13.5px; color:#374151; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; transition:background 0.15s; }
.btn-cancel:hover { background:#f3f4f6; }
.btn-submit { padding:9px 20px; border:1px solid #1e3a5f; border-radius:8px; background:#1e3a5f; font-size:13.5px; font-weight:600; color:white; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:background 0.15s; }
.btn-submit:hover { background:#162f4f; }
</style>
@endpush

@section('content')

<div class="page-header-row">
    <div class="page-header-left">
        <h1>Upload Hasil Sambutan</h1>
        <p>Unggah draf atau naskah sambutan yang telah selesai dikerjakan agar menyatu dengan surat permohonannya.</p>
    </div>
</div>

<form method="POST" action="{{ route('sambutan.upload-hasil-global') }}" enctype="multipart/form-data" id="mainHasilForm">
@csrf

<div class="form-2col">
    {{-- 1. Pilih Surat Permohonan --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            1. Target Surat Permohonan Sambutan
        </div>
        <div class="form-card-body">
            <div class="form-group">
                <label class="form-label">Pilih Surat Sambutan <span class="req">*</span></label>
                <select class="form-select" name="sambutan_id" id="selectSambutan" required onchange="updateSuratDetails(this)">
                    <option value="" disabled selected>Pilih surat sambutan...</option>
                    @foreach($pendingSambutan as $ps)
                        <option value="{{ $ps->id }}" 
                            data-nomor="{{ $ps->nomor_surat }}" 
                            data-instansi="{{ $ps->asal_instansi }}" 
                            data-perihal="{{ $ps->perihal }}"
                            data-petugas="{{ $ps->petugas ? $ps->petugas->nama_lengkap : '-' }}"
                            data-acara="{{ $ps->tanggal_acara ? $ps->tanggal_acara->translatedFormat('d M Y') : '-' }}"
                        >
                            {{ $ps->nomor_surat }} — {{ Str::limit($ps->perihal, 35) }} ({{ $ps->asal_instansi }})
                        </option>
                    @endforeach
                    @if($allSambutan->whereNotNull('file_hasil_path')->count() > 0)
                        <optgroup label="Sudah Memiliki Naskah (Perbarui)">
                            @foreach($allSambutan->whereNotNull('file_hasil_path') as $as)
                                <option value="{{ $as->id }}"
                                    data-nomor="{{ $as->nomor_surat }}" 
                                    data-instansi="{{ $as->asal_instansi }}" 
                                    data-perihal="{{ $as->perihal }}"
                                    data-petugas="{{ $as->petugas ? $as->petugas->nama_lengkap : '-' }}"
                                    data-acara="{{ $as->tanggal_acara ? $as->tanggal_acara->translatedFormat('d M Y') : '-' }}"
                                >
                                    {{ $as->nomor_surat }} — {{ Str::limit($as->perihal, 35) }} ({{ $as->asal_instansi }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>

            <div id="suratDetailPreview" style="display:none;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;margin-top:16px;">
                <div style="font-size:11.5px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Detail Surat Masuk:</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:12.5px;">
                    <div>
                        <span style="color:#64748b;display:block;font-size:11px;">Nomor Surat:</span>
                        <strong id="prevNomor" style="color:#0f172a;">-</strong>
                    </div>
                    <div>
                        <span style="color:#64748b;display:block;font-size:11px;">Asal Instansi:</span>
                        <strong id="prevInstansi" style="color:#0f172a;">-</strong>
                    </div>
                    <div>
                        <span style="color:#64748b;display:block;font-size:11px;">Tanggal Acara:</span>
                        <span id="prevAcara" style="color:#0f172a;font-weight:500;">-</span>
                    </div>
                    <div>
                        <span style="color:#64748b;display:block;font-size:11px;">Petugas Disposisi:</span>
                        <span id="prevPetugas" style="color:#0f172a;font-weight:500;">-</span>
                    </div>
                </div>
                <div style="margin-top:10px;padding-top:8px;border-top:1px solid #e2e8f0;font-size:12.5px;">
                    <span style="color:#64748b;display:block;font-size:11px;">Perihal:</span>
                    <div id="prevPerihal" style="color:#334155;font-weight:500;margin-top:2px;">-</div>
                </div>
            </div>

            <div class="form-group" style="margin-top:18px">
                <label class="form-label">Catatan Hasil (Opsional)</label>
                <textarea class="form-textarea" name="catatan_hasil" placeholder="Keterangan draf naskah hasil sambutan..."></textarea>
            </div>
        </div>
    </div>

    {{-- 2. Upload Naskah Hasil --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            2. Dokumen Naskah Hasil Sambutan
        </div>
        <div class="form-card-body">
            <div class="form-group">
                <label class="form-label">File Naskah Jadi (.docx, .doc, .pdf) <span class="req">*</span></label>
                <label class="upload-area" for="input-dokumen-hasil" id="upload-label-hasil">
                    <input type="file" id="input-dokumen-hasil" name="dokumen_hasil" accept=".docx,.doc,.pdf" required onchange="handleFileHasil(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" style="width:40px;height:40px;color:#059669;margin:0 auto 12px;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="upload-main" id="upload-main-text-hasil">Klik / Drag &amp; Drop naskah hasil di sini</div>
                    <div class="upload-sub" id="upload-sub-text-hasil">Format Word (.docx, .doc) atau PDF, maks. 15MB</div>
                    <div class="upload-hint">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        Naskah akan otomatis tersimpan menyatu di data surat ini.
                    </div>
                </label>
            </div>

            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;display:flex;align-items:center;gap:10px;margin-top:16px;">
                <input type="checkbox" name="status" value="selesai" id="cbSelesai" checked style="width:16px;height:16px;accent-color:#1e3a5f;cursor:pointer;">
                <label for="cbSelesai" style="font-size:13px;color:#166534;font-weight:500;cursor:pointer;margin:0;">
                    Tandai status surat permohonan langsung menjadi <strong>Selesai</strong>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="form-footer">
    <a href="{{ route('sambutan.index', ['tab' => 'hasil']) }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        Simpan &amp; Satukan Naskah Hasil
    </button>
</div>

</form>
@endsection

@push('scripts')
<script>
function handleFileHasil(input) {
    const uploadLabel = document.getElementById('upload-label-hasil');
    const mainText = document.getElementById('upload-main-text-hasil');
    const subText = document.getElementById('upload-sub-text-hasil');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        mainText.textContent = file.name;
        subText.textContent = 'File naskah siap diunggah (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        uploadLabel.style.borderColor = '#059669';
        uploadLabel.style.background = '#ecfdf5';
    } else {
        mainText.textContent = 'Klik / Drag & Drop naskah hasil di sini';
        subText.textContent = 'Format Word (.docx, .doc) atau PDF, maks. 15MB';
        uploadLabel.style.borderColor = '#d1d5db';
        uploadLabel.style.background = '#fafafa';
    }
}

function updateSuratDetails(select) {
    const preview = document.getElementById('suratDetailPreview');
    const selectedOption = select.options[select.selectedIndex];
    if (!selectedOption || !selectedOption.value) {
        preview.style.display = 'none';
        return;
    }

    document.getElementById('prevNomor').textContent = selectedOption.dataset.nomor || '-';
    document.getElementById('prevInstansi').textContent = selectedOption.dataset.instansi || '-';
    document.getElementById('prevAcara').textContent = selectedOption.dataset.acara || '-';
    document.getElementById('prevPetugas').textContent = selectedOption.dataset.petugas || '-';
    document.getElementById('prevPerihal').textContent = selectedOption.dataset.perihal || '-';

    preview.style.display = 'block';
}
</script>
@endpush
