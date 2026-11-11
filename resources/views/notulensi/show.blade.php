@extends('layouts.app')
@section('title', 'Detail Notulensi')
@section('topbar-title', 'Notulensi')
@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-title">{{ $notulensi->judul }}</h1>
        <p class="page-subtitle">{{ $notulensi->tanggal_rapat->format('d F Y') }} &middot; {{ $notulensi->tempat }}</p>
    </div>
    <div class="flex gap-2">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('notulensi.edit', $notulensi) }}" class="btn btn-outline">Edit</a>
        @endif
        <a href="{{ route('notulensi.index') }}" class="btn btn-outline">Kembali</a>
    </div>
</div>

{{-- Info Bar --}}
<div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:6px;padding:6px 14px;background:var(--surface-alt,var(--card-bg));border-radius:var(--radius);font-size:0.85rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
        <span class="text-muted">Notulis:</span>
        <strong>{{ $notulensi->notulis?->name ?? '—' }}</strong>
    </div>
    <div style="display:flex;align-items:center;gap:6px;padding:6px 14px;background:var(--surface-alt,var(--card-bg));border-radius:var(--radius);font-size:0.85rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
        <span class="text-muted">Kegiatan:</span>
        <strong>{{ $notulensi->kegiatan?->judul ?? 'Tanpa kegiatan' }}</strong>
    </div>
    <div>
        <span class="badge {{ $notulensi->status === 'final' ? 'badge-green' : 'badge-yellow' }}" style="font-size:0.85rem;padding:6px 14px;">{{ ucfirst($notulensi->status) }}</span>
    </div>
</div>

<div class="card" style="max-width:940px;">
    <div class="card-body">

        {{-- Keywords --}}
        @if($notulensi->keywords)
        <div style="margin-bottom:20px;padding:12px 16px;background:var(--info-bg,rgba(99,102,241,0.07));border-radius:var(--radius-sm);border-left:3px solid var(--accent);">
            <div style="font-size:0.78rem;font-weight:600;color:var(--accent);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Keywords</div>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                @foreach(explode(',', $notulensi->keywords) as $kw)
                @if(trim($kw))
                <a href="{{ route('notulensi.index', ['search' => trim($kw)]) }}" style="display:inline-block;padding:3px 12px;background:var(--accent);color:#fff;border-radius:20px;font-size:0.8rem;font-weight:500;text-decoration:none;transition:opacity 0.15s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">#{{ trim($kw) }}</a>
                @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- File Attachments --}}
        @if($notulensi->file_notulensi || $notulensi->file_paparan)
        <div style="margin-bottom:20px;">
            <div style="font-size:0.78rem;font-weight:600;color:var(--text-muted);margin-bottom:10px;text-transform:uppercase;letter-spacing:0.05em;">File Lampiran</div>
            <div style="display:flex;flex-wrap:wrap;gap:10px;">
                @if($notulensi->file_notulensi)
                <a href="{{ route('notulensi.download', [$notulensi, 'notulensi']) }}" style="display:flex;align-items:center;gap:10px;padding:12px 18px;background:var(--surface-alt,var(--card-bg));border:1px solid var(--border);border-radius:var(--radius-sm);text-decoration:none;color:inherit;transition:border-color 0.15s,box-shadow 0.15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.boxShadow='0 0 0 2px rgba(99,102,241,0.15)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:rgba(99,102,241,0.1);border-radius:var(--radius-sm);flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </div>
                    <div>
                        <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">File Notulensi</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Klik untuk mengunduh</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--text-muted)" style="margin-left:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                </a>
                @endif

                @if($notulensi->file_paparan)
                <a href="{{ route('notulensi.download', [$notulensi, 'paparan']) }}" style="display:flex;align-items:center;gap:10px;padding:12px 18px;background:var(--surface-alt,var(--card-bg));border:1px solid var(--border);border-radius:var(--radius-sm);text-decoration:none;color:inherit;transition:border-color 0.15s,box-shadow 0.15s;" onmouseover="this.style.borderColor='#d97706';this.style.boxShadow='0 0 0 2px rgba(217,119,6,0.15)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:rgba(245,158,11,0.1);border-radius:var(--radius-sm);flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" /></svg>
                    </div>
                    <div>
                        <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">File Paparan Dinas</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Klik untuk mengunduh</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--text-muted)" style="margin-left:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                </a>
                @endif
            </div>
        </div>
        @endif

        <hr style="border:none;border-top:1px solid var(--border);margin:4px 0 20px;">

        {{-- Isi Notulensi --}}
        @if($notulensi->isi_notulensi)
        <div style="margin-bottom:24px;">
            <div style="font-size:0.78rem;font-weight:600;color:var(--text-muted);margin-bottom:10px;text-transform:uppercase;letter-spacing:0.05em;">Isi Notulensi</div>
            <div style="line-height:1.8;color:var(--text-primary);white-space:pre-line;">{{ $notulensi->isi_notulensi }}</div>
        </div>
        @endif

        @if($notulensi->agenda)
        <div style="margin-bottom:16px;">
            <div style="font-size:0.78rem;font-weight:600;color:var(--text-muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Agenda</div>
            <div style="line-height:1.7;">{{ $notulensi->agenda }}</div>
        </div>
        @endif

        @if($notulensi->kesimpulan)
        <div style="margin-bottom:16px;padding:16px;background:var(--info-bg,rgba(99,102,241,0.07));border-radius:var(--radius-sm);">
            <div style="font-size:0.78rem;font-weight:600;color:var(--accent);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Kesimpulan</div>
            <div style="line-height:1.7;">{{ $notulensi->kesimpulan }}</div>
        </div>
        @endif

        @if($notulensi->tindak_lanjut)
        <div style="padding:16px;background:rgba(245,158,11,0.08);border-radius:var(--radius-sm);">
            <div style="font-size:0.78rem;font-weight:600;color:#d97706;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Tindak Lanjut</div>
            <div style="line-height:1.7;">{{ $notulensi->tindak_lanjut }}</div>
        </div>
        @endif

    </div>
</div>
@endsection
