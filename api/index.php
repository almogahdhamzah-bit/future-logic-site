<?php

// 1. إعادة توجيه مجلدات الكاش والتخزين إلى المجلد المؤقت المسموح به في Vercel
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
}
if (!is_dir($storagePath . '/sessions')) {
    mkdir($storagePath . '/sessions', 0755, true);
}
if (!is_dir($storagePath . '/cache')) {
    mkdir($storagePath . '/cache', 0755, true);
}

// إجبار لارافيل على استخدام المسارات المؤقتة للكتابة
putenv("APP_STORAGE=/tmp/storage");
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");

// 2. تحديد المسار الصحيح للمشروع ديناميكياً
$basePath = realpath(__DIR__ . '/..');

// 3. التحقق من وجود ملف الـ Autoload واستدعائه
if (file_exists($basePath . '/vendor/autoload.php')) {
    require $basePath . '/vendor/autoload.php';
} else if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    $basePath = __DIR__;
    require __DIR__ . '/vendor/autoload.php';
}

// 4. تشغيل تطبيق لارافيل
$app = require_once $basePath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);