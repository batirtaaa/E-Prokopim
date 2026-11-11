<?php

namespace App\Exports;

use App\Models\AsetBarang;
use App\Models\AsetKendaraan;
use App\Services\FileNamingService;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetExport
{
    protected string $type;

    /**
     * @param string $type 'all' | 'inventaris' | 'kendaraan'
     */
    public function __construct(string $type = 'all')
    {
        $this->type = in_array($type, ['inventaris', 'kendaraan']) ? $type : 'all';
    }

    public function buildSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        if ($this->type === 'all') {
            // Sheet 1: Inventaris Barang
            $sheetInventaris = $spreadsheet->getActiveSheet();
            $this->populateInventarisSheet($sheetInventaris);

            // Sheet 2: Kendaraan Operasional
            $sheetKendaraan = $spreadsheet->createSheet();
            $this->populateKendaraanSheet($sheetKendaraan);

            // Set default active tab back to first sheet
            $spreadsheet->setActiveSheetIndex(0);
        } elseif ($this->type === 'inventaris') {
            $sheetInventaris = $spreadsheet->getActiveSheet();
            $this->populateInventarisSheet($sheetInventaris);
        } else {
            $sheetKendaraan = $spreadsheet->getActiveSheet();
            $this->populateKendaraanSheet($sheetKendaraan);
        }

        return $spreadsheet;
    }

    protected function populateInventarisSheet(Worksheet $sheet): void
    {
        $sheet->setTitle('Inventaris Barang');
        $sheet->setShowGridLines(true);

        // Header Title Banner
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'PEMERINTAH KOTA BANDUNG');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Segoe UI', 'color' => ['rgb' => '475569']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'name' => 'Segoe UI', 'color' => ['rgb' => '0F2942']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'DAFTAR INVENTARIS BARANG & ASET KANTOR');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Segoe UI', 'color' => ['rgb' => '0F172A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A4:I4');
        $sheet->setCellValue('A4', 'Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB');
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'name' => 'Segoe UI', 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(22);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(18);
        $sheet->getRowDimension(5)->setRowHeight(10); // Spacing row

        // Table Header (Row 6)
        $headers = [
            'NO',
            'KODE ASET',
            'NAMA BARANG',
            'KATEGORI',
            'LOKASI',
            'PENANGGUNG JAWAB',
            'KONDISI',
            'STATUS',
            'TANGGAL PEROLEHAN',
        ];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

        $sheet->getRowDimension(6)->setRowHeight(28);
        foreach ($headers as $idx => $headerText) {
            $sheet->setCellValue($cols[$idx] . '6', $headerText);
        }

        $sheet->getStyle('A6:I6')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Segoe UI',
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0F2942'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '081D30'],
                ],
            ],
        ]);

        $items = AsetBarang::orderBy('id', 'asc')->get();
        $rowNum = 7;

        foreach ($items as $index => $item) {
            $sheet->getRowDimension($rowNum)->setRowHeight(22);

            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNum, (string)($item->kode_aset ?? '-'), DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $rowNum, $item->nama_barang ?? '-');
            $sheet->setCellValue('D' . $rowNum, $item->kategori ?? '-');
            $sheet->setCellValue('E' . $rowNum, $item->lokasi ?? '-');
            $sheet->setCellValue('F' . $rowNum, $item->penanggung_jawab ?? '-');
            $sheet->setCellValue('G' . $rowNum, ucfirst($item->kondisi ?? '-'));
            $sheet->setCellValue('H' . $rowNum, $item->status_label ?? ucfirst($item->status ?? '-'));
            $sheet->setCellValue('I' . $rowNum, $item->tanggal_perolehan ? $item->tanggal_perolehan->format('d/m/Y') : '-');

            $bgColor = ($index % 2 === 0) ? 'FFFFFF' : 'F8FAFC';
            $sheet->getStyle('A' . $rowNum . ':I' . $rowNum)->applyFromArray([
                'font' => [
                    'size' => 9.5,
                    'name' => 'Segoe UI',
                    'color' => ['rgb' => '1E293B'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
            ]);

            $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('I' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

            $rowNum++;
        }

        // Summary row
        $sheet->mergeCells('A' . $rowNum . ':C' . $rowNum);
        $sheet->setCellValue('A' . $rowNum, 'TOTAL INVENTARIS: ' . count($items) . ' Barang');
        $sheet->mergeCells('D' . $rowNum . ':I' . $rowNum);
        $sheet->setCellValue('D' . $rowNum, '');
        $sheet->getRowDimension($rowNum)->setRowHeight(24);
        $sheet->getStyle('A' . $rowNum . ':I' . $rowNum)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Segoe UI',
                'color' => ['rgb' => '0F172A'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2E8F0'],
            ],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '94A3B8']],
                'bottom' => ['borderStyle' => Border::BORDER_DOUBLE, 'color' => ['rgb' => '94A3B8']],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(34);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(24);
        $sheet->getColumnDimension('F')->setWidth(26);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(20);

        // Freeze Panes
        $sheet->freezePane('A7');
    }

    protected function populateKendaraanSheet(Worksheet $sheet): void
    {
        $sheet->setTitle('Kendaraan Operasional');
        $sheet->setShowGridLines(true);

        // Header Title Banner
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'PEMERINTAH KOTA BANDUNG');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Segoe UI', 'color' => ['rgb' => '475569']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'name' => 'Segoe UI', 'color' => ['rgb' => '0F2942']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'DAFTAR KENDARAAN OPERASIONAL & DINAS');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Segoe UI', 'color' => ['rgb' => '0F172A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A4:H4');
        $sheet->setCellValue('A4', 'Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB');
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'name' => 'Segoe UI', 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(22);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(18);
        $sheet->getRowDimension(5)->setRowHeight(10); // Spacing row

        // Table Header (Row 6)
        $headers = [
            'NO',
            'PLAT NOMOR',
            'NAMA KENDARAAN',
            'JENIS',
            'PEMEGANG / PENGGUNA',
            'TAHUN',
            'STATUS',
            'CATATAN',
        ];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        $sheet->getRowDimension(6)->setRowHeight(28);
        foreach ($headers as $idx => $headerText) {
            $sheet->setCellValue($cols[$idx] . '6', $headerText);
        }

        $sheet->getStyle('A6:H6')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Segoe UI',
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0F2942'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '081D30'],
                ],
            ],
        ]);

        $vehicles = AsetKendaraan::orderBy('id', 'asc')->get();
        $rowNum = 7;

        foreach ($vehicles as $index => $item) {
            $sheet->getRowDimension($rowNum)->setRowHeight(22);

            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNum, (string)($item->plat_nomor ?? '-'), DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $rowNum, $item->nama_kendaraan ?? '-');
            $sheet->setCellValue('D' . $rowNum, $item->jenis ?? '-');
            $sheet->setCellValue('E' . $rowNum, $item->pemegang_pengguna ?? '-');
            $sheet->setCellValueExplicit('F' . $rowNum, (string)($item->tahun ?? '-'), DataType::TYPE_STRING);
            $sheet->setCellValue('G' . $rowNum, $item->status_label ?? ucfirst(str_replace('_', ' ', $item->status ?? '-')));
            $sheet->setCellValue('H' . $rowNum, $item->catatan ?? '-');

            $bgColor = ($index % 2 === 0) ? 'FFFFFF' : 'F8FAFC';
            $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->applyFromArray([
                'font' => [
                    'size' => 9.5,
                    'name' => 'Segoe UI',
                    'color' => ['rgb' => '1E293B'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
            ]);

            $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);

            $rowNum++;
        }

        // Summary row
        $sheet->mergeCells('A' . $rowNum . ':C' . $rowNum);
        $sheet->setCellValue('A' . $rowNum, 'TOTAL KENDARAAN: ' . count($vehicles) . ' Unit');
        $sheet->mergeCells('D' . $rowNum . ':H' . $rowNum);
        $sheet->setCellValue('D' . $rowNum, '');
        $sheet->getRowDimension($rowNum)->setRowHeight(24);
        $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Segoe UI',
                'color' => ['rgb' => '0F172A'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2E8F0'],
            ],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '94A3B8']],
                'bottom' => ['borderStyle' => Border::BORDER_DOUBLE, 'color' => ['rgb' => '94A3B8']],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(28);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(26);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);

        // Freeze Panes
        $sheet->freezePane('A7');
    }

    public function download(): StreamedResponse
    {
        $namaKegiatan = match ($this->type) {
            'inventaris' => 'Daftar_Inventaris_Barang_Prokopim',
            'kendaraan'  => 'Daftar_Kendaraan_Operasional_Prokopim',
            default      => 'Rekap_Keseluruhan_Asset_Prokopim',
        };

        $filename = FileNamingService::formatIsoFileName(now(), $namaKegiatan, 'xlsx');

        $spreadsheet = $this->buildSpreadsheet();
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
            'Pragma' => 'public',
        ]);
    }
}

