<?php

// Tandai environment Vercel
if (!isset($_SERVER['VERCEL']) && !isset($_ENV['VERCEL'])) {
    $_ENV['VERCEL'] = '1';
    $_SERVER['VERCEL'] = '1';
}

// Pastikan direktori sementara /tmp tersedia untuk Laravel di lingkungan serverless Vercel
$directories = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
    '/tmp/storage/app/private',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        @mkdir($directory, 0755, true);
    }
}

// Teruskan request ke bootstrap & front controller Laravel
require __DIR__ . '/../public/index.php';

