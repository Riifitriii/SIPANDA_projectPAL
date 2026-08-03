<?php

use Illuminate\Http\Request;

// Pastikan folder storage yang diperlukan ada di /tmp (karena Vercel bersifat read-only)
if (getenv('VERCEL')) {
    $storagePaths = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
    ];
    
    foreach ($storagePaths as $path) {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }
}

define('LARAVEL_START', microtime(true));

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load bootstrap Laravel app
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle request
$app->handleRequest(Request::capture());
