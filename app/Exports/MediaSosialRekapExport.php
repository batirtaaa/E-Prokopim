<?php

namespace App\Exports;

use App\Models\MediaSosial;
use Illuminate\Support\Collection;

class MediaSosialRekapExport
{
    protected int $tahun;

    const NAMA_BULAN = [
        1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
        4  => 'April',    5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',     8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',  11 => 'November',  12 => 'Desember',
    ];

    const KATEGORI_LABELS = [
        'infografis'      => 'Infografis',
        'videografis'     => 'Videografis',
        'media_luar_ruang'=> 'Media Luar Ruang',
    ];

    public function __construct(int $tahun)
    {
        $this->tahun = $tahun;
    }

    /**
     * Generate rekap data per bulan
     * Returns array[ bulan => [ 'label', 'infografis', 'videografis', 'media_luar_ruang', 'total' ] ]
     */
    public function getRekapData(): Collection
    {
        // Ambil semua data tahun ini, group by bulan & kategori
        $rows = MediaSosial::whereYear('tanggal_publikasi', $this->tahun)
            ->whereNotNull('tanggal_publikasi')
            ->selectRaw('MONTH(tanggal_publikasi) as bulan, kategori, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal_publikasi), kategori')
            ->get();

        $byBulan = [];
        foreach ($rows as $row) {
            $b = (int) $row->bulan;
            if (!isset($byBulan[$b])) {
                $byBulan[$b] = [
                    'bulan'           => $b,
                    'label'           => self::NAMA_BULAN[$b] . ' ' . $this->tahun,
                    'infografis'      => 0,
                    'videografis'     => 0,
                    'media_luar_ruang'=> 0,
                ];
            }
            $byBulan[$b][$row->kategori] = (int) $row->total;
        }

        // Lengkapi 12 bulan, hitung total
        $result = collect();
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = $byBulan[$bulan] ?? [
                'bulan'           => $bulan,
                'label'           => self::NAMA_BULAN[$bulan] . ' ' . $this->tahun,
                'infografis'      => 0,
                'videografis'     => 0,
                'media_luar_ruang'=> 0,
            ];
            $data['total'] = $data['infografis'] + $data['videografis'] + $data['media_luar_ruang'];
            $result->push($data);
        }

