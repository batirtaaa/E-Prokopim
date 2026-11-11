@extends('layouts.app')
@section('title', isset($kegiatan) ? 'Edit Kegiatan Pimpinan — E-PROKOPIM' : 'Tambah Kegiatan Pimpinan — E-PROKOPIM')

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

/* Dokumentasi Tabs */
.dok-tab-nav {
    display: flex;
    gap: 0;
    border-bottom: 1px solid var(--border);
    margin-bottom: 20px;
}
.dok-tab-btn {
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-secondary);
    background: none;
    border: none;
    border-bottom: 2.5px solid transparent;
    cursor: pointer;
    margin-bottom: -1px;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 6px;
}
.dok-tab-btn:hover { color: var(--text-primary); }
.dok-tab-btn.active { color: #1e3a5f; font-weight: 600; border-bottom-color: #1e3a5f; }
.dok-tab-btn .tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 20px;
    font-size: 10.5px;
    font-weight: 700;
    background: #e5e7eb;
    color: #374151;
}
.dok-tab-btn.active .tab-badge { background: #1e3a5f; color: white; }

.dok-tab-pane { display: none; }
.dok-tab-pane.active { display: block; }

/* File Upload Area */
.file-drop-zone {
    border: 2px dashed var(--border);
    border-radius: 10px;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #fafafa;
    position: relative;
}
.file-drop-zone:hover, .file-drop-zone.dragging {
    border-color: #1e3a5f;
    background: #eff6ff;
}
.file-drop-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.file-drop-icon { margin-bottom: 8px; }
.file-drop-icon svg { width: 32px; height: 32px; color: #94a3b8; }
.file-drop-label { font-size: 13.5px; font-weight: 500; color: var(--text-primary); margin-bottom: 4px; }
.file-drop-hint { font-size: 11.5px; color: var(--text-muted); }

/* File Preview List */
.file-preview-list {
    margin-top: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.file-preview-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
}
.file-preview-item .file-icon { flex-shrink: 0; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
.file-preview-item .file-icon.foto { background: #dbeafe; color: #1e40af; }
.file-preview-item .file-icon.video { background: #fce7f3; color: #9d174d; }
.file-preview-item .file-icon.notulensi { background: #d1fae5; color: #065f46; }
.file-preview-item .file-name { flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--text-primary); font-weight: 500; }
.file-preview-item .file-size { font-size: 11.5px; color: var(--text-muted); flex-shrink: 0; }
.file-preview-item .file-remove { flex-shrink: 0; width: 20px; height: 20px; border: none; background: none; cursor: pointer; color: #ef4444; display: flex; align-items: center; justify-content: center; border-radius: 4px; }
.file-preview-item .file-remove:hover { background: #fee2e2; }

/* Keterangan dok */
.dok-keterangan-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
}
@media (max-width: 700px) { .dok-keterangan-row { grid-template-columns: 1fr; } }

/* Existing docs list */
.existing-docs {
    margin-bottom: 16px;
}
.existing-doc-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    font-size: 12.5px;
    margin-bottom: 6px;
}
.existing-doc-item .ed-name { flex: 1; color: #065f46; font-weight: 500; }
.existing-doc-item .ed-badge { font-size: 10.5px; padding: 2px 7px; border-radius: 10px; font-weight: 600; }
.ed-badge.foto { background: #dbeafe; color: #1e40af; }
.ed-badge.video { background: #fce7f3; color: #9d174d; }
.ed-badge.notulensi { background: #d1fae5; color: #065f46; }
.ed-del-btn { border: none; background: none; cursor: pointer; color: #ef4444; font-size: 11px; padding: 3px 8px; border-radius: 5px; }
.ed-del-btn:hover { background: #fee2e2; }

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

<form id="form-kegiatan" method="POST" action="{{ isset($kegiatan) ? route('kegiatan-pimpinan.update', $kegiatan) : route('kegiatan-pimpinan.store') }}" enctype="multipart/form-data">
@csrf
@if(isset($kegiatan))
    @method('PUT')
@endif

{{-- Section 1: Informasi Dasar --}}
<div class="form-card">
    <div class="form-card-section-title">Informasi Dasar</div>
    <div class="form-card-body">
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nomor Surat / Agenda <span class="required">*</span></label>
                <input type="text" class="form-input auto-generated" value="{{ old('nomor_agenda', $kegiatan->nomor_agenda ?? $nomorAgenda ?? 'AG-'.date('Ymd').'-001') }}" name="nomor_agenda" readonly>
                <span class="form-hint">Dihasilkan secara otomatis oleh sistem.</span>
            </div>
            @php
                $dinasList = [
                    'Dinas Pendidikan (Disdik)',
                    'Dinas Kesehatan (Dinkes)',
                    'Dinas Komunikasi dan Informatika (Diskominfo)',
                    'Dinas Perhubungan (Dishub)',
                    'Dinas Sumber Daya Air dan Bina Marga (DSDABM)',
                    'Dinas Cipta Karya, Bina Konstruksi dan Tata Ruang (Disciptabintar)',
                    'Dinas Perumahan dan Kawasan Permukiman (DPKP)',
                    'Dinas Sosial (Dinsos)',
                    'Dinas Tenaga Kerja (Disnaker)',
                    'Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)',
                    'Dinas Koperasi dan Usaha Kecil dan Menengah (KUKM)',
                    'Dinas Perdagangan dan Perindustrian (Disdagin)',
                    'Dinas Kebudayaan dan Pariwisata (Disbudpar)',
                    'Dinas Pemuda dan Olahraga (Dispora)',
                    'Dinas Ketahanan Pangan dan Pertanian (DKPP)',
                    'Dinas Lingkungan Hidup (DLH)',
                    'Dinas Pengendalian Penduduk dan KB (DPPKB)',
                    'Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A)',
                    'Dinas Kebakaran dan Penanggulangan Bencana (Diskar PB)',
                    'Dinas Penanaman Modal dan PTSP (DPMPTSP)',
                    'Dinas Perpustakaan dan Kearsipan (Dispusip)',
                    'Satuan Polisi Pamong Praja (Satpol PP)',
                    'Badan Perencanaan Pembangunan, Penelitian dan Pengembangan (Bappelitbang)',
                    'Badan Pendapatan Daerah (Bapenda)',
                    'Badan Keuangan dan Aset Daerah (BKAD)',
                    'Badan Kepegawaian dan Pengembangan SDM (BKPSDM)',
                    'Badan Kesatuan Bangsa dan Politik (Bakesbangpol)',
                    'Badan Penanggulangan Bencana Daerah (BPBD)',
                    'Inspektorat Daerah Kota Bandung',
                    'Sekretariat Daerah (Setda)',
                    'Sekretariat DPRD Kota Bandung',
                    'Bagian Protokol dan Komunikasi Pimpinan (Prokopim)',
                    'Bagian Tata Pemerintahan',
                    'Bagian Kesejahteraan Rakyat',
                    'Bagian Hukum',
                    'Bagian Perekonomian',
                    'Bagian Pengadaan Barang dan Jasa',
                    'Bagian Organisasi',
                    'Bagian Umum',
                    'Bagian Perencanaan dan Keuangan',
                    'Bagian Sumber Daya Alam',
                    'Kecamatan se-Kota Bandung',
                    'Kelurahan se-Kota Bandung',
                    'BUMD / Perumda Kota Bandung',
                    'Instansi Vertikal / Mitra Eksternal',
                ];

                $curLeading = old('leading_sektor', $kegiatan->leading_sektor ?? '');
                $customLeadingVal = old('leading_sektor_custom', '');
                $selectedLeading = '';
                $isLeadingCustom = false;

                if (!empty($curLeading)) {
                    if (in_array($curLeading, $dinasList)) {
                        $selectedLeading = $curLeading;
                    } else {
                        $selectedLeading = 'lainnya';
                        $isLeadingCustom = true;
                        if (empty($customLeadingVal)) {
                            $customLeadingVal = $curLeading;
                        }
                    }
                }
            @endphp
            <div class="form-group">
                <label class="form-label">Leading Sektor / Dinas Pengampu</label>
                <select class="form-select" name="leading_sektor" id="selectLeadingSektor" onchange="toggleLeadingCustom(this.value)">
                    <option value="">Pilih Dinas / OPD Pengampu...</option>
                    <optgroup label="Dinas Pemerintah Kota Bandung">
                        <option value="Dinas Pendidikan (Disdik)" {{ $selectedLeading === 'Dinas Pendidikan (Disdik)' ? 'selected' : '' }}>Dinas Pendidikan (Disdik)</option>
                        <option value="Dinas Kesehatan (Dinkes)" {{ $selectedLeading === 'Dinas Kesehatan (Dinkes)' ? 'selected' : '' }}>Dinas Kesehatan (Dinkes)</option>
                        <option value="Dinas Komunikasi dan Informatika (Diskominfo)" {{ $selectedLeading === 'Dinas Komunikasi dan Informatika (Diskominfo)' ? 'selected' : '' }}>Dinas Komunikasi dan Informatika (Diskominfo)</option>
                        <option value="Dinas Perhubungan (Dishub)" {{ $selectedLeading === 'Dinas Perhubungan (Dishub)' ? 'selected' : '' }}>Dinas Perhubungan (Dishub)</option>
                        <option value="Dinas Sumber Daya Air dan Bina Marga (DSDABM)" {{ $selectedLeading === 'Dinas Sumber Daya Air dan Bina Marga (DSDABM)' ? 'selected' : '' }}>Dinas Sumber Daya Air dan Bina Marga (DSDABM)</option>
                        <option value="Dinas Cipta Karya, Bina Konstruksi dan Tata Ruang (Disciptabintar)" {{ $selectedLeading === 'Dinas Cipta Karya, Bina Konstruksi dan Tata Ruang (Disciptabintar)' ? 'selected' : '' }}>Dinas Cipta Karya, Bina Konstruksi dan Tata Ruang (Disciptabintar)</option>
                        <option value="Dinas Perumahan dan Kawasan Permukiman (DPKP)" {{ $selectedLeading === 'Dinas Perumahan dan Kawasan Permukiman (DPKP)' ? 'selected' : '' }}>Dinas Perumahan dan Kawasan Permukiman (DPKP)</option>
                        <option value="Dinas Sosial (Dinsos)" {{ $selectedLeading === 'Dinas Sosial (Dinsos)' ? 'selected' : '' }}>Dinas Sosial (Dinsos)</option>
                        <option value="Dinas Tenaga Kerja (Disnaker)" {{ $selectedLeading === 'Dinas Tenaga Kerja (Disnaker)' ? 'selected' : '' }}>Dinas Tenaga Kerja (Disnaker)</option>
                        <option value="Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)" {{ $selectedLeading === 'Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)' ? 'selected' : '' }}>Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)</option>
                        <option value="Dinas Koperasi dan Usaha Kecil dan Menengah (KUKM)" {{ $selectedLeading === 'Dinas Koperasi dan Usaha Kecil dan Menengah (KUKM)' ? 'selected' : '' }}>Dinas Koperasi dan Usaha Kecil dan Menengah (KUKM)</option>
                        <option value="Dinas Perdagangan dan Perindustrian (Disdagin)" {{ $selectedLeading === 'Dinas Perdagangan dan Perindustrian (Disdagin)' ? 'selected' : '' }}>Dinas Perdagangan dan Perindustrian (Disdagin)</option>
                        <option value="Dinas Kebudayaan dan Pariwisata (Disbudpar)" {{ $selectedLeading === 'Dinas Kebudayaan dan Pariwisata (Disbudpar)' ? 'selected' : '' }}>Dinas Kebudayaan dan Pariwisata (Disbudpar)</option>
                        <option value="Dinas Pemuda dan Olahraga (Dispora)" {{ $selectedLeading === 'Dinas Pemuda dan Olahraga (Dispora)' ? 'selected' : '' }}>Dinas Pemuda dan Olahraga (Dispora)</option>
                        <option value="Dinas Ketahanan Pangan dan Pertanian (DKPP)" {{ $selectedLeading === 'Dinas Ketahanan Pangan dan Pertanian (DKPP)' ? 'selected' : '' }}>Dinas Ketahanan Pangan dan Pertanian (DKPP)</option>
                        <option value="Dinas Lingkungan Hidup (DLH)" {{ $selectedLeading === 'Dinas Lingkungan Hidup (DLH)' ? 'selected' : '' }}>Dinas Lingkungan Hidup (DLH)</option>
                        <option value="Dinas Pengendalian Penduduk dan KB (DPPKB)" {{ $selectedLeading === 'Dinas Pengendalian Penduduk dan KB (DPPKB)' ? 'selected' : '' }}>Dinas Pengendalian Penduduk dan KB (DPPKB)</option>
                        <option value="Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A)" {{ $selectedLeading === 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A)' ? 'selected' : '' }}>Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A)</option>
                        <option value="Dinas Kebakaran dan Penanggulangan Bencana (Diskar PB)" {{ $selectedLeading === 'Dinas Kebakaran dan Penanggulangan Bencana (Diskar PB)' ? 'selected' : '' }}>Dinas Kebakaran dan Penanggulangan Bencana (Diskar PB)</option>
                        <option value="Dinas Penanaman Modal dan PTSP (DPMPTSP)" {{ $selectedLeading === 'Dinas Penanaman Modal dan PTSP (DPMPTSP)' ? 'selected' : '' }}>Dinas Penanaman Modal dan PTSP (DPMPTSP)</option>
                        <option value="Dinas Perpustakaan dan Kearsipan (Dispusip)" {{ $selectedLeading === 'Dinas Perpustakaan dan Kearsipan (Dispusip)' ? 'selected' : '' }}>Dinas Perpustakaan dan Kearsipan (Dispusip)</option>
                        <option value="Satuan Polisi Pamong Praja (Satpol PP)" {{ $selectedLeading === 'Satuan Polisi Pamong Praja (Satpol PP)' ? 'selected' : '' }}>Satuan Polisi Pamong Praja (Satpol PP)</option>
                    </optgroup>
                    <optgroup label="Badan & Inspektorat">
                        <option value="Badan Perencanaan Pembangunan, Penelitian dan Pengembangan (Bappelitbang)" {{ $selectedLeading === 'Badan Perencanaan Pembangunan, Penelitian dan Pengembangan (Bappelitbang)' ? 'selected' : '' }}>Badan Perencanaan Pembangunan, Penelitian dan Pengembangan (Bappelitbang)</option>
                        <option value="Badan Pendapatan Daerah (Bapenda)" {{ $selectedLeading === 'Badan Pendapatan Daerah (Bapenda)' ? 'selected' : '' }}>Badan Pendapatan Daerah (Bapenda)</option>
                        <option value="Badan Keuangan dan Aset Daerah (BKAD)" {{ $selectedLeading === 'Badan Keuangan dan Aset Daerah (BKAD)' ? 'selected' : '' }}>Badan Keuangan dan Aset Daerah (BKAD)</option>
                        <option value="Badan Kepegawaian dan Pengembangan SDM (BKPSDM)" {{ $selectedLeading === 'Badan Kepegawaian dan Pengembangan SDM (BKPSDM)' ? 'selected' : '' }}>Badan Kepegawaian dan Pengembangan SDM (BKPSDM)</option>
                        <option value="Badan Kesatuan Bangsa dan Politik (Bakesbangpol)" {{ $selectedLeading === 'Badan Kesatuan Bangsa dan Politik (Bakesbangpol)' ? 'selected' : '' }}>Badan Kesatuan Bangsa dan Politik (Bakesbangpol)</option>
                        <option value="Badan Penanggulangan Bencana Daerah (BPBD)" {{ $selectedLeading === 'Badan Penanggulangan Bencana Daerah (BPBD)' ? 'selected' : '' }}>Badan Penanggulangan Bencana Daerah (BPBD)</option>
                        <option value="Inspektorat Daerah Kota Bandung" {{ $selectedLeading === 'Inspektorat Daerah Kota Bandung' ? 'selected' : '' }}>Inspektorat Daerah Kota Bandung</option>
                    </optgroup>
                    <optgroup label="Sekretariat & Bagian Setda">
                        <option value="Bagian Protokol dan Komunikasi Pimpinan (Prokopim)" {{ $selectedLeading === 'Bagian Protokol dan Komunikasi Pimpinan (Prokopim)' ? 'selected' : '' }}>Bagian Protokol dan Komunikasi Pimpinan (Prokopim)</option>
                        <option value="Bagian Tata Pemerintahan" {{ $selectedLeading === 'Bagian Tata Pemerintahan' ? 'selected' : '' }}>Bagian Tata Pemerintahan</option>
                        <option value="Bagian Kesejahteraan Rakyat" {{ $selectedLeading === 'Bagian Kesejahteraan Rakyat' ? 'selected' : '' }}>Bagian Kesejahteraan Rakyat</option>
                        <option value="Bagian Hukum" {{ $selectedLeading === 'Bagian Hukum' ? 'selected' : '' }}>Bagian Hukum</option>
                        <option value="Bagian Perekonomian" {{ $selectedLeading === 'Bagian Perekonomian' ? 'selected' : '' }}>Bagian Perekonomian</option>
                        <option value="Bagian Pengadaan Barang dan Jasa" {{ $selectedLeading === 'Bagian Pengadaan Barang dan Jasa' ? 'selected' : '' }}>Bagian Pengadaan Barang dan Jasa</option>
                        <option value="Bagian Organisasi" {{ $selectedLeading === 'Bagian Organisasi' ? 'selected' : '' }}>Bagian Organisasi</option>
                        <option value="Bagian Umum" {{ $selectedLeading === 'Bagian Umum' ? 'selected' : '' }}>Bagian Umum</option>
                        <option value="Bagian Perencanaan dan Keuangan" {{ $selectedLeading === 'Bagian Perencanaan dan Keuangan' ? 'selected' : '' }}>Bagian Perencanaan dan Keuangan</option>
                        <option value="Bagian Sumber Daya Alam" {{ $selectedLeading === 'Bagian Sumber Daya Alam' ? 'selected' : '' }}>Bagian Sumber Daya Alam</option>
                        <option value="Sekretariat Daerah (Setda)" {{ $selectedLeading === 'Sekretariat Daerah (Setda)' ? 'selected' : '' }}>Sekretariat Daerah (Setda)</option>
                        <option value="Sekretariat DPRD Kota Bandung" {{ $selectedLeading === 'Sekretariat DPRD Kota Bandung' ? 'selected' : '' }}>Sekretariat DPRD Kota Bandung</option>
                    </optgroup>
                    <optgroup label="Kewilayahan & Lainnya">
                        <option value="Kecamatan se-Kota Bandung" {{ $selectedLeading === 'Kecamatan se-Kota Bandung' ? 'selected' : '' }}>Kecamatan se-Kota Bandung</option>
                        <option value="Kelurahan se-Kota Bandung" {{ $selectedLeading === 'Kelurahan se-Kota Bandung' ? 'selected' : '' }}>Kelurahan se-Kota Bandung</option>
                        <option value="BUMD / Perumda Kota Bandung" {{ $selectedLeading === 'BUMD / Perumda Kota Bandung' ? 'selected' : '' }}>BUMD / Perumda Kota Bandung</option>
                        <option value="Instansi Vertikal / Mitra Eksternal" {{ $selectedLeading === 'Instansi Vertikal / Mitra Eksternal' ? 'selected' : '' }}>Instansi Vertikal / Mitra Eksternal</option>
                        <option value="lainnya" {{ $selectedLeading === 'lainnya' ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                    </optgroup>
                </select>
                <div id="leadingCustomWrapper" style="display: {{ $isLeadingCustom ? 'block' : 'none' }}; margin-top: 10px;">
                    <input type="text" class="form-input" name="leading_sektor_custom" id="inputLeadingCustom"
                           value="{{ $customLeadingVal }}"
                           placeholder="Ketik nama dinas / instansi pengampu..." {{ $isLeadingCustom ? 'required' : '' }}>
                </div>
                <span class="form-hint">Dinas, Badan, Bagian, atau Instansi yang menaungi acara.</span>
            </div>
        </div>

        <div class="form-row-1">
            <div class="form-group">
                <label class="form-label">Nama Kegiatan <span class="required">*</span></label>
                <input type="text" class="form-input" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->judul ?? '') }}" placeholder="Masukkan nama kegiatan" required>
            </div>
        </div>

        @php
            $selectedPimpinan = old('pimpinan', isset($kegiatan) ? (is_array($kegiatan->pimpinan) ? $kegiatan->pimpinan : []) : []);
        @endphp
        <div class="form-group">
            <label class="form-label">Pimpinan / Pelaksana Kegiatan <span class="required">*</span></label>
            <div class="checkbox-group">
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="wali_kota" {{ in_array('wali_kota', $selectedPimpinan) ? 'checked' : '' }}> Wali Kota (B1)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="wakil_wali_kota" {{ in_array('wakil_wali_kota', $selectedPimpinan) ? 'checked' : '' }}> Wakil Wali Kota (B2)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="sekda" {{ in_array('sekda', $selectedPimpinan) ? 'checked' : '' }}> Sekretaris Daerah (B3)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="pkk1" {{ in_array('pkk1', $selectedPimpinan) ? 'checked' : '' }}> Aryatri Benarto (PKK1)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="pkk2" {{ in_array('pkk2', $selectedPimpinan) ? 'checked' : '' }}> Fitriana Dewi (PKK2)
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="pimpinan[]" value="dwp" {{ in_array('dwp', $selectedPimpinan) ? 'checked' : '' }}> R. Dewi Pertiwi Zulkarnain (DWP)
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Section 2: Waktu & Lokasi --}}
<div class="form-card">
    <div class="form-card-section-title">Waktu &amp; Lokasi Pelaksanaan</div>
    <div class="form-card-body">
        <div class="form-row-2" style="margin-bottom:20px">
            <div class="form-group">
                <label class="form-label">Tanggal Pelaksanaan <span class="required">*</span></label>
                <input type="date" class="form-input" name="tanggal" value="{{ old('tanggal', isset($kegiatan) && $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('Y-m-d') : date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Waktu Pelaksanaan <span class="required">*</span></label>
                <div style="display:flex;align-items:center;gap:10px">
                    <input type="time" class="form-input" name="waktu_mulai" value="{{ old('waktu_mulai', isset($kegiatan) && $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('H:i') : '') }}" style="max-width:200px" required>
                    <span style="font-size:13.5px;font-weight:600;color:var(--text-secondary,#64748b);white-space:nowrap">s/d Selesai</span>
                </div>
            </div>
        </div>

        <div class="form-row-1">
            <div class="form-group">
                <label class="form-label">Lokasi <span class="required">*</span></label>
                @php 
                    $curLokasi = old('lokasi', $kegiatan->lokasi ?? ''); 
                    $selectedKey = '';
                    $isCustom = false;
                    if (in_array($curLokasi, ['pendopo', 'Pendopo Kota Bandung'])) {
                        $selectedKey = 'pendopo';
                    } elseif (in_array($curLokasi, ['balai_kota', 'Balai Kota Bandung'])) {
                        $selectedKey = 'balai_kota';
                    } elseif (in_array($curLokasi, ['gedung_dprd', 'Gedung DPRD Kota Bandung'])) {
                        $selectedKey = 'gedung_dprd';
                    } elseif (!empty($curLokasi)) {
                        $selectedKey = 'lainnya';
                        $isCustom = true;
                    }
                @endphp
                <select class="form-select" name="lokasi" id="selectLokasi" onchange="toggleLokasiCustom(this.value)" required>
                    <option value="">Pilih atau cari lokasi...</option>
                    <option value="pendopo" {{ $selectedKey === 'pendopo' ? 'selected' : '' }}>Pendopo Kota Bandung</option>
                    <option value="balai_kota" {{ $selectedKey === 'balai_kota' ? 'selected' : '' }}>Balai Kota Bandung</option>
                    <option value="gedung_dprd" {{ $selectedKey === 'gedung_dprd' ? 'selected' : '' }}>Gedung DPRD Kota Bandung</option>
                    <option value="lainnya" {{ $selectedKey === 'lainnya' ? 'selected' : '' }}>Lokasi Lainnya (Ketik Manual)</option>
                </select>
                <div id="lokasiCustomWrapper" style="display: {{ $isCustom ? 'block' : 'none' }}; margin-top: 10px;">
                    <input type="text" class="form-input" name="lokasi_custom" id="inputLokasiCustom" 
                           value="{{ old('lokasi_custom', $isCustom ? $curLokasi : '') }}" 
                           placeholder="Ketik nama lokasi..." {{ $isCustom ? 'required' : '' }}>
                </div>
            </div>
        </div>

        <div class="form-row-1">
            <div class="form-group">
                <label class="form-label">Detail Ruangan / Keterangan Tambahan</label>
                <textarea class="form-textarea" name="keterangan" placeholder="Contoh: Ruang Rapat Tengah, Lantai 2">{{ old('keterangan', $kegiatan->deskripsi ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Footer Buttons --}}
    <div class="form-footer">
        <button type="submit" name="action" value="draft" class="btn btn-secondary">Simpan Draft</button>
        <button type="submit" name="action" value="publish" class="btn btn-primary">Simpan &amp; Publikasikan</button>
    </div>
</div>

{{-- Section 3: Dokumentasi Kegiatan --}}
<div class="form-card" id="card-dokumentasi">
    <div class="form-card-section-title" style="display:flex;align-items:center;justify-content:space-between">
        <span>Dokumentasi Kegiatan</span>
        <span style="font-size:12px;font-weight:400;color:var(--text-muted)">Opsional — dapat ditambahkan setelah kegiatan berlangsung</span>
    </div>
    <div class="form-card-body">

        {{-- Banner Rekomendasi Standar ISO Penamaan File --}}
        <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:9px 12px;margin-bottom:14px;font-size:12px;color:#0369a1;display:flex;align-items:flex-start;gap:8px;line-height:1.45;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;flex-shrink:0;margin-top:2px;color:#0284c7;"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
            <div>
                <strong style="color:#0c4a6e;">Standar ISO Penamaan File:</strong> Format penamaan foto &amp; dokumen disarankan <code>Tanggal_Bulan_Tahun_Nama Kegiatan</code> (contoh: <code>11_11_2026_Nama_Kegiatan.jpg</code>). Sistem otomatis menerapkan penamaan standar ini saat disimpan.
            </div>
        </div>

        {{-- Tabs --}}
        <div class="dok-tab-nav">
            <button type="button" class="dok-tab-btn active" onclick="switchDokTab('foto', this)" id="tab-btn-foto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                Foto
                <span class="tab-badge" id="badge-foto">0</span>
            </button>
            <button type="button" class="dok-tab-btn" onclick="switchDokTab('video', this)" id="tab-btn-video">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                Video
                <span class="tab-badge" id="badge-video">0</span>
            </button>
            <button type="button" class="dok-tab-btn" onclick="switchDokTab('notulensi', this)" id="tab-btn-notulensi">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                Notulensi
                <span class="tab-badge" id="badge-notulensi">0</span>
            </button>
        </div>

        {{-- ========== TAB: FOTO ========== --}}
        <div class="dok-tab-pane active" id="pane-foto">

            @if(isset($kegiatan) && $kegiatan->galeriArsip->where('tipe','foto')->count() > 0)
            <div class="existing-docs">
                <div style="font-size:12.5px;font-weight:600;color:#065f46;margin-bottom:8px;">📁 Foto yang sudah tersimpan:</div>
                @foreach($kegiatan->galeriArsip->where('tipe','foto') as $doc)
                <div class="existing-doc-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3b82f6" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                    <span class="ed-name">{{ $doc->judul }} {{ $doc->file_name ? '(' . $doc->file_name . ')' : '' }}</span>
                    <span class="ed-badge foto">Foto</span>
                    <a href="{{ route('galeri-arsip.index', ['tab' => 'foto', 'kegiatan' => $kegiatan->id]) }}" target="_blank" style="font-size:11px;color:#1e40af;text-decoration:none;">Lihat →</a>
                </div>
                @endforeach
            </div>
            @endif

            <div class="file-drop-zone" id="dropFoto" onclick="document.getElementById('inputFoto').click()">
                <input type="file" id="inputFoto" name="dok_foto[]" accept="image/jpeg,image/png,image/webp" multiple onchange="handleFileSelect('foto', this.files)" style="display:none">
                <div class="file-drop-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="#94a3b8"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                </div>
                <div class="file-drop-label">Klik untuk unggah Foto Kegiatan</div>
                <div class="file-drop-hint">Format: JPG, PNG, WebP &bull; Bisa pilih banyak file sekaligus</div>
            </div>
            <div class="file-preview-list" id="preview-foto"></div>

            <div class="dok-keterangan-row">
                <div class="form-group">
                    <label class="form-label">Judul / Keterangan Foto</label>
                    <input type="text" class="form-input" name="dok_foto_judul" id="dok_foto_judul" placeholder="Contoh: Foto Kegiatan Rapat Koordinasi">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Foto (total)</label>
                    <input type="number" class="form-input" name="dok_foto_jumlah" id="dok_foto_jumlah" placeholder="Contoh: 25" min="1">
                </div>
            </div>
        </div>

        {{-- ========== TAB: VIDEO ========== --}}
        <div class="dok-tab-pane" id="pane-video">

            @if(isset($kegiatan) && $kegiatan->galeriArsip->where('tipe','video')->count() > 0)
            <div class="existing-docs">
                <div style="font-size:12.5px;font-weight:600;color:#065f46;margin-bottom:8px;">📁 Video yang sudah tersimpan:</div>
                @foreach($kegiatan->galeriArsip->where('tipe','video') as $doc)
                <div class="existing-doc-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ec4899" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                    <span class="ed-name">{{ $doc->judul }} {{ $doc->file_name ? '(' . $doc->file_name . ')' : '' }}</span>
                    <span class="ed-badge video">Video</span>
                    <a href="{{ route('galeri-arsip.index', ['tab' => 'video', 'kegiatan' => $kegiatan->id]) }}" target="_blank" style="font-size:11px;color:#9d174d;text-decoration:none;">Lihat →</a>
                </div>
                @endforeach
            </div>
            @endif

            <div class="file-drop-zone" id="dropVideo" onclick="document.getElementById('inputVideo').click()">
                <input type="file" id="inputVideo" name="dok_video[]" accept="video/mp4,video/quicktime,video/x-msvideo" multiple onchange="handleFileSelect('video', this.files)" style="display:none">
                <div class="file-drop-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="#94a3b8"><path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                </div>
                <div class="file-drop-label">Klik untuk unggah Video Kegiatan</div>
                <div class="file-drop-hint">Format: MP4, MOV, AVI &bull; Bisa pilih banyak file sekaligus</div>
            </div>
            <div class="file-preview-list" id="preview-video"></div>

            <div class="dok-keterangan-row">
                <div class="form-group">
                    <label class="form-label">Judul / Keterangan Video</label>
                    <input type="text" class="form-input" name="dok_video_judul" id="dok_video_judul" placeholder="Contoh: Rekaman Rapat Koordinasi OPD">
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" class="form-input" name="dok_video_durasi" id="dok_video_durasi" placeholder="Contoh: 45" min="1">
                </div>
            </div>
        </div>

        {{-- ========== TAB: NOTULENSI ========== --}}
        <div class="dok-tab-pane" id="pane-notulensi">

            @if(isset($kegiatan) && $kegiatan->galeriArsip->where('tipe','notulensi')->count() > 0)
            <div class="existing-docs">
                <div style="font-size:12.5px;font-weight:600;color:#065f46;margin-bottom:8px;">📁 Notulensi yang sudah tersimpan:</div>
                @foreach($kegiatan->galeriArsip->where('tipe','notulensi') as $doc)
                <div class="existing-doc-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    <span class="ed-name">{{ $doc->judul }} {{ $doc->file_name ? '(' . $doc->file_name . ')' : '' }}</span>
                    <span class="ed-badge notulensi">Notulensi</span>
                    <a href="{{ route('galeri-arsip.index', ['tab' => 'notulensi', 'kegiatan' => $kegiatan->id]) }}" target="_blank" style="font-size:11px;color:#065f46;text-decoration:none;">Lihat →</a>
                </div>
                @endforeach
            </div>
            @endif

            <div class="file-drop-zone" id="dropNotulensi" onclick="document.getElementById('inputNotulensi').click()">
                <input type="file" id="inputNotulensi" name="dok_notulensi[]" accept=".pdf,.doc,.docx,.ppt,.pptx" multiple onchange="handleFileSelect('notulensi', this.files)" style="display:none">
                <div class="file-drop-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="#94a3b8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                </div>
                <div class="file-drop-label">Klik untuk unggah Notulensi / Dokumen</div>
                <div class="file-drop-hint">Format: PDF, Word (.doc, .docx), PowerPoint (.ppt, .pptx)</div>
            </div>
            <div class="file-preview-list" id="preview-notulensi"></div>

            <div class="form-row-1" style="margin-top:16px">
                <div class="form-group">
                    <label class="form-label">Judul / Keterangan Notulensi</label>
                    <input type="text" class="form-input" name="dok_notulensi_judul" id="dok_notulensi_judul" placeholder="Contoh: Notulensi Rapat Koordinasi OPD — Oktober 2026">
                </div>
            </div>
        </div>

    </div>
    {{-- Footer Buttons bawah --}}
    <div class="form-footer">
        <button type="submit" form="form-kegiatan" name="action" value="draft" class="btn btn-secondary">Simpan Draft</button>
        <button type="submit" form="form-kegiatan" name="action" value="publish" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" /></svg>
            Simpan &amp; Publikasikan
        </button>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
function toggleLokasiCustom(val) {
    const wrap = document.getElementById('lokasiCustomWrapper');
    const input = document.getElementById('inputLokasiCustom');
    if (wrap && input) {
        if (val === 'lainnya') {
            wrap.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            wrap.style.display = 'none';
            input.required = false;
        }
    }
}

function toggleLeadingCustom(val) {
    const wrap = document.getElementById('leadingCustomWrapper');
    const input = document.getElementById('inputLeadingCustom');
    if (wrap && input) {
        if (val === 'lainnya') {
            wrap.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            wrap.style.display = 'none';
            input.required = false;
        }
    }
}

// =============================================
// Dokumentasi Tabs
// =============================================
const dokFilesMap = { foto: [], video: [], notulensi: [] };

function switchDokTab(tab, btn) {
    document.querySelectorAll('.dok-tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.dok-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('pane-' + tab).classList.add('active');
    btn.classList.add('active');
}

function handleFileSelect(tipe, files) {
    if (!files || files.length === 0) return;
    Array.from(files).forEach(f => {
        if (!dokFilesMap[tipe].find(x => x.name === f.name && x.size === f.size)) {
            dokFilesMap[tipe].push(f);
        }
    });
    renderPreview(tipe);
    updateBadge(tipe);
    rebuildFileInput(tipe);
}

function renderPreview(tipe) {
    const list = document.getElementById('preview-' + tipe);
    list.innerHTML = '';
    dokFilesMap[tipe].forEach((f, idx) => {
        const ext = f.name.split('.').pop().toLowerCase();
        const iconClass = tipe;
        const size = f.size < 1024 * 1024
            ? (f.size / 1024).toFixed(1) + ' KB'
            : (f.size / 1024 / 1024).toFixed(1) + ' MB';
        const item = document.createElement('div');
        item.className = 'file-preview-item';
        item.innerHTML = `
            <span class="file-icon ${iconClass}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            </span>
            <span class="file-name" title="${f.name}">${f.name}</span>
            <span class="file-size">${size}</span>
            <button type="button" class="file-remove" onclick="removeFile('${tipe}', ${idx})" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        `;
        list.appendChild(item);
    });
}

function removeFile(tipe, idx) {
    dokFilesMap[tipe].splice(idx, 1);
    renderPreview(tipe);
    updateBadge(tipe);
    rebuildFileInput(tipe);
}

function updateBadge(tipe) {
    const badge = document.getElementById('badge-' + tipe);
    if (badge) badge.textContent = dokFilesMap[tipe].length;
}

function rebuildFileInput(tipe) {
    const inputId = 'input' + tipe.charAt(0).toUpperCase() + tipe.slice(1);
    const originalInput = document.getElementById(inputId);
    if (!originalInput) return;
    // Build a DataTransfer to sync the file input
    const dt = new DataTransfer();
    dokFilesMap[tipe].forEach(f => dt.items.add(f));
    originalInput.files = dt.files;
}

// Drag & Drop
['Foto', 'Video', 'Notulensi'].forEach(t => {
    const tLow = t.toLowerCase();
    const zone = document.getElementById('drop' + t);
    if (!zone) return;
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragging'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('dragging'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('dragging');
        handleFileSelect(tLow, e.dataTransfer.files);
    });
});
</script>
@endpush
