<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Arahan;
use App\Models\Arsip;
use App\Models\Personel;
use App\Models\Sambutan;
use App\Models\GaleriArsip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        
        $periodeParam = $request->input('periode', '1');
        $isCustom = false;
        $startDateStr = $request->input('start_date');
        $endDateStr   = $request->input('end_date');

        if ($periodeParam === 'custom' && $startDateStr && $endDateStr) {
            try {
                $startDate = Carbon::parse($startDateStr)->startOfDay();
                $endDate   = Carbon::parse($endDateStr)->endOfDay();
                $isCustom  = true;
                $periode   = 'custom';
            } catch (\Exception $e) {
                $periode = 1;
                $startDate = Carbon::now()->startOfMonth()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
            }
        } else {
            $periode = (int) $periodeParam;
            if (!in_array($periode, [1, 3, 6, 12])) {
                $periode = 1;
            }

            if ($periode === 12) {
                // 1 Tahun: Dari 1 Januari sampai 31 Desember tahun berjalan
                $startDate = Carbon::now()->startOfYear()->startOfDay();
                $endDate   = Carbon::now()->endOfYear()->endOfDay();
            } else {
                // 1, 3, 6 Bulan: Awal bulan dari N bulan yang lalu sampai sekarang
                $startDate = Carbon::now()->startOfMonth()->subMonths($periode - 1)->startOfDay();
                $endDate   = Carbon::now()->endOfDay();
            }
        }

        // 1. Agenda Hari Ini
        $agendaHariIni = Kegiatan::whereDate('tanggal_mulai', $today)
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal_mulai')
            ->get();

        $agendaCount = $agendaHariIni->count();

        // Breakdown pimpinan hari ini
        $waliKotaCount      = $agendaHariIni->where('pimpinan', 'wali_kota')->count();
        $wakilWaliKotaCount = $agendaHariIni->where('pimpinan', 'wakil_wali_kota')->count();
        $sekdaCount         = $agendaHariIni->where('pimpinan', 'sekda')->count();

        // 2. Kegiatan Periode Ini
        $kegiatanBulanIni = Kegiatan::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // 3. Agenda Mendatang (7 hari ke depan, exclude hari ini)
        $agendaMendatang = Kegiatan::whereDate('tanggal_mulai', '>', $today)
            ->whereDate('tanggal_mulai', '<=', $today->copy()->addDays(7))
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // 4. Total Pegawai aktif
        $totalPegawai = Personel::count();

        // 5. Arahan & Arsip (info pendukung)
        $arahanBelumSelesai     = Arahan::whereIn('status', ['belum_selesai', 'sedang_berjalan', 'melewati_deadline'])->count();
        $arahanMelewatiDeadline = Arahan::where('status', 'melewati_deadline')->count();
        $totalArsip             = Arsip::count();

        // 6. Data personel untuk tabel dashboard (urutan sama dengan halaman Pegawai)
        $personelList = Personel::with('user')->orderBy('id', 'asc')->take(10)->get();

        // 7. Statistik kegiatan per bulan
        $namaBulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $namaBulanLengkap = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $targetMonths = [];
        if ($isCustom) {
            $cur = $startDate->copy()->startOfMonth();
            $endLimit = $endDate->copy()->startOfMonth();
            while ($cur->lte($endLimit) && count($targetMonths) < 24) {
                $targetMonths[] = [
                    'year'  => (int) $cur->year,
                    'month' => (int) $cur->month,
                ];
                $cur->addMonthsNoOverflow(1);
            }
        } elseif ($periode === 12) {
            // 1 Tahun: Januari sampai Desember tahun berjalan (12 bulan berurutan)
            $currentYear = (int) Carbon::now()->year;
            for ($m = 1; $m <= 12; $m++) {
                $targetMonths[] = [
                    'year'  => $currentYear,
                    'month' => $m,
                ];
            }
        } else {
            // 1, 3, 6 Bulan: N bulan terakhir secara kronologis dari yang terlama ke terbaru
            $count = (int) $periode;
            $startMonth = Carbon::now()->startOfMonth()->subMonths($count - 1);
            for ($i = 0; $i < $count; $i++) {
                $mDate = $startMonth->copy()->addMonthsNoOverflow($i);
                $targetMonths[] = [
                    'year'  => (int) $mDate->year,
                    'month' => (int) $mDate->month,
                ];
            }
        }

        // Ambil data kegiatan sekali query untuk efisiensi
        if (!empty($targetMonths)) {
            $firstMonth = $targetMonths[0];
            $lastMonth  = end($targetMonths);
            $queryStart = Carbon::create($firstMonth['year'], $firstMonth['month'], 1)->startOfMonth()->startOfDay();
            $queryEnd   = Carbon::create($lastMonth['year'], $lastMonth['month'], 1)->endOfMonth()->endOfDay();

            $kegiatanCollection = Kegiatan::whereBetween('tanggal_mulai', [$queryStart, $queryEnd])
                ->where('status', '!=', 'dibatalkan')
                ->get(['tanggal_mulai', 'kategori', 'judul']);
        } else {
            $kegiatanCollection = collect();
        }

        $statistikBulanan = [];
        foreach ($targetMonths as $tm) {
            $y = $tm['year'];
            $m = $tm['month'];

            $filtered = $kegiatanCollection->filter(function($k) use ($y, $m) {
                if (!$k->tanggal_mulai) return false;
                $t = Carbon::parse($k->tanggal_mulai);
                return (int)$t->year === $y && (int)$t->month === $m;
            });

            $countSemua = $filtered->count();
            $countRapat = $filtered->filter(fn($k) => strtolower($k->kategori ?? '') === 'rapat' || str_contains(strtolower($k->judul ?? ''), 'rapat'))->count();
            $countKunjungan = $filtered->filter(fn($k) => strtolower($k->kategori ?? '') === 'kunjungan' || str_contains(strtolower($k->judul ?? ''), 'kunjungan'))->count();
            $countAcara = $filtered->filter(fn($k) => strtolower($k->kategori ?? '') === 'acara' || str_contains(strtolower($k->judul ?? ''), 'acara') || str_contains(strtolower($k->judul ?? ''), 'upacara'))->count();
            $countAudiensi = $filtered->filter(fn($k) => strtolower($k->kategori ?? '') === 'audiensi' || str_contains(strtolower($k->judul ?? ''), 'audiensi'))->count();

            $label = $namaBulanIndo[$m] ?? Carbon::create($y, $m, 1)->translatedFormat('M');

            $statistikBulanan[] = [
                'label'      => $label,
                
                'bulan_nama' => $namaBulanLengkap[$m] ?? $label,
                'count'      => $countSemua,
                'rapat'      => $countRapat,
                'kunjungan'  => $countKunjungan,
                'acara'      => $countAcara,
                'audiensi'   => $countAudiensi,
            ];
        }

        // 8. Data Sambutan lengkap (semua tahun & bulan) untuk chart dengan filter client-side
        $bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $currentYear = (int) Carbon::now()->year;

        // Raw data: per tahun + bulan
        $rawSambutan = Sambutan::selectRaw('
            YEAR(COALESCE(tanggal_acara, tanggal_terima)) as tahun,
            MONTH(COALESCE(tanggal_acara, tanggal_terima)) as bulan,
            COUNT(*) as total
        ')
        ->whereNotNull('tanggal_terima')
        ->groupByRaw('YEAR(COALESCE(tanggal_acara, tanggal_terima)), MONTH(COALESCE(tanggal_acara, tanggal_terima))')
        ->orderByRaw('tahun ASC, bulan ASC')
        ->get();

        // Kumpulkan daftar tahun yang tersedia (sertakan rentang tahun berurutan)
        $sambutanYears = $rawSambutan->pluck('tahun')->unique()->filter()->sort()->values()->map(fn($y) => (int)$y)->toArray();
        $minSY = count($sambutanYears) > 0 ? min($sambutanYears) : $currentYear;
        $maxSY = count($sambutanYears) > 0 ? max($sambutanYears) : $currentYear;
        $startSY = min($minSY, $currentYear - 3);
        $endSY = max($maxSY, $currentYear + 1);
        for ($y = $startSY; $y <= $endSY; $y++) {
            if (!in_array($y, $sambutanYears)) {
                $sambutanYears[] = $y;
            }
        }
        rsort($sambutanYears);

        // Bangun matrix: tahun => [bulan1..12 => total]
        $sambutanMatrix = [];
        foreach ($sambutanYears as $yr) {
            $sambutanMatrix[$yr] = array_fill(1, 12, 0);
        }
        foreach ($rawSambutan as $row) {
            $yr = (int)($row->tahun ?? 0);
            $mn = (int)($row->bulan ?? 0);
            if ($yr > 0 && $mn >= 1 && $mn <= 12) {
                if (!isset($sambutanMatrix[$yr])) {
                    $sambutanMatrix[$yr] = array_fill(1, 12, 0);
                }
                $sambutanMatrix[$yr][$mn] = (int)$row->total;
            }
        }

        // Encode untuk JS
        $sambutanChartJson = json_encode([
            'years'       => $sambutanYears,
            'bulanLabels' => $bulanLabels,
            'matrix'      => $sambutanMatrix,
            'currentYear' => $currentYear,
        ]);

        // 9. Data Dokumentasi (Foto / Video / Notulensi) lengkap untuk chart dengan filter client-side
        $rawDokumentasi = GaleriArsip::selectRaw('
            YEAR(COALESCE(tanggal_kegiatan, created_at)) as tahun,
            MONTH(COALESCE(tanggal_kegiatan, created_at)) as bulan,
            tipe,
            COUNT(*) as total
        ')
        ->whereNotNull('tipe')
        ->groupByRaw('YEAR(COALESCE(tanggal_kegiatan, created_at)), MONTH(COALESCE(tanggal_kegiatan, created_at)), tipe')
        ->orderByRaw('tahun ASC, bulan ASC')
        ->get();

        $dokumentasiYears = $rawDokumentasi->pluck('tahun')->unique()->filter()->sort()->values()->map(fn($y) => (int)$y)->toArray();
        $minDY = count($dokumentasiYears) > 0 ? min($dokumentasiYears) : $currentYear;
        $maxDY = count($dokumentasiYears) > 0 ? max($dokumentasiYears) : $currentYear;
        $startDY = min($minDY, $currentYear - 3);
        $endDY = max($maxDY, $currentYear + 1);
        for ($y = $startDY; $y <= $endDY; $y++) {
            if (!in_array($y, $dokumentasiYears)) {
                $dokumentasiYears[] = $y;
            }
        }
        rsort($dokumentasiYears);

        $dokumentasiMatrix = [];
        foreach ($dokumentasiYears as $yr) {
            $dokumentasiMatrix[$yr] = [];
            for ($m = 1; $m <= 12; $m++) {
                $dokumentasiMatrix[$yr][$m] = [
                    'total'     => 0,
                    'foto'      => 0,
                    'video'     => 0,
                    'notulensi' => 0,
                ];
            }
        }

        foreach ($rawDokumentasi as $row) {
            $yr   = (int)($row->tahun ?? 0);
            $mn   = (int)($row->bulan ?? 0);
            $tipe = strtolower(trim($row->tipe ?? ''));
            $tot  = (int)($row->total ?? 0);

            if ($yr > 0 && $mn >= 1 && $mn <= 12) {
                if (!isset($dokumentasiMatrix[$yr])) {
                    $dokumentasiMatrix[$yr] = [];
                    for ($m = 1; $m <= 12; $m++) {
                        $dokumentasiMatrix[$yr][$m] = ['total' => 0, 'foto' => 0, 'video' => 0, 'notulensi' => 0];
                    }
                }
                if (in_array($tipe, ['foto', 'video', 'notulensi'])) {
                    $dokumentasiMatrix[$yr][$mn][$tipe] += $tot;
                }
                $dokumentasiMatrix[$yr][$mn]['total'] += $tot;
            }
        }

        $dokumentasiChartJson = json_encode([
            'years'       => $dokumentasiYears,
            'bulanLabels' => $bulanLabels,
            'matrix'      => $dokumentasiMatrix,
            'currentYear' => $currentYear,
        ]);

        return view('dashboard.index', compact(
            'periode', 'isCustom', 'startDateStr', 'endDateStr',
            'agendaCount', 'waliKotaCount', 'wakilWaliKotaCount', 'sekdaCount',
            'kegiatanBulanIni',
            'arahanBelumSelesai', 'arahanMelewatiDeadline',
            'totalArsip', 'agendaHariIni',
            'totalPegawai', 'agendaMendatang',
            'personelList', 'statistikBulanan',
            'sambutanChartJson',
            'dokumentasiChartJson'
        ));
    }
}

