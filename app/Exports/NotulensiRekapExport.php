<?php

namespace App\Exports;

use App\Models\GaleriArsip;
use App\Models\Notulensi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotulensiRekapExport
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

    const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'];
    const VIDEO_EXTENSIONS = ['mp4', 'mov', 'avi', 'mkv', 'webm'];

    public function __construct(int $tahun, ?int $selectedBulan = null)
    {
        $this->tahun = $tahun;
        $this->selectedBulan = $selectedBulan;
    }

    /**
     * Ambil data notulensi (dari GaleriArsip dan Notulensi)
     */
    public function getNotulensiByBulan(int $bulan): Collection
    {
        $data = collect();

        // 1. Dari GaleriArsip (semua arsip galeri: foto, video, notulensi)
        $galeriItems = GaleriArsip::whereYear('tanggal_kegiatan', $this->tahun)
            ->whereMonth('tanggal_kegiatan', $bulan)
            ->with(['kegiatan', 'user'])
            ->orderBy('tanggal_kegiatan', 'asc')
            ->get();

        foreach ($galeriItems as $item) {
            $tgl = $item->tanggal_kegiatan ? Carbon::parse($item->tanggal_kegiatan) : null;
            $tglStr = $tgl ? ($tgl->day . ' ' . (self::NAMA_BULAN[$tgl->month] ?? '') . ' ' . $tgl->year) : '-';

            // Gabungkan teks notulensi / keterangan
            $isiNotulensi = trim($item->keterangan ?? '');
            if ($item->kegiatan) {
                $extra = [];
                if ($item->kegiatan->pimpinan_label) {
                    $extra[] = $item->kegiatan->pimpinan_label;
                }
                if ($item->kegiatan->lokasi) {
                    $extra[] = 'Lokasi : ' . $item->kegiatan->lokasi;
                }
                if (!empty($extra) && empty($isiNotulensi)) {
                    $isiNotulensi = implode(", ", $extra);
                }
            }

            $docName = '-';
            $filePath = null;
            $fileUrl  = null;

            if ($item->file_path) {
                $docName = $item->file_name ?: basename($item->file_path);
                $fullDiskPath = storage_path('app/public/' . $item->file_path);
                if (file_exists($fullDiskPath)) {
                    $filePath = $fullDiskPath;
                }
                $fileUrl = asset('storage/' . $item->file_path);
            } elseif ($item->file_name) {
                $docName = $item->file_name;
            }

            $data->push([
                'id'          => 'GA-' . $item->id,
                'tanggal'     => $tglStr,
                'raw_date'    => $tgl ? $tgl->format('Y-m-d') : '9999-99-99',
                'judul'       => $item->judul ?? '-',
                'notulensi'   => $isiNotulensi ?: '-',
                'dokumentasi' => $docName,
                'file_path'   => $filePath,
                'file_url'    => $fileUrl,
                'tipe'        => $item->tipe,
            ]);
        }

        // 2. Dari tabel Notulensi jika ada
        if (class_exists(Notulensi::class)) {
            try {
                $notulensiItems = Notulensi::whereYear('tanggal_rapat', $this->tahun)
                    ->whereMonth('tanggal_rapat', $bulan)
                    ->with('kegiatan')
                    ->orderBy('tanggal_rapat', 'asc')
                    ->get();

                foreach ($notulensiItems as $n) {
                    $tgl = $n->tanggal_rapat ? Carbon::parse($n->tanggal_rapat) : null;
                    $tglStr = $tgl ? ($tgl->day . ' ' . (self::NAMA_BULAN[$tgl->month] ?? '') . ' ' . $tgl->year) : '-';

                    $isi = [];
                    if ($n->peserta) $isi[] = 'Peserta: ' . $n->peserta;
                    if ($n->agenda) $isi[] = 'Agenda: ' . $n->agenda;
                    if ($n->isi_notulensi) $isi[] = $n->isi_notulensi;
                    if ($n->kesimpulan) $isi[] = 'Kesimpulan: ' . $n->kesimpulan;
                    $isiStr = implode("\n", $isi);

                    $docName = '-';
                    $filePath = null;
                    $fileUrl  = null;

                    if ($n->file_notulensi) {
                        $docName = basename($n->file_notulensi);
                        $fullDiskPath = storage_path('app/public/' . $n->file_notulensi);
                        if (file_exists($fullDiskPath)) {
                            $filePath = $fullDiskPath;
                        }
                        $fileUrl = asset('storage/' . $n->file_notulensi);
                    }

                    $data->push([
                        'id'          => 'NOT-' . $n->id,
                        'tanggal'     => $tglStr,
                        'raw_date'    => $tgl ? $tgl->format('Y-m-d') : '9999-99-99',
                        'judul'       => $n->judul ?? ($n->kegiatan->judul ?? '-'),
                        'notulensi'   => $isiStr ?: '-',
                        'dokumentasi' => $docName,
                        'file_path'   => $filePath,
                        'file_url'    => $fileUrl,
                        'tipe'        => 'notulensi',
                    ]);
                }
            } catch (\Throwable $e) {
                // Ignore if table not present or error
            }
        }

        return $data->sortBy('raw_date')->values()->map(function ($row, $idx) {
            $row['no'] = $idx + 1;
            return $row;
        });
    }

    /**
     * Bangun Spreadsheet Excel dengan gambar tersemat (Drawing)
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
                    'color'       => ['rgb' => '94A3B8'],
                ],
            ],
        ];

        // 12 Monthly Sheets (JANUARI s/d DESEMBER)
        for ($m = 1; $m <= 12; $m++) {
            $sheetName  = self::NAMA_BULAN_UPPER[$m];
            $bulanLabel = self::NAMA_BULAN_UPPER[$m] . ' ' . $thn;
            $items      = $this->getNotulensiByBulan($m);

            if ($m === 1) {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($sheetName);
            } else {
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($sheetName);
            }

            $sheet->setShowGridLines(true);

            // Set Column Widths
            $sheet->getColumnDimension('A')->setWidth(6);   // NO
            $sheet->getColumnDimension('B')->setWidth(18);  // TANGGAL
            $sheet->getColumnDimension('C')->setWidth(32);  // JUDUL
            $sheet->getColumnDimension('D')->setWidth(48);  // NOTULENSI
            $sheet->getColumnDimension('E')->setWidth(26);  // DOKUMENTASI (FOTO / GAMBAR)

            // Row 1: Merged Title Banner
            $sheet->mergeCells('A1:E1');
            $sheet->setCellValue('A1', 'REKAP NOTULENSI KEGIATAN PIMPINAN BULAN ' . $bulanLabel);
            $sheet->getRowDimension(1)->setRowHeight(32);
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => '0F172A'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'CBD5E1'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getStyle('A1:E1')->applyFromArray($headerBorderStyle);

            // Row 2: Table Column Headers
            $headers = ['NO', 'TANGGAL', 'JUDUL', 'NOTULENSI', 'DOKUMENTASI'];
            $cols    = ['A', 'B', 'C', 'D', 'E'];
            $sheet->getRowDimension(2)->setRowHeight(26);

            foreach ($headers as $idx => $txt) {
                $cell = $cols[$idx] . '2';
                $sheet->setCellValue($cell, $txt);
            }

            $sheet->getStyle('A2:E2')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri',
                    'color' => ['rgb' => '1E293B'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getStyle('A2:E2')->applyFromArray($headerBorderStyle);

            // Data Rows
            if ($items->isEmpty()) {
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A3', 'Tidak ada data notulensi pada bulan ' . self::NAMA_BULAN[$m] . ' ' . $thn);
                $sheet->getRowDimension(3)->setRowHeight(30);
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
                $sheet->getStyle('A3:E3')->applyFromArray($borderThin);
            } else {
                foreach ($items as $idx => $row) {
                    $r = 3 + $idx;

                    $sheet->setCellValue('A' . $r, $row['no']);
                    $sheet->setCellValue('B' . $r, $row['tanggal']);
                    $sheet->setCellValue('C' . $r, $row['judul']);
                    $sheet->setCellValue('D' . $r, $row['notulensi']);

                    $hasImage = false;
                    if (!empty($row['file_path']) && file_exists($row['file_path'])) {
                        $ext = strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION));

                        if (in_array($ext, self::IMAGE_EXTENSIONS)) {
                            // Sisipkan gambar langsung ke dalam cell E
                            try {
                                $drawing = new Drawing();
                                $drawing->setName($row['dokumentasi']);
                                $drawing->setDescription($row['dokumentasi']);
                                $drawing->setPath($row['file_path']);
                                $drawing->setHeight(75);
                                $drawing->setCoordinates('E' . $r);
                                $drawing->setOffsetX(18);
                                $drawing->setOffsetY(6);
                                $drawing->setWorksheet($sheet);
                                $hasImage = true;
                            } catch (\Throwable $e) {
                                $hasImage = false;
                            }
                        }
                    }

                    if ($hasImage) {
                        $sheet->getRowDimension($r)->setRowHeight(72);
                        $sheet->setCellValue('E' . $r, ''); // Kosongkan text agar gambar terlihat bersih
                    } else {
                        $sheet->getRowDimension($r)->setRowHeight(38);
                        $ext = !empty($row['file_path']) ? strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION)) : '';

                        if (in_array($ext, self::VIDEO_EXTENSIONS)) {
                            $sheet->setCellValue('E' . $r, '🎬 ' . $row['dokumentasi']);
                        } elseif ($row['dokumentasi'] !== '-') {
                            $sheet->setCellValue('E' . $r, '📄 ' . $row['dokumentasi']);
                        } else {
                            $sheet->setCellValue('E' . $r, '-');
                        }

                        if (!empty($row['file_url'])) {
                            $sheet->getCell('E' . $r)->getHyperlink()->setUrl($row['file_url']);
                            $sheet->getStyle('E' . $r)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('2563EB'));
                            $sheet->getStyle('E' . $r)->getFont()->setUnderline(true);
                        }
                    }

                    // Styling cell A - E
                    $sheet->getStyle('A' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('D' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                    $sheet->getStyle('E' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);

                    $sheet->getStyle('A' . $r . ':E' . $r)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A' . $r . ':E' . $r)->getFont()->setName('Calibri')->setSize(10.5);
                    $sheet->getStyle('A' . $r . ':E' . $r)->applyFromArray($borderThin);
                }
            }
        }

        $spreadsheet->setActiveSheetIndex(0);
        return $spreadsheet;
    }

    /**
     * Download response format .xlsx dengan gambar tersemat
     */
    public function download(): StreamedResponse
    {
        $spreadsheet = $this->buildSpreadsheet();
        $filename    = 'Rekap_Notulensi_Kegiatan_Pimpinan_' . $this->tahun . '.xlsx';

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
