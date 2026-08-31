<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Illuminate\Support\Collection;

class KegiatanPimpinanRekapExport
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
     * Data rekap bulanan untuk tahun yang dipilih
     */
    public function getRekapData(): Collection
    {
        $rows = Kegiatan::whereYear('tanggal_mulai', $this->tahun)
            ->whereNotNull('tanggal_mulai')
            ->selectRaw('MONTH(tanggal_mulai) as bulan, status, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal_mulai), status')
            ->get();

        $byBulan = [];
        foreach ($rows as $row) {
            $b = (int) $row->bulan;
            if (!isset($byBulan[$b])) {
                $byBulan[$b] = [
                    'bulan'     => $b,
                    'label'     => self::NAMA_BULAN[$b] . ' ' . $this->tahun,
                    'total'     => 0,
                    'terjadwal' => 0,
                    'draft'     => 0,
                ];
            }
            $count = (int) $row->total;
            $byBulan[$b]['total'] += $count;
            if ($row->status === 'draft') {
                $byBulan[$b]['draft'] += $count;
            } else {
                $byBulan[$b]['terjadwal'] += $count;
            }
        }

        $result = collect();
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = $byBulan[$bulan] ?? [
                'bulan'     => $bulan,
                'label'     => self::NAMA_BULAN[$bulan] . ' ' . $this->tahun,
                'total'     => 0,
                'terjadwal' => 0,
                'draft'     => 0,
            ];
            $result->push($data);
        }

        return $result;
    }

    /**
     * Data detail seluruh kegiatan untuk tahun yang dipilih
     */
    public function getDetailData(): Collection
    {
        return Kegiatan::whereYear('tanggal_mulai', $this->tahun)
            ->whereNotNull('tanggal_mulai')
            ->orderBy('tanggal_mulai', 'asc')
            ->get()
            ->map(function ($item, $idx) {
                $waktu = '';
                if ($item->tanggal_mulai) {
                    $waktu = $item->tanggal_mulai->format('H:i') . ' WIB';
                    if ($item->tanggal_selesai) {
                        $waktu .= ' - ' . $item->tanggal_selesai->format('H:i') . ' WIB';
                    } else {
                        $waktu .= ' s/d Selesai';
                    }
                }

                return [
                    'no'             => $idx + 1,
                    'nomor_agenda'   => $item->nomor_agenda ?? ('#KG-' . str_pad($item->id, 6, '0', STR_PAD_LEFT)),
                    'judul'          => $item->judul,
                    'leading_sektor' => $item->leading_sektor ?: '—',
                    'tanggal'        => $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-',
                    'bulan'          => $item->tanggal_mulai ? (self::NAMA_BULAN[$item->tanggal_mulai->month] ?? '-') : '-',
                    'waktu'          => $waktu ?: '-',
                    'pimpinan'       => $item->pimpinan_label ?: '—',
                    'lokasi'         => $item->lokasi ?? '-',
                    'keterangan'     => $item->deskripsi ?? '-',
                    'status'         => $item->status_label,
                ];
            });
    }

    /**
     * Build XML SpreadsheetML (Format Excel)
     */
    public function buildXml(): string
    {
        $rekap  = $this->getRekapData();
        $detail = $this->getDetailData();
        $thn    = $this->tahun;

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
        // Sheet 1: REKAP BULANAN
        // ============================================================
        $xml .= '<Worksheet ss:Name="Rekap Bulanan">' . "\n";
        $xml .= '<Table ss:DefaultRowHeight="18">' . "\n";
        $xml .= '<Column ss:Width="40"/><Column ss:Width="140"/><Column ss:Width="110"/><Column ss:Width="110"/><Column ss:Width="90"/>' . "\n";

        // Title row
        $xml .= '<Row ss:Height="30"><Cell ss:MergeAcross="4" ss:StyleID="title"><Data ss:Type="String">REKAPITULASI KEGIATAN PIMPINAN TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="20"><Cell ss:MergeAcross="4" ss:StyleID="date_cell"><Data ss:Type="String">Diunduh: ' . now()->format('d/m/Y H:i') . ' | Bagian Protokol dan Komunikasi Pimpinan</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="6"><Cell><Data ss:Type="String"></Data></Cell></Row>' . "\n";

        // Header row
        $xml .= '<Row ss:Height="28">';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">No.</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Bulan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Terjadwal / Publikasi</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Draft</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Total Kegiatan</Data></Cell>';
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
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['terjadwal'] . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['draft'] . "</Data></Cell>";
            $xml .= "<Cell ss:StyleID=\"$nStyle\"><Data ss:Type=\"Number\">" . $row['total'] . "</Data></Cell>";
            $xml .= '</Row>' . "\n";
        }

        // Total row
        $xml .= '<Row ss:Height="22">';
        $xml .= '<Cell ss:MergeAcross="1" ss:StyleID="total_label"><Data ss:Type="String">TOTAL KESELURUHAN</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('terjadwal') . '</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('draft') . '</Data></Cell>';
        $xml .= '<Cell ss:StyleID="total_row"><Data ss:Type="Number">' . $rekap->sum('total') . '</Data></Cell>';
        $xml .= '</Row>' . "\n";

        $xml .= '</Table></Worksheet>' . "\n";

        // ============================================================
        // Sheet 2: DETAIL KEGIATAN
        // ============================================================
        $xml .= '<Worksheet ss:Name="Detail Seluruh Kegiatan">' . "\n";
        $xml .= '<Table ss:DefaultRowHeight="18">' . "\n";
        $xml .= '<Column ss:Width="35"/><Column ss:Width="110"/><Column ss:Width="230"/><Column ss:Width="160"/><Column ss:Width="80"/><Column ss:Width="80"/><Column ss:Width="130"/><Column ss:Width="180"/><Column ss:Width="180"/><Column ss:Width="180"/><Column ss:Width="90"/>' . "\n";

        // Title
        $xml .= '<Row ss:Height="30"><Cell ss:MergeAcross="10" ss:StyleID="title"><Data ss:Type="String">DETAIL RIWAYAT KEGIATAN PIMPINAN TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="20"><Cell ss:MergeAcross="10" ss:StyleID="date_cell"><Data ss:Type="String">Diunduh: ' . now()->format('d/m/Y H:i') . ' | Bagian Protokol dan Komunikasi Pimpinan</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="6"><Cell><Data ss:Type="String"></Data></Cell></Row>' . "\n";

        // Header
        $xml .= '<Row ss:Height="28">';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">No.</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">No. Agenda</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Nama Kegiatan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Leading Sektor</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Bulan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Tanggal</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Waktu Pelaksanaan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Pimpinan / Pelaksana</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Lokasi</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Detail Ruangan / Keterangan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="header"><Data ss:Type="String">Status</Data></Cell>';
        $xml .= '</Row>' . "\n";

        if ($detail->isEmpty()) {
            $xml .= '<Row ss:Height="20">';
            $xml .= '<Cell ss:MergeAcross="10" ss:StyleID="center_odd"><Data ss:Type="String">Tidak ada data kegiatan pada tahun ' . $thn . '</Data></Cell>';
            $xml .= '</Row>' . "\n";
        } else {
            foreach ($detail as $i => $row) {
                $isOdd = ($i % 2 === 0);
                $style = $isOdd ? 'odd' : 'even';
                $cStyle = $isOdd ? 'center_odd' : 'center_even';

                $xml .= '<Row ss:Height="20">';
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"Number\">" . $row['no'] . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['nomor_agenda']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['judul']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['leading_sektor']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['bulan']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['tanggal']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['waktu']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['pimpinan']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['lokasi']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">" . htmlspecialchars($row['keterangan']) . "</Data></Cell>";
                $xml .= "<Cell ss:StyleID=\"$cStyle\"><Data ss:Type=\"String\">" . htmlspecialchars($row['status']) . "</Data></Cell>";
                $xml .= '</Row>' . "\n";
            }
        }

        $xml .= '</Table></Worksheet>' . "\n";

        $xml .= '</Workbook>';
        return $xml;
    }

    /**
     * Download response
     */
    public function download(): \Illuminate\Http\Response
    {
        $xml      = $this->buildXml();
        $filename = 'rekap-kegiatan-pimpinan-' . $this->tahun . '.xls';

        return response($xml, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
