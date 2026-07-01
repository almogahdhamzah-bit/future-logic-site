<?php

// 1. تفعيل عرض الأخطاء بالكامل على الشاشة لكسر خطأ 500 الصامت
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. توجيه الكاش والتخزين للمجلد المؤقت
$storagePath = '/tmp/storage/framework';
foreach (['/views', '/sessions', '/cache'] as $path) {
    if (!is_dir($storagePath . $path)) {
        mkdir($storagePath . $path, 0755, true);
    }
}

putenv("APP_STORAGE=/tmp/storage");
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");

// 3. تحديد المسار واستدعاء المكونات محاطة بـ Try-Catch لقفص أي خطأ
try {
    $basePath = __DIR__ . '/..';

    if (!file_exists($basePath . '/vendor/autoload.php')) {
        die("Fatal Error: vendor/autoload.php not found at: " . realpath($basePath));
    }

    require $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    // إذا انهار لارافيل داخلياً، سيطبع السبب هنا بدلاً من خطأ 500
    echo "<h1>Laravel Runtime Exception:</h1>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}