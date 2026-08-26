<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotifikasiController;
use App\Models\Arahan;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckDeadlineNotifications extends Command
{
    protected $signature = 'notifikasi:check-deadline';
    protected $description = 'Cek deadline arahan dan kirim notifikasi pengingat (H-1 dan H-3)';

    public function handle(): int
    {
        $today = Carbon::today();

        // Check only users who have deadline notifications enabled
        $this->info('Memeriksa deadline arahan...');

        $deadlineDays = [1, 3]; // H-1 and H-3 before deadline

        foreach ($deadlineDays as $days) {
            $targetDate = $today->copy()->addDays($days);

            $arahans = Arahan::whereNotNull('deadline')
                ->whereDate('deadline', $targetDate)
                ->whereIn('status', ['belum_selesai', 'sedang_berjalan'])
                ->withTrashed(false)
                ->get();

            foreach ($arahans as $arahan) {
                // Check if we already sent this notification today (avoid duplicates)
                $existingCount = Notifikasi::where('tipe', 'deadline')
                    ->where('link', route('arahan.index'))
                    ->whereDate('created_at', $today)
                    ->where('judul', 'like', '%' . $arahan->judul . '%')
                    ->count();

                if ($existingCount > 0) {
                    $this->line("  [SKIP] Notifikasi H-{$days} sudah dikirim untuk: {$arahan->judul}");
                    continue;
                }

                $label = $days === 1 ? 'BESOK' : "{$days} hari lagi";
                $judul = "⚠️ Deadline Arahan {$label}!";
                $pesan = "Arahan \"{$arahan->judul}\" (Prioritas: " . ucfirst($arahan->prioritas) . ") akan berakhir pada " . Carbon::parse($arahan->deadline)->translatedFormat('d F Y') . ".";

                // Send only to users who have deadline notifications enabled
                $users = User::where('is_active', true)->get();

                foreach ($users as $user) {
                    $prefs = $user->notification_preferences ?? ['deadline' => true];
                    if (!($prefs['deadline'] ?? true)) {
                        continue;
                    }

                    Notifikasi::create([
                        'user_id'  => $user->id,
                        'judul'    => $judul,
                        'pesan'    => $pesan,
                        'tipe'     => 'deadline',
                        'link'     => route('arahan.index'),
                        'is_read'  => false,
                    ]);
                }

                $this->info("  [SENT] H-{$days} deadline: {$arahan->judul}");
            }
        }

        // Also flag arahan that have passed deadline and update status
        $overdueArahans = Arahan::whereNotNull('deadline')
            ->whereDate('deadline', '<', $today)
            ->whereIn('status', ['belum_selesai', 'sedang_berjalan'])
            ->get();

        foreach ($overdueArahans as $arahan) {
            $arahan->update(['status' => 'melewati_deadline']);
            $this->warn("  [AUTO-UPDATE] Melewati deadline: {$arahan->judul}");
        }

        $this->info('Selesai memeriksa deadline.');

        return Command::SUCCESS;
    }
}
