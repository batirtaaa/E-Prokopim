<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Carbon\Carbon;

class PegawaiExport
{
    protected $data;
    protected $filterInfo;

    public function __construct($data, $filterInfo = '')
    {
        $this->data = $data;
        $this->filterInfo = $filterInfo;
    }

    public function buildSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Pegawai');
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
            'font' => ['bold' => true, 'size' => 13, 'name' => 'Segoe UI', 'color' => ['rgb' => '1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->mergeCells('A3:H3');
        $title = 'DAFTAR PEGAWAI & PERSONEL PROKOPIM';
        if (!empty($this->filterInfo)) {
            $title .= ' (' . strtoupper($this->filterInfo) . ')';
        }
        $sheet->setCellValue('A3', $title);
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

        // Table Header
        $headers = ['NO', 'NAMA LENGKAP & GELAR', 'NIP', 'JABATAN', 'STATUS KEPEGAWAIAN', 'BIDANG TUGAS', 'EMAIL KEDINASAN', 'NO. TELEPON / WA'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        $sheet->getRowDimension(6)->setRowHeight(28);
        foreach ($headers as $idx => $headerText) {
            $col = $cols[$idx];
            $sheet->setCellValue($col . '6', $headerText);
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
                'startColor' => ['rgb' => '1E3A5F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '0F172A'],
                ],
            ],
        ]);

        // Data Rows
        $rowNum = 7;
        foreach ($this->data as $index => $item) {
            $sheet->getRowDimension($rowNum)->setRowHeight(22);

            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValue('B' . $rowNum, $item->nama_lengkap ?? '-');
            
            // Format NIP explicitly as string so no exponential notation occurs
            $nipVal = !empty($item->nip) && $item->nip !== '-' ? (string)$item->nip : '-';
            $sheet->setCellValueExplicit('C' . $rowNum, $nipVal, DataType::TYPE_STRING);

            $sheet->setCellValue('D' . $rowNum, $item->jabatan ?? '-');
            $sheet->setCellValue('E' . $rowNum, $item->status_kepegawaian_label ?? $item->status_kepegawaian ?? '-');
            $sheet->setCellValue('F' . $rowNum, $item->bidang_label ?? $item->bidang ?? '-');
            $sheet->setCellValue('G' . $rowNum, $item->display_email ?? $item->email ?? '-');
            
            $phoneVal = !empty($item->phone) && $item->phone !== '-' ? (string)$item->phone : '-';
            $sheet->setCellValueExplicit('H' . $rowNum, $phoneVal, DataType::TYPE_STRING);

            // Row zebra striping
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

            // Alignments
            $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

            $rowNum++;
        }

        // Summary row
        $sheet->mergeCells('A' . $rowNum . ':D' . $rowNum);
        $sheet->setCellValue('A' . $rowNum, 'TOTAL PEGAWAI: ' . count($this->data) . ' Orang');
        $sheet->mergeCells('E' . $rowNum . ':H' . $rowNum);
        $sheet->setCellValue('E' . $rowNum, '');
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
        $sheet->getColumnDimension('B')->setWidth(34);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(32);
        $sheet->getColumnDimension('E')->setWidth(24);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(34);
        $sheet->getColumnDimension('H')->setWidth(22);

        return $spreadsheet;
    }

    public function download($filename = null)
    {
        if (!$filename) {
            $filename = 'daftar_pegawai_prokopim_' . date('Ymd_His') . '.xlsx';
        }

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
