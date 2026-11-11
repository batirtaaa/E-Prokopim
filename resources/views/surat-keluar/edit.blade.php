@extends('layouts.app')
@section('title', 'Edit Surat Keluar — Bagian Protokol dan Komunikasi Pimpinan')

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
.form-header h2 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.form-header p { font-size: 13px; color: #64748b; margin: 0; }
.form-group { margin-bottom: 20px; }
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } }
.form-label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
.form-label .req { color: #dc2626; }
.form-input, .form-textarea {
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
.form-input:focus, .form-textarea:focus {
    border-color: #0891b2;
    box-shadow: 0 0 0 3px rgba(8,145,178,0.08);
}
.form-textarea { resize: vertical; min-height: 90px; }
.form-hint { font-size: 11.5px; color: #64748b; margin-top: 4px; }
.invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 4px; }

/* Upload Zone */
.upload-area {
    width: 100%;
    border: 2px dashed #a5f3fc;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s ease;
    background: #ecfeff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-sizing: border-box;
}
.upload-area:hover, .upload-area.dragover { border-color: #0891b2; background: #cffafe; }
.upload-area input[type="file"] { display: none; }
.upload-main { font-size: 14.5px; font-weight: 700; color: #0f172a; margin-top: 4px; }
.upload-sub { font-size: 12.5px; color: #64748b; }
.upload-hint { font-size: 11.5px; color: #94a3b8; display: flex; align-items: center; gap: 5px; margin-top: 4px; }
.upload-hint svg { width: 13px; height: 13px; }
.current-file-badge {
    margin-top: 10px;
    padding: 10px 14px;
    background: #ecfeff;
    border: 1px solid #a5f3fc;
    border-radius: 8px;
    font-size: 12.5px;
    color: #0e7490;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: fadeIn 0.15s ease;
}
@keyframes fadeIn { from { opacity:0; transform: translateY(-4px); } to { opacity:1; transform: translateY(0); } }

/* Footer */
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
    background: #155e75;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-submit:hover { background: #0e4a5c; }
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
.btn-cancel:hover { background: #f8fafc; color: #0f172a; }
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2>Edit Surat Keluar</h2>
        <p>Perbarui informasi surat keluar. Nomor surat dan tanggal dapat diubah secara manual.</p>
    </div>

    <form method="POST" action="{{ route('surat-keluar.update', $suratKeluar->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Row 1: Tanggal & Nomor Surat --}}
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                <input type="date" name="tanggal_surat"
                       class="form-input @error('tanggal_surat') is-invalid @enderror"
                       value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat ? $suratKeluar->tanggal_surat->format('Y-m-d') : '') }}"
                       required>
                <div class="form-hint">Tanggal pada surat keluar (bisa tanggal mundur).</div>
                @error('tanggal_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Surat <span class="req">*</span></label>
                <input type="text" name="nomor_surat"
                       class="form-input @error('nomor_surat') is-invalid @enderror"
                       value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}"
                       placeholder="Contoh: 001/Prokopim/IX/2026"
                       required>
                <div class="form-hint">Nomor surat diisi manual sesuai buku agenda.</div>
                @error('nomor_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 2: Instansi Tujuan --}}
        <div class="form-group">
            <label class="form-label">Instansi Tujuan <span class="req">*</span></label>
            <input type="text" name="tujuan"
                   class="form-input @error('tujuan') is-invalid @enderror"
                   value="{{ old('tujuan', $suratKeluar->tujuan) }}"
                   placeholder="Contoh: Dinas Komunikasi dan Informatika Kota Bandung"
                   required>
            @error('tujuan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 3: Perihal --}}
        <div class="form-group">
            <label class="form-label">Perihal Surat <span class="req">*</span></label>
            <textarea name="perihal"
                      class="form-textarea @error('perihal') is-invalid @enderror"
                      placeholder="Tuliskan perihal / pokok surat keluar..."
                      required>{{ old('perihal', $suratKeluar->perihal) }}</textarea>
            @error('perihal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 4: Keterangan --}}
        <div class="form-group">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan"
                      class="form-textarea @error('keterangan') is-invalid @enderror"
                      style="min-height:70px"
                      placeholder="Catatan tambahan (opsional)...">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Row 5: Upload Dokumen --}}
        <div class="form-group">
            <label class="form-label">Upload Dokumen</label>
            <label class="upload-area" for="input-dokumen" id="upload-label">
                <input type="file" id="input-dokumen" name="file_dokumen" accept=".pdf,.doc,.docx" onchange="handleFile(this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:38px;height:38px;color:#0891b2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                </svg>
                <div class="upload-main" id="upload-main-text">Drag &amp; Drop file di sini untuk mengganti</div>
                <div class="upload-sub" id="upload-sub-text">atau klik untuk menelusuri dari perangkat</div>
                <div class="upload-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    Format: PDF, DOC, DOCX. Maks: 15MB
                </div>
            </label>

            {{-- File existing --}}
            @if($suratKeluar->file_dokumen)
                <div id="current-file-badge" class="current-file-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span>File saat ini: <strong><a href="{{ $suratKeluar->file_url }}" target="_blank" style="color:#0e7490;text-decoration:underline">{{ basename($suratKeluar->file_dokumen) }}</a></strong></span>
                </div>
            @endif

            {{-- Badge file baru --}}
            <div id="selected-file-badge" class="current-file-badge" style="display:none;background:#f0fdf4;border-color:#bbf7d0;color:#166534">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:#16a34a"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>File baru terpilih: <strong id="selected-file-name">-</strong></span>
                <button type="button" onclick="removeSelectedFile()" style="margin-left:auto;background:none;border:none;color:#dc2626;cursor:pointer;font-size:18px;line-height:1;font-weight:bold" title="Batalkan">&times;</button>
            </div>

            @error('file_dokumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Footer --}}
        <div class="form-footer-card">
            <a href="{{ route('surat-keluar.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
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
        if (mainText) mainText.textContent = 'File baru berhasil dipilih';
    } else {
        if (badge) badge.style.display = 'none';
        if (mainText) mainText.textContent = 'Drag & Drop file di sini untuk mengganti';
    }
}
function removeSelectedFile() {
    const input = document.getElementById('input-dokumen');
    if (input) input.value = '';
    handleFile(input);
}
const uploadArea = document.getElementById('upload-label');
if (uploadArea) {
    ['dragover', 'dragenter'].forEach(e => {
        uploadArea.addEventListener(e, ev => { ev.preventDefault(); uploadArea.classList.add('dragover'); });
    });
    ['dragleave', 'dragend'].forEach(e => {
        uploadArea.addEventListener(e, () => { uploadArea.classList.remove('dragover'); });
    });
    uploadArea.addEventListener('drop', ev => {
        ev.preventDefault();
        uploadArea.classList.remove('dragover');
        const f = ev.dataTransfer.files[0];
        if (f) {
            const dt = new DataTransfer();
            dt.items.add(f);
            const fi = document.getElementById('input-dokumen');
            fi.files = dt.files;
            handleFile(fi);
        }
    });
}
</script>
@endpush
