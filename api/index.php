 <?php

// 1. تحديد المسار الصحيح للمشروع ديناميكياً
$basePath = realpath(__DIR__ . '/..');

// 2. التحقق من وجود ملف الـ Autoload واستدعائه
if (file_exists($basePath . '/vendor/autoload.php')) {
    require $basePath . '/vendor/autoload.php';
} else if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    $basePath = __DIR__;
    require __DIR__ . '/vendor/autoload.php';
}

// 3. تشغيل تطبيق لارافيل
$app = require_once $basePath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);