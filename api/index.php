<?php

// 1. توجيه الكاش والتخزين للمجلد المؤقت لإصلاح الـ Read-only
$storagePath = '/tmp/storage/framework';
foreach (['/views', '/sessions', '/cache'] as $path) {
    if (!is_dir($storagePath . $path)) {
        mkdir($storagePath . $path, 0755, true);
    }
}

putenv("APP_STORAGE=/tmp/storage");
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");

// 2. تحديد المسار الثابت والصارم لبيئة Vercel
$basePath = __DIR__ . '/..';

// 3. استدعاء المكونات الأساسية بشكل مباشر ومضمون
require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';

// 4. تشغيل وإقلاع التطبيق
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);