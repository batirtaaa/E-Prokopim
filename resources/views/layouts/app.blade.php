<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — E-PROKOPIM Kota Bandung</title>
    <meta name="description" content="Sistem Informasi Komunikasi Pimpinan Pemerintah Kota Bandung">
    <link rel="stylesheet" href="{{ asset('css/sikopim.css') }}">
    <style>
        /* ── Sidebar Navigation Group (Collapsible) ── */
        .sidebar-nav-group { margin-bottom: 2px; }
        .sidebar-nav-group-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: 13.5px;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.18s ease;
            margin-bottom: 2px;
            user-select: none;
        }
        .sidebar-nav-group-header:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }
        .sidebar-nav-group-header.active {
            background: #3b82f6 !important;
            color: #ffffff !important;
            font-weight: 500;
        }
        .sidebar-nav-group-header svg.main-icon {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            opacity: 0.8;
        }
        .sidebar-nav-group-header.active svg.main-icon {
            opacity: 1;
            color: #ffffff;
        }
        .sidebar-nav-group-header .chevron {
            margin-left: auto;
            width: 13px;
            height: 13px;
            opacity: 0.55;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .sidebar-nav-group-header.active .chevron {
            opacity: 1;
            color: #ffffff;
        }
        .sidebar-nav-group-header.open .chevron {
            transform: rotate(180deg);
        }
        .sidebar-nav-group-children {
            display: none;
            padding: 3px 0 6px 0;
        }
        .sidebar-nav-group-children.open { 
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .sidebar-nav-sublink {
            display: block;
            padding: 6px 12px 6px 36px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            font-weight: 400;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .sidebar-nav-sublink:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }
        .sidebar-nav-sublink.active {
            color: #22c55e !important;
            font-weight: 600;
            background: transparent !important;
        }

        /* ── Sidebar Sub-Nav-Group (nested collapsible under sublink level) ── */
        .sidebar-nav-subgroup { margin: 0; }
        .sidebar-nav-subgroup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 12px 6px 36px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            font-weight: 400;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.15s ease;
            user-select: none;
        }
        .sidebar-nav-subgroup-header:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.06);
        }
        .sidebar-nav-subgroup-header.active {
            color: #22c55e !important;
            font-weight: 600;
        }
        .sidebar-nav-subgroup-header .sub-chevron {
            width: 11px;
            height: 11px;
            opacity: 0.5;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .sidebar-nav-subgroup-header.open .sub-chevron {
            transform: rotate(180deg);
        }
        .sidebar-nav-subgroup-children {
            display: none;
            padding: 2px 0 4px 0;
        }
        .sidebar-nav-subgroup-children.open {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        .sidebar-nav-sublink--deep {
            padding-left: 52px;
            font-size: 12.5px;
        }

        .sidebar-nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            color: rgba(255,255,255,0.35);
            padding: 14px 10px 5px;
        }
        .sidebar-nav-link .ext-icon {
            margin-left: auto;
            width: 13px;
            height: 13px;
            opacity: 0.45;
            flex-shrink: 0;
        }

        /* ── Topbar Styling ── */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            flex: 1;
            padding-left: 36px;
        }
        .topbar-search-pill {
            position: relative;
            width: 100%;
            max-width: 540px;
        }
        .topbar-search-pill input {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 9.5px 20px 9.5px 44px;
            font-size: 13.5px;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease;
        }
        .topbar-search-pill input:focus {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }
        .topbar-search-pill .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            color: #94a3b8;
            pointer-events: none;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .topbar-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            cursor: pointer;
            position: relative;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .topbar-icon-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .topbar-icon-btn svg {
            width: 20px;
            height: 20px;
        }
        .notif-badge-pill {
            position: absolute;
            top: 4px;
            right: 4px;
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            background: #ef4444;
            color: #ffffff;
            border-radius: 10px;
            font-size: 9.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        /* Topbar User Profile */
        .topbar-profile-container {
            position: relative;
            margin-left: 8px;
        }
        .topbar-profile-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 10px;
            transition: background 0.15s ease;
            user-select: none;
            background: transparent;
            border: none;
        }
        .topbar-profile-btn:hover {
            background: #f8fafc;
        }
        .topbar-profile-info {
            text-align: right;
            display: flex;
            flex-direction: column;
        }
        .topbar-profile-name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
            white-space: nowrap;
        }
        .topbar-profile-role {
            font-size: 11px;
            font-weight: 500;
            color: #64748b;
            line-height: 1.2;
            margin-top: 2px;
        }
        .topbar-profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            background: #1e3a5f;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 2px solid #ffffff;
            overflow: hidden;
        }
        .topbar-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Profile Dropdown Menu */
        .profile-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 6px;
            z-index: 1000;
        }
        .profile-dropdown-menu.show { display: block; }
        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .profile-dropdown-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .profile-dropdown-item svg {
            width: 16px;
            height: 16px;
            color: #64748b;
        }
        .profile-dropdown-item.danger {
            color: #dc2626;
        }
        .profile-dropdown-item.danger:hover {
            background: #fef2f2;
            color: #b91c1c;
        }
        .profile-dropdown-item.danger svg {
            color: #dc2626;
        }
        .profile-dropdown-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 4px 0;
        }

        /* ── Notification Dropdown ── */
        .notif-wrapper { position: relative; }
        .topbar-icon-btn.notif-btn.has-unread svg {
            animation: bell-ring 1s ease-in-out;
        }
        @keyframes bell-ring {
            0%,100%{transform:rotate(0)}
            15%{transform:rotate(14deg)}
            30%{transform:rotate(-12deg)}
            45%{transform:rotate(8deg)}
            60%{transform:rotate(-5deg)}
            75%{transform:rotate(3deg)}
        }
        .notif-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 360px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            z-index: 1000;
            overflow: hidden;
        }
        .notif-dropdown.open { display: flex; flex-direction: column; }
        .notif-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .notif-dropdown-header h4 {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .notif-read-all-btn {
            font-size: 11.5px;
            color: #3b82f6;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            font-weight: 600;
        }
        .notif-read-all-btn:hover { text-decoration: underline; }
        .notif-list {
            max-height: 360px;
            overflow-y: auto;
            flex: 1;
        }
        .notif-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
        }
        .notif-item:hover { background: #f8fafc; }
        .notif-item.unread { background: rgba(59,130,246,0.05); }
        .notif-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
        }
        .notif-icon.kegiatan  { background: rgba(59,130,246,0.12); }
        .notif-icon.penugasan { background: rgba(245,158,11,0.12); }
        .notif-icon.arahan    { background: rgba(239,68,68,0.12);  }
        .notif-icon.deadline  { background: rgba(239,68,68,0.15);  }
        .notif-icon.info      { background: rgba(107,114,128,0.12); }
        .notif-content { flex: 1; min-width: 0; }
        .notif-content .notif-title {
            font-size: 12.5px;
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .notif-content .notif-pesan {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .notif-content .notif-time {
            font-size: 10.5px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .notif-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3b82f6;
            flex-shrink: 0;
            margin-top: 6px;
        }
        .notif-empty {
            padding: 32px 16px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
        .notif-empty svg { width: 32px; height: 32px; margin-bottom: 8px; opacity: 0.4; }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z"/>
                </svg>
            </div>
            <div class="sidebar-brand-text">
                <h2>E-PROKOPIM</h2>
                <p>Kota Bandung</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- 1. Dashboard --}}
            <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                Dashboard
            </a>

            {{-- 2. Kegiatan Pimpinan --}}
            <a href="{{ route('kegiatan-pimpinan.index') }}" class="sidebar-nav-link {{ request()->routeIs('kegiatan-pimpinan.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                Kegiatan Pimpinan
            </a>

            {{-- 3. Komunikasi Pimpinan (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('sambutan.*') || request()->routeIs('media-sosial.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                    Komunikasi Pimpinan
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('sambutan.*') || request()->routeIs('media-sosial.*')) ? 'open' : '' }}">
                    <a href="{{ route('sambutan.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('sambutan.*') ? 'active' : '' }}">
                        Sambutan
                    </a>
                    <a href="{{ route('media-sosial.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('media-sosial.*') ? 'active' : '' }}">
                        Media Sosial
                    </a>
                    <a href="#" class="sidebar-nav-sublink">
                        Analisis
                    </a>
                </div>
            </div>

            {{-- 4. Dokumentasi Pimpinan (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('sub-dokumentasi-pimpinan.*') || request()->routeIs('galeri-arsip.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                    Dokumentasi Pimpinan
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </div>
                <div class="sidebar-nav-group-children {{ request()->routeIs('galeri-arsip.*') ? 'open' : '' }}">
                    <a href="{{ route('galeri-arsip.index', ['tab'=>'foto']) }}" class="sidebar-nav-sublink {{ (request()->routeIs('galeri-arsip.*') && request()->get('tab') === 'foto') ? 'active' : '' }}">
                        Foto
                    </a>
                    <a href="{{ route('galeri-arsip.index', ['tab'=>'video']) }}" class="sidebar-nav-sublink {{ (request()->routeIs('galeri-arsip.*') && request()->get('tab') === 'video') ? 'active' : '' }}">
                        Video
                    </a>
                    <a href="{{ route('galeri-arsip.index', ['tab'=>'notulensi']) }}" class="sidebar-nav-sublink {{ (request()->routeIs('galeri-arsip.*') && request()->get('tab') === 'notulensi') ? 'active' : '' }}">
                        Notulensi
                    </a>
                </div>
            </div>

            {{-- 5. Protokol Pimpinan (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*') || request()->routeIs('sub-protokol.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Protokol Pimpinan
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*') || request()->routeIs('sub-protokol.*')) ? 'open' : '' }}">
                    <a href="{{ route('protokol-pimpinan.penugasan.index') }}" class="sidebar-nav-sublink {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*')) ? 'active' : '' }}">
                        Penugasan
                    </a>
                </div>
            </div>

            {{-- 6. Administrasi (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('arsip.*') || request()->routeIs('asset.*') || request()->routeIs('pegawai.*') || request()->routeIs('keuangan.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" /></svg>
                    Administrasi
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('arsip.*') || request()->routeIs('asset.*') || request()->routeIs('pegawai.*') || request()->routeIs('keuangan.*')) ? 'open' : '' }}">
                    <a href="{{ route('arsip.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('arsip.*') ? 'active' : '' }}">
                        Arsip Surat
                    </a>
                    <a href="{{ route('asset.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('asset.*') ? 'active' : '' }}">
                        Asset
                    </a>
                    <a href="{{ route('pegawai.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                        Pegawai
                    </a>
                    <a href="{{ route('keuangan.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                        Keuangan
                    </a>
                </div>
            </div>

            {{-- 7. Asisten AI --}}
            <a href="{{ route('asisten-ai.index') }}" class="sidebar-nav-link {{ request()->routeIs('asisten-ai.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
                Asisten AI
            </a>

            {{-- Tautan Sistem --}}
            <div class="sidebar-divider"></div>
            <div class="sidebar-nav-label">Tautan Sistem</div>

            <a href="https://prokopim.bandung.go.id" class="sidebar-nav-link" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                Website Prokopim
                <svg class="ext-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>

        </nav>

        {{-- Footer: Pengaturan & Profil --}}
        <div class="sidebar-footer">
            <a href="{{ route('pengaturan.index') }}" class="sidebar-nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Pengaturan
            </a>
            <a href="{{ route('profil-admin.index') }}" class="sidebar-nav-link {{ request()->routeIs('profil-admin.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Profil
            </a>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <header class="topbar">
            {{-- Left: Pill Search --}}
            <div class="topbar-left">
                <form method="GET" action="{{ route('arsip.index') }}" class="topbar-search-pill">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    <input type="text" name="search" placeholder="Cari data..." id="topbar-search-input" value="{{ request('search') }}">
                </form>
            </div>

            {{-- Right: Notification, Help, Apps Grid, Profile --}}
            <div class="topbar-right">
                {{-- 1. Notification Bell --}}
                <div class="notif-wrapper" id="notif-wrapper">
                    <button class="topbar-icon-btn notif-btn" id="notif-btn" title="Notifikasi" onclick="toggleNotifDropdown(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                        <span class="notif-badge-pill" id="notif-count" style="display:none;">0</span>
                    </button>

                    {{-- Notification Dropdown --}}
                    <div class="notif-dropdown" id="notif-dropdown">
                        <div class="notif-dropdown-header">
                            <h4>Notifikasi</h4>
                            <button class="notif-read-all-btn" onclick="markAllRead()">Tandai semua dibaca</button>
                        </div>
                        <div class="notif-list" id="notif-list">
                            <div class="notif-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                                <div>Tidak ada notifikasi</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Help / FAQ Icon --}}
                <button class="topbar-icon-btn" title="Bantuan" onclick="alert('Pusat Bantuan & Panduan Sistem E-PROKOPIM')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                </button>

                {{-- 3. Apps Grid (3x3 dots) Icon --}}
                <button class="topbar-icon-btn" title="Menu Aplikasi" onclick="alert('Menu Modul Sistem Terintegrasi')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="18" height="18"><circle cx="5" cy="5" r="2"/><circle cx="12" cy="5" r="2"/><circle cx="19" cy="5" r="2"/><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="12" cy="19" r="2"/><circle cx="19" cy="19" r="2"/></svg>
                </button>

                {{-- 4. User Profile with Name, Role, & Avatar --}}
                <div class="topbar-profile-container" id="profile-container">
                    <div class="topbar-profile-btn" onclick="toggleProfileMenu(event)">
                        <div class="topbar-profile-info">
                            <span class="topbar-profile-name">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="topbar-profile-role">
                                {{ auth()->user()->getRoleLabel() }}
                            </span>
                        </div>
                        <div class="topbar-profile-avatar">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" alt="Avatar" onerror="this.outerHTML='<div class=\'topbar-profile-avatar\'>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>'">
                            @endif
                        </div>
                    </div>

                    {{-- Profile Dropdown --}}
                    <div class="profile-dropdown-menu" id="profile-dropdown">
                        <a href="{{ route('profil-admin.index') }}" class="profile-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('pengaturan.index') }}" class="profile-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Pengaturan
                        </a>
                        <div class="profile-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="profile-dropdown-item danger" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="page-content">
            {{-- Flash Messages --}}
            <div class="toast-container">
                @if(session('success'))
                    <div class="toast toast-success" data-auto-dismiss>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="toast toast-error" data-auto-dismiss>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/sikopim.js') }}"></script>
<script>
function toggleNavGroup(header) {
    header.classList.toggle('open');
    const children = header.nextElementSibling;
    if (children) children.classList.toggle('open');
}

function toggleSubNavGroup(header) {
    header.classList.toggle('open');
    const children = header.nextElementSibling;
    if (children) children.classList.toggle('open');
}

// ── Profile Dropdown Toggle ──────────────────────────────────────
let profileMenuOpen = false;
function toggleProfileMenu(e) {
    e.stopPropagation();
    profileMenuOpen = !profileMenuOpen;
    document.getElementById('profile-dropdown').classList.toggle('show', profileMenuOpen);
}

document.addEventListener('click', function(e) {
    const profileContainer = document.getElementById('profile-container');
    if (profileContainer && !profileContainer.contains(e.target)) {
        profileMenuOpen = false;
        document.getElementById('profile-dropdown').classList.remove('show');
    }
});

// ── Notification System ──────────────────────────────────────────
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
const NOTIF_COUNT_URL  = '{{ route("notifikasi.count") }}';
const NOTIF_LIST_URL   = '{{ route("notifikasi.list") }}';
const NOTIF_READ_ALL   = '{{ route("notifikasi.read-all") }}';

let notifOpen = false;
let notifItems = [];

function toggleNotifDropdown(e) {
    e.stopPropagation();
    notifOpen = !notifOpen;
    document.getElementById('notif-dropdown').classList.toggle('open', notifOpen);
    if (notifOpen) fetchNotifList();
}

document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('notif-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        notifOpen = false;
        document.getElementById('notif-dropdown').classList.remove('open');
    }
});

function getNotifIcon(tipe) {
    const icons = {
        kegiatan:  '📅',
        penugasan: '📋',
        arahan:    '📌',
        deadline:  '⚠️',
        info:      '🔔',
    };
    return icons[tipe] || '🔔';
}

function renderNotifList(items) {
    const list = document.getElementById('notif-list');
    if (!items || items.length === 0) {
        list.innerHTML = `<div class="notif-empty">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
            <div>Tidak ada notifikasi</div>
        </div>`;
        return;
    }
    list.innerHTML = items.map(item => `
        <div class="notif-item ${item.is_read ? '' : 'unread'}" onclick="handleNotifClick(${item.id}, '${item.link || ''}')"
             role="button" tabindex="0">
            <div class="notif-icon ${item.tipe}">${getNotifIcon(item.tipe)}</div>
            <div class="notif-content">
                <div class="notif-title">${item.judul}</div>
                <div class="notif-pesan">${item.pesan}</div>
                <div class="notif-time">${item.created_at}</div>
            </div>
            ${item.is_read ? '' : '<div class="notif-dot"></div>'}
        </div>
    `).join('');
}

function handleNotifClick(id, link) {
    fetch(`/notifikasi/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    }).then(() => {
        updateBadge();
        if (link) { window.location.href = link; }
    });
}

function markAllRead() {
    fetch(NOTIF_READ_ALL, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    }).then(() => {
        updateBadge();
        fetchNotifList();
    });
}

function fetchNotifList() {
    fetch(NOTIF_LIST_URL, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            notifItems = data.items || [];
            renderNotifList(notifItems);
            updateBadgeDisplay(data.unread || 0);
        });
}

function updateBadgeDisplay(count) {
    const badge = document.getElementById('notif-count');
    const btn   = document.getElementById('notif-btn');
    if (!badge || !btn) return;
    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.style.display = 'flex';
        btn.classList.add('has-unread');
    } else {
        badge.style.display = 'none';
        btn.classList.remove('has-unread');
    }
}

function updateBadge() {
    fetch(NOTIF_COUNT_URL, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => updateBadgeDisplay(data.count || 0));
}

// Initial load + polling every 30 seconds
updateBadge();
setInterval(updateBadge, 30000);
</script>
@stack('scripts')
</body>
</html>
