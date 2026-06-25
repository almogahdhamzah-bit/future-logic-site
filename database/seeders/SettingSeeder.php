<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // إضافة إعدادات التواصل الافتراضية
        Setting::updateOrCreate(['key' => 'phone'], ['value' => '+967770000000']);
        Setting::updateOrCreate(['key' => 'whatsapp'], ['value' => 'https://wa.me/967770000000']);
        Setting::updateOrCreate(['key' => 'facebook'], ['value' => 'https://facebook.com/future.logic']);
        Setting::updateOrCreate(['key' => 'linkedin'], ['value' => 'https://linkedin.com/company/future.logic']);
        Setting::updateOrCreate(['key' => 'email'], ['value' => 'info@future-logic.com']);
    }
}