@extends('layouts.app')
@section('title', 'Buat Penugasan Baru — E-PROKOPIM')

@push('styles')
<style>
/* Base Container */
.pn-create-container {
    max-width: 900px;
    margin: 0 auto;
    color: #1e293b;
    font-family: inherit;
}

/* Page Header */
.pn-create-header {
    margin-bottom: 24px;
}
.pn-create-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0 0 4px 0;
}
.pn-create-subtitle {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

/* Form Main Card */
.pn-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    padding: 28px 32px;
}

/* Section Header */
.pn-form-section {
    margin-bottom: 28px;
}
.pn-form-section:last-of-type {
    margin-bottom: 20px;
}
.pn-section-title-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
}
.pn-section-icon {
    width: 17px;
    height: 17px;
    color: #2563eb;
    flex-shrink: 0;
}

/* Form Layout Grid */
.pn-form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 640px) {
    .pn-form-row-2 {
        grid-template-columns: 1fr;
    }
}
.pn-form-group {
    margin-bottom: 16px;
}
.pn-form-group:last-child {
    margin-bottom: 0;
}

/* Form Controls */
.pn-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.pn-label .req {
    color: #ef4444;
}
.pn-input-control, .pn-select-control, .pn-textarea-control {
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
.pn-input-control:focus, .pn-select-control:focus, .pn-textarea-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pn-select-control {
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 13px;
    appearance: none;
    cursor: pointer;
}
.pn-input-control::placeholder, .pn-textarea-control::placeholder {
    color: #94a3b8;
}
.pn-hint {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 5px;
}

/* Personel Multi-Tag Interactive Input */
.pn-tags-container {
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 5px 8px;
    background: #ffffff;
    min-height: 42px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    position: relative;
    cursor: text;
    transition: all 0.15s ease;
}
.pn-tags-container.focused {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.pn-tag-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    padding: 3px 8px 3px 4px;
    font-size: 12px;
    font-weight: 500;
    color: #1e40af;
    user-select: none;
}
.pn-tag-chip-av {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #3b82f6;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
}
.pn-tag-chip-remove {
    background: none;
    border: none;
    color: #93c5fd;
    cursor: pointer;
    font-size: 14px;
    line-height: 1;
    padding: 0;
    display: flex;
    align-items: center;
    margin-left: 2px;
}
.pn-tag-chip-remove:hover {
    color: #1e40af;
}
.pn-tags-search-input {
    border: none;
    outline: none;
    font-size: 13px;
    color: #1e293b;
    flex: 1;
    min-width: 130px;
    padding: 4px;
    background: transparent;
    font-family: inherit;
}
.pn-tags-search-input::placeholder {
    color: #94a3b8;
}

/* Personel Autocomplete Popover */
.pn-personel-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    max-height: 220px;
    overflow-y: auto;
    z-index: 100;
    display: none;
    padding: 4px;
}
.pn-personel-dropdown.is-open {
    display: block;
}
.pn-personel-opt-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.1s ease;
}
.pn-personel-opt-item:hover {
    background: #f1f5f9;
}
.pn-personel-opt-left {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pn-personel-opt-av {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #3b82f6;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
}
.pn-personel-opt-name {
    font-size: 12.5px;
    font-weight: 500;
    color: #0f172a;
}
.pn-personel-opt-job {
    font-size: 11.5px;
    color: #64748b;
}
.pn-personel-opt-status {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.pn-personel-opt-status.standby { color: #16a34a; }
.pn-personel-opt-status.bertugas { color: #dc2626; }
.pn-personel-opt-status.cuti { color: #94a3b8; }

/* Standby counter indicator */
.pn-standby-pill-note {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #16a34a;
    font-weight: 500;
    margin-top: 6px;
}
.pn-standby-pill-note::before {
    content: '●';
    font-size: 9px;
    color: #16a34a;
}

/* Bottom Action Buttons */
.pn-form-actions-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
}
.pn-btn-batal {
    padding: 9px 20px;
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
.pn-btn-batal:hover {
    border-color: #94a3b8;
    color: #0f172a;
}
.pn-btn-submit {
    padding: 9px 22px;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
    background: #0f2942;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.15s ease;
}
.pn-btn-submit:hover {
    background: #081d30;
}
</style>
@endpush

@section('content')
<div class="pn-create-container">

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

    {{-- Page Header --}}
    <div class="pn-create-header">
        <h1 class="pn-create-title">Buat Penugasan Baru</h1>
        <p class="pn-create-subtitle">Isi formulir di bawah ini untuk menugaskan personel ke agenda pimpinan.</p>
    </div>

    {{-- Form Container Card --}}
    <div class="pn-form-card">
        <form method="POST" action="{{ route('protokol-pimpinan.penugasan.store') }}" id="pnCreateForm">
            @csrf

            {{-- SECTION 1: Informasi Kegiatan --}}
            <div class="pn-form-section">
                <div class="pn-section-title-wrap">
                    <svg class="pn-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span>Informasi Kegiatan</span>
                </div>

                <div class="pn-form-group">
                    <label class="pn-label">Pilih Kegiatan <span class="req">*</span></label>
                    <select name="kegiatan_id" class="pn-select-control" required>
                        <option value="">Pilih agenda pimpinan...</option>
                        @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}" {{ old('kegiatan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->judul }} ({{ $k->tanggal_mulai ? $k->tanggal_mulai->format('d M Y, H:i') : '' }} WIB) — {{ $k->lokasi }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pn-hint">Kegiatan harus sudah terdaftar di modul 'Kegiatan Pimpinan'.</div>
                </div>
            </div>

            {{-- SECTION 2: Detail Penugasan --}}
            <div class="pn-form-section">
                <div class="pn-section-title-wrap">
                    <svg class="pn-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Detail Penugasan</span>
                </div>

                <div class="pn-form-row-2">
                    <div class="pn-form-group">
                        <label class="pn-label">Kategori Tugas <span class="req">*</span></label>
                        <select name="kategori_tugas" id="pnKategoriSelect" class="pn-select-control" onchange="handleKategoriChange()">
                            <option value="">Pilih kategori...</option>
                            <option value="Protokol" {{ old('kategori_tugas') == 'Protokol' ? 'selected' : '' }}>Protokol</option>
                            <option value="Komunikasi Pimpinan" {{ old('kategori_tugas') == 'Komunikasi Pimpinan' ? 'selected' : '' }}>Komunikasi Pimpinan</option>
                            <option value="Dokumentasi" {{ old('kategori_tugas') == 'Dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                        </select>
                    </div>

                    <div class="pn-form-group">
                        <label class="pn-label">Peran / Jobdesk <span class="req">*</span></label>
                        <select name="peran" id="pnPeranSelect" class="pn-select-control" required>
                            <option value="">Pilih peran...</option>
                            <option value="Protokol" {{ old('peran') == 'Protokol' ? 'selected' : '' }}>Protokol</option>
                            <option value="MC" {{ old('peran') == 'MC' ? 'selected' : '' }}>MC</option>
                            <option value="Fotografer" {{ old('peran') == 'Fotografer' ? 'selected' : '' }}>Fotografer</option>
                            <option value="Videografer" {{ old('peran') == 'Videografer' ? 'selected' : '' }}>Videografer</option>
                            <option value="Notulis" {{ old('peran') == 'Notulis' ? 'selected' : '' }}>Notulis</option>
                            <option value="Dokumentasi" {{ old('peran') == 'Dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                            <option value="Lainnya" {{ old('peran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="pn-form-group">
                    <label class="pn-label">Personel yang Ditugaskan <span class="req">*</span></label>
                    
                    {{-- Tag Chip Interactive Multi-select Input --}}
                    <div class="pn-tags-container" id="pnTagsContainer" onclick="focusSearchInput(event)">
                        {{-- Render Selected Chips --}}
                        <div id="pnChipsList" style="display:flex; flex-wrap:wrap; gap:6px; align-items:center;">
                            {{-- Initial default sample if none selected --}}
                            @if(old('personel_ids'))
                                @foreach(old('personel_ids') as $oldId)
                                    @php $pObj = $personelList->firstWhere('id', $oldId); @endphp
                                    @if($pObj)
                                        <div class="pn-tag-chip" data-id="{{ $pObj->id }}">
                                            <span class="pn-tag-chip-av">{{ $pObj->initials }}</span>
                                            <span>{{ $pObj->nama_lengkap }}</span>
                                            <button type="button" class="pn-tag-chip-remove" onclick="removePersonelChip({{ $pObj->id }}, event)">&times;</button>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <input type="text" id="pnSearchPersonelInput" class="pn-tags-search-input" placeholder="Cari nama personel..." oninput="filterPersonelDropdown()" onfocus="openPersonelDropdown()">

                        {{-- Hidden inputs container for form submit --}}
                        <div id="pnHiddenInputsContainer">
                            @if(old('personel_ids'))
                                @foreach(old('personel_ids') as $oldId)
                                    <input type="hidden" name="personel_ids[]" value="{{ $oldId }}" id="hidden-personel-{{ $oldId }}">
                                @endforeach
                            @endif
                        </div>

                        {{-- Autocomplete dropdown popover --}}
                        <div class="pn-personel-dropdown" id="pnPersonelDropdown">
                            @foreach($personelList as $p)
                            @php
                                $st = strtolower($p->status_ketersediaan ?? 'standby');
                            @endphp
                            <div class="pn-personel-opt-item" 
                                 data-id="{{ $p->id }}" 
                                 data-name="{{ $p->nama_lengkap }}" 
                                 data-initials="{{ $p->initials }}" 
                                 data-job="{{ $p->jabatan }}"
                                 onclick="addPersonelChip({{ $p->id }}, '{{ addslashes($p->nama_lengkap) }}', '{{ $p->initials }}')">
                                <div class="pn-personel-opt-left">
                                    <div class="pn-personel-opt-av">{{ $p->initials }}</div>
                                    <div>
                                        <div class="pn-personel-opt-name">{{ $p->nama_lengkap }}</div>
                                        <div class="pn-personel-opt-job">{{ $p->jabatan }}</div>
                                    </div>
                                </div>
                                <span class="pn-personel-opt-status {{ $st }}">{{ $p->status_label }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Standby Counter Helper --}}
                    <div class="pn-standby-pill-note">Standby: {{ $personelSiaga }}</div>
                </div>
            </div>

            {{-- SECTION 3: Waktu & Instruksi --}}
            <div class="pn-form-section">
                <div class="pn-section-title-wrap">
                    <svg class="pn-section-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Waktu &amp; Instruksi</span>
                </div>

                <div class="pn-form-group">
                    <label class="pn-label">Tenggat Waktu Berkumpul <span class="req">*</span></label>
                    <input type="datetime-local" name="tenggat_waktu" class="pn-input-control" value="{{ old('tenggat_waktu') }}" required>
                </div>

                <div class="pn-form-group">
                    <label class="pn-label">Instruksi Tambahan</label>
                    <textarea name="catatan" class="pn-textarea-control" rows="4" placeholder="Masukkan catatan khusus, dresscode, atau peralatan spesifik yang perlu dibawa...">{{ old('catatan') }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pn-form-actions-row">
                <a href="{{ route('protokol-pimpinan.penugasan.index') }}" class="pn-btn-batal">Batal</a>
                <button type="submit" class="pn-btn-submit">
                    {{-- Paper airplane / send icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                        <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 004.835 9.25h8.415a.75.75 0 010 1.5H4.835a1.5 1.5 0 00-1.142 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                    </svg>
                    <span>Simpan &amp; Kirim Penugasan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Dynamic Role by Kategori Selection
function handleKategoriChange() {
    const kat = document.getElementById('pnKategoriSelect').value;
    const peran = document.getElementById('pnPeranSelect');
    
    if (kat === 'Protokol') {
        peran.value = 'Protokol';
    } else if (kat === 'Komunikasi Pimpinan') {
        peran.value = 'MC';
    } else if (kat === 'Dokumentasi') {
        peran.value = 'Fotografer';
    }
}

// Personel Multi-tag interactive selection
const selectedPersonelSet = new Set();

// Initialize from existing hidden inputs or sample
document.querySelectorAll('#pnHiddenInputsContainer input').forEach(input => {
    selectedPersonelSet.add(parseInt(input.value));
});

// Auto pre-select Budi K if empty (matches example image BK Budi K)
@if(!old('personel_ids') && $personelList->isNotEmpty())
    @php
        $defaultSample = $personelList->firstWhere('status_ketersediaan', 'standby') ?? $personelList->first();
    @endphp
    @if($defaultSample)
        addPersonelChip({{ $defaultSample->id }}, '{{ addslashes($defaultSample->nama_lengkap) }}', '{{ $defaultSample->initials }}');
    @endif
@endif

function focusSearchInput(e) {
    if (e.target.tagName !== 'BUTTON' && !e.target.classList.contains('pn-tag-chip-remove')) {
        document.getElementById('pnSearchPersonelInput').focus();
    }
}

function openPersonelDropdown() {
    document.getElementById('pnTagsContainer').classList.add('focused');
    document.getElementById('pnPersonelDropdown').classList.add('is-open');
    filterPersonelDropdown();
}

function closePersonelDropdown() {
    document.getElementById('pnTagsContainer').classList.remove('focused');
    document.getElementById('pnPersonelDropdown').classList.remove('is-open');
}

function filterPersonelDropdown() {
    const query = document.getElementById('pnSearchPersonelInput').value.toLowerCase();
    const items = document.querySelectorAll('.pn-personel-opt-item');
    
    items.forEach(item => {
        const id = parseInt(item.getAttribute('data-id'));
        const name = (item.getAttribute('data-name') || '').toLowerCase();
        const job = (item.getAttribute('data-job') || '').toLowerCase();
        
        const isSelected = selectedPersonelSet.has(id);
        const matchesQuery = name.includes(query) || job.includes(query);
        
        if (!isSelected && matchesQuery) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

function addPersonelChip(id, name, initials) {
    if (selectedPersonelSet.has(id)) return;
    
    selectedPersonelSet.add(id);
    
    // Add Chip element
    const chipsList = document.getElementById('pnChipsList');
    const chip = document.createElement('div');
    chip.className = 'pn-tag-chip';
    chip.id = `chip-${id}`;
    chip.innerHTML = `
        <span class="pn-tag-chip-av">${initials}</span>
        <span>${name}</span>
        <button type="button" class="pn-tag-chip-remove" onclick="removePersonelChip(${id}, event)">&times;</button>
    `;
    chipsList.appendChild(chip);
    
    // Add Hidden Input
    const hiddenContainer = document.getElementById('pnHiddenInputsContainer');
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'personel_ids[]';
    hiddenInput.value = id;
    hiddenInput.id = `hidden-personel-${id}`;
    hiddenContainer.appendChild(hiddenInput);
    
    // Reset search
    const searchInput = document.getElementById('pnSearchPersonelInput');
    searchInput.value = '';
    filterPersonelDropdown();
    searchInput.focus();
}

function removePersonelChip(id, event) {
    if (event) event.stopPropagation();
    selectedPersonelSet.delete(id);
    
    const chip = document.getElementById(`chip-${id}`);
    if (chip) chip.remove();
    
    const hidden = document.getElementById(`hidden-personel-${id}`);
    if (hidden) hidden.remove();
    
    filterPersonelDropdown();
}

// Close dropdown on outside click
document.addEventListener('click', function(e) {
    const container = document.getElementById('pnTagsContainer');
    if (container && !container.contains(e.target)) {
        closePersonelDropdown();
    }
});
</script>
@endpush
