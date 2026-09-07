<?php

namespace App\Exports;

use App\Models\AnalisisIsu;
use Illuminate\Support\Collection;

class AnalisisIsuRekapExport
{
    protected int $tahun;

    const NAMA_BULAN = [
        1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
        4  => 'April',    5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',     8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',  11 => 'November',  12 => 'Desember',
    ];

    public function __construct(int $tahun)
    {
        $this->tahun = $tahun;
    }

    /**
     * Get rekap data per bulan (12 bulan)
     */
    public function getRekapData(): Collection
    {
        $rows = AnalisisIsu::whereYear('tanggal', $this->tahun)
            ->selectRaw('MONTH(tanggal) as bulan, sentimen, jenis_media, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal), sentimen, jenis_media')
            ->get();

        $byBulan = [];
        foreach ($rows as $row) {
            $b = (int) $row->bulan;
            if (!isset($byBulan[$b])) {
                $byBulan[$b] = [
                    'bulan'    => $b,
                    'label'    => self::NAMA_BULAN[$b] . ' ' . $this->tahun,
                    'positif'  => 0,
                    'negatif'  => 0,
                    'netral'   => 0,
                    'sosial'   => 0,
                    'online'   => 0,
                    'cetak'    => 0,
                ];
            }
            if ($row->sentimen === 'Positif')    $byBulan[$b]['positif'] += (int) $row->total;
            if ($row->sentimen === 'Negatif')    $byBulan[$b]['negatif'] += (int) $row->total;
            if ($row->sentimen === 'Netral')     $byBulan[$b]['netral']  += (int) $row->total;
            if ($row->jenis_media === 'Sosial')  $byBulan[$b]['sosial']  += (int) $row->total;
            if ($row->jenis_media === 'Online')  $byBulan[$b]['online']  += (int) $row->total;
            if ($row->jenis_media === 'Cetak')   $byBulan[$b]['cetak']   += (int) $row->total;
        }

        $result = collect();
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $d = $byBulan[$bulan] ?? [
                'bulan' => $bulan, 'label' => self::NAMA_BULAN[$bulan] . ' ' . $this->tahun,
                'positif' => 0, 'negatif' => 0, 'netral' => 0,
                'sosial' => 0, 'online' => 0, 'cetak' => 0,
            ];
            $d['total'] = $d['positif'] + $d['negatif'] + $d['netral'];
            $result->push($d);
        }

