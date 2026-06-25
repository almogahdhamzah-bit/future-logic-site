<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Message; // تأكد من استدعاء موديل الرسائل

class SettingController extends Controller
{
    // عرض صفحة إعدادات الروابط والسوشيال ميديا
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    // حفظ وتحديث الروابط
    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'تم تحديث الروابط بنجاح يا حمزة!🌟');
    }

    // عرض رسائل العملاء (هذا السطر الذي كان يسبب الـ 404)
    public function messages()
    {
        $messages = Message::latest()->get();
        return view('admin.messages', compact('messages'));
    }

    // حذف رسالة
    public function destroyMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'تم حذف الرسالة بنجاح!');
    }
}