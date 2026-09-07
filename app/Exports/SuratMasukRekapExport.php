<?php

namespace App\Exports;

use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SuratMasukRekapExport
{
    protected int $tahun;
    protected ?int $bulan;
    protected ?string $statusPrint;
    protected ?string $search;

    const NAMA_BULAN = [
        1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
        4  => 'April',    5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',     8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',  11 => 'November',  12 => 'Desember',
    ];

    public function __construct(int $tahun, ?int $bulan = null, ?string $statusPrint = null, ?string $search = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan ? (int)$bulan : null;
        $this->statusPrint = $statusPrint;
        $this->search = $search;
    }

    /**
     * Get monthly aggregation for the 12 months summary
     */
    public function getRekapBulanan(): Collection
    {
        $rows = Keuangan::where(function ($q) {
            $q->whereYear('tanggal_diterima', $this->tahun)
              ->orWhere(function ($sub) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $this->tahun);
              });
        })
        ->selectRaw('MONTH(COALESCE(tanggal_diterima, tanggal)) as bulan, is_printed, COUNT(*) as total')
        ->groupByRaw('MONTH(COALESCE(tanggal_diterima, tanggal)), is_printed')
        ->get();

        $byBulan = [];
        foreach ($rows as $row) {
            $b = (int) $row->bulan;
            if (!isset($byBulan[$b])) {
                $byBulan[$b] = [
                    'bulan'     => $b,
                    'label'     => self::NAMA_BULAN[$b] . ' ' . $this->tahun,
                    'total'     => 0,
                    'printed'   => 0,
                    'unprinted' => 0,
                ];
            }
            $byBulan[$b]['total'] += (int) $row->total;
            if ($row->is_printed) {
                $byBulan[$b]['printed'] += (int) $row->total;
            } else {
                $byBulan[$b]['unprinted'] += (int) $row->total;
            }
        }

        $result = collect();
        for ($m = 1; $m <= 12; $m++) {
            $d = $byBulan[$m] ?? [
                'bulan'     => $m,
                'label'     => self::NAMA_BULAN[$m] . ' ' . $this->tahun,
                'total'     => 0,
                'printed'   => 0,
                'unprinted' => 0,
            ];
            $d['persentase'] = $d['total'] > 0 ? round(($d['printed'] / $d['total']) * 100) : 0;
            $result->push($d);
        }

        return $result;
    }

    /**
     * Get detailed records based on year, month, and filters
     */
    public function getDetailData(): Collection
    {
        $query = Keuangan::with('createdBy')->where(function ($q) {
            $q->whereYear('tanggal_diterima', $this->tahun)
              ->orWhere(function ($sub) {
                  $sub->whereNull('tanggal_diterima')->whereYear('tanggal', $this->tahun);
              });
        })->orderByRaw('COALESCE(tanggal_diterima, tanggal) ASC')->orderBy('id', 'asc');

        if ($this->bulan) {
            $query->where(function ($q) {
                $q->whereMonth('tanggal_diterima', $this->bulan)
                  ->orWhere(function ($sub) {
                      $sub->whereNull('tanggal_diterima')->whereMonth('tanggal', $this->bulan);
                  });
            });
        }

        if ($this->statusPrint === '1' || $this->statusPrint === 'printed') {
            $query->where('is_printed', true);
        } elseif ($this->statusPrint === '0' || $this->statusPrint === 'unprinted') {
            $query->where(function ($q) {
                $q->where('is_printed', false)->orWhereNull('is_printed');
            });
        }

        if ($this->search) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat', 'like', "%{$s}%")
                  ->orWhere('pengirim', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%")
                  ->orWhere('disposisi', 'like', "%{$s}%");
            });
        }

        return $query->get()->map(function ($item, $idx) {
            $tgl = $item->formatted_tanggal_diterima;
            $noSurat = $item->nomor_surat ?? $item->no_bukti ?? '-';
            $asal = $item->pengirim ?? $item->penanggung_jawab ?? '-';
            $perihal = $item->perihal ?? $item->uraian ?? '-';
            $disposisi = $item->disposisi ?? '-';
            $doc = $item->file_dokumen ? 'Ada Berkas' : '-';
            $printVal = $item->is_printed ? 'V' : '-';
            $userInput = $item->createdBy ? $item->createdBy->name : '-';

            return [
                'no'           => $idx + 1,
                'tanggal'      => $tgl,
                'nomor_surat'  => $noSurat,
                'asal_instansi'=> $asal,
                'perihal'      => $perihal,
                'disposisi'    => $disposisi,
                'dokumen'      => $doc,
                'is_printed'   => $printVal,
                'input_oleh'   => $userInput,
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
        $thn = $this->tahun;
        $bln = $this->bulan;
        $rekapBulanan = $this->getRekapBulanan();
        $detail = $this->getDetailData();

        $totalSuratTahun = $rekapBulanan->sum('total');
        $totalPrintedTahun = $rekapBulanan->sum('printed');
        $totalUnprintedTahun = $rekapBulanan->sum('unprinted');

        $periodeTitle = $bln ? ('BULAN ' . strtoupper(self::NAMA_BULAN[$bln] ?? '') . ' ' . $thn) : ('TAHUN ' . $thn);

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
<Style ss:ID="title"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Size="14" ss:FontName="Calibri" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>
<Style ss:ID="subtitle"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Size="11" ss:FontName="Calibri" ss:Color="#1E3A5F"/><Interior ss:Color="#F1F5F9" ss:Pattern="Solid"/></Style>
<Style ss:ID="header"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/></Borders></Style>
<Style ss:ID="header_green"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#059669" ss:Pattern="Solid"/></Style>
<Style ss:ID="header_red"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:Color="#FFFFFF" ss:FontName="Calibri" ss:Size="11"/><Interior ss:Color="#DC2626" ss:Pattern="Solid"/></Style>
<Style ss:ID="odd"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="even"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="center_odd"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="center_even"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10"/><Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="print_yes"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#047857"/><Interior ss:Color="#ECFDF5" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="print_no"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="10" ss:Color="#94A3B8"/><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/></Borders></Style>
<Style ss:ID="total_row"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>
<Style ss:ID="total_label"><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Font ss:Bold="1" ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A5F" ss:Pattern="Solid"/></Style>
</Styles>' . "\n";

        // ============================================================
        // SHEET 1: REKAP BULANAN (Tampil jika rekap per tahun)
        // ============================================================
        if (!$bln) {
            $xml .= '<Worksheet ss:Name="Rekap Per Bulan"><Table ss:DefaultRowHeight="20">' . "\n";
            $xml .= '<Column ss:Width="35"/>';  // No
            $xml .= '<Column ss:Width="140"/>'; // Bulan
            $xml .= '<Column ss:Width="110"/>'; // Total Surat
            $xml .= '<Column ss:Width="110"/>'; // Sudah Diprint
            $xml .= '<Column ss:Width="110"/>'; // Belum Diprint
            $xml .= '<Column ss:Width="100"/>'; // % Selesai
            $xml .= "\n";

            $xml .= '<Row ss:Height="32"><Cell ss:StyleID="title" ss:MergeAcross="5"><Data ss:Type="String">REKAPITULASI SURAT MASUK — TAHUN ' . $thn . '</Data></Cell></Row>' . "\n";
            $xml .= '<Row ss:Height="22"><Cell ss:StyleID="subtitle" ss:MergeAcross="5"><Data ss:Type="String">Bagian Protokol dan Komunikasi Pimpinan — Pemerintah Kota Bandung</Data></Cell></Row>' . "\n";
            $xml .= '<Row ss:Height="8"></Row>' . "\n";

            // Headers
            $xml .= '<Row ss:Height="24">';
            $xml .= $this->cell('No', 'header');
            $xml .= $this->cell('Bulan', 'header');
            $xml .= $this->cell('Total Surat', 'header');
            $xml .= $this->cell('Sudah Diprint', 'header_green');
            $xml .= $this->cell('Belum Diprint', 'header_red');
            $xml .= $this->cell('% Selesai', 'header');
            $xml .= '</Row>' . "\n";

            foreach ($rekapBulanan as $i => $r) {
                $isOdd = ($i % 2 === 0);
                $c = $isOdd ? 'center_odd' : 'center_even';
                $s = $isOdd ? 'odd' : 'even';

                $xml .= '<Row ss:Height="20">';
                $xml .= $this->cell((string)($i + 1), $c);
                $xml .= $this->cell($r['label'], $s);
                $xml .= $this->cell((string)$r['total'], $c);
                $xml .= $this->cell((string)$r['printed'], $c);
                $xml .= $this->cell((string)$r['unprinted'], $c);
                $xml .= $this->cell($r['persentase'] . '%', $c);
                $xml .= '</Row>' . "\n";
            }

            // Total Row
            $pctTahun = $totalSuratTahun > 0 ? round(($totalPrintedTahun / $totalSuratTahun) * 100) : 0;
            $xml .= '<Row ss:Height="24">';
            $xml .= $this->cell('TOTAL KESELURUHAN', 'total_label', 1);
            $xml .= $this->cell((string)$totalSuratTahun, 'total_row');
            $xml .= $this->cell((string)$totalPrintedTahun, 'total_row');
            $xml .= $this->cell((string)$totalUnprintedTahun, 'total_row');
            $xml .= $this->cell($pctTahun . '%', 'total_row');
            $xml .= '</Row>' . "\n";

            $xml .= '</Table></Worksheet>' . "\n";
        }

        // ============================================================
        // SHEET 2 (atau SHEET UTAMA): DETAIL SURAT MASUK
        // ============================================================
        $sheetDetailName = $bln ? (self::NAMA_BULAN[$bln] . ' ' . $thn) : ('Detail Surat ' . $thn);
        $xml .= '<Worksheet ss:Name="' . $this->esc($sheetDetailName) . '"><Table ss:DefaultRowHeight="20">' . "\n";
        $xml .= '<Column ss:Width="35"/>';  // No
        $xml .= '<Column ss:Width="120"/>'; // Tanggal Diterima
        $xml .= '<Column ss:Width="160"/>'; // Nomor
        $xml .= '<Column ss:Width="200"/>'; // Asal Instansi
        $xml .= '<Column ss:Width="280"/>'; // Perihal
        $xml .= '<Column ss:Width="180"/>'; // Disposisi
        $xml .= '<Column ss:Width="90"/>';  // Dokumen
        $xml .= '<Column ss:Width="65"/>';  // Print
        $xml .= '<Column ss:Width="130"/>'; // Dicatat Oleh
        $xml .= "\n";

        // Title
        $xml .= '<Row ss:Height="32"><Cell ss:StyleID="title" ss:MergeAcross="8"><Data ss:Type="String">BUKU SURAT MASUK — ' . $periodeTitle . '</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="22"><Cell ss:StyleID="subtitle" ss:MergeAcross="8"><Data ss:Type="String">Bagian Protokol dan Komunikasi Pimpinan — Pemerintah Kota Bandung</Data></Cell></Row>' . "\n";
        $xml .= '<Row ss:Height="8"></Row>' . "\n";

        // Headers
        $xml .= '<Row ss:Height="24">';
        $xml .= $this->cell('No', 'header');
        $xml .= $this->cell('TANGGAL DITERIMA', 'header');
        $xml .= $this->cell('NOMOR', 'header');
        $xml .= $this->cell('ASAL INSTANSI', 'header');
        $xml .= $this->cell('PERIHAL', 'header');
        $xml .= $this->cell('DISPOSISI', 'header');
        $xml .= $this->cell('DOKUMEN', 'header');
        $xml .= $this->cell('PRINT', 'header');
        $xml .= $this->cell('DICATAT OLEH', 'header');
        $xml .= '</Row>' . "\n";

        if ($detail->isEmpty()) {
            $xml .= '<Row ss:Height="24"><Cell ss:StyleID="center_odd" ss:MergeAcross="8"><Data ss:Type="String">Tidak ada data surat masuk untuk periode ini.</Data></Cell></Row>' . "\n";
        } else {
            foreach ($detail as $i => $row) {
                $isOdd = ($i % 2 === 0);
                $s = $isOdd ? 'odd' : 'even';
                $c = $isOdd ? 'center_odd' : 'center_even';
                $p = $row['is_printed'] === 'V' ? 'print_yes' : 'print_no';

                $xml .= '<Row ss:AutoFitHeight="1">';
                $xml .= $this->cell((string)$row['no'], $c);
                $xml .= $this->cell($row['tanggal'], $c);
                $xml .= $this->cell($row['nomor_surat'], $s);
                $xml .= $this->cell($row['asal_instansi'], $s);
                $xml .= $this->cell($row['perihal'], $s);
                $xml .= $this->cell($row['disposisi'], $s);
                $xml .= $this->cell($row['dokumen'], $c);
                $xml .= $this->cell($row['is_printed'], $p);
                $xml .= $this->cell($row['input_oleh'], $c);
                $xml .= '</Row>' . "\n";
            }
        }

        $xml .= '</Table></Worksheet>' . "\n";
        $xml .= '</Workbook>';

        return $xml;
    }

    public function stream(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'REKAP_SURAT_MASUK_' . $this->tahun . ($this->bulan ? ('_BULAN_' . $this->bulan) : '') . '_' . date('Ymd_His') . '.xls';
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
