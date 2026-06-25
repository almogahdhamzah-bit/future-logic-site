<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// مسار الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// مسار تبديل اللغة (يستقبل الرمز ar أو en ويخزنه في الـ Session ثم يعود لنفس الصفحة)
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');