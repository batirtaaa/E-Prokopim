@extends('layouts.app')
@section('title', 'Edit Analisis Isu & Media — E-PROKOPIM')

@push('styles')
<style>
/* Header & Breadcrumbs */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 22px;
}
.page-header-left h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.page-header-left p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

/* Two-column form grid */
.form-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
@media (max-width: 1024px) {
    .form-2col { grid-template-columns: 1fr; }
}

/* Form Card */
.form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: column;
}
.form-card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
}
.form-card-title svg { width: 17px; height: 17px; color: #1e3a5f; }
.form-card-body {
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    flex: 1;
}

/* Form Fields */
.form-group {
    display: flex;
    flex-direction: column;
}
.form-group .form-label,
.form-group label.form-label {
    text-transform: none !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #334155 !important;
    letter-spacing: 0 !important;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.form-label .req { color: #ef4444; }
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
@media (max-width: 640px) {
    .form-row-2 { grid-template-columns: 1fr; }
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    outline: none;
    transition: all 0.15s ease;
    font-family: inherit;
    box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
}
.form-input::placeholder, .form-textarea::placeholder { color: #94a3b8; }
.form-textarea { resize: vertical; min-height: 95px; line-height: 1.5; }
.form-select {
    appearance: none;
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 15px;
    padding-right: 36px;
}

/* Radio Pill Group for Media */
.pill-radio-group {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}
.pill-radio-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
    text-align: center;
}
.pill-radio-label input[type="radio"] { display: none; }
.pill-radio-label:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}
.pill-radio-label.active-sosial {
    background: #eef2ff;
    border-color: #6366f1;
    color: #4338ca;
    font-weight: 600;
}
.pill-radio-label.active-online {
    background: #f0f9ff;
    border-color: #0284c7;
    color: #0369a1;
    font-weight: 600;
}
.pill-radio-label.active-cetak {
    background: #fffbeb;
    border-color: #d97706;
    color: #b45309;
    font-weight: 600;
}

/* Radio Pill Group for Sentimen */
.sentiment-radio-group {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}
.sentiment-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
}
.sentiment-label input[type="radio"] { display: none; }
.sentiment-label:hover { border-color: #cbd5e1; background: #f8fafc; }
.sentiment-label.active-positif {
    background: #ecfdf5;
    border-color: #10b981;
    color: #047857;
}
.sentiment-label.active-negatif {
    background: #fef2f2;
    border-color: #ef4444;
    color: #b91c1c;
}
.sentiment-label.active-netral {
    background: #f1f5f9;
    border-color: #64748b;
    color: #334155;
}

/* Footer Actions */
.form-footer-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.btn-cancel {
    padding: 10px 20px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    font-size: 13.5px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
}
.btn-cancel:hover { background: #f1f5f9; color: #0f172a; }
.btn-submit {
    padding: 10px 22px;
    border: 1px solid #1e3a5f;
    border-radius: 8px;
    background: #1e3a5f;
    font-size: 13.5px;
    font-weight: 600;
    color: #ffffff;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.15s;
    box-shadow: 0 2px 4px rgba(30, 58, 95, 0.15);
}
.btn-submit:hover {
    background: #162f4f;
    box-shadow: 0 4px 8px rgba(30, 58, 95, 0.2);
}
.btn-submit svg { width: 16px; height: 16px; }

.input-error {
    font-size: 11.5px;
    color: #dc2626;
    margin-top: 4px;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div class="page-header-left">
        <h1>Edit Analisis Isu &amp; Media</h1>
        <p>Perbarui informasi pemetaan, uraian telaahan, atau rekomendasi pimpinan.</p>
    </div>
</div>

<form method="POST" action="{{ route('analisis.update', $analisi->id) }}">
@csrf
@method('PUT')

<div class="form-2col">
    {{-- SISI KIRI: 1. Informasi & Pemetaan Isu --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            1. Informasi &amp; Pemetaan Isu
        </div>
        <div class="form-card-body">
            {{-- Judul Isu --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Judul Isu <span class="req">*</span></span>
                </label>
                <input type="text" class="form-input" name="judul" value="{{ old('judul', $analisi->judul) }}" placeholder="Contoh: Penertiban Pedagang Kaki Lima di Kawasan Alun-Alun" required autofocus>
                @error('judul') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Hari/Tanggal & Sumber Isu --}}
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">
                        <span>Hari / Tanggal <span class="req">*</span></span>
                    </label>
                    <input type="date" class="form-input" name="tanggal" value="{{ old('tanggal', $analisi->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span>Sumber Isu <span class="req">*</span></span>
                    </label>
                    <input type="text" class="form-input" name="sumber_isu" value="{{ old('sumber_isu', $analisi->sumber_isu) }}" placeholder="Contoh: Instagram @humas_bandung / Detik" required>
                    @error('sumber_isu') <div class="input-error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Jenis Media --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Jenis Media <span class="req">*</span></span>
                </label>
                <div class="pill-radio-group">
                    <label class="pill-radio-label {{ old('jenis_media', $analisi->jenis_media) === 'Sosial' ? 'active-sosial' : '' }}" onclick="selectMedia(this, 'Sosial')">
                        <input type="radio" name="jenis_media" value="Sosial" {{ old('jenis_media', $analisi->jenis_media) === 'Sosial' ? 'checked' : '' }} required>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/></svg>
                        Media Sosial
                    </label>
                    <label class="pill-radio-label {{ old('jenis_media', $analisi->jenis_media) === 'Online' ? 'active-online' : '' }}" onclick="selectMedia(this, 'Online')">
                        <input type="radio" name="jenis_media" value="Online" {{ old('jenis_media', $analisi->jenis_media) === 'Online' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                        Media Online
                    </label>
                    <label class="pill-radio-label {{ old('jenis_media', $analisi->jenis_media) === 'Cetak' ? 'active-cetak' : '' }}" onclick="selectMedia(this, 'Cetak')">
                        <input type="radio" name="jenis_media" value="Cetak" {{ old('jenis_media', $analisi->jenis_media) === 'Cetak' ? 'checked' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                        Media Cetak
                    </label>
                </div>
                @error('jenis_media') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Leading Sector --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Leading Sector <span class="req">*</span></span>
                </label>
                <input list="leadingSectorsList" class="form-input" name="leading_sector" value="{{ old('leading_sector', $analisi->leading_sector) }}" placeholder="Pilih atau ketik nama dinas/bagian..." required>
                <datalist id="leadingSectorsList">
                    @foreach($suggestedLeadingSectors as $sector)
                    <option value="{{ $sector }}"></option>
                    @endforeach
                </datalist>
                @error('leading_sector') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Sentimen Isu --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Sentimen Isu <span class="req">*</span></span>
                </label>
                <div class="sentiment-radio-group">
                    <label class="sentiment-label {{ old('sentimen', $analisi->sentimen) === 'Positif' ? 'active-positif' : '' }}" onclick="selectSentimen(this, 'Positif')">
                        <input type="radio" name="sentimen" value="Positif" {{ old('sentimen', $analisi->sentimen) === 'Positif' ? 'checked' : '' }} required>
                        Positif
                    </label>
                    <label class="sentiment-label {{ old('sentimen', $analisi->sentimen) === 'Netral' ? 'active-netral' : '' }}" onclick="selectSentimen(this, 'Netral')">
                        <input type="radio" name="sentimen" value="Netral" {{ old('sentimen', $analisi->sentimen) === 'Netral' ? 'checked' : '' }}>
                        Netral
                    </label>
                    <label class="sentiment-label {{ old('sentimen', $analisi->sentimen) === 'Negatif' ? 'active-negatif' : '' }}" onclick="selectSentimen(this, 'Negatif')">
                        <input type="radio" name="sentimen" value="Negatif" {{ old('sentimen', $analisi->sentimen) === 'Negatif' ? 'checked' : '' }}>
                        Negatif
                    </label>
                </div>
                @error('sentimen') <div class="input-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- SISI KANAN: 2. Telaahan Analisis & Rekomendasi --}}
    <div class="form-card">
        <div class="form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 6"/></svg>
            2. Telaahan Analisis &amp; Rekomendasi
        </div>
        <div class="form-card-body">
            {{-- Analisis --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Uraian Analisis Isu <span class="req">*</span></span>
                </label>
                <textarea class="form-textarea" name="analisis" style="min-height:95px" placeholder="Jelaskan deskripsi telaahan, fakta di lapangan, dinamika percakapan publik, dan potensi implikasi terhadap citra pimpinan/pemerintah kota..." required>{{ old('analisis', $analisi->analisis) }}</textarea>
                @error('analisis') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Rekomendasi Kebijakan --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Rekomendasi Kebijakan <span class="req">*</span></span>
                </label>
                <textarea class="form-textarea" name="rekomendasi_kebijakan" style="min-height:85px" placeholder="Tuliskan rekomendasi langkah kebijakan teknis untuk Pimpinan dan OPD terkait..." required>{{ old('rekomendasi_kebijakan', $analisi->rekomendasi_kebijakan) }}</textarea>
                @error('rekomendasi_kebijakan') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Rekomendasi Publikasi --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Rekomendasi Publikasi <span class="req">*</span></span>
                </label>
                <textarea class="form-textarea" name="rekomendasi_publikasi" style="min-height:85px" placeholder="Tuliskan strategi publikasi, penyiapan rilis klarifikasi, infografis fakta, atau narasi komunikasi publik..." required>{{ old('rekomendasi_publikasi', $analisi->rekomendasi_publikasi) }}</textarea>
                @error('rekomendasi_publikasi') <div class="input-error">{{ $message }}</div> @enderror
            </div>

            {{-- Link Sumber Berita (Opsional) --}}
            <div class="form-group">
                <label class="form-label">
                    <span>Link Sumber Berita (Opsional)</span>
                </label>
                <input type="url" class="form-input" name="link_sumber" value="{{ old('link_sumber', $analisi->link_sumber) }}" placeholder="https://instagram.com/p/... atau https://news.detik.com/...">
                @error('link_sumber') <div class="input-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

{{-- Footer Actions --}}
<div class="form-footer-card">
    <a href="{{ route('analisis.show', $analisi->id) }}" class="btn-cancel">Batal</a>
    <button type="submit" class="btn-submit">
        Simpan Analisis
    </button>
</div>

</form>

@endsection

@push('scripts')
<script>
function selectMedia(labelEl, type) {
    document.querySelectorAll('.pill-radio-label').forEach(el => {
        el.className = 'pill-radio-label';
    });
    labelEl.classList.add('active-' + type.toLowerCase());
}

function selectSentimen(labelEl, type) {
    document.querySelectorAll('.sentiment-label').forEach(el => {
        el.className = 'sentiment-label';
    });
    labelEl.classList.add('active-' + type.toLowerCase());
}
</script>
@endpush
