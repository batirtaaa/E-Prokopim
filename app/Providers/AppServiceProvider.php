<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale ke Bahasa Indonesia secara global
        Carbon::setLocale('id');

        // Paksa skema HTTPS di production atau saat di-host di Vercel
        if (app()->environment('production') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}