        return $result;
    }

    /**
     * Generate detail data per kategori per bulan (sheet per kategori)
     */
    public function getDetailData(string $kategori): Collection
    {
        return MediaSosial::whereYear('tanggal_publikasi', $this->tahun)
            ->where('kategori', $kategori)
            ->whereNotNull('tanggal_publikasi')
            ->orderBy('tanggal_publikasi')
            ->get()
            ->map(function ($item, $idx) {
                return [
                    'no'               => $idx + 1,
                    'judul'            => $item->judul,
                    'sub_kategori'     => $item->sub_kategori_label ?? $item->sub_kategori ?? '-',
                    'platform'         => $item->platform_label,
                    'tanggal'          => $item->tanggal_publikasi?->format('d/m/Y') ?? '-',
                    'bulan'            => self::NAMA_BULAN[$item->tanggal_publikasi?->month] ?? '-',
                    'status'           => $item->status_label,
                    'deskripsi'        => $item->deskripsi ?? '-',
                    'link_post'        => $item->link_post ?? '-',
                ];
            });
    }

    /**
     * Build XML SpreadsheetML yang kompatibel Excel (.xls)
     */
    public function buildXml(): string
    {
        $rekap  = $this->getRekapData();
        $infogr = $this->getDetailData('infografis');
        $videogr= $this->getDetailData('videografis');
        $media  = $this->getDetailData('media_luar_ruang');

        $grandTotal = $rekap->sum('total');
        $thn = $this->tahun;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
            xmlns:o="urn:schemas-microsoft-com:office:office"
            xmlns:x="urn:schemas-microsoft-com:office:excel"
            xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
            xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";

        // Styles
        $xml .= '<Styles>' . "\n";
        $xml .= '<Style ss:ID="Default" ss:Name="Normal"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="11"/></Style>' . "\n";
        $xml .= '<Style ss:ID="title"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Size="14" ss:FontName="Calibri" ss:Color="#1E3A5F"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/></Style>' . "\n";
        $xml .= '<Style ss:ID="header"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="subheader"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#2563EB" ss:Pattern="Solid"/></Style>' . "\n";
        $xml .= '<Style ss:ID="odd"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="even"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="center_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="center_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="num_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#1E3A5F"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="num_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#1E3A5F"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>' . "\n";
        $xml .= '<Style ss:ID="total_row"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>' . "\n";
        $xml .= '<Style ss:ID="total_label"><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>' . "\n";
        $xml .= '<Style ss:ID="date_cell"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/></Style>' . "\n";
        $xml .= '</Styles>' . "\n";

        // ============================================================
        // Sheet 1: REKAP PER BULAN
        // ============================================================
        $xml .= '<Worksheet ss:Name="Rekap Per Bulan">' . "\n";
        $xml .= '<Table ss:DefaultRowHeight="18">' . "\n";
        $xml .= '<Column ss:Width="40"/><Column ss:Width="130"/><Column ss:Width="90"/><Column ss:Width="90"/><Column ss:Width="100"/><Column ss:Width="80"/>' . "\n";

        // Title row
        $xml .= '<Row ss:Height="30"><Cell ss:MergeAcross="5" ss:StyleID="title"><Data ss:Type="String">REKAP UPLOAD MEDIA SOSIAL TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="20"><Cell ss:MergeAcross="5" ss:StyleID="date_cell"><Data ss:Type="String">Diunduh: ' . now()->format('d/m/Y H:i') . ' | Komunikasi Pimpinan</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="6"><Cell><Data ss:Type="String"></Data></Cell></Row>' . "\n";

        // Header row
        $xml .= '<Row ss:Height="28">';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">No.</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Bulan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Infografis</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Videografis</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Media Luar Ruang</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Total</Data></Cell>';
        $xml .= '</Row>' . "\n";

        // Data rows
        foreach ($rekap as $i => $row) {
            $isOdd = ($i % 2 === 0);
            $style = $isOdd ? 'odd' : 'even';
            $cStyle = $isOdd ? 'center_odd' : 'center_even';
            $nStyle = $isOdd ? 'num_odd' : 'num_even';
            $xml .= '<Row ss:Height="20">';
            $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"Number\">" . ($i + 1) . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['label']) . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['infografis'] . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['videografis'] . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['media_luar_ruang'] . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['total'] . "</Data></Cell>";
            $xml .= '</Row>' . "\n";
        }

        // Total row
        $xml .= '<Row ss:Height="22">';
        $xml .= '<Cell ss:MergeAcross="1" ss:StyleID="total_label"><Data ss:Type="String">TOTAL KESELURUHAN</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('infografis') . '</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('videografis') . '</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('media_luar_ruang') . '</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $grandTotal . '</Data></Cell>';
        $xml .= '</Row>' . "\n";

        $xml .= '</Table></Worksheet>' . "\n";

        // ============================================================
        // Sheet 2, 3, 4: Detail per Kategori
        // ============================================================
        $sheets = [
            ['name' => 'Infografis',       'data' => $infogr,  'has_sub_kat' => true],
            ['name' => 'Videografis',       'data' => $videogr, 'has_sub_kat' => false],
            ['name' => 'Media Luar Ruang',  'data' => $media,   'has_sub_kat' => false],
        ];

        foreach ($sheets as $sheet) {
            $xml .= '<Worksheet ss:Name="' . $sheet['name'] . '">' . "\n";
            $xml .= '<Table ss:DefaultRowHeight="18">' . "\n";

            if ($sheet['has_sub_kat']) {
                $xml .= '<Column ss:Width="35"/><Column ss:Width="220"/><Column ss:Width="100"/><Column ss:Width="90"/><Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="220"/>' . "\n";
            } else {
                $xml .= '<Column ss:Width="35"/><Column ss:Width="220"/><Column ss:Width="90"/><Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="220"/>' . "\n";
            }

            // Title
            $mergeAcross = $sheet['has_sub_kat'] ? 7 : 6;
            $xml .= '<Row ss:Height="30"><Cell ss:MergeAcross="' . $mergeAcross . '" ss:StyleID="title"><Data ss:Type="String">DETAIL ' . strtoupper($sheet['name']) . ' TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
            $xml .= '<Row ss:Height="20"><Cell ss:MergeAcross="' . $mergeAcross . '" ss:StyleID="date_cell"><Data ss:Type="String">Diunduh: ' . now()->format('d/m/Y H:i') . ' | Komunikasi Pimpinan</Data></Cell></Row>' . "\n";
            $xml .= '<Row ss:Height="6"><Cell><Data ss:Type="String"></Data></Cell></Row>' . "\n";

            // Header
            $xml .= '<Row ss:Height="28">';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">No.</Data></Cell>';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Judul</Data></Cell>';
            if ($sheet['has_sub_kat']) {
                $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Kategori</Data></Cell>';
            }
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Platform</Data></Cell>';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Bulan</Data></Cell>';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Tanggal</Data></Cell>';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Status</Data></Cell>';
            $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Deskripsi / URL</Data></Cell>';
            $xml .= '</Row>' . "\n";

            if ($sheet['data']->isEmpty()) {
                $xml .= '<Row ss:Height="20">';
                $xml .= '<Cell ss:MergeAcross="' . $mergeAcross . '" ss:StyleID="center_odd"><Data ss:Type="String">Tidak ada data untuk kategori ini pada tahun ' . $thn . '</Data></Cell>';
                $xml .= '</Row>' . "\n";
            } else {
                foreach ($sheet['data'] as $i => $row) {
                    $isOdd = ($i % 2 === 0);
                    $style = $isOdd ? 'odd' : 'even';
                    $cStyle = $isOdd ? 'center_odd' : 'center_even';
                    $xml .= '<Row ss:Height="20">';
                    $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"Number\">" . $row['no'] . "</Data></Cell>";
                    $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['judul']) . "</Data></Cell>";
                    if ($sheet['has_sub_kat']) {
                        $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['sub_kategori']) . "</Data></Cell>";
                    }
                    $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['platform']) . "</Data></Cell>";
                    $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['bulan']) . "</Data></Cell>";
                    $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['tanggal']) . "</Data></Cell>";
                    $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['status']) . "</Data></Cell>";
                    $desc = $row['link_post'] !== '-' ? $row['link_post'] : $row['deskripsi'];
                    $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($desc) . "</Data></Cell>";
                    $xml .= '</Row>' . "\n";
                }
            }

            $xml .= '</Table></Worksheet>' . "\n";
        }

        $xml .= '</Workbook>';
        return $xml;
    }

    /**
     * Download response
     */
    public function download(): \Illuminate\Http\Response
    {
        $xml      = $this->buildXml();
        $filename = 'rekap-media-sosial-' . $this->tahun . '.xls';

        return response($xml, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
