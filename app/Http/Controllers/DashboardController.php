<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Arahan;
use App\Models\Arsip;
use App\Models\Personel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Agenda Hari Ini
        $agendaHariIni = Kegiatan::whereDate('tanggal_mulai', $today)
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal_mulai')
            ->get();

        $agendaCount = $agendaHariIni->count();

        // Breakdown pimpinan hari ini
        $waliKotaCount     = $agendaHariIni->where('pimpinan', 'wali_kota')->count();
        $wakilWaliKotaCount = $agendaHariIni->where('pimpinan', 'wakil_wali_kota')->count();
        $sekdaCount        = $agendaHariIni->where('pimpinan', 'sekda')->count();

        // Kegiatan Bulan Ini
        $kegiatanBulanIni = Kegiatan::whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // Bulan lalu untuk perbandingan
        $kegiatanBulanLalu = Kegiatan::whereBetween('tanggal_mulai', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->where('status', '!=', 'dibatalkan')->count();

        $kenaikanPersen = $kegiatanBulanLalu > 0
            ? round((($kegiatanBulanIni - $kegiatanBulanLalu) / $kegiatanBulanLalu) * 100, 0)
            : 0;

        // Arahan Belum Selesai
        $arahanBelumSelesai     = Arahan::whereIn('status', ['belum_selesai', 'sedang_berjalan', 'melewati_deadline'])->count();
        $arahanMelewatiDeadline = Arahan::where('status', 'melewati_deadline')->count();

        // Total Arsip
        $totalArsip = Arsip::count();

        // Total Pegawai aktif
        $totalPegawai = Personel::count();

        // Agenda Mendatang (7 hari ke depan, exclude hari ini)
        $agendaMendatang = Kegiatan::whereDate('tanggal_mulai', '>', $today)
            ->whereDate('tanggal_mulai', '<=', $today->copy()->addDays(7))
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // Kegiatan terbaru untuk tampilan
        $kegiatanTerbaru = Kegiatan::with('penugasan.personel')
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        // Data personel untuk tabel
        $personelList = Personel::with('user')->take(5)->get();

        // Statistik kegiatan per bulan (7 bulan terakhir)
        $statistikBulanan = [];
        for ($i = 6; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $statistikBulanan[] = [
                'label' => $bulan->translatedFormat('M'),
                'count' => Kegiatan::whereYear('tanggal_mulai', $bulan->year)
                    ->whereMonth('tanggal_mulai', $bulan->month)
                    ->where('status', '!=', 'dibatalkan')
                    ->count(),
            ];
        }

        return view('dashboard.index', compact(
            'agendaCount', 'waliKotaCount', 'wakilWaliKotaCount', 'sekdaCount',
            'kegiatanBulanIni', 'kenaikanPersen',
            'arahanBelumSelesai', 'arahanMelewatiDeadline',
            'totalArsip', 'kegiatanTerbaru', 'agendaHariIni',
            'totalPegawai', 'agendaMendatang',
            'personelList', 'statistikBulanan'
        ));
    }
}
