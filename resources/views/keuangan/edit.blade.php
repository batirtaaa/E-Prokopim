@extends('layouts.app')
@section('title', 'Edit Data Transaksi Keuangan — E-PROKOPIM')

@push('styles')
<style>
.keu-form-container {
    max-width: 860px;
    margin: 0 auto;
    color: #1e293b;
    font-family: inherit;
}

/* Page Header with Back Button */
.keu-form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}
.keu-back-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #334155;
    text-decoration: none;
    transition: all 0.15s ease;
    flex-shrink: 0;
}
.keu-back-btn:hover {
    border-color: #0f172a;
    color: #0f172a;
    background: #f8fafc;
}
.keu-form-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 3px 0;
}
.keu-form-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Card */
.keu-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    padding: 24px 28px;
    margin-bottom: 20px;
}
.keu-section-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 18px;
}
.keu-section-icon {
    width: 17px;
    height: 17px;
    color: #0f172a;
    flex-shrink: 0;
}

/* Grid */
.keu-form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 16px;
}
.keu-form-grid-2:last-child {
    margin-bottom: 0;
}
@media (max-width: 640px) {
    .keu-form-grid-2 {
        grid-template-columns: 1fr;
    }
}
.keu-form-group {
    display: flex;
    flex-direction: column;
}

/* Labels and Inputs */
.keu-label-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}
.keu-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}
.keu-label .req {
    color: #ef4444;
}
.keu-input-text, .keu-select, .keu-textarea {
    width: 100%;
    padding: 9px 12px;
    font-size: 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.15s ease;
    box-sizing: border-box;
    font-family: inherit;
}
.keu-input-text:focus, .keu-select:focus, .keu-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.keu-input-text.readonly-auto {
    background: #f1f5f9;
    color: #64748b;
    border-color: #cbd5e1;
    cursor: not-allowed;
}
.keu-select {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 13px;
    appearance: none;
    cursor: pointer;
}

/* Actions */
.keu-form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 10px;
    margin-bottom: 40px;
}
.keu-btn-cancel {
    padding: 9px 22px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s ease;
}
.keu-btn-cancel:hover {
    border-color: #94a3b8;
    color: #0f172a;
}
.keu-btn-save {
    padding: 9px 24px;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s ease;
}
.keu-btn-save:hover {
    background: #081d30;
}
</style>
@endpush

