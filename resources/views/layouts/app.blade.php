<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-PROKOPIM</title>
    <meta name="description" content="Sistem Informasi Komunikasi Pimpinan Pemerintah Kota Bandung">
    <link rel="stylesheet" href="{{ asset('css/sikopim.css') }}">
    <script>
        if (localStorage.getItem('prokopim_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
        if (localStorage.getItem('prokopim_theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
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

        /* ── Sidebar Collapsible Feature ── */
        :root {
            --sidebar-width: 220px;
            --sidebar-collapsed-width: 68px;
        }
        .sidebar {
            transition: width 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .main-content {
            transition: margin-left 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        html.sidebar-collapsed .sidebar,
        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width) !important;
        }
        html.sidebar-collapsed .main-content,
        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width) !important;
        }
        html.sidebar-collapsed .sidebar-brand-text,
        body.sidebar-collapsed .sidebar-brand-text,
        html.sidebar-collapsed .nav-text,
        body.sidebar-collapsed .nav-text,
        html.sidebar-collapsed .sidebar-nav-label,
        body.sidebar-collapsed .sidebar-nav-label,
        html.sidebar-collapsed .sidebar-nav-group-header .chevron,
        body.sidebar-collapsed .sidebar-nav-group-header .chevron,
        html.sidebar-collapsed .sidebar-nav-group-children,
        body.sidebar-collapsed .sidebar-nav-group-children,
        html.sidebar-collapsed .ext-icon,
        body.sidebar-collapsed .ext-icon,
        html.sidebar-collapsed .sidebar-brand-collapse-btn,
        body.sidebar-collapsed .sidebar-brand-collapse-btn {
            display: none !important;
        }
        html.sidebar-collapsed .sidebar-brand,
        body.sidebar-collapsed .sidebar-brand {
            padding: 16px 8px;
            justify-content: center;
        }
        html.sidebar-collapsed .sidebar-nav-link,
        body.sidebar-collapsed .sidebar-nav-link,
        html.sidebar-collapsed .sidebar-nav-group-header,
        body.sidebar-collapsed .sidebar-nav-group-header {
            justify-content: center;
            padding: 10px 0;
            border-radius: 8px;
        }
        html.sidebar-collapsed .sidebar-nav-link svg,
        body.sidebar-collapsed .sidebar-nav-link svg,
        html.sidebar-collapsed .sidebar-nav-group-header svg.main-icon,
        body.sidebar-collapsed .sidebar-nav-group-header svg.main-icon {
            margin: 0;
        }
        html.sidebar-collapsed .sidebar-footer a,
        body.sidebar-collapsed .sidebar-footer a {
            justify-content: center;
            padding: 10px 0;
        }

        /* Topbar Toggle Button */
        .sidebar-toggle-btn {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
            margin-right: 14px;
        }
        .sidebar-toggle-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .sidebar-toggle-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Sidebar Brand Inline Collapse Button */
        .sidebar-brand-collapse-btn {
            margin-left: auto;
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .sidebar-brand-collapse-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
        }
        .sidebar-brand-collapse-btn svg {
            width: 14px;
            height: 14px;
        }
    </style>
    @stack('styles')
    <style id="prokopim-dark-mode">
        /* ══════════════════════════════════════════════════════════════
           E-PROKOPIM COMPLETE DARK MODE ENGINE
           Designed for Midnight Navy theme (#0b1320, #131f33, #17263d)
        ══════════════════════════════════════════════════════════════ */
        html.dark-mode {
            color-scheme: dark;
            --bg-main: #0b1320;
            --bg-card: #131f33;
            --bg-input: #17263d;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border: #1e3352;
            --border-focus: #3b82f6;
            --primary: #15243b;
            --primary-light: #182d4d;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.4);
            --shadow: 0 4px 14px rgba(0,0,0,0.5);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.6);
        }

        /* ── Base & Layout ── */
        html.dark-mode,
        html.dark-mode body,
        html.dark-mode .app-layout,
        html.dark-mode .main-content,
        html.dark-mode .page-content {
            background-color: #0b1320 !important;
            color: #e2e8f0 !important;
        }

        /* ── Headings & Titles ── */
        html.dark-mode h1,
        html.dark-mode h2,
        html.dark-mode h3,
        html.dark-mode h4,
        html.dark-mode h5,
        html.dark-mode h6,
        html.dark-mode .page-title,
        html.dark-mode .card-title,
        html.dark-mode .dash-card-title,
        html.dark-mode .dash-table-header-title,
        html.dark-mode .pgw-title,
        html.dark-mode .page-header-left h1 {
            color: #f8fafc !important;
        }

        html.dark-mode p,
        html.dark-mode .page-subtitle,
        html.dark-mode .page-header-left p {
            color: #94a3b8 !important;
        }

        /* ── Topbar ── */
        html.dark-mode .topbar {
            background: #0f1c30 !important;
            border-bottom: 1px solid #1e3352 !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.4) !important;
        }
        html.dark-mode .topbar-title { color: #f8fafc !important; }
        html.dark-mode .topbar-icon-btn { color: #94a3b8 !important; }
        html.dark-mode .topbar-icon-btn:hover { background: #17263d !important; color: #f8fafc !important; }
        html.dark-mode .sidebar-toggle-btn { background: #17263d !important; border-color: #1e3352 !important; color: #94a3b8 !important; }
        html.dark-mode .sidebar-toggle-btn:hover { background: #1e3352 !important; color: #ffffff !important; }
        html.dark-mode .topbar-profile-name { color: #f8fafc !important; }
        html.dark-mode .topbar-profile-role { color: #94a3b8 !important; }
        html.dark-mode .topbar-profile-btn:hover { background: #17263d !important; }
        html.dark-mode .topbar-profile-avatar { border-color: #0f1c30 !important; }
        html.dark-mode .notif-badge-pill { border-color: #0f1c30 !important; }

        /* ── Topbar Dropdowns ── */
        html.dark-mode .profile-dropdown-menu,
        html.dark-mode .notif-dropdown {
            background: #131f33 !important;
            border: 1px solid #1e3352 !important;
            box-shadow: 0 12px 30px rgba(0,0,0,0.6) !important;
        }
        html.dark-mode .profile-dropdown-item { color: #cbd5e1 !important; }
        html.dark-mode .profile-dropdown-item:hover { background: #1a2d47 !important; color: #ffffff !important; }
        html.dark-mode .profile-dropdown-divider { background: #1e3352 !important; }
        html.dark-mode .notif-dropdown-header { background: #0f1c30 !important; border-bottom: 1px solid #1e3352 !important; color: #f8fafc !important; }
        html.dark-mode .notif-dropdown-header h4 { color: #f8fafc !important; }
        html.dark-mode .notif-read-all-btn { color: #60a5fa !important; }
        html.dark-mode .notif-item { border-bottom: 1px solid #1e3352 !important; color: #cbd5e1 !important; }
        html.dark-mode .notif-item:hover { background: #17263d !important; }
        html.dark-mode .notif-item.unread { background: #0e223d !important; }
        html.dark-mode .notif-title { color: #f8fafc !important; }
        html.dark-mode .notif-pesan { color: #94a3b8 !important; }
        html.dark-mode .notif-time { color: #64748b !important; }
        html.dark-mode .notif-empty { color: #64748b !important; }

        /* ── Theme Toggle Button Icons ── */
        .theme-toggle-btn { position: relative; cursor: pointer; }
        .theme-icon-sun { display: none; color: #f59e0b; }
        .theme-icon-moon { display: block; color: #475569; }
        .topbar-icon-btn:hover .theme-icon-moon { color: #1e293b; }
        html.dark-mode .theme-icon-sun { display: block; color: #fbbf24; }
        html.dark-mode .theme-icon-moon { display: none; }
        html.dark-mode .theme-toggle-btn:hover .theme-icon-sun { color: #fde047; }

        /* ── All Cards & Containers (No White Segments) ── */
        html.dark-mode .card,
        html.dark-mode .stat-card,
        html.dark-mode .table-card,
        html.dark-mode .table-wrapper,
        html.dark-mode .chart-card,
        html.dark-mode .dash-stat-card,
        html.dark-mode .dash-card,
        html.dark-mode .dash-table-card,
        html.dark-mode .pgw-card,
        html.dark-mode .kg-table-wrap,
        html.dark-mode .kg-toolbar,
        html.dark-mode .ga-card,
        html.dark-mode .ast-card,
        html.dark-mode .ar-card,
        html.dark-mode .ar-table-card,
        html.dark-mode .ar-filter-card,
        html.dark-mode .pn-main-card,
        html.dark-mode .pn-sidebar-card,
        html.dark-mode .pn-stat-card,
        html.dark-mode .form-card,
        html.dark-mode .filter-card,
        html.dark-mode .trash-stat-card,
        html.dark-mode .trash-container-card,
        html.dark-mode .sb-toolbar-wrap,
        html.dark-mode .sb-table-wrap,
        html.dark-mode .ms-toolbar-wrap,
        html.dark-mode .an-toolbar-card,
        html.dark-mode .an-table-card,
        html.dark-mode [class*="-toolbar-wrap"],
        html.dark-mode [class*="-table-wrap"],
        html.dark-mode [class*="-card"],
        html.dark-mode [class*="card-"],
        html.dark-mode .bg-white,
        html.dark-mode [style*="background: #ffffff"],
        html.dark-mode [style*="background: #fff"],
        html.dark-mode [style*="background: white"],
        html.dark-mode [style*="background-color: #ffffff"],
        html.dark-mode [style*="background-color: #fff"],
        html.dark-mode [style*="background-color: white"] {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
            color: #e2e8f0 !important;
        }

        html.dark-mode .card-header,
        html.dark-mode .card-footer,
        html.dark-mode .dash-card-header,
        html.dark-mode .dash-table-header,
        html.dark-mode .pgw-toolbar,
        html.dark-mode .kg-toolbar,
        html.dark-mode .ga-toolbar-wrap,
        html.dark-mode .ms-toolbar-wrap {
            background-color: #131f33 !important;
            border-bottom-color: #1e3352 !important;
            border-color: #1e3352 !important;
        }

        /* ── Sambutan & Document Management Specific Elements ── */
        html.dark-mode .sb-toolbar-wrap,
        html.dark-mode .sb-table-wrap {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .sb-tabs {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .sb-tab {
            color: #94a3b8 !important;
        }
        html.dark-mode .sb-tab:hover {
            color: #f8fafc !important;
        }
        html.dark-mode .sb-tab.active {
            color: #38bdf8 !important;
            border-bottom-color: #38bdf8 !important;
        }
        html.dark-mode .sb-search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .sb-date-range-box {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .sb-date-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .sb-date-input {
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .sb-date-sep {
            color: #64748b !important;
        }
        html.dark-mode .btn-export-outline {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .btn-export-outline:hover {
            background: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .sb-table thead th {
            background: #0f1c30 !important;
            color: #94a3b8 !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .sb-table tbody td {
            border-bottom-color: #1a2a44 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .sb-table tbody tr:hover {
            background: #17263d !important;
        }
        html.dark-mode .sb-nomor {
            color: #94a3b8 !important;
        }
        html.dark-mode .sb-perihal-main {
            color: #f8fafc !important;
        }
        html.dark-mode .sb-perihal-sub {
            color: #94a3b8 !important;
        }
        html.dark-mode .sb-pagination {
            background: #0f1c30 !important;
            border-top-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .sb-page-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .sb-page-btn:hover {
            background: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        /* ── Dashboard Specific Elements ── */
        html.dark-mode .period-filter {
            background: #0f1c30 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .period-btn {
            color: #94a3b8 !important;
            background: transparent !important;
        }
        html.dark-mode .period-btn:hover {
            color: #ffffff !important;
            background: #17263d !important;
        }
        html.dark-mode .period-btn.active {
            background: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(37,99,235,0.4) !important;
        }
        html.dark-mode .dash-stat-label,
        html.dark-mode .stat-card-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .dash-stat-value,
        html.dark-mode .stat-card-value {
            color: #f8fafc !important;
        }
        html.dark-mode .dash-stat-sub,
        html.dark-mode .stat-card-sub {
            color: #94a3b8 !important;
        }
        html.dark-mode .dash-stat-sub.success { color: #34d399 !important; }
        html.dark-mode .dash-stat-sub.danger  { color: #f87171 !important; }

        /* Stat Card Icons */
        html.dark-mode .dash-stat-icon.blue,
        html.dark-mode .stat-card-icon.blue { background: #172e54 !important; color: #60a5fa !important; }
        html.dark-mode .dash-stat-icon.green,
        html.dark-mode .stat-card-icon.green { background: #0c3a28 !important; color: #34d399 !important; }
        html.dark-mode .dash-stat-icon.orange,
        html.dark-mode .stat-card-icon.orange { background: #3d2806 !important; color: #fbbf24 !important; }
        html.dark-mode .dash-stat-icon.purple,
        html.dark-mode .stat-card-icon.purple { background: #2e1b4d !important; color: #a78bfa !important; }
        html.dark-mode .stat-card-icon.gray { background: #1e293b !important; color: #94a3b8 !important; }

        /* Dashboard Filter Select & Search Mini */
        html.dark-mode .filter-select,
        html.dark-mode select.filter-select {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f1f5f9 !important;
        }
        html.dark-mode .dash-search-mini {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .dash-search-mini input {
            color: #f8fafc !important;
            background: transparent !important;
        }
        html.dark-mode .dash-search-mini input::placeholder {
            color: #64748b !important;
        }

        /* Chart Elements */
        html.dark-mode .chart-bar-label { color: #94a3b8 !important; }
        html.dark-mode .chart-bar-tooltip {
            background: #0f1c30 !important;
            color: #f8fafc !important;
            border: 1px solid #1e3352 !important;
        }

        /* Agenda Timeline */
        html.dark-mode .agenda-timeline {
            background: transparent !important;
        }
        html.dark-mode .agenda-item {
            border-bottom: 1px solid #1e3352 !important;
            background: transparent !important;
        }
        html.dark-mode .agenda-item:hover {
            background: #17263d !important;
        }
        html.dark-mode .agenda-time {
            color: #f8fafc !important;
        }
        html.dark-mode .agenda-judul {
            color: #f1f5f9 !important;
        }
        html.dark-mode .agenda-meta,
        html.dark-mode .agenda-meta span {
            color: #94a3b8 !important;
        }
        html.dark-mode .agenda-line {
            background: #1e3352 !important;
        }
        html.dark-mode .agenda-badge.berlangsung { background: #172e54 !important; color: #60a5fa !important; }
        html.dark-mode .agenda-badge.selesai     { background: #0c3a28 !important; color: #34d399 !important; }
        html.dark-mode .agenda-badge.terjadwal   { background: #3d2806 !important; color: #fbbf24 !important; }

        /* Dashboard Table & "Lihat Semua Pegawai" Footer */
        html.dark-mode .dash-see-all {
            background: #0f1c30 !important;
            border-top: 1px solid #1e3352 !important;
        }
        html.dark-mode .dash-see-all a {
            color: #60a5fa !important;
        }

        /* Action Icons */
        html.dark-mode .action-icon,
        html.dark-mode .kg-icon-btn,
        html.dark-mode .ga-btn-action {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .action-icon:hover,
        html.dark-mode .kg-icon-btn:hover,
        html.dark-mode .ga-btn-action:hover {
            background: #1e3352 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }

        /* Filter Buttons & Dropdowns in Dark Mode */
        html.dark-mode .pgw-btn-filter,
        html.dark-mode .ar-btn-filter,
        html.dark-mode .ast-btn-filter,
        html.dark-mode [class*="-btn-filter"],
        html.dark-mode [class*="btn-filter"],
        html.dark-mode .filter-btn,
        html.dark-mode .btn-filter {
            background: #17263d !important;
            color: #f8fafc !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .pgw-btn-filter:hover,
        html.dark-mode .ar-btn-filter:hover,
        html.dark-mode .ast-btn-filter:hover,
        html.dark-mode [class*="-btn-filter"]:hover,
        html.dark-mode [class*="btn-filter"]:hover,
        html.dark-mode .filter-btn:hover,
        html.dark-mode .btn-filter:hover {
            background: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .pgw-btn-filter svg,
        html.dark-mode .ar-btn-filter svg,
        html.dark-mode .ast-btn-filter svg {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-btn-filter:hover svg {
            color: #ffffff !important;
        }
        html.dark-mode .pgw-filter-dropdown {
            background: #131f33 !important;
            border: 1px solid #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .pgw-filter-dropdown select {
            background: #17263d !important;
            border: 1px solid #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-perpage-select {
            background: #17263d !important;
            border: 1px solid #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-perpage-wrap label {
            color: #94a3b8 !important;
        }

        /* Pegawai Avatar & Status Pills */
        html.dark-mode .pegawai-avatar,
        html.dark-mode .pgw-avatar {
            background: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pgw-name-text {
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-email-text,
        html.dark-mode .pgw-email-text svg {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-email-text:hover,
        html.dark-mode .pgw-email-text:hover svg {
            color: #60a5fa !important;
        }
        html.dark-mode .pgw-status-pill.status-pns {
            background: #172e54 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .pgw-status-pill.status-pppk-penuh {
            background: #2e1b4d !important;
            color: #a78bfa !important;
        }
        html.dark-mode .pgw-status-pill.status-pppk-paruh,
        html.dark-mode .pgw-status-pill.status-outsourcing,
        html.dark-mode .pgw-status-pill.status-default {
            background: #1e293b !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pgw-pagination-footer {
            background: #0f1c30 !important;
            border-top: 1px solid #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-p-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pgw-p-btn:hover {
            background: #1e3352 !important;
            color: #ffffff !important;
        }
        html.dark-mode .pgw-p-btn.active {
            background: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }
        html.dark-mode .pgw-p-btn.disabled {
            background: #0f1c30 !important;
            color: #475569 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pgw-icon-btn {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-icon-btn:hover {
            color: #ffffff !important;
            background: #1e3352 !important;
        }

        /* ── All Tables in Dark Mode ── */
        html.dark-mode table,
        html.dark-mode .table,
        html.dark-mode .dash-table,
        html.dark-mode .kg-table,
        html.dark-mode .pgw-table {
            background: transparent !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode table thead tr,
        html.dark-mode .table thead tr,
        html.dark-mode .dash-table thead tr,
        html.dark-mode .kg-table thead tr,
        html.dark-mode .pgw-table thead tr {
            background: #0f1c30 !important;
        }
        html.dark-mode table th,
        html.dark-mode .table th,
        html.dark-mode .dash-table th,
        html.dark-mode .kg-table th,
        html.dark-mode .pgw-table th {
            background: #0f1c30 !important;
            color: #94a3b8 !important;
            border-bottom: 1px solid #1e3352 !important;
        }
        html.dark-mode table td,
        html.dark-mode .table td,
        html.dark-mode .dash-table td,
        html.dark-mode .kg-table td,
        html.dark-mode .pgw-table td {
            background: transparent !important;
            border-bottom: 1px solid #1a2a44 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .dash-table td div[style*="font-weight:600"],
        html.dark-mode .dash-table td span[style*="font-weight:600"],
        html.dark-mode .dash-table td div[style*="font-weight: 600"],
        html.dark-mode .dash-table td span[style*="font-weight: 600"],
        html.dark-mode .dash-table td [style*="color:#0f172a"],
        html.dark-mode .dash-table td [style*="color: #0f172a"],
        html.dark-mode .kg-table td strong,
        html.dark-mode .pgw-table td strong {
            color: #f8fafc !important;
        }
        html.dark-mode table tbody tr:hover,
        html.dark-mode .table tbody tr:hover,
        html.dark-mode .dash-table tr:hover td,
        html.dark-mode .kg-table tbody tr:hover,
        html.dark-mode .pgw-table tbody tr:hover {
            background: #17263d !important;
        }
        html.dark-mode .kg-table tbody tr.row-selected {
            background: #1a3254 !important;
        }

        /* ── Form Controls & Search Bars ── */
        html.dark-mode .form-control,
        html.dark-mode .form-select,
        html.dark-mode .search-bar input,
        html.dark-mode .kg-search-input,
        html.dark-mode .pgw-search-input,
        html.dark-mode input[type="text"],
        html.dark-mode input[type="search"],
        html.dark-mode input[type="password"],
        html.dark-mode input[type="email"],
        html.dark-mode input[type="date"],
        html.dark-mode input[type="time"],
        html.dark-mode input[type="number"],
        html.dark-mode select,
        html.dark-mode textarea {
            background-color: #17263d !important;
            border: 1px solid #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .form-control:focus,
        html.dark-mode .search-bar input:focus,
        html.dark-mode .kg-search-input:focus,
        html.dark-mode .pgw-search-input:focus,
        html.dark-mode input:focus,
        html.dark-mode select:focus,
        html.dark-mode textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
            background-color: #1a2c47 !important;
        }
        html.dark-mode .form-label,
        html.dark-mode .form-label-normal,
        html.dark-mode label {
            color: #cbd5e1 !important;
        }
        html.dark-mode .search-bar svg,
        html.dark-mode .kg-search-wrap svg,
        html.dark-mode .pgw-search-icon {
            color: #64748b !important;
        }
        html.dark-mode input::placeholder,
        html.dark-mode textarea::placeholder {
            color: #64748b !important;
        }

        /* ── Modals & Popups ── */
        html.dark-mode .modal,
        html.dark-mode .modal-content,
        html.dark-mode .modal-box,
        html.dark-mode .modal-dialog,
        html.dark-mode .custom-modal-content {
            background-color: #131f33 !important;
            border: 1px solid #1e3352 !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6) !important;
            color: #f1f5f9 !important;
        }
        html.dark-mode .modal-header,
        html.dark-mode .custom-modal-header {
            background: #0f1c30 !important;
            border-bottom: 1px solid #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .modal-footer {
            background: #0f1c30 !important;
            border-top: 1px solid #1e3352 !important;
        }
        html.dark-mode .custom-modal-body {
            background: #131f33 !important;
        }

        /* ── Pegawai Modal Detail — Dark Mode ── */
        html.dark-mode .pegawai-modal-item {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pegawai-modal-item label {
            color: #94a3b8 !important;
        }
        html.dark-mode .pegawai-modal-item span {
            color: #f1f5f9 !important;
        }
        html.dark-mode #modal-nama,
        html.dark-mode .dash-modal-nama {
            color: #f1f5f9 !important;
        }
        html.dark-mode #modal-nip,
        html.dark-mode .dash-modal-nip {
            color: #94a3b8 !important;
        }
        html.dark-mode .custom-modal-footer {
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .btn-modal-cancel {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .btn-modal-cancel:hover {
            background: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .btn-modal-submit {
            background: #2563eb !important;
        }
        html.dark-mode .date-preset-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .date-preset-btn:hover {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }
        html.dark-mode .date-input-wrap label {
            color: #94a3b8 !important;
        }

        /* ── Buttons in Dark Mode ── */
        html.dark-mode .btn-outline {
            background: #131f33 !important;
            color: #cbd5e1 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .btn-outline:hover {
            background: #17263d !important;
            color: #ffffff !important;
            border-color: #2b456b !important;
        }
        html.dark-mode .btn-welcome-outline {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .btn-welcome-outline:hover {
            background: #1e3352 !important;
            border-color: #2b456b !important;
        }

        /* ── Tabs & Navigation Pills ── */
        html.dark-mode .ga-tab { color: #94a3b8 !important; }
        html.dark-mode .ga-tab:hover { color: #f8fafc !important; }
        html.dark-mode .ga-tab.active { color: #38bdf8 !important; border-bottom-color: #38bdf8 !important; }
        html.dark-mode .settings-tab-item { color: #94a3b8 !important; }
        html.dark-mode .settings-tab-item.active { background: #17263d !important; color: #38bdf8 !important; }

        /* ── Pagination ── */
        html.dark-mode .pagination-wrapper {
            background: #0f1c30 !important;
            border-top: 1px solid #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pagination a,
        html.dark-mode .pagination span {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pagination a:hover {
            background: #17263d !important;
        }
        html.dark-mode .pagination .active span {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }
        html.dark-mode .pagination .disabled span {
            color: #475569 !important;
            background: #0f1c30 !important;
        }

        /* ── Selection Action Bar (Kegiatan Pimpinan) ── */
        html.dark-mode .selection-action-bar {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .selection-info {
            color: #f8fafc !important;
        }

        /* ══════════════════════════════════════════════════════════════
           UNIVERSAL MULTI-LAYERED TEXT, NUMBER & CONTRAST ENGINE
           Guarantees NO letters or numbers blend into dark background
        ══════════════════════════════════════════════════════════════ */
        
        /* 1. Global App Layout & Content Base Text */
        html.dark-mode body,
        html.dark-mode .app-layout,
        html.dark-mode .main-content,
        html.dark-mode .page-content,
        html.dark-mode .content-area {
            color: #cbd5e1 !important;
        }

        /* 2. All Headings, Titles, Names, Strong & Bold Text across ANY page */
        html.dark-mode h1,
        html.dark-mode h2,
        html.dark-mode h3,
        html.dark-mode h4,
        html.dark-mode h5,
        html.dark-mode h6,
        html.dark-mode strong,
        html.dark-mode b,
        html.dark-mode th,
        html.dark-mode dt,
        html.dark-mode .page-title,
        html.dark-mode .card-title,
        html.dark-mode .modal-title,
        html.dark-mode .section-title,
        html.dark-mode .font-bold,
        html.dark-mode .font-semibold,
        html.dark-mode [class*="-title"],
        html.dark-mode [class*="_title"],
        html.dark-mode [class*="-heading"],
        html.dark-mode [class*="_heading"],
        html.dark-mode [class*="-header-title"],
        html.dark-mode [class*="-name"]:not(.btn):not(button),
        html.dark-mode [class*="_name"]:not(.btn):not(button) {
            color: #f8fafc !important;
        }

        /* 3. Universal Numbers, Counts, Values, Totals & Metrics */
        html.dark-mode [class*="-number"],
        html.dark-mode [class*="_number"],
        html.dark-mode [class*="-count"],
        html.dark-mode [class*="_count"],
        html.dark-mode [class*="-value"],
        html.dark-mode [class*="_value"],
        html.dark-mode [class*="-val"]:not(.modal),
        html.dark-mode [class*="_val"],
        html.dark-mode [class*="-total"],
        html.dark-mode [class*="_total"],
        html.dark-mode [class*="-amount"],
        html.dark-mode [class*="_amount"],
        html.dark-mode [class*="stat-val"],
        html.dark-mode [class*="stat-number"],
        html.dark-mode [class*="stat-value"],
        html.dark-mode [class*="stat-count"],
        html.dark-mode .stat-value,
        html.dark-mode .stat-card-value,
        html.dark-mode .trash-stat-value,
        html.dark-mode .pn-stat-number,
        html.dark-mode .td-nomor,
        html.dark-mode .ar-doc-nomor,
        html.dark-mode .kg-tanggal-date,
        html.dark-mode .folder-count-badge {
            color: #f8fafc !important;
        }

        /* 4. Subtitles, Descriptions, Hints, Notes, Units, Jobs, Dates, Times */
        html.dark-mode p,
        html.dark-mode dd,
        html.dark-mode .page-subtitle,
        html.dark-mode .card-subtitle,
        html.dark-mode .modal-desc,
        html.dark-mode [class*="-subtitle"],
        html.dark-mode [class*="_subtitle"],
        html.dark-mode [class*="-desc"],
        html.dark-mode [class*="_desc"],
        html.dark-mode [class*="-description"],
        html.dark-mode [class*="-sub"]:not([class*="-sub-"]):not(.modal),
        html.dark-mode [class*="_sub"],
        html.dark-mode [class*="-job"],
        html.dark-mode [class*="_job"],
        html.dark-mode [class*="-unit"],
        html.dark-mode [class*="_unit"],
        html.dark-mode [class*="-hint"],
        html.dark-mode [class*="_hint"],
        html.dark-mode [class*="-note"],
        html.dark-mode [class*="_note"],
        html.dark-mode [class*="-time"],
        html.dark-mode [class*="_time"],
        html.dark-mode [class*="-date"],
        html.dark-mode [class*="_date"],
        html.dark-mode [class*="-location"],
        html.dark-mode [class*="-lokasi"],
        html.dark-mode [class*="-label"]:not([class*="badge"]),
        html.dark-mode [class*="_label"]:not([class*="badge"]),
        html.dark-mode [class*="-lbl"]:not([class*="badge"]) {
            color: #94a3b8 !important;
        }

        /* 5. Global Table System (applies across all tables and page tables) */
        html.dark-mode table,
        html.dark-mode .table,
        html.dark-mode [class*="-table"],
        html.dark-mode [class*="table-"] {
            color: #cbd5e1 !important;
        }
        html.dark-mode table thead,
        html.dark-mode table thead tr,
        html.dark-mode table thead th,
        html.dark-mode .table thead,
        html.dark-mode .table thead tr,
        html.dark-mode .table thead th,
        html.dark-mode [class*="-table"] thead,
        html.dark-mode [class*="-table"] thead tr,
        html.dark-mode [class*="-table"] thead th {
            background-color: #0f1c30 !important;
            border-bottom: 1px solid #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode table tbody td,
        html.dark-mode .table tbody td,
        html.dark-mode [class*="-table"] tbody td {
            background-color: transparent !important;
            border-bottom: 1px solid #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode table tbody tr:hover,
        html.dark-mode table tbody tr:hover td,
        html.dark-mode .table tbody tr:hover,
        html.dark-mode .table tbody tr:hover td,
        html.dark-mode [class*="-table"] tbody tr:hover,
        html.dark-mode [class*="-table"] tbody tr:hover td {
            background-color: #17263d !important;
        }
        html.dark-mode table tbody td strong,
        html.dark-mode table tbody td b,
        html.dark-mode table tbody td .font-semibold,
        html.dark-mode table tbody td .font-bold,
        html.dark-mode [class*="-table"] tbody td strong,
        html.dark-mode [class*="-table"] tbody td b,
        html.dark-mode [class*="-table"] tbody td .font-semibold,
        html.dark-mode [class*="-table"] tbody td .font-bold,
        html.dark-mode [class*="-table"] tbody td [class*="-title"],
        html.dark-mode [class*="-table"] tbody td [class*="-name"] {
            color: #f8fafc !important;
        }
        html.dark-mode table tbody td .text-muted,
        html.dark-mode [class*="-table"] tbody td .text-muted,
        html.dark-mode [class*="-table"] tbody td [class*="-sub"],
        html.dark-mode [class*="-table"] tbody td [class*="-job"],
        html.dark-mode [class*="-table"] tbody td [class*="-time"],
        html.dark-mode [class*="-table"] tbody td [class*="-date"] {
            color: #94a3b8 !important;
        }

        /* 6. Form Controls, Labels, Inputs & Placeholders */
        html.dark-mode label,
        html.dark-mode .form-label,
        html.dark-mode .form-label-normal,
        html.dark-mode [class*="-form-label"] {
            color: #cbd5e1 !important;
        }
        html.dark-mode input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
        html.dark-mode select,
        html.dark-mode textarea,
        html.dark-mode .form-control,
        html.dark-mode [class*="-control"],
        html.dark-mode [class*="-input"]:not(.btn),
        html.dark-mode [class*="-select"] {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode input::placeholder,
        html.dark-mode textarea::placeholder,
        html.dark-mode [class*="-input"]::placeholder {
            color: #64748b !important;
        }

        /* 7. Universal Pagination System */
        html.dark-mode .pagination-wrapper,
        html.dark-mode [class*="-pagination-wrap"],
        html.dark-mode [class*="-pagination-row"],
        html.dark-mode [class*="-pagination-footer"],
        html.dark-mode [class*="-pagination"],
        html.dark-mode .pagination {
            color: #94a3b8 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pagination a,
        html.dark-mode .pagination span,
        html.dark-mode .pagination-wrapper a,
        html.dark-mode .pagination-wrapper span,
        html.dark-mode [class*="-page-btn"],
        html.dark-mode [class*="-p-btn"],
        html.dark-mode .page-link,
        html.dark-mode .ar-page-btn,
        html.dark-mode .ast-p-btn,
        html.dark-mode .pgw-p-btn,
        html.dark-mode .kg-page-btn,
        html.dark-mode .ms-page-btn,
        html.dark-mode .pn-page-btn,
        html.dark-mode .sb-page-btn {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pagination a:hover,
        html.dark-mode .pagination-wrapper a:hover,
        html.dark-mode [class*="-page-btn"]:hover:not(.active):not(.disabled),
        html.dark-mode [class*="-p-btn"]:hover:not(.active):not(.disabled),
        html.dark-mode .page-link:hover,
        html.dark-mode .ar-page-btn:hover:not(.active):not(.disabled),
        html.dark-mode .ast-p-btn:hover:not(.active):not(.disabled),
        html.dark-mode .pgw-p-btn:hover:not(.active):not(.disabled),
        html.dark-mode .kg-page-btn:hover:not(.active):not(.disabled),
        html.dark-mode .ms-page-btn:hover:not(.active):not(.disabled),
        html.dark-mode .pn-page-btn:hover:not(.active):not(.disabled),
        html.dark-mode .sb-page-btn:hover:not(.active):not(.disabled) {
            background-color: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .pagination .active a,
        html.dark-mode .pagination .active span,
        html.dark-mode .pagination-wrapper .active,
        html.dark-mode [class*="-page-btn"].active,
        html.dark-mode [class*="-p-btn"].active,
        html.dark-mode .ar-page-btn.active,
        html.dark-mode .ast-p-btn.active,
        html.dark-mode .pgw-p-btn.active,
        html.dark-mode .kg-page-btn.active,
        html.dark-mode .ms-page-btn.active,
        html.dark-mode .pn-page-btn.active,
        html.dark-mode .sb-page-btn.active {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        html.dark-mode .pagination .disabled a,
        html.dark-mode .pagination .disabled span,
        html.dark-mode [class*="-page-btn"].disabled,
        html.dark-mode [class*="-p-btn"].disabled,
        html.dark-mode .ar-page-btn.disabled,
        html.dark-mode .ast-p-btn.disabled,
        html.dark-mode .pgw-p-btn.disabled,
        html.dark-mode .kg-page-btn.disabled,
        html.dark-mode .ms-page-btn.disabled,
        html.dark-mode .pn-page-btn.disabled,
        html.dark-mode .sb-page-btn.disabled {
            background-color: #0f1c30 !important;
            border-color: #1e3352 !important;
            color: #64748b !important;
            opacity: 0.45 !important;
        }

        /* 8. Empty States across all modules */
        html.dark-mode .empty-state,
        html.dark-mode [class*="-empty-state"],
        html.dark-mode td[colspan][style*="text-align:center"],
        html.dark-mode div[style*="text-align:center"] p {
            color: #94a3b8 !important;
        }

        /* 9. Hardcoded Hex Colors Nullification & High Contrast Remapping */
        /* Near Black / Deep Slate -> Bright Crisp White (#f8fafc) */
        html.dark-mode [style*="color:#000"],
        html.dark-mode [style*="color: #000"],
        html.dark-mode [style*="color:black"],
        html.dark-mode [style*="color: black"],
        html.dark-mode [style*="color:#020617"],
        html.dark-mode [style*="color: #020617"],
        html.dark-mode [style*="color:#091e42"],
        html.dark-mode [style*="color: #091e42"],
        html.dark-mode [style*="color:#0f172a"],
        html.dark-mode [style*="color: #0f172a"],
        html.dark-mode [style*="color:#0f2942"],
        html.dark-mode [style*="color: #0f2942"],
        html.dark-mode [style*="color:#111827"],
        html.dark-mode [style*="color: #111827"],
        html.dark-mode [style*="color:#162f4f"],
        html.dark-mode [style*="color: #162f4f"],
        html.dark-mode [style*="color:#1e293b"],
        html.dark-mode [style*="color: #1e293b"],
        html.dark-mode [style*="color:#1e3a5f"],
        html.dark-mode [style*="color: #1e3a5f"],
        html.dark-mode [style*="color:#1f2937"],
        html.dark-mode [style*="color: #1f2937"],
        html.dark-mode .text-dark,
        html.dark-mode .text-black,
        html.dark-mode .text-gray-900,
        html.dark-mode .text-gray-800,
        html.dark-mode .text-slate-900,
        html.dark-mode .text-slate-800,
        html.dark-mode .text-zinc-900,
        html.dark-mode .text-zinc-800,
        html.dark-mode .text-neutral-900,
        html.dark-mode .text-neutral-800 {
            color: #f8fafc !important;
        }

        /* Slate / Gray 700-600 -> Light readable Slate (#cbd5e1) */
        html.dark-mode [style*="color:#334155"],
        html.dark-mode [style*="color: #334155"],
        html.dark-mode [style*="color:#374151"],
        html.dark-mode [style*="color: #374151"],
        html.dark-mode [style*="color:#475569"],
        html.dark-mode [style*="color: #475569"],
        html.dark-mode [style*="color:#4b5563"],
        html.dark-mode [style*="color: #4b5563"],
        html.dark-mode .text-gray-700,
        html.dark-mode .text-slate-700,
        html.dark-mode .text-zinc-700,
        html.dark-mode .text-neutral-700 {
            color: #cbd5e1 !important;
        }

        /* Slate / Gray 500-400 & Muted -> High contrast secondary (#94a3b8) */
        html.dark-mode [style*="color:#64748b"],
        html.dark-mode [style*="color: #64748b"],
        html.dark-mode [style*="color:#6b7280"],
        html.dark-mode [style*="color: #6b7280"],
        html.dark-mode [style*="color:#9ca3af"],
        html.dark-mode [style*="color: #9ca3af"],
        html.dark-mode [style*="color:#94a3b8"],
        html.dark-mode [style*="color: #94a3b8"],
        html.dark-mode .text-muted,
        html.dark-mode .text-gray-500,
        html.dark-mode .text-slate-500 {
            color: #94a3b8 !important;
        }

        /* Dark / Deep Blues -> Vibrant Sky Blue (#38bdf8 / #60a5fa) */
        html.dark-mode [style*="color:#1e40af"],
        html.dark-mode [style*="color: #1e40af"],
        html.dark-mode [style*="color:#1d4ed8"],
        html.dark-mode [style*="color: #1d4ed8"],
        html.dark-mode [style*="color:#0369a1"],
        html.dark-mode [style*="color: #0369a1"],
        html.dark-mode [style*="color:#0284c7"],
        html.dark-mode [style*="color: #0284c7"],
        html.dark-mode [style*="color:#155e75"],
        html.dark-mode [style*="color: #155e75"],
        html.dark-mode [style*="color:#2563eb"],
        html.dark-mode [style*="color: #2563eb"],
        html.dark-mode [style*="color:#0891b2"],
        html.dark-mode [style*="color: #0891b2"],
        html.dark-mode [style*="color:#172554"],
        html.dark-mode [style*="color: #172554"] {
            color: #38bdf8 !important;
        }

        /* Dark / Deep Greens -> Vibrant Mint Green (#4ade80) */
        html.dark-mode [style*="color:#065f46"],
        html.dark-mode [style*="color: #065f46"],
        html.dark-mode [style*="color:#047857"],
        html.dark-mode [style*="color: #047857"],
        html.dark-mode [style*="color:#166534"],
        html.dark-mode [style*="color: #166534"],
        html.dark-mode [style*="color:#15803d"],
        html.dark-mode [style*="color: #15803d"],
        html.dark-mode [style*="color:#059669"],
        html.dark-mode [style*="color: #059669"],
        html.dark-mode [style*="color:#16a34a"],
        html.dark-mode [style*="color: #16a34a"],
        html.dark-mode [style*="color:#0f766e"],
        html.dark-mode [style*="color: #0f766e"] {
            color: #4ade80 !important;
        }

        /* Dark / Deep Reds -> Vibrant Coral Red (#f87171) */
        html.dark-mode [style*="color:#991b1b"],
        html.dark-mode [style*="color: #991b1b"],
        html.dark-mode [style*="color:#b91c1c"],
        html.dark-mode [style*="color: #b91c1c"],
        html.dark-mode [style*="color:#dc2626"],
        html.dark-mode [style*="color: #dc2626"],
        html.dark-mode [style*="color:#ef4444"],
        html.dark-mode [style*="color: #ef4444"],
        html.dark-mode [style*="color:#be185d"],
        html.dark-mode [style*="color: #be185d"],
        html.dark-mode [style*="color:#7f1d1d"],
        html.dark-mode [style*="color: #7f1d1d"] {
            color: #f87171 !important;
        }

        /* Dark / Deep Ambers & Browns -> Bright Warm Amber (#fbbf24) */
        html.dark-mode [style*="color:#78350f"],
        html.dark-mode [style*="color: #78350f"],
        html.dark-mode [style*="color:#854d0e"],
        html.dark-mode [style*="color: #854d0e"],
        html.dark-mode [style*="color:#92400e"],
        html.dark-mode [style*="color: #92400e"],
        html.dark-mode [style*="color:#b45309"],
        html.dark-mode [style*="color: #b45309"],
        html.dark-mode [style*="color:#d97706"],
        html.dark-mode [style*="color: #d97706"],
        html.dark-mode [style*="color:#c2410c"],
        html.dark-mode [style*="color: #c2410c"] {
            color: #fbbf24 !important;
        }

        /* Dark / Deep Purples -> Soft Lavender (#c084fc) */
        html.dark-mode [style*="color:#581c87"],
        html.dark-mode [style*="color: #581c87"],
        html.dark-mode [style*="color:#6d28d9"],
        html.dark-mode [style*="color: #6d28d9"],
        html.dark-mode [style*="color:#7e22ce"],
        html.dark-mode [style*="color: #7e22ce"],
        html.dark-mode [style*="color:#4338ca"],
        html.dark-mode [style*="color: #4338ca"] {
            color: #c084fc !important;
        }

        /* Universal Borders */
        html.dark-mode .border,
        html.dark-mode [style*="border-color:#e2e8f0"],
        html.dark-mode [style*="border-color: #e2e8f0"],
        html.dark-mode [style*="border-color:#e5e7eb"],
        html.dark-mode [style*="border-color: #e5e7eb"],
        html.dark-mode [style*="border-color:#cbd5e1"],
        html.dark-mode [style*="border-color: #cbd5e1"],
        html.dark-mode [style*="border-bottom:1px solid #f1f5f9"],
        html.dark-mode [style*="border-bottom: 1px solid #f1f5f9"],
        html.dark-mode [style*="border-bottom:1px solid #e2e8f0"],
        html.dark-mode [style*="border-bottom: 1px solid #e2e8f0"],
        html.dark-mode [style*="border-top:1px solid #f1f5f9"],
        html.dark-mode [style*="border-top: 1px solid #f1f5f9"] {
            border-color: #1e3352 !important;
        }

        /* ── Asisten AI Full Dark Mode ── */
        html.dark-mode .ai-chat-card,
        html.dark-mode .ai-chat-header,
        html.dark-mode .ai-chat-bottom,
        html.dark-mode .ai-messages-area,
        html.dark-mode .ai-sidebar {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ai-header-title {
            color: #f8fafc !important;
        }
        html.dark-mode .ai-header-subtitle {
            color: #94a3b8 !important;
        }
        html.dark-mode .ai-btn-header {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ai-btn-header:hover {
            background: #1e3352 !important;
            color: #f8fafc !important;
            border-color: #3b82f6 !important;
        }
        html.dark-mode .ai-bubble-bot,
        html.dark-mode .ai-msg-bubble-bot {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .ai-bubble-bot p,
        html.dark-mode .ai-msg-bubble-bot p {
            color: #e2e8f0 !important;
        }
        html.dark-mode .ai-msg-bubble-user {
            background-color: #1e3a5f !important;
            border-color: #2563eb !important;
            color: #f8fafc !important;
        }
        html.dark-mode .ai-msg-sender-bot,
        html.dark-mode .ai-msg-sender-user {
            color: #94a3b8 !important;
        }
        html.dark-mode .ai-file-badge {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .ai-file-badge:hover {
            border-color: #3b82f6 !important;
            background-color: #1e3352 !important;
        }
        html.dark-mode .ai-schedule-card,
        html.dark-mode .ai-mail-card {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ai-schedule-item,
        html.dark-mode .ai-mail-item {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .ai-schedule-time {
            color: #38bdf8 !important;
        }
        html.dark-mode .ai-schedule-title {
            color: #f8fafc !important;
        }
        html.dark-mode .ai-schedule-location {
            color: #94a3b8 !important;
        }
        html.dark-mode .ai-typing-indicator {
            background-color: #17263d !important;
        }
        html.dark-mode .ai-chip-btn {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ai-chip-btn:hover {
            background-color: #1e3352 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }
        html.dark-mode .ai-input-bar {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ai-input-bar:focus-within {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }
        html.dark-mode .ai-text-input {
            color: #f8fafc !important;
        }
        html.dark-mode .ai-text-input::placeholder {
            color: #64748b !important;
        }
        html.dark-mode .ai-clip-icon {
            color: #94a3b8 !important;
        }
        html.dark-mode .ai-clip-icon:hover {
            color: #f8fafc !important;
            background-color: #1e3352 !important;
        }
        html.dark-mode .ai-send-btn {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }
        html.dark-mode .ai-send-btn:hover {
            background-color: #1d4ed8 !important;
        }
        html.dark-mode .ai-disclaimer {
            color: #64748b !important;
        }
        html.dark-mode .ai-modal-card {
            background-color: #131f33 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .ai-modal-title {
            color: #f8fafc !important;
        }
        html.dark-mode .ai-modal-desc {
            color: #94a3b8 !important;
        }
        html.dark-mode .ai-modal-input {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }

        /* ── Media Sosial (ms-) Dark Mode ── */
        html.dark-mode .ms-toolbar-wrap {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ms-tabs { gap: 8px; }
        html.dark-mode .ms-tab {
            color: #94a3b8 !important;
        }
        html.dark-mode .ms-tab:hover { color: #f8fafc !important; }
        html.dark-mode .ms-tab.active {
            color: #38bdf8 !important;
            border-bottom-color: #38bdf8 !important;
        }
        html.dark-mode .ms-search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .ms-btn-filter {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .ms-btn-filter:hover {
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .ms-card,
        html.dark-mode .folder-card,
        html.dark-mode .file-card,
        html.dark-mode .file-body {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .folder-card:hover,
        html.dark-mode .file-card:hover {
            border-color: #3b82f6 !important;
        }
        html.dark-mode .folder-name,
        html.dark-mode .file-title {
            color: #f8fafc !important;
        }
        html.dark-mode .folder-count,
        html.dark-mode .file-desc {
            color: #94a3b8 !important;
            background: #0f1c30 !important;
        }
        html.dark-mode .folder-cal-year,
        html.dark-mode .ms-card-title {
            color: #f8fafc !important;
            background: #131f33 !important;
        }
        html.dark-mode .ms-card-desc,
        html.dark-mode .ms-date {
            color: #94a3b8 !important;
        }
        html.dark-mode .ms-card-footer {
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .dropdown-menu-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6) !important;
        }
        html.dark-mode .dropdown-menu-item {
            color: #cbd5e1 !important;
        }
        html.dark-mode .dropdown-menu-item:hover {
            background: #17263d !important;
            color: #ffffff !important;
        }
        html.dark-mode .dropdown-menu-item.danger { color: #f87171 !important; }
        html.dark-mode .dropdown-menu-item.danger:hover { background: #2d1515 !important; }
        html.dark-mode .ms-page-btn,
        html.dark-mode .ms-pagination-wrap .ms-page-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ms-page-btn:hover { border-color: #3b82f6 !important; color: #ffffff !important; }
        html.dark-mode .ms-page-btn.active { background: #2563eb !important; border-color: #2563eb !important; color: #fff !important; }
        html.dark-mode .ms-card-add,
        html.dark-mode .folder-card-add {
            background: #0f1c30 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ms-add-title { color: #f8fafc !important; }
        html.dark-mode .ms-add-sub { color: #94a3b8 !important; }
        html.dark-mode .ms-add-icon-wrap { background: #17263d !important; color: #60a5fa !important; }
        /* Folder search bar (folder.blade.php) */
        html.dark-mode .folder-search-bar {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .folder-search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .folder-filter-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .folder-filter-btn:hover { border-color: #3b82f6 !important; color: #fff !important; }
        html.dark-mode .kat-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .kat-btn:hover { border-color: #3b82f6 !important; }
        html.dark-mode .folder-header-cal-year { background: #131f33 !important; color: #f8fafc !important; }
        html.dark-mode .folder-header-info h1 { color: #f8fafc !important; }
        html.dark-mode .folder-header-info p { color: #94a3b8 !important; }
        html.dark-mode .btn-back {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .btn-back:hover { border-color: #3b82f6 !important; color: #fff !important; }
        html.dark-mode .folder-breadcrumb { color: #64748b !important; }
        html.dark-mode .folder-breadcrumb a { color: #60a5fa !important; }
        html.dark-mode .folder-breadcrumb .current { color: #f8fafc !important; }
        html.dark-mode .file-thumb { background: #0f1c30 !important; border-color: #1e3352 !important; }
        html.dark-mode .file-thumb-empty { background: linear-gradient(135deg, #17263d 0%, #0f1c30 100%) !important; }
        html.dark-mode .file-date-badge {
            background: rgba(19,31,51,0.92) !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .file-footer { border-top-color: #1e3352 !important; }

        /* ── Analisis (an-) Dark Mode ── */
        html.dark-mode .an-toolbar-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .an-filter-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .an-search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .an-select {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .an-table-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .an-table thead th {
            background: #0f1c30 !important;
            color: #94a3b8 !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .an-table tbody td {
            border-bottom-color: #1a2a44 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .an-table tbody tr:hover { background: #17263d !important; }
        html.dark-mode .an-judul-link { color: #f8fafc !important; }
        html.dark-mode .an-judul-link:hover { color: #60a5fa !important; }
        html.dark-mode .an-source-tag { background: #0f1c30 !important; color: #94a3b8 !important; }
        html.dark-mode .an-date-badge { color: #94a3b8 !important; }
        html.dark-mode .an-preview-text { color: #94a3b8 !important; }
        html.dark-mode .an-icon-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .an-icon-btn:hover { background: #1e3352 !important; color: #f8fafc !important; }
        html.dark-mode .an-icon-btn.delete:hover { background: #2d1515 !important; border-color: #7f1d1d !important; color: #f87171 !important; }
        html.dark-mode .an-year-select {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .an-breadcrumb a { color: #60a5fa !important; }
        html.dark-mode .an-breadcrumb span { color: #64748b !important; }
        html.dark-mode .folder-count-badge.folder-count-zero { background: #0f1c30 !important; color: #64748b !important; }
        html.dark-mode .folder-count-badge.folder-count-has { background: #172e54 !important; color: #93c5fd !important; border-color: #1e3a5f !important; }
        html.dark-mode .folder-name { color: #f8fafc !important; }
        html.dark-mode .output-info-grid {
            background: #0f1c30 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .info-field-label { color: #94a3b8 !important; }
        html.dark-mode .info-field-val { color: #f8fafc !important; }
        html.dark-mode .output-section-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .output-section-header.analisis-hdr { background: #0f1c30 !important; color: #f8fafc !important; }
        html.dark-mode .output-section-body { color: #cbd5e1 !important; }
        html.dark-mode .modal-container,
        html.dark-mode .modal-backdrop { background: rgba(11,19,32,0.8) !important; }
        html.dark-mode .modal-container {
            background: #131f33 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .modal-header {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .modal-footer {
            background: #0f1c30 !important;
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .empty-state { background: #0f1c30 !important; border-color: #1e3352 !important; }
        html.dark-mode .empty-state-icon { background: #17263d !important; }
        html.dark-mode .empty-state-title { color: #f8fafc !important; }
        html.dark-mode .empty-state-text { color: #94a3b8 !important; }

        /* ── Galeri Arsip (ga-) Full Dark Mode ── */
        html.dark-mode .ga-toolbar-wrap {
            border-bottom-color: #1e3352 !important;
            background: transparent !important;
        }
        html.dark-mode .ga-tabs { border-color: #1e3352 !important; }
        html.dark-mode .ga-tab { color: #94a3b8 !important; }
        html.dark-mode .ga-tab:hover { color: #f8fafc !important; }
        html.dark-mode .ga-tab.active {
            color: #38bdf8 !important;
            border-bottom-color: #38bdf8 !important;
            font-weight: 600 !important;
        }
        html.dark-mode .ga-btn-action {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .ga-btn-action:hover { background: #1e3352 !important; color: #fff !important; border-color: #3b82f6 !important; }
        html.dark-mode .ga-btn-select {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .ga-btn-select:hover { border-color: #ef4444 !important; color: #f87171 !important; background: #2d1515 !important; }
        html.dark-mode .ga-btn-select.active { background: #2d1515 !important; border-color: #ef4444 !important; color: #f87171 !important; }
        
        /* Galeri Arsip Toolbar Filters */
        html.dark-mode .ga-search-inp {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .ga-search-inp:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2) !important;
        }
        html.dark-mode .ga-search-icon,
        html.dark-mode .ga-search-clear {
            color: #64748b !important;
        }
        html.dark-mode .ga-search-clear:hover { color: #f87171 !important; }

        html.dark-mode .ga-date-filter-wrap,
        html.dark-mode .ga-toolbar-right div[style*="background:white"],
        html.dark-mode .ga-toolbar-right div[style*="background: white"],
        html.dark-mode .ga-toolbar-right div[style*="background:#fff"] {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ga-date-filter-wrap span,
        html.dark-mode .ga-date-lbl,
        html.dark-mode .ga-toolbar-right div[style*="background:white"] span,
        html.dark-mode .ga-toolbar-right div[style*="background: white"] span {
            color: #94a3b8 !important;
        }
        html.dark-mode .ga-date-filter-wrap input[type="date"],
        html.dark-mode .ga-toolbar-right input[type="date"] {
            color: #f8fafc !important;
            color-scheme: dark !important;
            background: transparent !important;
        }
        html.dark-mode select.ga-filter-select,
        html.dark-mode .ga-toolbar-right select {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .ga-btn-reset,
        html.dark-mode .ga-toolbar-right a[title*="Reset"] {
            background: #2d1515 !important;
            border-color: #7f1d1d !important;
            color: #f87171 !important;
        }

        /* Galeri Arsip Download Excel Button */
        html.dark-mode .ga-btn-export,
        html.dark-mode a.ga-btn-export,
        html.dark-mode a[onclick*="openExportModal"] {
            background: #132f22 !important;
            border-color: #16a34a !important;
            color: #4ade80 !important;
        }
        html.dark-mode .ga-btn-export:hover,
        html.dark-mode a.ga-btn-export:hover,
        html.dark-mode a[onclick*="openExportModal"]:hover {
            background: #166534 !important;
            color: #fff !important;
        }

        /* Galeri Arsip Active Filter Banner */
        html.dark-mode .ga-active-filter-banner,
        html.dark-mode [style*="background:#f0f9ff"][style*="border:1px solid #bae6fd"] {
            background: #0c233c !important;
            border-color: #1e3a5f !important;
            color: #38bdf8 !important;
        }
        html.dark-mode .ga-active-filter-banner span[style*="background:#dbeafe"],
        html.dark-mode .ga-active-filter-banner span[style*="background:#e0e7ff"] {
            background: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #93c5fd !important;
        }

        /* Galeri Arsip Cards */
        html.dark-mode .ga-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ga-card:hover {
            border-color: #2563eb !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4) !important;
        }
        html.dark-mode .ga-card-body {
            background: #131f33 !important;
        }
        html.dark-mode .ga-title { color: #f8fafc !important; }
        html.dark-mode .ga-date { color: #64748b !important; }
        html.dark-mode .ga-kode {
            background: #172e54 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .ga-kode:hover { background: #1e3a5f !important; }
        html.dark-mode .ga-card-tag.ga-instansi-tag,
        html.dark-mode .ga-card [style*="color:#1e40af"] {
            background: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #93c5fd !important;
        }
        html.dark-mode .ga-card-tag.ga-kegiatan-tag,
        html.dark-mode .ga-card [style*="color:#047857"] {
            background: #064e3b !important;
            border-color: #047857 !important;
            color: #6ee7b7 !important;
        }
        html.dark-mode .ga-file-badge.notulensi {
            background: #064e3b !important;
            border-color: #047857 !important;
            color: #6ee7b7 !important;
        }
        html.dark-mode .ga-file-badge.notulensi:hover { background: #047857 !important; color: #fff !important; }
        html.dark-mode .ga-file-badge.paparan {
            background: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #60a5fa !important;
        }
        html.dark-mode .ga-file-badge.paparan:hover { background: #1e3a5f !important; color: #fff !important; }
        html.dark-mode .ga-kw-badge {
            background: #0f1c30 !important;
            border-color: #1e3352 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .ga-kw-badge.more {
            background: #0f1c30 !important;
            border-color: #1e3352 !important;
            color: #64748b !important;
        }
        html.dark-mode .ga-footer { border-top-color: #1e3352 !important; }
        html.dark-mode .ga-akses { color: #94a3b8 !important; }
        html.dark-mode .ga-more-btn { color: #64748b !important; }
        html.dark-mode .ga-more-btn:hover { background: #17263d !important; color: #f8fafc !important; }
        html.dark-mode .ga-dropdown {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6) !important;
        }
        html.dark-mode .ga-dd-item { color: #cbd5e1 !important; }
        html.dark-mode .ga-dd-item:hover { background: #17263d !important; color: #fff !important; }
        html.dark-mode .ga-dd-item.danger { color: #f87171 !important; }
        html.dark-mode .ga-dd-item.danger:hover { background: #2d1515 !important; }
        html.dark-mode .ga-load-more-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ga-load-more-btn:hover { border-color: #3b82f6 !important; color: #fff !important; background: #1e3352 !important; }
        html.dark-mode .ga-thumb-bg { background-color: #0f1c30 !important; }

        /* Galeri Arsip & Kegiatan Pimpinan Modals */
        html.dark-mode #exportNotulensiModal > div,
        html.dark-mode #exportModal > div,
        html.dark-mode .ga-export-card,
        html.dark-mode .export-modal-card {
            background: #131f33 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode #exportNotulensiModal label,
        html.dark-mode #exportModal label {
            color: #cbd5e1 !important;
        }
        html.dark-mode #exportNotulensiModal p,
        html.dark-mode #exportModal p {
            color: #94a3b8 !important;
        }
        html.dark-mode #exportNotulensiModal select,
        html.dark-mode #exportModal select,
        html.dark-mode #exportTahunSelect {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode #exportNotulensiModal button[onclick*="closeExportModal"],
        html.dark-mode #exportModal button[onclick*="none"] {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .modal-content {
            background: #131f33 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .modal-header {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .modal-header h3 { color: #f8fafc !important; }
        html.dark-mode .modal-close { color: #94a3b8 !important; }
        html.dark-mode .modal-close:hover { color: #f8fafc !important; }
        html.dark-mode .modal-footer {
            background: #0f1c30 !important;
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .form-lbl { color: #cbd5e1 !important; }
        html.dark-mode .form-inp,
        html.dark-mode .form-sel,
        html.dark-mode .form-txa {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .viewer-doc-wrap { background: #131f33 !important; }
        html.dark-mode .viewer-doc-toolbar {
            background: #0f1c30 !important;
            border-bottom-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }

        /* ── Kegiatan Pimpinan (kg-) Dark Mode Rules ── */
        html.dark-mode .kg-btn-export,
        html.dark-mode button[onclick*="openExportModal"] {
            background: #132f22 !important;
            border-color: #16a34a !important;
            color: #4ade80 !important;
        }
        html.dark-mode .kg-btn-export:hover,
        html.dark-mode button[onclick*="openExportModal"]:hover {
            background: #166534 !important;
            color: #fff !important;
        }
        html.dark-mode .kg-id { color: #94a3b8 !important; }
        html.dark-mode .kg-judul { color: #f8fafc !important; }
        html.dark-mode .kg-judul-sub { color: #64748b !important; }
        html.dark-mode .kg-leading-tag {
            background: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #93c5fd !important;
        }
        html.dark-mode .kg-tanggal-date { color: #f8fafc !important; }
        html.dark-mode .kg-tanggal-time { color: #64748b !important; }
        html.dark-mode .kg-lokasi { color: #94a3b8 !important; }
        html.dark-mode .kg-dok-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .kg-dok-btn:hover {
            border-color: #3b82f6 !important;
            color: #38bdf8 !important;
            background: #1e3352 !important;
        }
        html.dark-mode .kg-dok-btn .kg-dok-badge.empty {
            background: #1e3352 !important;
            color: #64748b !important;
        }
        html.dark-mode .kg-dok-menu {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6) !important;
        }
        html.dark-mode .kg-dok-menu-header {
            border-bottom-color: #1e3352 !important;
            color: #64748b !important;
        }
        html.dark-mode .kg-dok-menu-item { color: #cbd5e1 !important; }
        html.dark-mode .kg-dok-menu-item:hover {
            background: #17263d !important;
            color: #38bdf8 !important;
        }
        html.dark-mode .kg-dok-menu-item .kg-dok-item-count {
            background: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .kg-dok-menu-item .kg-dok-item-count.has-data {
            background: #172e54 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .kg-page-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .kg-page-btn:hover { background: #1e3352 !important; color: #fff !important; }
        html.dark-mode .kg-page-btn.active {
            background: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #fff !important;
        }
        html.dark-mode .selection-action-bar {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .selection-info { color: #f8fafc !important; }

        /* ── Surat Keluar / Arsip Surat stat cards ── */
        html.dark-mode .stat-value { color: #f8fafc !important; }
        html.dark-mode .stat-label { color: #94a3b8 !important; }
        html.dark-mode .stat-sub { color: #64748b !important; }
        html.dark-mode .stat-icon-wrap {
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        html.dark-mode .stat-icon-masuk {
            background: #172e54 !important;
            color: #60a5fa !important;
            border-color: rgba(96, 165, 250, 0.25) !important;
        }
        html.dark-mode .stat-icon-keluar {
            background: #083344 !important;
            color: #22d3ee !important;
            border-color: rgba(34, 211, 238, 0.25) !important;
        }
        html.dark-mode .stat-icon-total {
            background: #064e3b !important;
            color: #4ade80 !important;
            border-color: rgba(74, 222, 128, 0.25) !important;
        }
        html.dark-mode .filter-card,
        html.dark-mode .table-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .btn-filter-submit {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .btn-filter-submit:hover { background: #1e3352 !important; color: #fff !important; }

        /* ── Asset Dark Mode (ast-) ── */
        html.dark-mode .ast-tabs-bar {
            background: #131f33 !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .ast-tab-link { color: #94a3b8 !important; }
        html.dark-mode .ast-tab-link:hover { color: #f8fafc !important; }
        html.dark-mode .ast-tab-link.active { color: #38bdf8 !important; border-bottom-color: #38bdf8 !important; }
        html.dark-mode .ast-toolbar { border-bottom-color: #1e3352 !important; }

        /* ── Penugasan Personel (pn-) Dark Mode ── */
        html.dark-mode .pn-container { color: #cbd5e1 !important; }
        html.dark-mode .pn-header h1,
        html.dark-mode .pn-title,
        html.dark-mode .pn-create-title { color: #f8fafc !important; }
        html.dark-mode .pn-subtitle,
        html.dark-mode .pn-create-subtitle { color: #94a3b8 !important; }

        /* Stat Cards */
        html.dark-mode .pn-stat-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pn-stat-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-stat-number {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-stat-number.red-text {
            color: #f87171 !important;
        }
        html.dark-mode .pn-stat-unit {
            color: #cbd5e1 !important;
        }
        html.dark-mode .pn-stat-icon-circle.blue {
            background: #172e54 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .pn-stat-icon-circle.orange {
            background: #3b2210 !important;
            color: #fb923c !important;
        }
        html.dark-mode .pn-stat-icon-circle.red {
            background: #3b1717 !important;
            color: #f87171 !important;
        }

        /* Sidebar: Status Personel */
        html.dark-mode .pn-sidebar-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pn-sidebar-card-title {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-p-name {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-p-job {
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-p-indicator-dot {
            border-color: #131f33 !important;
        }
        html.dark-mode .pn-personel-items-list::-webkit-scrollbar-thumb {
            background: #1e3352 !important;
        }

        /* Main Card & Toolbar */
        html.dark-mode .pn-main-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pn-toolbar {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .pn-search-input {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pn-search-input::placeholder {
            color: #64748b !important;
        }
        html.dark-mode .pn-search-icon {
            color: #64748b !important;
        }
        html.dark-mode .pn-select-role {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .pn-date-input {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .pn-btn-tugas-baru {
            background: #1e3a5f !important;
            color: #ffffff !important;
        }
        html.dark-mode .pn-btn-tugas-baru:hover {
            background: #2563eb !important;
        }

        /* Table & Rows */
        html.dark-mode .pn-data-table thead th {
            background: #0f1c30 !important;
            border-bottom-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-data-table tbody td {
            border-bottom-color: #1e3352 !important;
            color: #cbd5e1 !important;
            background: transparent !important;
        }
        html.dark-mode .pn-data-table tbody tr:hover {
            background: #17263d !important;
        }
        html.dark-mode .pn-kegiatan-name {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-kegiatan-time {
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-kegiatan-time svg {
            color: #64748b !important;
        }
        html.dark-mode .pn-lokasi-name {
            color: #cbd5e1 !important;
        }
        html.dark-mode .pn-pimpinan-tag {
            background: #17263d !important;
            color: #94a3b8 !important;
            border: 1px solid #1e3352 !important;
        }
        html.dark-mode .pn-pimpinan-tag svg {
            color: #64748b !important;
        }
        html.dark-mode .pn-member-name {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-member-role {
            color: #94a3b8 !important;
        }

        /* Status Pills */
        html.dark-mode .pn-status-pill.dikonfirmasi {
            background: #172e54 !important;
            color: #60a5fa !important;
        }
        html.dark-mode .pn-status-pill.ditugaskan {
            background: #17263d !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-status-pill.berlangsung {
            background: #064e3b !important;
            color: #6ee7b7 !important;
        }
        html.dark-mode .pn-status-pill.selesai {
            background: #064e3b !important;
            color: #34d399 !important;
        }
        html.dark-mode .pn-status-pill.tidak_hadir {
            background: #3b1717 !important;
            color: #f87171 !important;
        }

        /* Action Dropdown */
        html.dark-mode .pn-btn-dots-menu {
            color: #64748b !important;
        }
        html.dark-mode .pn-btn-dots-menu:hover {
            background: #17263d !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pn-actions-dropdown {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark-mode .pn-dropdown-action-btn {
            color: #cbd5e1 !important;
        }
        html.dark-mode .pn-dropdown-action-btn:hover {
            background: #17263d !important;
            color: #ffffff !important;
        }
        html.dark-mode .pn-dropdown-action-btn.danger-action {
            color: #f87171 !important;
        }
        html.dark-mode .pn-dropdown-action-btn.danger-action:hover {
            background: #2d1515 !important;
        }

        /* Pagination & Empty */
        html.dark-mode .pn-pagination-row {
            border-top-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-page-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-page-btn:hover {
            background: #1e3352 !important;
            color: #ffffff !important;
        }
        html.dark-mode .pn-page-btn.active {
            background: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .pn-data-table td[colspan] {
            color: #94a3b8 !important;
        }
        html.dark-mode .pn-data-table td[colspan] p {
            color: #cbd5e1 !important;
        }
        html.dark-mode .pn-data-table td[colspan] a {
            color: #38bdf8 !important;
        }

        /* Penugasan Create Form */
        html.dark-mode .pn-form-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pn-section-title-wrap {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-label {
            color: #cbd5e1 !important;
        }
        html.dark-mode .pn-input-control,
        html.dark-mode .pn-select-control,
        html.dark-mode .pn-textarea-control {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .pn-hint {
            color: #64748b !important;
        }
        html.dark-mode .pn-tags-container {
            background: #17263d !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .pn-tags-search-input {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-tag-chip {
            background: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #93c5fd !important;
        }
        html.dark-mode .pn-personel-dropdown {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark-mode .pn-personel-opt-item:hover {
            background: #17263d !important;
        }
        html.dark-mode .pn-personel-opt-name {
            color: #f8fafc !important;
        }
        html.dark-mode .pn-personel-opt-job {
            color: #94a3b8 !important;
        }

        /* ── Universal Dark Form & Date Controls ── */
        html.dark-mode input,
        html.dark-mode select,
        html.dark-mode textarea {
            color-scheme: dark !important;
        }

        /* ── Universal Light Background Segments Nullification ── */
        html.dark-mode [style*="background:#fafafa"],
        html.dark-mode [style*="background: #fafafa"],
        html.dark-mode [style*="background:#f8fafc"],
        html.dark-mode [style*="background: #f8fafc"],
        html.dark-mode [style*="background:#f1f5f9"],
        html.dark-mode [style*="background: #f1f5f9"],
        html.dark-mode [style*="background:#f9fafb"],
        html.dark-mode [style*="background: #f9fafb"],
        html.dark-mode [style*="background:#fafbff"],
        html.dark-mode [style*="background: #fafbff"],
        html.dark-mode [style*="background:#f4f6f9"],
        html.dark-mode [style*="background: #f4f6f9"],
        html.dark-mode [style*="background:#e2e8f0"],
        html.dark-mode [style*="background: #e2e8f0"],
        html.dark-mode [style*="background:#eff6ff"],
        html.dark-mode [style*="background: #eff6ff"],
        html.dark-mode [style*="background:#f0f7ff"],
        html.dark-mode [style*="background: #f0f7ff"],
        html.dark-mode [style*="background:#f0fdf4"],
        html.dark-mode [style*="background: #f0fdf4"],
        html.dark-mode [style*="background:#f0f9ff"],
        html.dark-mode [style*="background: #f0f9ff"],
        html.dark-mode div[style*="background:white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode div[style*="background: white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode div[style*="background:#fff"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode div[style*="background: #fff"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode select[style*="background:white"],
        html.dark-mode select[style*="background: white"] {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
        }

        /* ── Arsip Terhapus (trash-) Full Dark Mode ── */
        html.dark-mode .trash-header-left h1 {
            color: #f8fafc !important;
        }
        html.dark-mode .trash-header-left p {
            color: #94a3b8 !important;
        }
        html.dark-mode .two-layer-banner {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.4) 0%, rgba(12, 74, 110, 0.35) 100%) !important;
            border-color: rgba(16, 185, 129, 0.35) !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
        }
        html.dark-mode .two-layer-banner-icon {
            background: rgba(16, 185, 129, 0.2) !important;
            color: #34d399 !important;
            border: 1px solid rgba(52, 211, 153, 0.35) !important;
            box-shadow: none !important;
        }
        html.dark-mode .two-layer-banner-text h4 {
            color: #f1f5f9 !important;
        }
        html.dark-mode .two-layer-banner-text p {
            color: #cbd5e1 !important;
        }
        html.dark-mode .two-layer-banner-text strong {
            color: #38bdf8 !important;
        }
        html.dark-mode .trash-stat-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .trash-stat-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .trash-stat-value {
            color: #f8fafc !important;
        }
        html.dark-mode .trash-stat-sub {
            color: #64748b !important;
        }
        html.dark-mode .trash-container-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .trash-toolbar {
            background-color: #131f33 !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .trash-filter-select {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .trash-search-box input {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .trash-search-box input:focus {
            border-color: #3b82f6 !important;
        }
        html.dark-mode .btn-trash-empty {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .btn-trash-empty:hover {
            background-color: #2d1515 !important;
            border-color: #7f1d1d !important;
            color: #f87171 !important;
        }
        html.dark-mode .trash-table thead th {
            background-color: #0f1c30 !important;
            border-bottom-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .trash-table tbody td {
            border-bottom-color: #1e3352 !important;
            color: #cbd5e1 !important;
            background-color: transparent !important;
        }
        html.dark-mode .trash-table tbody tr:hover td {
            background-color: #17263d !important;
        }
        html.dark-mode .trash-table tbody tr.selected td {
            background-color: #172e54 !important;
        }
        html.dark-mode .file-chip {
            background-color: #17263d !important;
            color: #cbd5e1 !important;
        }

        /* ── Pegawai Form Edit/Create (pgw-form-*) Full Dark Mode ── */
        html.dark-mode .pgw-form-container {
            color: #f1f5f9 !important;
        }
        html.dark-mode .pgw-form-title {
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-form-subtitle {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-back-btn {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pgw-back-btn:hover {
            background: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-form-card {
            background: #131f33 !important;
            border-color: #1e3352 !important;
            box-shadow: 0 1px 6px rgba(0,0,0,0.3) !important;
        }
        html.dark-mode .pgw-section-header {
            color: #f1f5f9 !important;
        }
        html.dark-mode .pgw-section-icon {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .pgw-input-text,
        html.dark-mode .pgw-select {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #f1f5f9 !important;
            color-scheme: dark !important;
        }
        html.dark-mode .pgw-input-text:focus,
        html.dark-mode .pgw-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2) !important;
        }
        html.dark-mode .pgw-input-text::placeholder {
            color: #475569 !important;
        }
        html.dark-mode .pgw-select {
            background: #17263d url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E") no-repeat right 12px center / 13px !important;
        }
        html.dark-mode .pgw-btn-cancel {
            background: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .pgw-btn-cancel:hover {
            background: #1e3352 !important;
            color: #f8fafc !important;
        }
        html.dark-mode .pgw-btn-save {
            background: #1a4a7a !important;
        }
        html.dark-mode .pgw-btn-save:hover {
            background: #1e5490 !important;
        }

        /* ── File Drop Zone & Form Footer Full Dark Mode ── */
        html.dark-mode .file-drop-zone {
            background-color: #0f1c30 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .file-drop-zone:hover,
        html.dark-mode .file-drop-zone.dragging {
            border-color: #38bdf8 !important;
            background-color: #17263d !important;
        }
        html.dark-mode .file-drop-label {
            color: #f1f5f9 !important;
        }
        html.dark-mode .file-drop-hint {
            color: #94a3b8 !important;
        }
        html.dark-mode .form-footer {
            background-color: #0f1c30 !important;
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .form-card-section-title {
            color: #f8fafc !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .dok-tab-nav {
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .dok-tab-btn {
            color: #94a3b8 !important;
        }
        html.dark-mode .dok-tab-btn:hover {
            color: #f1f5f9 !important;
        }
        html.dark-mode .dok-tab-btn.active {
            color: #38bdf8 !important;
            border-bottom-color: #38bdf8 !important;
        }
        html.dark-mode .dok-tab-btn .tab-badge {
            background: #17263d !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .dok-tab-btn.active .tab-badge {
            background: #0284c7 !important;
            color: #ffffff !important;
        }
        html.dark-mode .btn-secondary,
        html.dark-mode .btn-outline {
            background-color: #17263d !important;
            color: #cbd5e1 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .btn-secondary:hover,
        html.dark-mode .btn-outline:hover {
            background-color: #1e3352 !important;
            color: #f8fafc !important;
            border-color: #3b82f6 !important;
        }

        /* ── Arsip Surat (ar-) Full Dark Mode ── */
        html.dark-mode .arsip-page {
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-header-left h1 {
            color: #f8fafc !important;
        }
        html.dark-mode .ar-header-left p {
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-filter-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ar-filter-label {
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-select-control,
        html.dark-mode .ar-date-control {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .ar-date-separator {
            color: #64748b !important;
        }
        html.dark-mode .ar-table-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .ar-table thead th {
            background-color: #0f1c30 !important;
            border-bottom-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-table tbody td {
            border-bottom-color: #1e3352 !important;
            color: #cbd5e1 !important;
            background-color: transparent !important;
        }
        html.dark-mode .ar-clickable-row:hover td {
            background-color: #17263d !important;
        }
        html.dark-mode .ar-clickable-row:active td {
            background-color: #1e3352 !important;
        }
        html.dark-mode .ar-cell-no {
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-doc-title {
            color: #f8fafc !important;
        }
        html.dark-mode .ar-doc-nomor {
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-date-text,
        html.dark-mode .ar-uploader-text,
        html.dark-mode [class*="-uploader-text"],
        html.dark-mode [class*="-uploader"] {
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-pagination-footer,
        html.dark-mode [class*="-pagination-footer"] {
            border-top-color: #1e3352 !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-page-btn,
        html.dark-mode .ast-p-btn,
        html.dark-mode .pgw-p-btn,
        html.dark-mode [class*="-p-btn"],
        html.dark-mode [class*="-page-btn"] {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-page-btn:hover,
        html.dark-mode .ast-p-btn:hover,
        html.dark-mode .pgw-p-btn:hover,
        html.dark-mode [class*="-p-btn"]:hover:not(.active):not(.disabled),
        html.dark-mode [class*="-page-btn"]:hover:not(.active):not(.disabled) {
            background-color: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .ar-page-btn.active,
        html.dark-mode .ast-p-btn.active,
        html.dark-mode .pgw-p-btn.active,
        html.dark-mode [class*="-p-btn"].active,
        html.dark-mode [class*="-page-btn"].active {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        html.dark-mode .ar-page-btn.disabled,
        html.dark-mode .ast-p-btn.disabled,
        html.dark-mode .pgw-p-btn.disabled,
        html.dark-mode [class*="-p-btn"].disabled,
        html.dark-mode [class*="-page-btn"].disabled {
            background-color: #0f1c30 !important;
            border-color: #1e3352 !important;
            color: #64748b !important;
            opacity: 0.45 !important;
        }
        html.dark-mode a[title="Edit Arsip"],
        html.dark-mode td a[style*="background:#ffffff"],
        html.dark-mode td a[style*="background: #ffffff"],
        html.dark-mode td a[style*="background:white"],
        html.dark-mode td a[style*="background: white"] {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode a[title="Edit Arsip"]:hover,
        html.dark-mode td a[style*="background:#ffffff"]:hover,
        html.dark-mode td a[style*="background: #ffffff"]:hover,
        html.dark-mode td a[style*="background:white"]:hover,
        html.dark-mode td a[style*="background: white"]:hover {
            background-color: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .ar-modal-card,
        html.dark-mode .ar-doc-viewer-container {
            background-color: #131f33 !important;
            border: 1px solid #1e3352 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark-mode .ar-modal-header,
        html.dark-mode .ar-viewer-header {
            background-color: #131f33 !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .ar-modal-title,
        html.dark-mode .ar-viewer-title,
        html.dark-mode #arViewTitle {
            color: #f8fafc !important;
        }
        html.dark-mode .ar-modal-sub,
        html.dark-mode .ar-viewer-meta {
            color: #94a3b8 !important;
        }
        html.dark-mode .ar-modal-footer {
            background-color: #0f1c30 !important;
            border-top-color: #1e3352 !important;
        }
        html.dark-mode .ar-btn-cancel {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-btn-cancel:hover {
            background-color: #1e3352 !important;
            color: #ffffff !important;
        }
        html.dark-mode .ar-form-lbl {
            color: #cbd5e1 !important;
        }
        html.dark-mode .ar-form-input,
        html.dark-mode .ar-form-select,
        html.dark-mode .ar-form-textarea {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }

        /* ── Surat Keluar & Surat Masuk (Keuangan) Dark Mode ── */
        html.dark-mode .page-header-left h1 {
            color: #f8fafc !important;
        }
        html.dark-mode .page-header-left p {
            color: #94a3b8 !important;
        }
        html.dark-mode .btn-secondary-action {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .btn-secondary-action:hover {
            background-color: #1e3352 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }
        html.dark-mode .filter-select {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .td-nomor,
        html.dark-mode .td-perihal,
        html.dark-mode .td-pengirim,
        html.dark-mode .sb-perihal-main,
        html.dark-mode .suc-title,
        html.dark-mode .suc-field-value {
            color: #f8fafc !important;
        }
        html.dark-mode .td-tujuan,
        html.dark-mode .td-date,
        html.dark-mode .td-disposisi,
        html.dark-mode .td-keterangan,
        html.dark-mode .sb-nomor {
            color: #cbd5e1 !important;
        }

        /* ── Profil Admin & Pengaturan Dark Mode ── */
        html.dark-mode .profile-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .profile-name {
            color: #f8fafc !important;
        }
        html.dark-mode .profile-role-badge {
            background-color: #172e54 !important;
            border-color: #1e3a5f !important;
            color: #93c5fd !important;
        }
        html.dark-mode .settings-tabs {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .settings-tab-item {
            color: #94a3b8 !important;
        }
        html.dark-mode .settings-tab-item:hover {
            background-color: #17263d !important;
            color: #f8fafc !important;
        }
        html.dark-mode .settings-tab-item.active {
            background-color: #17263d !important;
            color: #38bdf8 !important;
            border-left-color: #38bdf8 !important;
        }

        /* ── Additional Background Segments Nullification ── */
        html.dark-mode button[style*="background:white"],
        html.dark-mode button[style*="background: white"],
        html.dark-mode button[style*="background:#fff"],
        html.dark-mode button[style*="background: #fff"],
        html.dark-mode span[style*="background:white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode span[style*="background: white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode a[style*="background:white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode a[style*="background: white"]:not(.kg-avatar):not(.user-avatar),
        html.dark-mode [style*="background:#edf2f7"],
        html.dark-mode [style*="background: #edf2f7"] {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
        }

        /* ── Universal File Upload Area & Form Elements in Dark Mode ── */
        html.dark-mode .upload-area,
        html.dark-mode [class*="-upload-area"],
        html.dark-mode .drop-zone {
            background-color: #0f1c30 !important;
            border-color: #1e3352 !important;
            color: #cbd5e1 !important;
        }
        html.dark-mode .upload-area:hover,
        html.dark-mode .upload-area.dragover {
            background-color: #17263d !important;
            border-color: #3b82f6 !important;
        }
        html.dark-mode .upload-main,
        html.dark-mode .upload-title,
        html.dark-mode [class*="-upload-main"] {
            color: #f8fafc !important;
        }
        html.dark-mode .upload-sub,
        html.dark-mode .upload-hint,
        html.dark-mode [class*="-upload-sub"],
        html.dark-mode [class*="-upload-hint"] {
            color: #94a3b8 !important;
        }
        html.dark-mode .disposisi-card,
        html.dark-mode .form-card {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }
        html.dark-mode .disposisi-title,
        html.dark-mode .form-card-title {
            color: #f8fafc !important;
            border-bottom-color: #1e3352 !important;
        }
        html.dark-mode .form-group .form-label,
        html.dark-mode .form-group label.form-label,
        html.dark-mode .upload-label-text {
            color: #cbd5e1 !important;
        }
        html.dark-mode .form-input,
        html.dark-mode .form-select,
        html.dark-mode .form-textarea {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
            color-scheme: dark !important;
        }
        html.dark-mode .form-input::placeholder,
        html.dark-mode .form-textarea::placeholder {
            color: #64748b !important;
        }
    </style>
</head>
<body>
<div class="app-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon" onclick="if(document.body.classList.contains('sidebar-collapsed')) toggleSidebarCollapse()" style="cursor:pointer;" title="E-PROKOPIM">
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
            <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                <span class="nav-text">Dashboard</span>
            </a>

            {{-- 2. Kegiatan Pimpinan --}}
            <a href="{{ route('kegiatan-pimpinan.index') }}" class="sidebar-nav-link {{ request()->routeIs('kegiatan-pimpinan.*') ? 'active' : '' }}" title="Kegiatan Pimpinan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                <span class="nav-text">Kegiatan Pimpinan</span>
            </a>

            {{-- 3. Komunikasi Pimpinan (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('sambutan.*') || request()->routeIs('media-sosial.*') || request()->routeIs('analisis.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)" title="Komunikasi Pimpinan">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                    <span class="nav-text">Komunikasi Pimpinan</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('sambutan.*') || request()->routeIs('media-sosial.*') || request()->routeIs('analisis.*')) ? 'open' : '' }}">
                    <a href="{{ route('sambutan.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('sambutan.*') ? 'active' : '' }}">
                        Sambutan
                    </a>
                    <a href="{{ route('media-sosial.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('media-sosial.*') ? 'active' : '' }}">
                        Media Sosial
                    </a>
                    <a href="{{ route('analisis.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('analisis.*') ? 'active' : '' }}">
                        Analisis
                    </a>
                </div>
            </div>

            {{-- 4. Dokumentasi Pimpinan (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('sub-dokumentasi-pimpinan.*') || request()->routeIs('galeri-arsip.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)" title="Dokumentasi Pimpinan">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                    <span class="nav-text">Dokumentasi Pimpinan</span>
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
                <div class="sidebar-nav-group-header {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*') || request()->routeIs('sub-protokol.*') || request()->routeIs('arahan.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)" title="Protokol Pimpinan">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    <span class="nav-text">Protokol Pimpinan</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*') || request()->routeIs('sub-protokol.*') || request()->routeIs('arahan.*')) ? 'open' : '' }}">
                    <a href="{{ route('protokol-pimpinan.penugasan.index') }}" class="sidebar-nav-sublink {{ (request()->routeIs('penugasan.*') || request()->routeIs('protokol-pimpinan.penugasan.*')) ? 'active' : '' }}">
                        Penugasan
                    </a>
                    <a href="{{ route('arahan.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('arahan.*') ? 'active' : '' }}">
                        Arahan Pimpinan
                    </a>
                </div>
            </div>

            {{-- 6. Administrasi (dropdown) --}}
            <div class="sidebar-nav-group">
                <div class="sidebar-nav-group-header {{ (request()->routeIs('arsip.*') || request()->routeIs('asset.*') || request()->routeIs('pegawai.*') || request()->routeIs('keuangan.*') || request()->routeIs('surat-keluar.*')) ? 'active open' : '' }}" onclick="toggleNavGroup(this)" title="Administrasi">
                    <svg class="main-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" /></svg>
                    <span class="nav-text">Administrasi</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </div>
                <div class="sidebar-nav-group-children {{ (request()->routeIs('arsip.*') || request()->routeIs('asset.*') || request()->routeIs('pegawai.*') || request()->routeIs('keuangan.*') || request()->routeIs('surat-keluar.*')) ? 'open' : '' }}">
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
                        Surat Masuk
                    </a>
                    <a href="{{ route('surat-keluar.index') }}" class="sidebar-nav-sublink {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                        Surat Keluar
                    </a>
                </div>
            </div>

            {{-- 7. Asisten AI --}}
            <a href="{{ route('asisten-ai.index') }}" class="sidebar-nav-link {{ request()->routeIs('asisten-ai.*') ? 'active' : '' }}" title="Asisten AI">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
                <span class="nav-text">Asisten AI</span>
            </a>

            {{-- 8. Arsip Terhapus (Recycle Bin) --}}
            <a href="{{ route('trash.index') }}" class="sidebar-nav-link {{ request()->routeIs('trash.*') ? 'active' : '' }}" title="Arsip Terhapus">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                <span class="nav-text">Arsip Terhapus</span>
            </a>

            {{-- Tautan Sistem --}}
            <div class="sidebar-divider"></div>
            <div class="sidebar-nav-label">Tautan Sistem</div>

            <a href="https://prokopim.bandung.go.id" class="sidebar-nav-link" target="_blank" title="Website Prokopim">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                <span class="nav-text">Website Prokopim</span>
                <svg class="ext-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>

        </nav>

        {{-- Footer: Pengaturan & Profil --}}
        <div class="sidebar-footer">
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('pengaturan.index') }}" class="sidebar-nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" title="Pengaturan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span class="nav-text">Pengaturan</span>
            </a>
            @endif
            <a href="{{ route('profil-admin.index') }}" class="sidebar-nav-link {{ request()->routeIs('profil-admin.*') ? 'active' : '' }}" title="Profil">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span class="nav-text">Profil</span>
            </a>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <header class="topbar">
            {{-- Left --}}
            <div class="topbar-left"></div>

            {{-- Right: Notification, Help, Apps Grid, Profile --}}
            <div class="topbar-right">
                {{-- Theme Mode Toggle (Dark / Light) --}}
                <button type="button" class="topbar-icon-btn theme-toggle-btn" id="theme-toggle-btn" title="Beralih ke Mode Gelap" onclick="toggleThemeMode()" aria-label="Toggle Dark/Light Mode">
                    <svg class="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg class="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>

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
                <a href="{{ route('panduan.index') }}" target="_blank" rel="noopener noreferrer" class="topbar-icon-btn" title="Pusat Bantuan & Panduan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                </a>


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
                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('pengaturan.index') }}" class="profile-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Pengaturan
                        </a>
                        @endif
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
function toggleSidebarCollapse() {
    const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
    document.documentElement.classList.toggle('sidebar-collapsed', isCollapsed);
    localStorage.setItem('prokopim_sidebar_collapsed', isCollapsed ? 'true' : 'false');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    if (toggleBtn) {
        toggleBtn.setAttribute('title', isCollapsed ? 'Buka Sidebar' : 'Lipat Sidebar');
    }
}
if (localStorage.getItem('prokopim_sidebar_collapsed') === 'true') {
    document.body.classList.add('sidebar-collapsed');
}

function toggleNavGroup(header) {
    if (document.body.classList.contains('sidebar-collapsed')) {
        toggleSidebarCollapse();
    }
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

// ── Theme Mode (Dark / Light) ──────────────────────────────────
function toggleThemeMode() {
    const isDark = document.documentElement.classList.toggle('dark-mode');
    localStorage.setItem('prokopim_theme', isDark ? 'dark' : 'light');
    syncThemeToggleState(isDark);
}

function syncThemeToggleState(isDark) {
    const btn = document.getElementById('theme-toggle-btn');
    if (btn) {
        btn.setAttribute('title', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');
        btn.setAttribute('aria-label', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    syncThemeToggleState(document.documentElement.classList.contains('dark-mode'));
});
</script>
@stack('scripts')
</body>
</html>
