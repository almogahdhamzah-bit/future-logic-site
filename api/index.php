<?php

// 1. توجيه جميع الطلبات للملفات الثابتة (مثل الصور والـ CSS المرفوعة في public)
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// 2. استدعاء ملفات لارافيل الأساسية بالمسارات الصحيحة لـ Vercel
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);