@section('content')
<div class="keu-form-container">

    {{-- Error messages --}}
    @if(isset($errors) && $errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px;">
        <div style="font-weight:600; margin-bottom:4px;">Terdapat kesalahan pada isian formulir:</div>
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Header --}}
    <div class="keu-form-header">
        <a href="{{ route('keuangan.index') }}" class="keu-back-btn" title="Kembali ke Daftar Keuangan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        <div>
            <h1 class="keu-form-title">Edit Data Transaksi Keuangan</h1>
            <p class="keu-form-subtitle">Perbarui data transaksi {{ $keuangan->no_bukti }} di bawah ini.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('keuangan.update', $keuangan) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Card 1: Informasi Transaksi --}}
        <div class="keu-form-card">
            <div class="keu-section-header">
                <svg class="keu-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
                <span>Informasi Transaksi &amp; Anggaran</span>
            </div>

            <div class="keu-form-grid-2">
                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">No. Bukti / Kode Transaksi</label>
                    </div>
                    <input type="text" class="keu-input-text readonly-auto" value="{{ $keuangan->no_bukti }}" readonly>
                </div>

                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Tanggal Transaksi <span class="req">*</span></label>
                    </div>
                    <input type="date" name="tanggal" class="keu-input-text" value="{{ old('tanggal', $keuangan->tanggal ? $keuangan->tanggal->format('Y-m-d') : '') }}" required>
                </div>
            </div>

            <div class="keu-form-group" style="margin-bottom: 16px;">
                <div class="keu-label-row">
                    <label class="keu-label">Uraian Transaksi / Kegiatan <span class="req">*</span></label>
                </div>
                <input type="text" name="uraian" class="keu-input-text" value="{{ old('uraian', $keuangan->uraian) }}" required>
            </div>

            <div class="keu-form-grid-2">
                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Kategori <span class="req">*</span></label>
                    </div>
                    <select name="kategori" class="keu-select" required>
                        <option value="Jamuan Tamu" {{ old('kategori', $keuangan->kategori) == 'Jamuan Tamu' ? 'selected' : '' }}>Jamuan Tamu</option>
                        <option value="Perjalanan Dinas" {{ old('kategori', $keuangan->kategori) == 'Perjalanan Dinas' ? 'selected' : '' }}>Perjalanan Dinas</option>
                        <option value="Honorarium" {{ old('kategori', $keuangan->kategori) == 'Honorarium' ? 'selected' : '' }}>Honorarium</option>
                        <option value="Operasional" {{ old('kategori', $keuangan->kategori) == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="Pemeliharaan" {{ old('kategori', $keuangan->kategori) == 'Pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
                        <option value="Publikasi" {{ old('kategori', $keuangan->kategori) == 'Publikasi' ? 'selected' : '' }}>Publikasi</option>
                    </select>
                </div>

                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Jenis Transaksi <span class="req">*</span></label>
                    </div>
                    <select name="jenis" class="keu-select" required>
                        <option value="pengeluaran" {{ old('jenis', $keuangan->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Realisasi Belanja)</option>
                        <option value="pemasukan" {{ old('jenis', $keuangan->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Penerimaan / Droping)</option>
                    </select>
                </div>
            </div>

            <div class="keu-form-grid-2">
                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Nominal (Rp) <span class="req">*</span></label>
                    </div>
                    <input type="number" name="nominal" class="keu-input-text" min="0" step="100" value="{{ old('nominal', $keuangan->nominal) }}" required>
                </div>

                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Penanggung Jawab / Penerima</label>
                    </div>
                    <input type="text" name="penanggung_jawab" list="keuPegawaiList" class="keu-input-text" value="{{ old('penanggung_jawab', $keuangan->penanggung_jawab) }}">
                    <datalist id="keuPegawaiList">
                        @foreach($pegawaiList as $pgw)
                            <option value="{{ $pgw->nama_lengkap }}">{{ $pgw->jabatan }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="keu-form-grid-2">
                <div class="keu-form-group">
                    <div class="keu-label-row">
                        <label class="keu-label">Status Transaksi <span class="req">*</span></label>
                    </div>
                    <select name="status" class="keu-select" required>
                        <option value="selesai" {{ old('status', $keuangan->status) == 'selesai' ? 'selected' : '' }}>Selesai (Lunas / Diverifikasi)</option>
                        <option value="pending" {{ old('status', $keuangan->status) == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="proses" {{ old('status', $keuangan->status) == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="draft" {{ old('status', $keuangan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Card 2: Bukti / LPJ & Catatan --}}
        <div class="keu-form-card">
            <div class="keu-section-header">
                <svg class="keu-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.373L8.552 18.32a1.5 1.5 0 01-2.122-2.122l9.88-9.878" />
                </svg>
                <span>Lampiran Bukti &amp; Keterangan</span>
            </div>

            <div style="margin-bottom: 16px;">
                <label class="keu-label" style="margin-bottom: 8px; display:block;">File Bukti / Kuitansi</label>
                @if($keuangan->file_bukti)
                    <div style="font-size:12.5px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                        <span>File saat ini:</span>
                        <a href="{{ asset('storage/' . $keuangan->file_bukti) }}" target="_blank" style="color:#2563eb; font-weight:600; text-decoration:none;">Lihat Dokumen</a>
                    </div>
                @endif
                <input type="file" name="file_bukti" accept=".pdf,.jpg,.jpeg,.png,.docx" class="keu-input-text">
            </div>

            <div class="keu-form-group">
                <label class="keu-label" style="margin-bottom: 6px;">Catatan Tambahan</label>
                <textarea name="catatan" class="keu-textarea" rows="3">{{ old('catatan', $keuangan->catatan) }}</textarea>
            </div>
        </div>

        {{-- Actions --}}
        <div class="keu-form-actions">
            <a href="{{ route('keuangan.index') }}" class="keu-btn-cancel">Batal</a>
            <button type="submit" class="keu-btn-save">Perbarui Transaksi</button>
        </div>
    </form>
</div>
@endsection
