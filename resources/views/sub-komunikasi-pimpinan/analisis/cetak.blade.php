<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telaahan Analisis Isu — {{ $analisi->judul }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Times New Roman', Times, serif; }
        body { background: #f1f5f9; padding: 30px 15px; color: #000000; font-size: 12pt; line-height: 1.5; }
        
        .print-page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            padding: 20mm 20mm;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
            border-bottom: 3px double #000000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .kop-logo { width: 75px; height: auto; }
        .kop-text h2 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .kop-text h3 { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .kop-text h4 { font-size: 11pt; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; }
        .kop-text p  { font-size: 9pt; font-style: italic; }

        /* Document Title */
        .doc-title-wrap {
            text-align: center;
            margin-bottom: 20px;
        }
        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .doc-subtitle {
            font-size: 10pt;
        }

        /* Meta Table */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        .meta-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .meta-table td.lbl {
            width: 180px;
            font-weight: bold;
        }
        .meta-table td.sep {
            width: 15px;
            text-align: center;
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 18px;
        }
        .section-heading {
            font-size: 11.5pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #f1f5f9;
            padding: 4px 8px;
            border-left: 4px solid #0f172a;
            margin-bottom: 8px;
        }
        .section-text {
            font-size: 11pt;
            line-height: 1.6;
            text-align: justify;
            white-space: pre-line;
            padding: 0 8px;
        }

        /* Signature block */
        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 35px;
            page-break-inside: avoid;
        }
        .signature-col {
            text-align: center;
            font-size: 11pt;
        }
        .signature-col .date-place { margin-bottom: 4px; }
        .signature-col .role { font-weight: bold; margin-bottom: 60px; }
        .signature-col .name { font-weight: bold; text-decoration: underline; }
        .signature-col .nip  { font-size: 10pt; }

        /* Floating Toolbar */
        .print-toolbar {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            background: #ffffff;
            padding: 10px 16px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            z-index: 999;
        }
        .btn-print {
            padding: 8px 16px;
            background: #1e3a5f;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-print:hover { background: #162f4f; }
        .btn-close-print {
            padding: 8px 14px;
            background: #e2e8f0;
            color: #334155;
            border: none;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        @media print {
            body { background: #ffffff; padding: 0; }
            .print-page { padding: 0; box-shadow: none; max-width: 100%; }
            .print-toolbar { display: none; }
            .section-heading { background: #ffffff !important; border-left: 3px solid #000000; }
        }
    </style>
</head>
<body>

<div class="print-toolbar">
    <button onclick="window.print()" class="btn-print">🖨️ Cetak Dokumen</button>
    <button onclick="window.close()" class="btn-close-print">Tutup</button>
</div>

<div class="print-page">
    {{-- Kop Surat --}}
    <div class="kop-surat">
        <div class="kop-text">
            <h2>Pemerintah Kota Bandung</h2>
            <h3>Sekretariat Daerah</h3>
            <h4>Bagian Protokol dan Komunikasi Pimpinan</h4>
            <p>Jalan Wastukancana No. 2 Bandung 40117 Telepon (022) 4232338</p>
        </div>
    </div>

    {{-- Title --}}
    <div class="doc-title-wrap">
        <div class="doc-title">Lembar Telaahan dan Analisis Isu Pimpinan</div>
        <div class="doc-subtitle">Nomor Register Telaahan: {{ date('Ymd', strtotime($analisi->tanggal)) }}/AN-PROKOPIM/{{ $analisi->id }}</div>
    </div>

    {{-- Meta Table --}}
    <table class="meta-table">
        <tr>
            <td class="lbl">Judul Isu</td>
            <td class="sep">:</td>
            <td><strong>{{ $analisi->judul }}</strong></td>
        </tr>
        <tr>
            <td class="lbl">Hari / Tanggal</td>
            <td class="sep">:</td>
            <td>{{ $analisi->hari_tanggal }}</td>
        </tr>
        <tr>
            <td class="lbl">Jenis Media</td>
            <td class="sep">:</td>
            <td>Media {{ $analisi->jenis_media }}</td>
        </tr>
        <tr>
            <td class="lbl">Sumber Isu</td>
            <td class="sep">:</td>
            <td>{{ $analisi->sumber_isu }}</td>
        </tr>
        <tr>
            <td class="lbl">Leading Sector</td>
            <td class="sep">:</td>
            <td>{{ $analisi->leading_sector }}</td>
        </tr>
        <tr>
            <td class="lbl">Sentimen Isu</td>
            <td class="sep">:</td>
            <td><strong>{{ $analisi->sentimen }}</strong></td>
        </tr>
        @if($analisi->link_sumber)
        <tr>
            <td class="lbl">Link Sumber Berita</td>
            <td class="sep">:</td>
            <td>{{ $analisi->link_sumber }}</td>
        </tr>
        @endif
    </table>

    {{-- 1. Uraian Analisis Isu --}}
    <div class="content-section">
        <div class="section-heading">I. Uraian dan Analisis Isu</div>
        <div class="section-text">
            {{ $analisi->analisis }}
        </div>
    </div>

    {{-- 2. Rekomendasi Kebijakan --}}
    <div class="content-section">
        <div class="section-heading">II. Rekomendasi Kebijakan Strategis</div>
        <div class="section-text">
            {{ $analisi->rekomendasi_kebijakan }}
        </div>
    </div>

    {{-- 3. Rekomendasi Publikasi --}}
    <div class="content-section">
        <div class="section-heading">III. Rekomendasi Publikasi &amp; Komunikasi Publik</div>
        <div class="section-text">
            {{ $analisi->rekomendasi_publikasi }}
        </div>
    </div>

    {{-- Signatures --}}
    <div class="signature-grid">
        <div class="signature-col">
            <!-- Optional Left Signature if needed -->
        </div>
        <div class="signature-col">
            <div class="date-place">Bandung, {{ $analisi->tanggal->format('d F Y') }}</div>
            <div class="role">Tim Komunikasi Pimpinan</div>
            <div class="name">{{ $analisi->user ? $analisi->user->name : 'Pranata Humas / Analis' }}</div>
            <div class="nip">NIP. {{ $analisi->user ? ($analisi->user->nip ?? '-') : '-' }}</div>
        </div>
    </div>
</div>

</body>
</html>
