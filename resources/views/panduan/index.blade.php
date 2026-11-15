<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Panduan Penggunaan — E-PROKOPIM Kota Bandung</title>
    <meta name="description" content="Buku panduan lengkap dan dokumentasi resmi penggunaan Sistem Informasi Protokol dan Komunikasi Pimpinan (E-PROKOPIM) Pemerintah Kota Bandung.">
    <script>
        if (localStorage.getItem('prokopim_theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-900: #0b192c;
            --primary-800: #0d2137;
            --primary-700: #133358;
            --primary-600: #1e40af;
            --primary-500: #2563eb;
            --primary-400: #3b82f6;
            --primary-100: #dbeafe;
            --primary-50: #eff6ff;

            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-500: #64748b;
            --slate-400: #94a3b8;
            --slate-300: #cbd5e1;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;

            --emerald-600: #059669;
            --emerald-50: #ecfdf5;
            --amber-600: #d97706;
            --amber-50: #fffbeb;
            --rose-600: #e11d48;
            --rose-50: #fff1f2;
            --purple-600: #7c3aed;
            --purple-50: #faf5ff;

            --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --sidebar-width: 290px;
            --header-height: 64px;
        }

        html.dark-mode {
            --primary-900: #0b1320;
            --primary-800: #131f33;
            --primary-700: #17263d;
            --primary-50: #172e54;
            --primary-100: #1e3a5f;
            --slate-900: #f8fafc;
            --slate-800: #f1f5f9;
            --slate-700: #cbd5e1;
            --slate-600: #94a3b8;
            --slate-500: #64748b;
            --slate-400: #475569;
            --slate-300: #1e3352;
            --slate-200: #1e3352;
            --slate-100: #17263d;
            --slate-50: #0b1320;
            --emerald-50: #064e3b;
            --amber-50: #451a03;
            --rose-50: #4c0519;
            --purple-50: #2e1065;
            color-scheme: dark;
        }

        html.dark-mode body {
            background: #0b1320;
            color: #cbd5e1;
        }

        html.dark-mode .guide-header,
        html.dark-mode .guide-sidebar,
        html.dark-mode .guide-topic,
        html.dark-mode .guide-card,
        html.dark-mode .feature-box,
        html.dark-mode .faq-item {
            background-color: #131f33 !important;
            border-color: #1e3352 !important;
        }

        html.dark-mode .guide-search-input,
        html.dark-mode .code-block {
            background-color: #17263d !important;
            border-color: #1e3352 !important;
            color: #f8fafc !important;
        }

        html.dark-mode .sidebar-link:hover,
        html.dark-mode .sidebar-link.active {
            background-color: #17263d !important;
            color: #38bdf8 !important;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-main);
            color: var(--slate-800);
            background: #f8fafc;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header ── */
        .guide-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: #ffffff;
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 50;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .header-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-600) 100%);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 8px -2px rgba(13, 33, 55, 0.3);
        }

        .header-title-box h1 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--primary-800);
            letter-spacing: -0.2px;
            line-height: 1.2;
        }

        .header-title-box span {
            font-size: 11.5px;
            color: var(--slate-500);
            display: block;
        }

        .header-center-search {
            flex: 1;
            max-width: 480px;
            margin: 0 24px;
            position: relative;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input-wrap svg {
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            color: var(--slate-400);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            height: 38px;
            padding: 0 40px 0 36px;
            background: var(--slate-100);
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--slate-800);
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--primary-400);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .search-kbd {
            position: absolute;
            right: 10px;
            padding: 2px 6px;
            background: #ffffff;
            border: 1px solid var(--slate-300);
            border-radius: 4px;
            font-size: 10.5px;
            font-family: var(--font-mono);
            color: var(--slate-500);
            pointer-events: none;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.18s ease;
            cursor: pointer;
            border: none;
        }

        .btn-ghost {
            background: transparent;
            color: var(--slate-700);
            border: 1px solid var(--slate-300);
        }

        .btn-ghost:hover {
            background: var(--slate-100);
            color: var(--slate-900);
        }

        .btn-primary {
            background: var(--primary-600);
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-700);
        }

        /* ── Layout ── */
        .guide-container {
            display: flex;
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height));
        }

        /* ── Sidebar ── */
        .guide-sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            background: #ffffff;
            border-right: 1px solid var(--slate-200);
            overflow-y: auto;
            padding: 20px 14px 40px;
            z-index: 40;
        }

        .sidebar-section {
            margin-bottom: 22px;
        }

        .sidebar-heading {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--slate-400);
            padding: 0 10px 8px;
        }

        .sidebar-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 13px;
            color: var(--slate-600);
            text-decoration: none;
            transition: all 0.15s ease;
            font-weight: 450;
        }

        .sidebar-link:hover {
            background: var(--slate-100);
            color: var(--primary-700);
        }

        .sidebar-link.active {
            background: var(--primary-50);
            color: var(--primary-600);
            font-weight: 600;
        }

        .sidebar-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.75;
        }

        .sidebar-link.active svg {
            opacity: 1;
            color: var(--primary-600);
        }

        .badge-role {
            font-size: 9.5px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: auto;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-super {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-all {
            background: #e0f2fe;
            color: #0369a1;
        }

        /* ── Main Content ── */
        .guide-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            max-width: 960px;
            padding: 36px 48px 80px;
        }

        /* ── Hero Banner ── */
        .guide-hero {
            background: linear-gradient(135deg, var(--primary-900) 0%, var(--primary-800) 60%, var(--primary-700) 100%);
            border-radius: 16px;
            padding: 36px 36px 32px;
            color: #ffffff;
            margin-bottom: 36px;
            box-shadow: 0 10px 25px -5px rgba(11, 25, 44, 0.25);
            position: relative;
            overflow: hidden;
        }

        .guide-hero::after {
            content: '';
            position: absolute;
            right: -60px;
            bottom: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
            color: #93c5fd;
            margin-bottom: 14px;
        }

        .hero-badge-pill .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 8px #38bdf8;
        }

        .guide-hero h2 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            line-height: 1.25;
        }

        .guide-hero p {
            font-size: 14px;
            color: #cbd5e1;
            max-width: 680px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .hero-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 12px;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 14px;
            backdrop-filter: blur(4px);
        }

        .hero-stat-val {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            font-family: var(--font-mono);
        }

        .hero-stat-label {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ── Content Sections ── */
        .guide-section {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            padding: 28px 32px;
            margin-bottom: 28px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            scroll-margin-top: calc(var(--header-height) + 20px);
        }

        .section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--slate-100);
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-50);
            color: var(--primary-600);
            flex-shrink: 0;
        }

        .section-icon-badge svg {
            width: 22px;
            height: 22px;
        }

        .section-title {
            font-size: 19px;
            font-weight: 700;
            color: var(--slate-900);
            letter-spacing: -0.3px;
        }

        .section-subtitle {
            font-size: 13px;
            color: var(--slate-500);
            margin-top: 2px;
        }

        .guide-prose {
            font-size: 14px;
            color: var(--slate-700);
            line-height: 1.7;
        }

        .guide-prose p {
            margin-bottom: 14px;
        }

        .guide-prose h3 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--slate-900);
            margin: 22px 0 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guide-prose h3::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 15px;
            background: var(--primary-500);
            border-radius: 2px;
        }

        /* ── Step-by-Step Flow ── */
        .step-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 16px 0;
        }

        .step-item {
            display: flex;
            gap: 14px;
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            padding: 14px 16px;
            transition: all 0.15s ease;
        }

        .step-item:hover {
            border-color: var(--primary-400);
            background: #ffffff;
            box-shadow: 0 3px 8px -2px rgba(37, 99, 235, 0.08);
        }

        .step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary-600);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-content h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--slate-800);
            margin-bottom: 3px;
        }

        .step-content p {
            font-size: 13px;
            color: var(--slate-600);
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* ── Callout Boxes ── */
        .callout {
            border-radius: 10px;
            padding: 14px 16px;
            margin: 16px 0;
            display: flex;
            gap: 12px;
            font-size: 13px;
            line-height: 1.6;
        }

        .callout svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .callout-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .callout-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .callout-warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }

        .callout-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* ── Matrix Table ── */
        .table-responsive {
            overflow-x: auto;
            margin: 18px 0;
            border-radius: 10px;
            border: 1px solid var(--slate-200);
        }

        .guide-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        .guide-table th {
            background: var(--slate-100);
            color: var(--slate-700);
            font-weight: 600;
            padding: 12px 14px;
            border-bottom: 1px solid var(--slate-200);
        }

        .guide-table td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--slate-200);
            color: var(--slate-700);
        }

        .guide-table tr:last-child td {
            border-bottom: none;
        }

        .guide-table tr:hover td {
            background: var(--slate-50);
        }

        .badge-check {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-check-yes {
            background: #dcfce7;
            color: #166534;
        }

        .badge-check-no {
            background: #f1f5f9;
            color: #94a3b8;
        }

        .badge-check-partial {
            background: #fef3c7;
            color: #92400e;
        }

        /* ── Grid Cards for Features ── */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            margin: 16px 0;
        }

        .feature-box {
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            padding: 14px 16px;
        }

        .feature-box h5 {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--slate-900);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .feature-box p {
            font-size: 12.5px;
            color: var(--slate-600);
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* ── Accordion FAQ ── */
        .faq-item {
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            margin-bottom: 10px;
            overflow: hidden;
            background: #ffffff;
        }

        .faq-question {
            width: 100%;
            text-align: left;
            padding: 14px 16px;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            color: var(--slate-800);
            cursor: pointer;
            font-family: inherit;
        }

        .faq-question:hover {
            background: var(--slate-50);
        }

        .faq-question svg {
            width: 16px;
            height: 16px;
            color: var(--slate-400);
            transition: transform 0.2s ease;
        }

        .faq-item.open .faq-question svg {
            transform: rotate(180deg);
        }

        .faq-answer {
            display: none;
            padding: 0 16px 14px;
            font-size: 13.5px;
            color: var(--slate-600);
            line-height: 1.6;
            border-top: 1px solid var(--slate-100);
            padding-top: 12px;
        }

        .faq-item.open .faq-answer {
            display: block;
        }

        /* ── Keyboard Shortcuts Badge ── */
        .kbd-tag {
            display: inline-block;
            padding: 2px 6px;
            background: #ffffff;
            border: 1px solid var(--slate-300);
            border-radius: 4px;
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--slate-700);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        /* ── Footer ── */
        .guide-footer {
            margin-top: 60px;
            padding-top: 24px;
            border-top: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            color: var(--slate-500);
        }

        /* ── Print Media Optimization ── */
        @media print {
            .guide-header,
            .guide-sidebar,
            .btn-action,
            .search-input-wrap,
            .kbd-tag {
                display: none !important;
            }

            .guide-container {
                margin-top: 0 !important;
            }

            .guide-main {
                margin-left: 0 !important;
                max-width: 100% !important;
                padding: 0 !important;
            }

            .guide-section {
                border: none !important;
                box-shadow: none !important;
                padding: 16px 0 !important;
                page-break-inside: avoid;
            }

            .guide-hero {
                background: #0d2137 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .header-center-search {
                display: none;
            }
            .guide-main {
                padding: 24px;
            }
        }

        @media (max-width: 768px) {
            .guide-sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }
            .guide-sidebar.open {
                transform: translateX(0);
            }
            .guide-main {
                margin-left: 0;
                padding: 16px;
            }
            .mobile-menu-btn {
                display: block !important;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            color: var(--slate-700);
        }
    </style>
</head>
<body>

    <!-- ── Header Topbar ── -->
    <header class="guide-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Menu Panduan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
            <a href="{{ route('panduan.index') }}" class="header-brand">
                <div class="header-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="header-title-box">
                    <h1>E-PROKOPIM</h1>
                    <span>Buku Panduan & Dokumentasi Sistem</span>
                </div>
            </a>
        </div>

        <!-- Center Search Input -->
        <div class="header-center-search">
            <div class="search-input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" id="guideSearch" class="search-input" placeholder="Cari panduan fitur (contoh: sambutan, API key, surat masuk)..." onkeyup="filterGuideTopics()">
                <span class="search-kbd">Ctrl K</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="header-actions">
            <button class="btn-action btn-ghost" onclick="window.print()" title="Cetak atau Simpan sebagai PDF">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.037.245-2.043 1.15-2.438a4.992 4.992 0 013.914 0c.905.395 1.39 1.401 1.15 2.438a2.5 2.5 0 01-2.42 1.921H8.08a2.5 2.5 0 01-1.36-.421zm10.53-2.079a4.5 4.5 0 00-8.5-1.5 5 5 0 00-7.5 4.5v3a2 2 0 002 2h14a2 2 0 002-2v-3a4.5 4.5 0 00-2-3.75z" />
                </svg>
                <span>Cetak / PDF</span>
            </button>
            <a href="{{ route('dashboard') }}" class="btn-action btn-primary" title="Buka Dashboard E-PROKOPIM">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span>Dashboard</span>
            </a>
        </div>
    </header>

    <!-- ── Container ── -->
    <div class="guide-container">

        <!-- ── Left Sidebar Navigation ── -->
        <aside class="guide-sidebar" id="guideSidebar">
            <!-- Section 1 -->
            <div class="sidebar-section">
                <div class="sidebar-heading">Pengenalan & Akun</div>
                <ul class="sidebar-nav-list">
                    <li>
                        <a href="#tentang" class="sidebar-link active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                            <span>Tentang E-Prokopim</span>
                        </a>
                    </li>
                    <li>
                        <a href="#hak-akses" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                            <span>Hak Akses (Role)</span>
                            <span class="badge-role badge-super">Kritis</span>
                        </a>
                    </li>
                    <li>
                        <a href="#dashboard" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            <span>Dashboard Analitik</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Section 2 -->
            <div class="sidebar-section">
                <div class="sidebar-heading">Modul Pimpinan</div>
                <ul class="sidebar-nav-list">
                    <li>
                        <a href="#kegiatan-pimpinan" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            <span>Kegiatan Pimpinan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#sambutan" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <span>Naskah Sambutan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#media-sosial" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.62 1.022 1.072 1.394a3.75 3.75 0 005.13-5.13 8.948 8.948 0 01-1.394-1.072c-.891-.401-1.82-.732-2.783-.985m-3.01 3.01l3.01-3.01m0 0a8.948 8.948 0 001.072-1.394 3.75 3.75 0 00-5.13-5.13c-.452.372-.825.844-1.072 1.394a8.948 8.948 0 00-.985 2.783m6.187-6.187a4.5 4.5 0 00-6.364 0" /></svg>
                            <span>Media Sosial</span>
                        </a>
                    </li>
                    <li>
                        <a href="#analisis-isu" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                            <span>Analisis Isu & Media</span>
                        </a>
                    </li>
                    <li>
                        <a href="#galeri-arsip" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                            <span>Dokumentasi & Galeri</span>
                        </a>
                    </li>
                    <li>
                        <a href="#protokol" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span>Penugasan & Arahan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div class="sidebar-section">
                <div class="sidebar-heading">Administrasi & Surat</div>
                <ul class="sidebar-nav-list">
                    <li>
                        <a href="#pegawai" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span>Data Pegawai / Personel</span>
                        </a>
                    </li>
                    <li>
                        <a href="#asset" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            <span>Aset & Kendaraan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#surat-masuk" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <span>Surat Masuk & Disposisi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#surat-keluar" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                            <span>Surat Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Section 4 -->
            <div class="sidebar-section">
                <div class="sidebar-heading">Fitur Pintar & Pengaturan</div>
                <ul class="sidebar-nav-list">
                    <li>
                        <a href="#asisten-ai" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" /></svg>
                            <span>Asisten AI (Google Gemini)</span>
                            <span class="badge-role badge-all">AI Cerdas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#recycle-bin" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            <span>Arsip Terhapus (Recycle Bin)</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pengaturan" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>Pengaturan & Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="#faq" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                            <span>Pertanyaan Umum (FAQ)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- ── Main Content Area ── -->
        <main class="guide-main">

            <!-- Hero Banner -->
            <div class="guide-hero">
                <div class="hero-badge-pill">
                    <span class="pulse-dot"></span>
                    <span>Dokumentasi Resmi Versi 1.0</span>
                </div>
                <h2>Buku Panduan Penggunaan E-PROKOPIM</h2>
                <p>
                    Selamat datang di Pusat Panduan Resmi <strong>Sistem Informasi Protokol dan Komunikasi Pimpinan Pemerintah Kota Bandung</strong>. 
                    Panduan ini disusun untuk membantu seluruh pejabat, staf protokol, sekretariat, dan administrator dalam memaksimalkan fitur pencatatan jadwal, 
                    naskah sambutan, komunikasi publik, administrasi arsip, serta pemanfaatan kecerdasan buatan Google Gemini.
                </p>

                <div class="hero-stats-row">
                    <div class="hero-stat-card">
                        <div class="hero-stat-val">11+</div>
                        <div class="hero-stat-label">Modul Terintegrasi</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="hero-stat-val">2 Role</div>
                        <div class="hero-stat-label">Super Admin & User</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="hero-stat-val">Multi-AI</div>
                        <div class="hero-stat-label">Google Gemini Flash / Hydrogen</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="hero-stat-val">Real-Time</div>
                        <div class="hero-stat-label">Notifikasi & Disposisi</div>
                    </div>
                </div>
            </div>

            <!-- 1. Tentang E-Prokopim -->
            <section id="tentang" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">1. Mengenal Sistem E-PROKOPIM</h3>
                            <p class="section-subtitle">Latar belakang, visi, dan gambaran umum operasional platform</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        <strong>E-PROKOPIM</strong> (Sistem Informasi Protokol dan Komunikasi Pimpinan) dirancang khusus untuk memenuhi standar digitalisasi birokrasi di lingkungan <strong>{{ $instansi->nama_instansi ?? 'Bagian Protokol dan Komunikasi Pimpinan Pemerintah Kota Bandung' }}</strong>. 
                        Sebelum hadirnya platform ini, koordinasi kegiatan pimpinan, permohonan naskah sambutan, pengelolaan media sosial, serta arsip disposisi surat masih tersebar di berbagai buku register dan spreadsheet terpisah.
                    </p>

                    <div class="feature-grid">
                        <div class="feature-box">
                            <h5>🎯 Agenda Pimpinan Terkoordinasi</h5>
                            <p>Sinkronisasi jadwal Wali Kota, Wakil Wali Kota, dan Sekretaris Daerah dengan kalender interaktif tanpa bentrok jadwal.</p>
                        </div>
                        <div class="feature-box">
                            <h5>📝 Siklus Naskah Sambutan Rapi</h5>
                            <p>Alur permintaan draf, penelaahan substansi, upload naskah final berformat Word/PDF, hingga siap dibacakan di podium.</p>
                        </div>
                        <div class="feature-box">
                            <h5>🤖 Asisten Cerdas Terkoneksi Database</h5>
                            <p>Memanfaatkan model Google Gemini Generasi Terbaru untuk menyusun pidato, merangkum surat disposisi, dan mengecek jadwal pimpinan.</p>
                        </div>
                        <div class="feature-box">
                            <h5>🛡️ Keamanan & Pemulihan Arsip</h5>
                            <p>Fitur <em>Soft Delete</em> dengan Recycle Bin menjamin data kedinasan tidak hilang permanen saat terjadi kesalahan penghapusan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 2. Hak Akses (Role Matrix) -->
            <section id="hak-akses" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge" style="background: #fee2e2; color: #b91c1c;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">2. Pembagian Peran & Hak Akses (Role)</h3>
                            <p class="section-subtitle">Perbedaan wewenang operasional antara Super Admin dan User (Staf)</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Untuk menjaga integritas dan keamanan data instansi, E-PROKOPIM membagi hak akses ke dalam dua tingkat pengguna:
                    </p>

                    <div class="table-responsive">
                        <table class="guide-table">
                            <thead>
                                <tr>
                                    <th style="width: 38%;">Fitur & Modul Sistem</th>
                                    <th style="width: 31%; text-align: center;">Super Admin</th>
                                    <th style="width: 31%; text-align: center;">User (Staf / Operator)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Dashboard & Statistik Real-Time</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Kegiatan Pimpinan (Input, Edit, Hapus)</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh + Bulk Delete</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Input & Update Status</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Ekspor Rekap Kegiatan & Sambutan ke Excel</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Seluruh Periode</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Seluruh Periode</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Pengelolaan Naskah Sambutan & Media Sosial</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Administrasi Pegawai, Aset, & Surat Masuk/Keluar</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Akses Penuh</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Kelola Operasional</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Asisten AI (Chatbot Google Gemini)</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Konsultasi + Atur API Key</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-partial">✓ Konsultasi Berkas/Chat</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Konfigurasi Kunci API Gemini (.env)</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Eksklusif Super Admin</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-no">✕ Terkunci</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Manajemen Akun Pengguna (Tambah / Blokir Akun)</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Eksklusif Super Admin</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-no">✕ Terkunci</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Pengaturan Identitas Instansi Global</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Eksklusif Super Admin</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-no">✕ Hanya Profil Pribadi</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Recycle Bin (Kosongkan Sampah Permanen)</strong></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-yes">✓ Hapus Selamanya</span></td>
                                    <td style="text-align: center;"><span class="badge-check badge-check-partial">✓ Hanya Pulihkan Data</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="callout callout-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                        <div>
                            <strong>Catatan Keamanan:</strong> Pengaturan sistem vital dan mutasi akun pengguna sengaja dibatasi hanya untuk Super Admin guna mencegah kebocoran data konfigurasi dan memastikan kesinambungan operasional sistem.
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Dashboard Analitik -->
            <section id="dashboard" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">3. Modul Dashboard & Analitik Data</h3>
                            <p class="section-subtitle">Pusat pemantauan kinerja, grafik statistik dinamis, dan agenda terkini</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Dashboard merupakan halaman pertama yang muncul setelah berhasil masuk. Halaman ini menyajikan visualisasi data komprehensif yang dirancang untuk mendukung pengambilan keputusan pimpinan secara cepat.
                    </p>

                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Statistik Ringkas (KPI Counter)</h4>
                                <p>Menampilkan total Agenda Hari Ini (diklasifikasikan per pimpinan: Wali Kota, Wakil Wali Kota, Sekda), Total Kegiatan Periode Ini, Arahan Belum Selesai, Total Pegawai, dan Total Berkas Digital.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Filter Rentang Waktu Interaktif</h4>
                                <p>Gunakan tombol filter di pojok kanan atas grafik: <strong>1 Bulan</strong>, <strong>3 Bulan</strong>, <strong>6 Bulan</strong>, <strong>1 Tahun</strong>, atau <strong>Kustom Tanggal</strong> untuk menyesuaikan data grafik sesuai periode yang diinginkan.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Tiga Grafik Interaktif (Chart.js)</h4>
                                <p>
                                    • <strong>Statistik Kegiatan Bulanan:</strong> Memvisualisasikan distribusi Rapat, Acara Seremonial, Kunjungan Kerja, dan Audiensi.<br>
                                    • <strong>Tren Naskah Sambutan:</strong> Memantau lonjakan permohonan naskah sambutan sepanjang tahun.<br>
                                    • <strong>Statistik Dokumentasi Kegiatan:</strong> Rasio volume foto, video, dan notulensi yang berhasil diarsipkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Kegiatan Pimpinan -->
            <section id="kegiatan-pimpinan" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">4. Modul Kegiatan Pimpinan</h3>
                            <p class="section-subtitle">Manajemen jadwal acara resmi, rekapitulasi, dan ekspor data</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Modul ini digunakan untuk mencatat, mengedit, dan memonitor seluruh agenda kedinasan para pimpinan daerah.
                    </p>

                    <h3>Langkah Menambahkan Jadwal Kegiatan Baru:</h3>
                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Buka Menu Kegiatan Pimpinan</h4>
                                <p>Klik menu <strong>Kegiatan Pimpinan</strong> di sidebar navigasi, lalu tekan tombol biru <strong>+ Tambah Kegiatan</strong>.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Isi Formulir Agenda Resmi</h4>
                                <p>Masukkan Nama Kegiatan, Tanggal & Waktu Pelaksanaan, Lokasi / Tempat Acara, Pimpinan yang Menghadiri (Wali Kota, Wakil, atau Sekda), serta Kategori Acara.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Simpan & Verifikasi Kalender</h4>
                                <p>Tekan <strong>Simpan Jadwal</strong>. Agenda akan otomatis langsung terintegrasi dengan widget agenda hari ini di dashboard dan penugasan personel protokol.</p>
                            </div>
                        </div>
                    </div>

                    <div class="callout callout-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <strong>Fitur Ekspor Rekap:</strong> Anda dapat mengeklik tombol <strong>Ekspor Rekap (Excel)</strong> untuk mengunduh rekapitulasi agenda bulanan dalam format spreadsheet lengkap dengan durasi dan status kehadiran.
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. Sambutan -->
            <section id="sambutan" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">5. Modul Naskah Sambutan</h3>
                            <p class="section-subtitle">Pengajuan permohonan draf sambutan, penelaahan, dan publikasi naskah final</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Sub-bagian Komunikasi Pimpinan bertanggung jawab atas perancangan materi pidato resmi pimpinan. Modul ini memfasilitasi siklus lengkap naskah sambutan:
                    </p>

                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Permohonan Draf Sambutan</h4>
                                <p>SKPD / OPD pemohon mengajukan judul acara, tanggal perayaan, tema kunci, dan target audiens yang hadir.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Bantuan Asisten AI Pembuat Pidato</h4>
                                <p>Penulis naskah dapat meminta bantuan Asisten AI untuk menyusun draf awal pidato dalam format resmi Keprotokolan Pemerintah Daerah.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Upload & Preview Berkas Sambutan</h4>
                                <p>Unggah file hasil naskah dalam format DOCX atau PDF. Petugas dapat melihat pratinjau (preview) langsung di browser atau mengunduhnya saat acara berlangsung.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 6. Media Sosial & Analisis Isu -->
            <section id="media-sosial" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.62 1.022 1.072 1.394a3.75 3.75 0 005.13-5.13 8.948 8.948 0 01-1.394-1.072c-.891-.401-1.82-.732-2.783-.985m-3.01 3.01l3.01-3.01m0 0a8.948 8.948 0 001.072-1.394 3.75 3.75 0 00-5.13-5.13c-.452.372-.825.844-1.072 1.394a8.948 8.948 0 00-.985 2.783m6.187-6.187a4.5 4.5 0 00-6.364 0" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">6. Media Sosial & Analisis Isu Media</h3>
                            <p class="section-subtitle">Pengarsipan konten publikasi dan pemantauan sentimen isu strategis</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <h3>Media Sosial (Instagram, TikTok, Twitter, YouTube):</h3>
                    <p>
                        Setiap postingan media sosial diorganisasikan secara otomatis dalam struktur folder tahunan dan bulanan. Anda dapat mengunggah aset visual, caption, tautan konten, serta indikator jangkauan publikasi.
                    </p>

                    <h3 id="analisis-isu">Analisis Isu & Media Monitoring:</h3>
                    <p>
                        Digunakan oleh tim analisis untuk mengidentifikasi isu-isu yang berkembang di media massa maupun warganet mengenai kebijakan pemerintah kota:
                    </p>
                    <div class="feature-grid">
                        <div class="feature-box">
                            <h5>Klasifikasi Sentimen</h5>
                            <p>Label sentimen Positif, Netral, atau Negatif untuk memetakan respon masyarakat terhadap program pimpinan.</p>
                        </div>
                        <div class="feature-box">
                            <h5>Skor Dampak Isu</h5>
                            <p>Penilaian skala 1-10 untuk menentukan apakah isu memerlukan tanggapan siaran pers atau klarifikasi resmi segera.</p>
                        </div>
                        <div class="feature-box">
                            <h5>Cetak Lembar Analisis</h5>
                            <p>Fitur cetak satu-klik untuk mencetak lembar telaahan isu yang siap dilaporkan ke meja pimpinan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 7. Dokumentasi & Galeri Arsip -->
            <section id="galeri-arsip" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">7. Dokumentasi Pimpinan & Galeri Arsip</h3>
                            <p class="section-subtitle">Pusat dokumentasi foto resolusi tinggi, video kegiatan, paparan materi, dan notulensi rapat</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Galeri Arsip mengelola aset dokumentasi visual setiap kegiatan pimpinan daerah dengan fitur thumbnail cerdas dan tagging kata kunci.
                    </p>

                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Upload Multi-File Aset Dokumentasi</h4>
                                <p>Dukungan unggah foto (JPG, PNG), materi paparan presentasi (PDF, PPTX), serta dokumen notulensi hasil rapat.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Pemberian Kata Kunci & Instansi</h4>
                                <p>Sertakan kata kunci (tags) dan instansi mitra saat mengunggah agar berkas mudah ditemukan kembali dalam hitungan detik.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Streaming Thumbnail Otomatis</h4>
                                <p>Sistem secara otomatis mengompresi dan menghasilkan thumbnail ringan melalui endpoint internal tanpa membebani kuota server.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 8. Protokol Pimpinan (Penugasan & Arahan) -->
            <section id="protokol" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">8. Protokol Pimpinan: Penugasan & Arahan</h3>
                            <p class="section-subtitle">Surat tugas petugas lapangan, ajudan, MC, dan pemantauan tenggat waktu arahan pimpinan</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <h3>Penugasan Personel Protokol:</h3>
                    <p>
                        Memungkinkan koordinator lapangan untuk menugaskan petugas protokol, pengatur acara (MC), ajudan, dan dokumenter pada kegiatan tertentu. Petugas yang ditugaskan akan menerima pemberitahuan otomatis.
                    </p>

                    <h3>Arahan Pimpinan & Status Deadline:</h3>
                    <p>
                        Setiap arahan yang disampaikan oleh pimpinan pada saat rapat atau briefing dicatat dan diberi batas waktu penyelesaian (deadline).
                    </p>
                    <div class="callout callout-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                        <div>
                            <strong>Peringatan Deadline Otomatis:</strong> Arahan yang mendekati atau telah melewati tenggat waktu akan memicu notifikasi peringatan berkedip di ikon lonceng topbar sistem agar segera ditindaklanjuti.
                        </div>
                    </div>
                </div>
            </section>

            <!-- 9. Administrasi: Pegawai, Aset, Surat Masuk & Keluar -->
            <section id="pegawai" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">9. Modul Administrasi Bagian</h3>
                            <p class="section-subtitle">Pengelolaan personel pegawai, aset inventaris & kendaraan dinas, serta tata naskah surat</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <div class="feature-grid">
                        <div class="feature-box" id="asset">
                            <h5>👥 Data Pegawai & Personel</h5>
                            <p>Pencatatan NIP, Nama Lengkap, Pangkat/Golongan, Jabatan, Nomor Telepon WhatsApp, serta penugasan operasional protokol.</p>
                        </div>
                        <div class="feature-box">
                            <h5>🏢 Aset Inventaris & Kendaraan</h5>
                            <p>Inventarisasi barang elektronik kantor dan pemantauan armada kendaraan dinas pimpinan (plat nomor, kondisi fisik, masa pajak).</p>
                        </div>
                        <div class="feature-box" id="surat-masuk">
                            <h5>📥 Surat Masuk & Disposisi</h5>
                            <p>Registrasi nomor agenda surat masuk, asal instansi pengirim, perihal, lembar disposisi pimpinan, dan status cetak fisik.</p>
                        </div>
                        <div class="feature-box" id="surat-keluar">
                            <h5>📤 Surat Keluar</h5>
                            <p>Penomoran otomatis surat dinas keluar, tujuan instansi eksternal, lampiran berkas resmi, dan riwayat penandatanganan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 10. Asisten AI (Google Gemini) -->
            <section id="asisten-ai" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge" style="background: #faf5ff; color: #7c3aed;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">10. Modul Asisten AI (Google Gemini Terintegrasi)</h3>
                            <p class="section-subtitle">Chatbot kecerdasan buatan kedinasan, multi-model terbaru, dan analisis berkas multimodal</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Asisten AI E-PROKOPIM ditenagai langsung oleh <strong>Google Gemini API</strong> generasi terbaru, dirancang khusus dengan konteks database lokal kedinasan Pemerintah Kota Bandung.
                    </p>

                    <h3>Model AI Terbaru yang Didukung:</h3>
                    <div class="table-responsive">
                        <table class="guide-table">
                            <thead>
                                <tr>
                                    <th>Nama Model</th>
                                    <th>Karakteristik & Keunggulan</th>
                                    <th>Rekomendasi Penggunaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Gemini 3.5 Flash-Lite</strong></td>
                                    <td>Jawaban instan, latensi sangat rendah, ultra-cepat</td>
                                    <td>Pengecekan jadwal harian, pencarian arsip, ringkasan singkat</td>
                                </tr>
                                <tr>
                                    <td><strong>Gemini 4 Hydrogen</strong></td>
                                    <td>Penalaran mendalam, penalaran seimbang & komprehensif</td>
                                    <td>Penyusunan naskah pidato berbobot, telaah isu strategis</td>
                                </tr>
                                <tr>
                                    <td><strong>Gemini Flash-Lite Latest</strong></td>
                                    <td>Model terbaru versi rilis stabil resmi Google AI</td>
                                    <td>Pemrosesan multimodal (gambar surat / file dokumen)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>Cara Mengatur Kunci API Permanen (Khusus Super Admin):</h3>
                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Buka Tombol Pengaturan API</h4>
                                <p>Pada halaman Asisten AI, klik tombol <strong>Google Gemini API</strong> di pojok kanan atas jendela obrolan.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Masukkan API Key dari Google AI Studio</h4>
                                <p>Tempelkan kunci API Anda. Anda dapat mengeklik ikon <strong>Mata</strong> di sebelah kanan input untuk mengintip / menyembunyikan karakter API key.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Simpan Permanen ke .env</h4>
                                <p>Pilih model default yang diinginkan lalu klik <strong>Simpan Permanen</strong>. Kunci akan otomatis tersimpan ke file konfigurasi server sehingga tidak akan pernah ter-reset saat laptop atau server di-restart.</p>
                            </div>
                        </div>
                    </div>

                    <div class="callout callout-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <strong>Engine Fallback Cerdas:</strong> Jika sewaktu-waktu kuota Google API habis atau koneksi internet terputus, sistem secara otomatis beralih ke <em>Local Database Query Engine</em> untuk tetap menjawab pertanyaan seputar jadwal hari ini, data pegawai, dan aset kantor.
                        </div>
                    </div>
                </div>
            </section>

            <!-- 11. Recycle Bin & Pemulihan Data -->
            <section id="recycle-bin" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">11. Modul Arsip Terhapus (Recycle Bin)</h3>
                            <p class="section-subtitle">Mekanisme pemulihan data (restore), soft delete, dan pembersihan permanen</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <p>
                        Semua data yang dihapus dari modul Kegiatan Pimpinan, Sambutan, Pegawai, Galeri, Surat Masuk, dan Aset tidak langsung dimusnahkan, melainkan dipindahkan ke menu <strong>Arsip Terhapus (Recycle Bin)</strong>.
                    </p>

                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">✓</div>
                            <div class="step-content">
                                <h4>Memulihkan Data (Restore)</h4>
                                <p>Klik tombol hijau <strong>Pulihkan</strong> pada baris data terkait, atau centang beberapa baris sekaligus lalu klik <strong>Pulihkan Terpilih</strong> untuk mengembalikan data ke modul asalnya secara utuh.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">⚠</div>
                            <div class="step-content">
                                <h4>Hapus Permanen (Khusus Super Admin)</h4>
                                <p>Data yang dihapus permanen atau melalui tombol <strong>Kosongkan Tempat Sampah</strong> akan dimusnahkan secara permanen dari database dan tidak dapat dipulihkan kembali.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 12. Pengaturan & Profil -->
            <section id="pengaturan" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">12. Pengaturan Sistem & Profil Pengguna</h3>
                            <p class="section-subtitle">Identitas instansi, manajemen akun pengguna, ganti kata sandi, dan foto profil</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <h3>Pengaturan Profil Mandiri (Semua Pengguna):</h3>
                    <p>
                        Setiap pengguna dapat memperbarui Nama Lengkap, Nomor Telepon, Kata Sandi, dan Foto Profil pribadi melalui menu <strong>Profil</strong> di bilah sidebar bawah.
                    </p>

                    <h3>Pengaturan Instansi & Pengguna (Khusus Super Admin):</h3>
                    <p>
                        Pada menu <strong>Pengaturan</strong>, Super Admin dapat:
                    </p>
                    <ul style="margin-left: 20px; margin-bottom: 14px;">
                        <li>Mengubah Nama Instansi, Alamat Kantor Pemerintah Daerah, Email Resmi, dan Nomor Telepon.</li>
                        <li>Menambahkan akun staf baru dengan menentukan perannya (Super Admin atau User).</li>
                        <li>Mengaktifkan atau menonaktifkan sementara status akun pegawai yang mutasi tugas.</li>
                    </ul>
                </div>
            </section>

            <!-- 13. FAQ -->
            <section id="faq" class="guide-section guide-topic">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <div class="section-icon-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                        </div>
                        <div>
                            <h3 class="section-title">13. Pertanyaan yang Sering Diajukan (FAQ)</h3>
                            <p class="section-subtitle">Solusi cepat untuk kendala operasional yang sering ditemui</p>
                        </div>
                    </div>
                </div>

                <div class="guide-prose">
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            <span>Bagaimana cara mencetak / mengekspor jadwal pimpinan ke format Excel?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="faq-answer">
                            Buka menu <strong>Kegiatan Pimpinan</strong>, lalu klik tombol <strong>Ekspor Rekap</strong> di bagian atas tabel. File spreadsheet (.xlsx) akan otomatis terunduh ke perangkat Anda.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            <span>Apakah data yang tidak sengaja terhapus dapat dikembalikan?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="faq-answer">
                            Ya, tentu saja. Buka menu <strong>Arsip Terhapus</strong> di sidebar. Cari data yang ingin dikembalikan lalu klik tombol <strong>Pulihkan</strong>. Data akan kembali aktif di tabel modul terkait.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            <span>Mengapa Asisten AI tidak merespons atau muncul pesan error kuota?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="faq-answer">
                            Pastikan server terhubung ke internet dan API Key Google Gemini yang tersimpan di modal pengaturan berstatus aktif. Jika kuota API gratis Google Studio Anda telah mencapai limit harian, Anda dapat mengganti kunci API baru di modal pengaturan Google Gemini API.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            <span>Bagaimana cara mengganti kata sandi atau foto profil?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="faq-answer">
                            Klik menu <strong>Profil</strong> di sidebar bawah. Unggah foto baru berukuran maksimal 2MB (format JPG/PNG), atau isi kolom <em>Password Saat Ini</em> dan <em>Password Baru</em> lalu klik <strong>Simpan Perubahan</strong>.
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="guide-footer">
                <div>
                    <strong>E-PROKOPIM Kota Bandung</strong> &copy; {{ date('Y') }} — Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div>
                    {{ $instansi->nama_instansi ?? 'Bagian Protokol dan Komunikasi Pimpinan' }}
                </div>
            </footer>

        </main>
    </div>

    <!-- ── Interactive JavaScript ── -->
    <script>
        // Toggle Accordion FAQ
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            item.classList.toggle('open');
        }

        // Toggle Mobile Sidebar Drawer
        function toggleSidebar() {
            const sidebar = document.getElementById('guideSidebar');
            sidebar.classList.toggle('open');
        }

        // Filter Topics from Search Input
        function filterGuideTopics() {
            const q = document.getElementById('guideSearch').value.toLowerCase().trim();
            const sections = document.querySelectorAll('.guide-topic');
            const links = document.querySelectorAll('.sidebar-link');

            sections.forEach(sec => {
                const text = sec.innerText.toLowerCase();
                if (text.includes(q)) {
                    sec.style.display = 'block';
                } else {
                    sec.style.display = 'none';
                }
            });

            links.forEach(link => {
                const text = link.innerText.toLowerCase();
                const targetId = link.getAttribute('href');
                if (targetId && targetId.startsWith('#')) {
                    const sec = document.querySelector(targetId);
                    if (sec && sec.style.display !== 'none') {
                        link.style.display = 'flex';
                    } else if (q.length > 0) {
                        link.style.display = 'none';
                    } else {
                        link.style.display = 'flex';
                    }
                }
            });
        }

        // Keyboard Shortcut: Ctrl + K or Cmd + K to Focus Search
        window.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                const search = document.getElementById('guideSearch');
                if (search) {
                    search.focus();
                    search.select();
                }
            }
        });

        // Highlight Active Link on Scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    document.querySelectorAll('.sidebar-link').forEach(link => {
                        if (link.getAttribute('href') === '#' + id) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });

        document.querySelectorAll('.guide-topic').forEach(sec => observer.observe(sec));
    </script>
</body>
</html>
