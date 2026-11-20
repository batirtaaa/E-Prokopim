#!/bin/bash
set -e

# Buat link storage jika belum ada
php artisan storage:link || true

# Cache konfigurasi untuk performa optimal di production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Jalankan Apache web server
exec apache2-foreground
