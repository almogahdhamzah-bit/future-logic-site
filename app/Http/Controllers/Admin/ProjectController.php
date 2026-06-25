<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // عرض المشاريع في لوحة التحكم
    public function index()
    {
        if (!session()->has('admin_logged_in')) { return redirect('/login'); }
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    // فتح صفحة إضافة مشروع جديد
    public function create()
    {
        if (!session()->has('admin_logged_in')) { return redirect('/login'); }
        return view('admin.projects.create'); 
    }

    // تخزين المشروع الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        if (!session()->has('admin_logged_in')) { return redirect('/login'); }

        // التحقق من الحقول
        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category' => 'required|string',
            'desc_ar'  => 'required|string',
            'desc_en'  => 'required|string',
            'image'    => 'nullable|string', // أو رابط صورة مؤقت
        ]);

        // إدخال البيانات في الموديل
        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'تم إضافة المشروع بنجاح 🎉');
    }

    // حذف مشروع
    public function destroy($id)
    {
        if (!session()->has('admin_logged_in')) { return redirect('/login'); }
        Project::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'تم حذف المشروع بنجاح!');
    }
}