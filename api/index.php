<?php

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

// Forward request ke entrypoint Laravel asli
require __DIR__ . '/../public/index.php';
