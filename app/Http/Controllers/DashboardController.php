<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Arahan;
use App\Models\Arsip;
use App\Models\Personel;
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

                $diffDays      = max(1, $startDate->diffInDays($endDate) + 1);
                $prevEndDate   = $startDate->copy()->subDay()->endOfDay();
                $prevStartDate = $prevEndDate->copy()->subDays($diffDays)->startOfDay();
            } catch (\Exception $e) {
                $periode = 1;
                $startDate = Carbon::now()->subMonths(1)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $prevStartDate = Carbon::now()->subMonths(2)->startOfDay();
                $prevEndDate = Carbon::now()->subMonths(1)->endOfDay();
            }
        } else {
            $periode = (int) $periodeParam;
            if (!in_array($periode, [1, 3, 6, 12])) {
                $periode = 1;
            }

            $startDate = Carbon::now()->subMonths($periode)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            // Previous period for comparison
            $prevStartDate = Carbon::now()->subMonths($periode * 2)->startOfDay();
            $prevEndDate = Carbon::now()->subMonths($periode)->endOfDay();
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

        // 2. Kegiatan Periode Ini & Perbandingan
        $kegiatanBulanIni = Kegiatan::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $kegiatanPeriodeLalu = Kegiatan::whereBetween('tanggal_mulai', [$prevStartDate, $prevEndDate])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $kenaikanPersen = $kegiatanPeriodeLalu > 0
            ? round((($kegiatanBulanIni - $kegiatanPeriodeLalu) / $kegiatanPeriodeLalu) * 100, 0)
            : ($kegiatanBulanIni > 0 ? 100 : 0);

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
        if ($isCustom) {
            $monthCount = max(2, min(12, $startDate->diffInMonths($endDate) + 1));
            $baseDate = $endDate->copy();
        } else {
            $monthCount = max((int)$periode, 7);
            if ($periode === 12) $monthCount = 12;
            elseif ($periode === 6) $monthCount = 6;
            elseif ($periode === 3) $monthCount = 6;
            else $monthCount = 7;
            $baseDate = Carbon::now();
        }

        $statistikBulanan = [];
        for ($i = $monthCount - 1; $i >= 0; $i--) {
            $bulan = $baseDate->copy()->subMonths($i);
            $countSemua = Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                ->whereMonth('tanggal_mulai', $bulan->month)
                ->where('status', '!=', 'dibatalkan')
                ->count();

            $countRapat = Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                ->whereMonth('tanggal_mulai', $bulan->month)
                ->where('status', '!=', 'dibatalkan')
                ->where(function($q) {
                    $q->where('kategori', 'rapat')->orWhere('judul', 'like', '%rapat%');
                })->count();

            $countKunjungan = Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                ->whereMonth('tanggal_mulai', $bulan->month)
                ->where('status', '!=', 'dibatalkan')
                ->where(function($q) {
                    $q->where('kategori', 'kunjungan')->orWhere('judul', 'like', '%kunjungan%');
                })->count();

            $countAcara = Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                ->whereMonth('tanggal_mulai', $bulan->month)
                ->where('status', '!=', 'dibatalkan')
                ->where(function($q) {
                    $q->where('kategori', 'acara')->orWhere('judul', 'like', '%acara%')->orWhere('judul', 'like', '%upacara%');
                })->count();

            $countAudiensi = Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                ->whereMonth('tanggal_mulai', $bulan->month)
                ->where('status', '!=', 'dibatalkan')
                ->where(function($q) {
                    $q->where('kategori', 'audiensi')->orWhere('judul', 'like', '%audiensi%');
                })->count();

            $statistikBulanan[] = [
                'label'     => $bulan->translatedFormat('M'),
                'count'     => $countSemua,
                'rapat'     => $countRapat,
                'kunjungan' => $countKunjungan,
                'acara'     => $countAcara,
                'audiensi'  => $countAudiensi,
            ];
        }

        return view('dashboard.index', compact(
            'periode', 'isCustom', 'startDateStr', 'endDateStr',
            'agendaCount', 'waliKotaCount', 'wakilWaliKotaCount', 'sekdaCount',
            'kegiatanBulanIni', 'kenaikanPersen',
            'arahanBelumSelesai', 'arahanMelewatiDeadline',
            'totalArsip', 'agendaHariIni',
            'totalPegawai', 'agendaMendatang',
            'personelList', 'statistikBulanan'
        ));
    }
}

