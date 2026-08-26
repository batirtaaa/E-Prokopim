<?php

use App\Console\Commands\CheckDeadlineNotifications;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan deadline checker setiap hari pukul 07:00
Schedule::command('notifikasi:check-deadline')
    ->dailyAt('07:00')
    ->withoutOverlapping()
    ->runInBackground();