        return $result;
    }

    /**
     * Get all detail data for the year
     */
    public function getDetailData(): Collection
    {
        return AnalisisIsu::whereYear('tanggal', $this->tahun)
            ->with('user')
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($item, $idx) {
                return [
                    'no'                    => $idx + 1,
                    'judul'                 => $item->judul ?? '-',
                    'tanggal'               => $item->tanggal ? $item->tanggal->format('d/m/Y') : '-',
                    'bulan'                 => $item->tanggal ? self::NAMA_BULAN[$item->tanggal->month] : '-',
                    'jenis_media'           => 'Media ' . ($item->jenis_media ?? '-'),
                    'sumber_isu'            => $item->sumber_isu ?? '-',
                    'sentimen'              => $item->sentimen ?? '-',
                    'leading_sector'        => $item->leading_sector ?? '-',
                    'analisis'              => $item->analisis ?? '-',
                    'rekomendasi_kebijakan' => $item->rekomendasi_kebijakan ?? '-',
                    'rekomendasi_publikasi' => $item->rekomendasi_publikasi ?? '-',
                    'link_sumber'           => $item->link_sumber ?? '-',
                    'dibuat_oleh'           => $item->user ? $item->user->name : '-',
                    'waktu_input'           => $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                ];
            });
    }

    private function esc(string $str): string
    {
        return htmlspecialchars($str, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private function cell(string $value, string $style = 'Default', int $mergeAcross = 0): string
    {
        $merge = $mergeAcross > 0 ? " ss:MergeAcross=\"{$mergeAcross}\"" : '';
        return "<Cell ss:StyleID=\"{$style}\"{$merge}><Data ss:Type=\"String\">" . $this->esc($value) . "</Data></Cell>";
    }

    public function buildXml(): string
    {
        $rekap  = $this->getRekapData();
        $detail = $this->getDetailData();
        $thn    = $this->tahun;

        $grandTotal  = $rekap->sum('total');
        $totalPos    = $rekap->sum('positif');
        $totalNeg    = $rekap->sum('negatif');
        $totalNetral = $rekap->sum('netral');
        $totalSosial = $rekap->sum('sosial');
        $totalOnline = $rekap->sum('online');
        $totalCetak  = $rekap->sum('cetak');

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";

        // STYLES
        $xml .= '<Styles>
<Style ss:ID="Default" ss:Name="Normal"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="11"/></Style>
<Style ss:ID="title"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Size="14" ss:FontName="Calibri" ss:Color="#1E3A5F"/></Style>
<Style ss:ID="subtitle"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Size="11" ss:FontName="Calibri" ss:Color="#64748B"/></Style>
<Style ss:ID="header"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/></Borders></Style>
<Style ss:ID="header_green"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#059669" ss:Pattern="Solid"/></Style>
<Style ss:ID="header_red"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#DC2626" ss:Pattern="Solid"/></Style>
<Style ss:ID="header_gray"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#475569" ss:Pattern="Solid"/></Style>
<Style ss:ID="header_blue"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#2563EB" ss:Pattern="Solid"/></Style>
<Style ss:ID="odd"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="even"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="center_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="center_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="num_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#1E3A5F"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="num_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#1E3A5F"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="pos_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="10" ss:Color="#047857"/><Interior ss:Color="#F0FDF4" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="pos_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="10" ss:Color="#047857"/><Interior ss:Color="#ECFDF5" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="neg_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="10" ss:Color="#B91C1C"/><Interior ss:Color="#FFF0F0" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="neg_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="10" ss:Color="#B91C1C"/><Interior ss:Color="#FEF2F2" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="wrap_odd"><Alignment ss:Vertical="Top" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="wrap_even"><Alignment ss:Vertical="Top" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="total_row"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>
<Style ss:ID="total_label"><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>
</Styles>' . "\n";

        // ============================================================
        // SHEET 1: REKAP PER BULAN
        // ============================================================
        $xml .= '<Worksheet ss:Name="Rekap Per Bulan"><Table ss:DefaultRowHeight="18">' . "\n";
        $xml .= '<Column ss:Width="30"/><Column ss:Width="110"/><Column ss:Width="75"/>
<Column ss:Width="75"/><Column ss:Width="75"/><Column ss:Width="80"/>
<Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="80"/>' . "\n";

        // Title
        $xml .= '<Row ss:Height="32"><Cell ss:StyleID="title" ss:MergeAcross="8"><Data ss:Type="String">REKAP ANALISIS ISU &amp; MEDIA — TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="20"><Cell ss:StyleID="subtitle" ss:MergeAcross="8"><Data ss:Type="String">Bagian Protokol dan Komunikasi Pimpinan — Pemerintah Kota Bandung</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="8"></Row>' . "\n";

        // Group header
        $xml .= '<Row ss:Height="22">';
        $xml .= $this->cell('PERIODE', 'header', 1);
        $xml .= $this->cell('SENTIMEN ISU', 'header_green', 2);
        $xml .= $this->cell('JENIS MEDIA', 'header_blue', 2);
        $xml .= $this->cell('TOTAL ISU', 'header');
        $xml .= '</Row>' . "\n";

        // Sub-header
        $xml .= '<Row ss:Height="20">';
        $xml .= $this->cell('No', 'header');
        $xml .= $this->cell('Bulan', 'header');
        $xml .= $this->cell('Positif', 'header_green');
        $xml .= $this->cell('Negatif', 'header_red');
        $xml .= $this->cell('Netral', 'header_gray');
        $xml .= $this->cell('Media Sosial', 'header_blue');
        $xml .= $this->cell('Media Online', 'header_blue');
        $xml .= $this->cell('Media Cetak', 'header_blue');
        $xml .= $this->cell('Total', 'header');
        $xml .= '</Row>' . "\n";

        // Data rows
        foreach ($rekap as $i => $row) {
            $isOdd = ($i % 2 === 0);
            $s   = $isOdd ? 'odd' : 'even';
            $c   = $isOdd ? 'center_odd' : 'center_even';
            $n   = $isOdd ? 'num_odd' : 'num_even';
            $p   = $isOdd ? 'pos_odd' : 'pos_even';
            $neg = $isOdd ? 'neg_odd' : 'neg_even';

            $xml .= '<Row ss:Height="18">';
            $xml .= $this->cell((string)($i + 1), $c);
            $xml .= $this->cell($row['label'], $s);
            $xml .= $this->cell((string)$row['positif'], $p);
            $xml .= $this->cell((string)$row['negatif'], $neg);
            $xml .= $this->cell((string)$row['netral'], $c);
            $xml .= $this->cell((string)$row['sosial'], $c);
            $xml .= $this->cell((string)$row['online'], $c);
            $xml .= $this->cell((string)$row['cetak'], $c);
            $xml .= $this->cell((string)$row['total'], $n);
            $xml .= '</Row>' . "\n";
        }

        // Total row
        $xml .= '<Row ss:Height="24">';
        $xml .= $this->cell('TOTAL KESELURUHAN', 'total_label', 1);
        $xml .= $this->cell((string)$totalPos, 'total_row');
        $xml .= $this->cell((string)$totalNeg, 'total_row');
        $xml .= $this->cell((string)$totalNetral, 'total_row');
        $xml .= $this->cell((string)$totalSosial, 'total_row');
        $xml .= $this->cell((string)$totalOnline, 'total_row');
        $xml .= $this->cell((string)$totalCetak, 'total_row');
        $xml .= $this->cell((string)$grandTotal, 'total_row');
        $xml .= '</Row>' . "\n";

        $xml .= '</Table></Worksheet>' . "\n";

        // ============================================================
        // SHEET 2: DETAIL ANALISIS ISU
        // ============================================================
        $xml .= '<Worksheet ss:Name="Detail Analisis Isu"><Table ss:DefaultRowHeight="18">' . "\n";
        $xml .= '<Column ss:Width="30"/><Column ss:Width="200"/><Column ss:Width="80"/>
<Column ss:Width="85"/><Column ss:Width="100"/><Column ss:Width="110"/>
<Column ss:Width="80"/><Column ss:Width="160"/><Column ss:Width="250"/>
<Column ss:Width="220"/><Column ss:Width="220"/><Column ss:Width="180"/>
<Column ss:Width="120"/><Column ss:Width="100"/>' . "\n";

        $xml .= '<Row ss:Height="32"><Cell ss:StyleID="title" ss:MergeAcross="13"><Data ss:Type="String">DETAIL DATA ANALISIS ISU &amp; MEDIA — TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="20"><Cell ss:StyleID="subtitle" ss:MergeAcross="13"><Data ss:Type="String">Bagian Protokol dan Komunikasi Pimpinan — Pemerintah Kota Bandung</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="8"></Row>' . "\n";

        // Header
        $headers = [
            'No', 'Judul Isu', 'Tanggal', 'Bulan', 'Jenis Media',
            'Sumber Isu', 'Sentimen', 'Leading Sector', 'Uraian Analisis',
            'Rekomendasi Kebijakan', 'Rekomendasi Publikasi', 'Link Sumber Berita',
            'Dibuat Oleh', 'Waktu Input',
        ];
        $xml .= '<Row ss:Height="22">';
        foreach ($headers as $h) {
            $xml .= $this->cell($h, 'header');
        }
        $xml .= '</Row>' . "\n";

        if ($detail->isEmpty()) {
            $xml .= '<Row><Cell ss:StyleID="center_odd" ss:MergeAcross="13"><Data ss:Type="String">Tidak ada data analisis isu untuk tahun ' . $thn . '.</Data></Cell></Row>' . "\n";
        } else {
            foreach ($detail as $i => $row) {
                $isOdd = ($i % 2 === 0);
                $s  = $isOdd ? 'odd' : 'even';
                $c  = $isOdd ? 'center_odd' : 'center_even';
                $n  = $isOdd ? 'num_odd' : 'num_even';
                $ws = $isOdd ? 'wrap_odd' : 'wrap_even';
                $sc = match($row['sentimen']) {
                    'Positif' => $isOdd ? 'pos_odd' : 'pos_even',
                    'Negatif' => $isOdd ? 'neg_odd' : 'neg_even',
                    default   => $c,
                };

                $xml .= '<Row ss:AutoFitHeight="1">';
                $xml .= $this->cell((string)$row['no'], $n);
                $xml .= $this->cell($row['judul'], $s);
                $xml .= $this->cell($row['tanggal'], $c);
                $xml .= $this->cell($row['bulan'], $c);
                $xml .= $this->cell($row['jenis_media'], $c);
                $xml .= $this->cell($row['sumber_isu'], $s);
                $xml .= $this->cell($row['sentimen'], $sc);
                $xml .= $this->cell($row['leading_sector'], $s);
                $xml .= $this->cell($row['analisis'], $ws);
                $xml .= $this->cell($row['rekomendasi_kebijakan'], $ws);
                $xml .= $this->cell($row['rekomendasi_publikasi'], $ws);
                $xml .= $this->cell($row['link_sumber'], $s);
                $xml .= $this->cell($row['dibuat_oleh'], $c);
                $xml .= $this->cell($row['waktu_input'], $c);
                $xml .= '</Row>' . "\n";
            }
        }

        $xml .= '</Table></Worksheet>' . "\n";
        $xml .= '</Workbook>';

        return $xml;
    }

    public function stream(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'Rekap_Analisis_Isu_' . $this->tahun . '_' . date('Ymd_His') . '.xls';
        $xml = $this->buildXml();

        return response()->stream(function () use ($xml) {
            echo $xml;
        }, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }
}
