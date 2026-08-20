@extends('layouts.app')
@section('title', 'Tambah Kegiatan Pimpinan — E-PROKOPIM')

@push('styles')
<style>
/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.breadcrumb a { color: var(--text-secondary); }
.breadcrumb a:hover { color: var(--accent); }
.breadcrumb-sep { color: var(--text-muted); font-size: 11px; }
.breadcrumb-current { color: var(--text-primary); font-weight: 500; }

/* Page Header */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
}
.page-header-left h1 { font-size: 22px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
.page-header-left p { font-size: 13px; color: var(--text-secondary); }
.page-header-actions { display: flex; align-items: center; gap: 10px; }

/* Form Card */
.form-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 16px;
    overflow: hidden;
}
.form-card-section-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
}
.form-card-body {
    padding: 24px;
}

/* Form Grid */
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.form-row-1 { margin-bottom: 20px; }
.form-row-time {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 8px;
    align-items: end;
    margin-bottom: 20px;
}
.form-row-time .form-group { margin-bottom: 0; }
.form-sep {
    font-size: 13px;
    color: var(--text-secondary);
    padding-bottom: 9px;
    font-weight: 500;
}

/* Form elements */
.form-group { display: flex; flex-direction: column; }
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 6px;
}
.form-label .required { color: var(--danger); }
.form-input, .form-select, .form-textarea {
    padding: 9px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13.5px;
    color: var(--text-primary);
    background: white;
    outline: none;
    transition: border-color 0.15s;
    font-family: inherit;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.08);
}
.form-input::placeholder, .form-textarea::placeholder { color: var(--text-muted); }
.form-input.auto-generated {
    background: #f8f9fa;
    color: var(--text-secondary);
}
.form-hint {
    font-size: 11.5px;
    color: var(--text-muted);
    margin-top: 4px;
}
.form-textarea { resize: vertical; min-height: 90px; }
.form-select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 16px; padding-right: 36px; }

/* Checkbox group */
.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 4px;
}
.checkbox-item {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    font-size: 13px;
    color: var(--text-primary);
}
.checkbox-item input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--accent);
    cursor: pointer;
    flex-shrink: 0;
}

/* Form Footer */
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    background: #fafafa;
}

/* Buttons */
.btn { padding: 9px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 500; cursor: pointer; border: 1px solid transparent; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
.btn-primary { background: var(--primary); color: white; border-color: var(--primary); }
.btn-primary:hover { background: var(--primary-hover); }
.btn-secondary { background: white; color: var(--text-primary); border-color: var(--border); }
.btn-secondary:hover { background: #f3f4f6; }
.btn-outline { background: white; color: var(--text-primary); border-color: var(--border); }
.btn-outline:hover { background: #f9fafb; }
</style>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">›</span>
    <a href="{{ route('kegiatan-pimpinan.index') }}">Kegiatan Pimpinan</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current">Tambah Kegiatan</span>
</div>

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Tambah Kegiatan Pimpinan</h1>
        <p>Lengkapi form di bawah ini untuk menambahkan jadwal kegiatan baru.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('kegiatan-pimpinan.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" form="form-kegiatan" name="action" value="publish" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" /></svg>
            Simpan Kegiatan
        </button>
    </div>
</div>

<form id="form-kegiatan" method="POST" action="{{ route('kegiatan-pimpinan.store') }}">
@csrf

{{-- Section 1: Informasi Dasar --}}
<div class="form-card">
    <div class="form-card-section-title">Informasi Dasar</div>
    <div class="form-card-body">
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nomor Surat / Agenda <span class="required">*</span></label>
                <input type="text" class="form-input auto-generated" value="{{ old('nomor_agenda', $nomorAgenda ?? 'AG-'.date('Ymd').'-001') }}" name="nomor_agenda" readonly>
                <span class="form-hint">Dihasilkan secara otomatis oleh sistem.</span>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Kegiatan <span class="required">*</span></label>
                <input type="text" class="form-input" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Pimpinan / Pelaksana Kegiatan <span class="required">*</span></label>
            <div class="checkbox-group">
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="wali_kota"> Wali Kota (B1)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="wakil_wali_kota"> Wakil Wali Kota (B2)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="sekda"> Sekretaris Daerah (B3)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="pkk1"> Aryatri Benarto (PKK1)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="pkk2"> Fitriana Dewi (PKK2)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="dwp"> R. Dewi Pertiwi Zulkarnain (DWP)
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Section 2: Waktu & Tempat --}}
<div class="form-card">
    <div class="form-card-section-title">Waktu &amp; Tempat Pelaksanaan</div>
    <div class="form-card-body">
        <div class="form-row-2" style="margin-bottom:20px">
            <div class="form-group">
                <label class="form-label">Tanggal Pelaksanaan <span class="required">*</span></label>
                <input type="date" class="form-input" name="tanggal" required>
            </div>
            <div class="form-group">
                <label class="form-label">Waktu Pelaksanaan <span class="required">*</span></label>
                <div style="display:flex;align-items:center;gap:8px">
                    <input type="time" class="form-input" name="waktu_mulai" style="flex:1">
                    <span style="font-size:13px;color:var(--text-secondary);white-space:nowrap">s/d</span>
                    <input type="time" class="form-input" name="waktu_selesai" style="flex:1">
                </div>
            </div>
        </div>

        <div class="form-row-1">
            <div class="form-group">
                <label class="form-label">Lokasi / Tempat <span class="required">*</span></label>
                <select class="form-select" name="lokasi" required>
                    <option value="">Pilih atau cari lokasi...</option>
                    <option value="gedung_dprd">Gedung DPRD Kota Bandung</option>
                    <option value="balai_kota">Balai Kota Bandung</option>
                    <option value="taman_sekeloa">Taman Sekeloa</option>
                    <option value="kolam_retensi">Kolam Retensi Gedebage</option>
                    <option value="ruang_rapat_tengah">Ruang Rapat Tengah</option>
                </select>
            </div>
        </div>

        <div class="form-row-1">
            <div class="form-group">
                <label class="form-label">Detail Ruangan / Keterangan Tambahan</label>
                <textarea class="form-textarea" name="keterangan" placeholder="Contoh: Ruang Rapat Tengah, Lantai 2"></textarea>
            </div>
        </div>
    </div>

    {{-- Footer Buttons --}}
    <div class="form-footer">
        <button type="submit" name="action" value="draft" class="btn btn-secondary">Simpan Draft</button>
        <button type="submit" name="action" value="publish" class="btn btn-primary">Simpan &amp; Publikasikan</button>
    </div>
</div>

</form>
@endsection
