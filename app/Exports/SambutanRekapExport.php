<?php

namespace App\Exports;

use App\Models\Sambutan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SambutanRekapExport
{
    protected int $tahun;
    protected ?int $selectedBulan;

    const NAMA_BULAN = [
        1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
        4  => 'April',     5  => 'Mei',       6  => 'Juni',
        7  => 'Juli',      8  => 'Agustus',   9  => 'September',
        10 => 'Oktober',   11 => 'November',  12 => 'Desember',
    ];

    const NAMA_BULAN_UPPER = [
        1  => 'JANUARI',   2  => 'FEBRUARI', 3  => 'MARET',
        4  => 'APRIL',     5  => 'MEI',       6  => 'JUNI',
        7  => 'JULI',      8  => 'AGUSTUS',   9  => 'SEPTEMBER',
        10 => 'OKTOBER',   11 => 'NOVEMBER',  12 => 'DESEMBER',
    ];

    const NAMA_HARI = [
        'Sunday'    => 'Minggu',
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
    ];

    public function __construct(int $tahun, ?int $selectedBulan = null)
    {
        $this->tahun = $tahun;
        $this->selectedBulan = $selectedBulan;
    }

    /**
     * Ambil data sambutan berdasarkan bulan
     */
    public function getSambutanByBulan(int $bulan): Collection
    {
        $items = Sambutan::with('petugas')
            ->whereYear('tanggal_terima', $this->tahun)
            ->whereMonth('tanggal_terima', $bulan)
            ->orderBy('tanggal_terima', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return $items->map(function ($item, $idx) {
            // Tanggal Surat
            $dtSurat = $item->tanggal_surat ? Carbon::parse($item->tanggal_surat) : null;
            $tglSurat = $dtSurat
                ? ($dtSurat->day . ' ' . (self::NAMA_BULAN[$dtSurat->month] ?? '') . ' ' . $dtSurat->year)
                : '-';

            // Tanggal Disposisi (Tanggal Terima)
            $dtTerima = $item->tanggal_terima ? Carbon::parse($item->tanggal_terima) : null;
            $tglDisposisi = $dtTerima
                ? ($dtTerima->day . ' ' . (self::NAMA_BULAN[$dtTerima->month] ?? '') . ' ' . $dtTerima->year)
                : '-';

            // Tanggal Acara (dengan Nama Hari, misal: Minggu, 18 Januari 2026)
            $dtAcara = $item->tanggal_acara ? Carbon::parse($item->tanggal_acara) : null;
            $tglAcara = $dtAcara
                ? ((self::NAMA_HARI[$dtAcara->format('l')] ?? '') . ', ' . $dtAcara->day . ' ' . (self::NAMA_BULAN[$dtAcara->month] ?? '') . ' ' . $dtAcara->year)
                : '-';

            // Jam Acara
            $jam = '-';
            if ($item->waktu_acara) {
                $jam = str_contains($item->waktu_acara, 'WIB')
                    ? $item->waktu_acara
                    : ($item->waktu_acara . ' WIB');
            }

            // Tempat Acara (dari deskripsi singkat atau fallback)
            $tempat = $item->deskripsi_singkat ?: '-';

            // Tanggal Selesai (dari tgl_upload_hasil)
            $dtSelesai = $item->tgl_upload_hasil ? Carbon::parse($item->tgl_upload_hasil) : null;
            $tglSelesai = $dtSelesai
                ? ($dtSelesai->day . ' ' . (self::NAMA_BULAN[$dtSelesai->month] ?? '') . ' ' . $dtSelesai->year)
                : '-';

            // Status
            $statusLabel = match($item->status) {
                'selesai'  => 'Selesai',
                'diproses' => 'Progres',
                default    => 'Draft',
            };

            // Keterangan WA / Catatan
            $keteranganWA = $item->catatan_hasil ?: ($item->instruksi_disposisi ?: '-');

            // Konseptor / Petugas Disposisi
            $konseptor = '-';
            if ($item->petugas) {
                $konseptor = $item->petugas->nama_lengkap;
            }

            // Naskah Hasil
            $docName = '-';
            $fileUrl = null;
            $hasHasil = false;

            if ($item->file_hasil_path) {
                $docName = $item->file_hasil_name ?: basename($item->file_hasil_path);
                $fileUrl = route('sambutan.preview-hasil', $item->id);
                $hasHasil = true;
            }

            return [
                'no'               => $idx + 1,
                'tanggal_surat'    => $tglSurat,
                'tanggal_disposisi'=> $tglDisposisi,
                'nomor_surat'      => $item->nomor_surat ?? '-',
                'tujuan'           => $item->tujuan ?? '-',
                'pengirim'         => $item->asal_instansi ?? '-',
                'tanggal_acara'    => $tglAcara,
                'jam'              => $jam,
                'tempat'           => $tempat,
                'tema'             => $item->perihal ?? '-',
                'konseptor'        => $konseptor,
                'status'           => $statusLabel,
                'tanggal_selesai'  => $tglSelesai,
                'keterangan_wa'    => $keteranganWA,
                'naskah_hasil'     => $hasHasil ? $docName : 'Belum Ada',
                'file_url'         => $fileUrl,
                'has_hasil'        => $hasHasil,
            ];
        });
    }

    /**
     * Bangun Spreadsheet Excel
     */
    public function buildSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $thn = $this->tahun;

        // Border style presets
        $borderThin = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CBD5E1'],
                ],
            ],
        ];

        $headerBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => '15803D'],
                ],
            ],
        ];

        $months = $this->selectedBulan ? [$this->selectedBulan] : range(1, 12);
        $grandTotal = 0;
        $isFirst = true;

        foreach ($months as $m) {
            $sheetName  = self::NAMA_BULAN_UPPER[$m];
            $bulanLabel = self::NAMA_BULAN_UPPER[$m] . ' ' . $thn;
            $items      = $this->getSambutanByBulan($m);

            if ($isFirst) {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($sheetName);
                $isFirst = false;
            } else {
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($sheetName);
            }

            $sheet->setShowGridLines(true);

            // Set Column Widths (15 Kolom sesuai format referensi)
            $sheet->getColumnDimension('A')->setWidth(6);   // # (NO)
            $sheet->getColumnDimension('B')->setWidth(18);  // Tanggal Surat
            $sheet->getColumnDimension('C')->setWidth(18);  // Tanggal Disposisi
            $sheet->getColumnDimension('D')->setWidth(22);  // Nomor Surat
            $sheet->getColumnDimension('E')->setWidth(24);  // Tujuan
            $sheet->getColumnDimension('F')->setWidth(28);  // Pengirim
            $sheet->getColumnDimension('G')->setWidth(26);  // Tanggal acara
            $sheet->getColumnDimension('H')->setWidth(14);  // Jam
            $sheet->getColumnDimension('I')->setWidth(30);  // Tempat
            $sheet->getColumnDimension('J')->setWidth(40);  // Tema
            $sheet->getColumnDimension('K')->setWidth(26);  // Konseptor
            $sheet->getColumnDimension('L')->setWidth(14);  // Status
            $sheet->getColumnDimension('M')->setWidth(18);  // Tanggal Selesai
            $sheet->getColumnDimension('N')->setWidth(38);  // Keterangan WA
            $sheet->getColumnDimension('O')->setWidth(32);  // Naskah Hasil

            // Row 1: Merged Title Banner
            $sheet->mergeCells('A1:O1');
            $sheet->setCellValue('A1', 'REKAP SAMBUTAN PIMPINAN BULAN ' . $bulanLabel);
            $sheet->getRowDimension(1)->setRowHeight(34);
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B5E20'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getStyle('A1:O1')->applyFromArray($headerBorderStyle);

            // Row 2: Table Column Headers (15 Kolom)
            $headers = [
                '#',
                'Tanggal Surat',
                'Tanggal Disposisi',
                'Nomor Surat',
                'Tujuan',
                'Pengirim',
                'Tanggal acara',
                'Jam',
                'Tempat',
                'Tema',
                'Konseptor',
                'Status',
                'Tanggal Selesai',
                'Keterangan WA',
                'Naskah Hasil',
            ];
            $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
            $sheet->getRowDimension(2)->setRowHeight(28);

            foreach ($headers as $idx => $txt) {
                $cell = $cols[$idx] . '2';
                $sheet->setCellValue($cell, $txt);
            }

            $sheet->getStyle('A2:O2')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 10,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E7D32'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getStyle('A2:O2')->applyFromArray($headerBorderStyle);

            // Data Rows
            $dataCount = $items->count();
            $grandTotal += $dataCount;

            if ($items->isEmpty()) {
                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', 'Tidak ada data sambutan pada bulan ' . self::NAMA_BULAN[$m] . ' ' . $thn);
                $sheet->getRowDimension(3)->setRowHeight(32);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size'   => 10,
                        'name'   => 'Calibri',
                        'color'  => ['rgb' => '64748B'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getStyle('A3:O3')->applyFromArray($borderThin);

                // Total row for empty month
                $totalRow = 4;
                $sheet->mergeCells('A' . $totalRow . ':N' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL JUMLAH SAMBUTAN BULAN ' . self::NAMA_BULAN_UPPER[$m] . ' ' . $thn);
                $sheet->setCellValue('O' . $totalRow, 0);
                $sheet->getRowDimension($totalRow)->setRowHeight(28);
                $this->applyTotalRowStyle($sheet, $totalRow, $headerBorderStyle);
            } else {
                foreach ($items as $idx => $row) {
                    $r = 3 + $idx;

                    $sheet->setCellValue('A' . $r, $row['no']);
                    $sheet->setCellValue('B' . $r, $row['tanggal_surat']);
                    $sheet->setCellValue('C' . $r, $row['tanggal_disposisi']);
                    $sheet->setCellValue('D' . $r, $row['nomor_surat']);
                    $sheet->setCellValue('E' . $r, $row['tujuan']);
                    $sheet->setCellValue('F' . $r, $row['pengirim']);
                    $sheet->setCellValue('G' . $r, $row['tanggal_acara']);
                    $sheet->setCellValue('H' . $r, $row['jam']);
                    $sheet->setCellValue('I' . $r, $row['tempat']);
                    $sheet->setCellValue('J' . $r, $row['tema']);
                    $sheet->setCellValue('K' . $r, $row['konseptor']);
                    $sheet->setCellValue('L' . $r, $row['status']);
                    $sheet->setCellValue('M' . $r, $row['tanggal_selesai']);
                    $sheet->setCellValue('N' . $r, $row['keterangan_wa']);
                    $sheet->setCellValue('O' . $r, $row['naskah_hasil']);

                    $sheet->getRowDimension($r)->setRowHeight(32);

                    // Alignments
                    $sheet->getStyle('A' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('D' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('E' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('F' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('G' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                    $sheet->getStyle('H' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('I' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('J' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('K' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('L' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('M' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('N' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);

                    // Status color
                    $statusColor = match($row['status']) {
                        'Selesai' => '15803D',
                        'Progres' => 'B45309',
                        default   => '475569',
                    };
                    $sheet->getStyle('L' . $r)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($statusColor))->setBold(true);

                    // Naskah hasil formatting & hyperlink
                    if ($row['has_hasil'] && !empty($row['file_url'])) {
                        $sheet->getCell('O' . $r)->getHyperlink()->setUrl($row['file_url']);
                        $sheet->getStyle('O' . $r)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('2563EB'))->setUnderline(true)->setBold(true);
                        $sheet->getStyle('O' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    } else {
                        $sheet->getStyle('O' . $r)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DC2626'))->setBold(false);
                        $sheet->getStyle('O' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    $sheet->getStyle('A' . $r . ':O' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A' . $r . ':O' . $r)->getFont()->setName('Calibri')->setSize(10);
                    $sheet->getStyle('A' . $r . ':O' . $r)->applyFromArray($borderThin);
                }

                // Total row after data
                $totalRow = 3 + $dataCount;
                $sheet->mergeCells('A' . $totalRow . ':N' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL JUMLAH SAMBUTAN BULAN ' . self::NAMA_BULAN_UPPER[$m] . ' ' . $thn);
                $sheet->setCellValue('O' . $totalRow, $dataCount);
                $sheet->getRowDimension($totalRow)->setRowHeight(28);
                $this->applyTotalRowStyle($sheet, $totalRow, $headerBorderStyle);
            }
        }

        // If multiple months, add a summary sheet at the end
        if (count($months) > 1) {
            $summarySheet = $spreadsheet->createSheet();
            $summarySheet->setTitle('REKAP TOTAL');
            $summarySheet->setShowGridLines(true);

            $summarySheet->getColumnDimension('A')->setWidth(6);
            $summarySheet->getColumnDimension('B')->setWidth(24);
            $summarySheet->getColumnDimension('C')->setWidth(22);

            // Title
            $summarySheet->mergeCells('A1:C1');
            $summarySheet->setCellValue('A1', 'REKAP TOTAL SAMBUTAN TAHUN ' . $thn);
            $summarySheet->getRowDimension(1)->setRowHeight(34);
            $summarySheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B5E20'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $summarySheet->getStyle('A1:C1')->applyFromArray($headerBorderStyle);

            // Headers
            $summarySheet->setCellValue('A2', '#');
            $summarySheet->setCellValue('B2', 'BULAN');
            $summarySheet->setCellValue('C2', 'JUMLAH SAMBUTAN');
            $summarySheet->getRowDimension(2)->setRowHeight(26);
            $summarySheet->getStyle('A2:C2')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 10,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E7D32'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $summarySheet->getStyle('A2:C2')->applyFromArray($headerBorderStyle);

            // Monthly data
            $totalAll = 0;
            for ($m = 1; $m <= 12; $m++) {
                $r = 2 + $m;
                $count = Sambutan::whereYear('tanggal_terima', $thn)
                    ->whereMonth('tanggal_terima', $m)
                    ->count();
                $totalAll += $count;

                $summarySheet->setCellValue('A' . $r, $m);
                $summarySheet->setCellValue('B' . $r, self::NAMA_BULAN_UPPER[$m]);
                $summarySheet->setCellValue('C' . $r, $count);

                $summarySheet->getRowDimension($r)->setRowHeight(24);
                $summarySheet->getStyle('A' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $summarySheet->getStyle('B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $summarySheet->getStyle('C' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $summarySheet->getStyle('A' . $r . ':C' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $summarySheet->getStyle('A' . $r . ':C' . $r)->getFont()->setName('Calibri')->setSize(10);
                $summarySheet->getStyle('A' . $r . ':C' . $r)->applyFromArray($borderThin);

                if ($count > 0) {
                    $summarySheet->getStyle('C' . $r)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1B5E20'));
                }
            }

            // Grand total
            $totalRow = 15;
            $summarySheet->mergeCells('A' . $totalRow . ':B' . $totalRow);
            $summarySheet->setCellValue('A' . $totalRow, 'TOTAL KESELURUHAN TAHUN ' . $thn);
            $summarySheet->setCellValue('C' . $totalRow, $totalAll);
            $summarySheet->getRowDimension($totalRow)->setRowHeight(30);
            $summarySheet->getStyle('A' . $totalRow . ':C' . $totalRow)->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B5E20'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $summarySheet->getStyle('A' . $totalRow . ':C' . $totalRow)->applyFromArray($headerBorderStyle);
        }

        $spreadsheet->setActiveSheetIndex(0);
        return $spreadsheet;
    }

    /**
     * Apply styling untuk baris total
     */
    private function applyTotalRowStyle($sheet, int $row, array $borderStyle): void
    {
        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 10.5,
                'name'  => 'Calibri',
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1B5E20'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($borderStyle);
    }

    /**
     * Download response format .xlsx
     */
    public function download(): StreamedResponse
    {
        $spreadsheet = $this->buildSpreadsheet();

        $bulanSuffix = $this->selectedBulan ? '_' . self::NAMA_BULAN_UPPER[$this->selectedBulan] : '';
        $filename    = 'Rekap_Sambutan_Pimpinan_' . $this->tahun . $bulanSuffix . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
