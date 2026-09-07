@extends('layouts.app')
@section('title', 'Tambah Surat Masuk — Bagian Protokol dan Komunikasi Pimpinan')

@push('styles')
<style>
.form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    max-width: 840px;
    margin: 0 auto;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.form-header {
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 16px;
    margin-bottom: 24px;
}
.form-header h2 {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}
.form-header p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.form-group {
    margin-bottom: 20px;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 640px) {
    .form-row { grid-template-columns: 1fr; }
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.form-label .req {
    color: #dc2626;
}
.form-input, .form-textarea, .form-select {
    width: 100%;
    padding: 10px 14px;
    font-size: 13.5px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #0f172a;
    outline: none;
    transition: all 0.15s ease;
    box-sizing: border-box;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
.form-textarea {
    resize: vertical;
    min-height: 90px;
}
.form-hint {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 4px;
}
.invalid-feedback {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}

/* Drag & Drop Upload Zone */
.upload-area {
    width: 100%;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s ease;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-sizing: border-box;
}
.upload-area:hover, .upload-area.dragover {
    border-color: #2563eb;
    background: #eff6ff;
}
.upload-area input[type="file"] {
    display: none;
}
.upload-main {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 4px;
}
.upload-sub {
    font-size: 12.5px;
    color: #64748b;
}
.upload-hint {
    font-size: 11.5px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
}
.upload-hint svg {
    width: 13px;
    height: 13px;
}

.current-file-badge {
    margin-top: 10px;
    padding: 10px 14px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    font-size: 12.5px;
    color: #1e40af;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: fadeIn 0.15s ease;
}
@keyframes fadeIn { from { opacity:0; transform: translateY(-4px); } to { opacity:1; transform: translateY(0); } }

/* Checkbox Card for Print */
.print-status-box {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.print-status-box:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}
.print-status-box input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #16a34a;
    cursor: pointer;
}
.print-status-info {
    display: flex;
    flex-direction: column;
}
.print-status-title {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
}
.print-status-desc {
    font-size: 12px;
    color: #64748b;
}

/* Footer Actions */
.form-footer-card {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}
.btn-submit {
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 600;
    background: #1e3a5f;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-submit:hover {
    background: #162f4f;
}
.btn-cancel {
    padding: 9px 18px;
    font-size: 13.5px;
    font-weight: 500;
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.15s ease;
}
.btn-cancel:hover {
    background: #f8fafc;
    color: #0f172a;
}
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2>Catat Surat Masuk Baru</h2>
        <p>Lengkapi formulir di bawah ini untuk mencatat surat masuk, disposisi, dan berkas lampiran ke dalam buku agenda digital.</p>
    </div>

    <form method="POST" action="{{ route('keuangan.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Row 1: Tanggal Diterima & Nomor Surat --}}
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal Diterima <span class="req">*</span></label>
                <input type="date" name="tanggal_diterima" class="form-input @error('tanggal_diterima') is-invalid @enderror" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required>
                @error('tanggal_diterima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Surat <span class="req">*</span></label>
                <input type="text" name="nomor_surat" class="form-input @error('nomor_surat') is-invalid @enderror" value="{{ old('nomor_surat') }}" placeholder="Contoh: 180-Bag.Tapem/2026 atau B/TU.04/002-Bag.Perkap/2026" required>
                @error('nomor_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 2: Asal Instansi --}}
        <div class="form-group">
            <label class="form-label">Asal Instansi <span class="req">*</span></label>
            <input type="text" name="pengirim" class="form-input @error('pengirim') is-invalid @enderror" value="{{ old('pengirim') }}" placeholder="Contoh: Bagian Tata Pemerintahan Setda / Dinas Kesehatan / Polrestabes Bandung" required>
            @error('pengirim')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 3: Perihal --}}
        <div class="form-group">
            <label class="form-label">Perihal Surat <span class="req">*</span></label>
            <textarea name="perihal" class="form-textarea @error('perihal') is-invalid @enderror" placeholder="Tuliskan ringkasan isi atau perihal surat masuk..." required>{{ old('perihal') }}</textarea>
            @error('perihal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 4: Disposisi --}}
        <div class="form-group">
            <label class="form-label">Disposisi</label>
            <input type="text" name="disposisi" list="disposisiList" class="form-input @error('disposisi') is-invalid @enderror" value="{{ old('disposisi') }}" placeholder="Contoh: Suhendro Drajad, S.T. / Andre Pratama, S.I.Kom, M.Si.">
            <datalist id="disposisiList">
                <option value="Suhendro Drajad, S.T.">
                <option value="Andre Pratama, S.I.Kom, M.Si.">
                <option value="Primanda Wijaksana, S.Sos.">
                <option value="Yudha Pratama, S.Tr.Kom">
                <option value="Andre Pratama, S.I.Kom, M.Si. dan Suhendro Drajad, S.T.">
                @if(isset($pegawaiList))
                    @foreach($pegawaiList as $p)
                        <option value="{{ $p->nama_lengkap }}">
                    @endforeach
                @endif
            </datalist>
            <div class="form-hint">Pilih dari saran atau ketik nama/tim yang menerima disposisi.</div>
            @error('disposisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 5: Upload Dokumen (Drag & Drop Zone) --}}
        <div class="form-group">
            <label class="form-label">Dokumen Pendukung</label>
            <label class="upload-area" for="input-dokumen" id="upload-label">
                <input type="file" id="input-dokumen" name="file_dokumen" accept=".pdf,.doc,.docx" onchange="handleFile(this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:38px;height:38px;color:#2563eb"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                <div class="upload-main" id="upload-main-text">Drag &amp; Drop file di sini</div>
                <div class="upload-sub" id="upload-sub-text">atau klik untuk menelusuri dari perangkat</div>
                <div class="upload-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    Format: PDF, DOC, DOCX. Maks: 15MB
                </div>
            </label>

            {{-- Badge file terpilih --}}
            <div id="selected-file-badge" class="current-file-badge" style="display:none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <span>File terpilih: <strong id="selected-file-name">-</strong></span>
                <button type="button" onclick="removeSelectedFile()" style="margin-left:auto;background:none;border:none;color:#dc2626;cursor:pointer;font-size:18px;line-height:1;font-weight:bold" title="Hapus file">&times;</button>
            </div>

            @error('file_dokumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 6: Status Pencetakan --}}
        <div class="form-group" style="margin-top: 10px;">
            <label class="form-label">Status Pencetakan</label>
            <label class="print-status-box" for="is_printed">
                <input type="checkbox" name="is_printed" id="is_printed" value="1" {{ old('is_printed') ? 'checked' : '' }}>
                <div class="print-status-info">
                    <span class="print-status-title">Tandai Sudah Diprint</span>
                    <span class="print-status-desc">Centang jika fisik surat sudah dicetak / didistribusikan.</span>
                </div>
            </label>
        </div>

        {{-- Footer --}}
        <div class="form-footer-card">
            <a href="{{ route('keuangan.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Simpan Surat Masuk</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function handleFile(input) {
    const file = input.files[0];
    const badge = document.getElementById('selected-file-badge');
    const nameEl = document.getElementById('selected-file-name');
    const mainText = document.getElementById('upload-main-text');

    if (file) {
        if (nameEl) nameEl.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
        if (badge) badge.style.display = 'flex';
        if (mainText) mainText.textContent = 'File berhasil dipilih';
    } else {
        if (badge) badge.style.display = 'none';
        if (mainText) mainText.textContent = 'Drag & Drop file di sini';
    }
}

function removeSelectedFile() {
    const input = document.getElementById('input-dokumen');
    if (input) input.value = '';
    handleFile(input);
}

// Drag & Drop event handlers
const uploadArea = document.getElementById('upload-label');
if (uploadArea) {
    ['dragover', 'dragenter'].forEach(e => {
        uploadArea.addEventListener(e, ev => {
            ev.preventDefault();
            uploadArea.classList.add('dragover');
        });
    });

    ['dragleave', 'dragend'].forEach(e => {
        uploadArea.addEventListener(e, () => {
            uploadArea.classList.remove('dragover');
        });
    });

    uploadArea.addEventListener('drop', ev => {
        ev.preventDefault();
        uploadArea.classList.remove('dragover');
        const f = ev.dataTransfer.files[0];
        if (f) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(f);
            const fileInput = document.getElementById('input-dokumen');
            fileInput.files = dataTransfer.files;
            handleFile(fileInput);
        }
    });
}
</script>
@endpush
