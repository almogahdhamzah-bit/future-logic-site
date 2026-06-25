<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Project; 

// 🔑 1. مسارات متاحة للجميع (شاشة تسجيل الدخول ومعالجة البيانات)
Route::middleware(['web'])->group(function () {
    
    // شاشة تسجيل الدخول
    Route::get('/login', function () {
        if (Session::has('admin_logged_in') || Session::has('user_logged_in')) { 
            return redirect('/'); 
        }

        $errorHtml = session('error') ? '<p style="color:#dc3545; text-align:center; font-size:0.9rem; margin-bottom:15px;">'.session('error').'</p>' : '';
        
        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>تسجيل الدخول</title>
            <style>
                body { font-family: 'Cairo', sans-serif; background: #0B132B; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                .login-box { background: #1C2541; padding: 40px 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); width: 100%; max-width: 350px; border-top: 5px solid #FF9F1C; }
                h2 { text-align: center; color: #FF9F1C; margin-bottom: 25px; font-weight: 800; }
                input { width: 100%; padding: 12px; margin: 10px 0 15px 0; background: #0B132B; border: 1.5px solid #3A506B; border-radius: 6px; box-sizing: border-box; color: white; font-family: 'Cairo', sans-serif; }
                input:focus { outline: none; border-color: #FF9F1C; }
                button { width: 100%; padding: 12px; background: #FF9F1C; color: #0B132B; border: none; border-radius: 6px; cursor: pointer; font-size: 1rem; font-weight: bold; font-family: 'Cairo', sans-serif; transition: 0.3s; }
                button:hover { background: white; }
            </style>
        </head>
        <body>
            <div class='login-box'>
                <h2>تسجيل الدخول للنظام</h2>
                $errorHtml
                <form action='".route('login.submit')."' method='POST'>
                    <input type='hidden' name='_token' value='".csrf_token()."'>
                    <input type='email' name='username' placeholder='البريد الإلكتروني' required>
                    <input type='password' name='password' placeholder='كلمة المرور' required>
                    <button type='submit'>دخول</button>
                </form>
            </div>
        </body>
        </html>";
    })->name('login');

    Route::post('/login', function (Request $request) {
        $username = trim($request->username);
        $password = $request->password;

        if ($username === 'admin@future.com' && $password === 'hamza123') {
            Session::put('admin_logged_in', true);
            return redirect('/'); 
        }

        if (filter_var($username, FILTER_VALIDATE_EMAIL) && $password === '123456') {
            Session::put('user_logged_in', true);
            return redirect('/'); 
        }

        return redirect()->back()->with('error', 'بيانات الدخول غير صحيحة!');
    })->name('login.submit');

    Route::get('/logout', function () {
        Session::forget('admin_logged_in');
        Session::forget('user_logged_in');
        return redirect('/login'); 
    })->name('logout');
});


// 🔒 2. الحماية الصارمة: أي مسار هنا لن يفتح إلا إذا كان الشخص مسجلاً للدخول
Route::middleware(['web'])->group(function () {
    
    $checkAuth = function() {
        if (!Session::has('admin_logged_in') && !Session::has('user_logged_in')) {
            return redirect('/login')->send();
        }
    };

    Route::get('/', function () use ($checkAuth) {
        $checkAuth();
        return view('welcome');
    })->name('home');

    Route::get('/about', function () use ($checkAuth) {
        $checkAuth();
        return view('about');
    })->name('about');

    Route::get('/consultation', function () use ($checkAuth) {
        $checkAuth();
        return view('consultation');
    })->name('consultation');

    Route::get('/projects/{category?}', function ($category = null) use ($checkAuth) {
        $checkAuth();
        $query = Project::query();
        if ($category) { $query->where('category', $category); }
        $projects = $query->latest()->get();
        return view('projects', compact('projects', 'category'));
    })->name('projects.index');
});


// 🔐 3. لوحة تحكم LANX الحصرية للآدمن فقط
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () { return redirect('/admin/projects'); });

    // ميثود مشتركة لبناء الهيدر المتناسق مع تحديد الزر النشط وإضافة زر العودة
    $getAdminNav = function($activePage) {
        $linksUrl = route('admin.links.index');
        $messagesUrl = route('admin.messages.index');
        $projectsUrl = route('admin.projects.index');
        $homeUrl = route('home');
        $logoutUrl = route('logout');

        $activeLinks = $activePage === 'links' ? 'active' : '';
        $activeMessages = $activePage === 'messages' ? 'active' : '';
        $activeProjects = $activePage === 'projects' ? 'active' : '';

        return "
        <nav class='admin-nav'>
            <a href='{$linksUrl}' class='nav-link {$activeLinks}'>إعدادات الروابط</a>
            <a href='{$messagesUrl}' class='nav-link {$activeMessages}'>رسائل العملاء</a>
            <a href='{$projectsUrl}' class='nav-link {$activeProjects}'>إدارة المشاريع</a>
            <a href='{$homeUrl}' class='nav-link' style='background:#3A506B; color:white; margin-right:auto; font-weight:600;'>🖥️ العودة للموقع الرئيسي</a>
            <a href='{$logoutUrl}' class='nav-link' style='color:#dc3545;'>تسجيل الخروج 🚪</a>
        </nav>";
    };

    // 📊 صفحة إدارة المشاريع القائمة
    Route::get('projects', function () use ($getAdminNav) {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }
        
        $projects = Project::latest()->get();
        $rows = '';
        foreach($projects as $p) {
            $rows .= "
            <tr style='border-bottom: 1px solid #3A506B;'>
                <td style='padding:15px;'>{$p->title_ar}</td>
                <td style='padding:15px; text-transform:uppercase; color:#FF9F1C;'>{$p->category}</td>
                <td style='padding:15px;'>
                    <form action='".route('admin.projects.destroy', $p->id)."' method='POST' style='display:inline;'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='".csrf_token()."'>
                        <button type='submit' style='background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-family:\"Cairo\", sans-serif; font-weight:bold;'>حذف</button>
                    </form>
                </td>
            </tr>";
        }

        $navHtml = $getAdminNav('projects');

        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <title>لوحة التحكم | إدارة المشاريع</title>
            <link href='https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;800&display=swap' rel='stylesheet'>
            <style>
                body { background-color: #0B132B; color: #FFFFFF; font-family: 'Cairo', sans-serif; margin: 0; padding: 40px 20px; }
                .admin-container { max-width: 900px; background: #1C2541; margin: 0 auto; padding: 35px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-top: 5px solid #FF9F1C; }
                .admin-nav { display: flex; gap: 15px; margin-bottom: 30px; border-bottom: 2px solid #3A506B; padding-bottom: 15px; align-items: center; }
                .nav-link { text-decoration: none; color: #CDD1D6; font-weight: 600; padding: 10px 20px; border-radius: 8px; }
                .nav-link.active { background-color: #FF9F1C; color: #0B132B; font-weight: 800; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; text-align: right; }
                th { background: #0B132B; padding: 12px; color: #FF9F1C; }
            </style>
        </head>
        <body>
            <div class='admin-container'>
                $navHtml
                <h2>📊 مشاريع الشركة الحالية</h2>
                <a href='".route('admin.projects.create')."' style='background-color: #FF9F1C; color: #0B132B; text-decoration:none; padding: 10px 20px; border-radius: 8px; font-weight: 800; display: inline-block; margin-bottom: 20px;'>➕ إضافة مشروع جديد</a>
                <table>
                    <thead>
                        <tr>
                            <th>اسم المشروع</th>
                            <th>القسم</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        ".($rows ?: "<tr><td colspan='3' style='text-align:center; padding:20px; color:#CDD1D6;'>لا توجد مشاريع مضافة حالياً</td></tr>")."
                    </tbody>
                </table>
            </div>
        </body>
        </html>";
    })->name('projects.index');

    // 📬 صفحة رسائل العملاء
    Route::get('messages', function () use ($getAdminNav) {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }
        
        $navHtml = $getAdminNav('messages');

        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <title>لوحة التحكم | رسائل العملاء</title>
            <link href='https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;800&display=swap' rel='stylesheet'>
            <style>
                body { background-color: #0B132B; color: #FFFFFF; font-family: 'Cairo', sans-serif; margin: 0; padding: 40px 20px; }
                .admin-container { max-width: 900px; background: #1C2541; margin: 0 auto; padding: 35px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-top: 5px solid #FF9F1C; }
                .admin-nav { display: flex; gap: 15px; margin-bottom: 30px; border-bottom: 2px solid #3A506B; padding-bottom: 15px; align-items: center; }
                .nav-link { text-decoration: none; color: #CDD1D6; font-weight: 600; padding: 10px 20px; border-radius: 8px; }
                .nav-link.active { background-color: #FF9F1C; color: #0B132B; font-weight: 800; }
                .msg-card { background: #0B132B; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-right: 4px solid #FF9F1C; }
                .msg-meta { color: #FF9F1C; font-size: 0.9rem; margin-bottom: 10px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='admin-container'>
                $navHtml
                <h2>📬 رسائل واستشارات العملاء الواردة</h2>
                <div class='msg-card'>
                    <div class='msg-meta'>من: م. أحمد اليافعي | البريد: ahmed@example.com</div>
                    <p style='margin:0;'>السلام عليكم، نود الاستفسار عن إمكانية تطوير برمجية سحابية خاصة بمؤسستنا وحمايتها بالكامل عبر نظام LANX الصارم ضد التعديلات غير المصرح بها.</p>
                </div>
            </div>
        </body>
        </html>";
    })->name('messages.index');

    // 🔗 صفحة إعدادات الروابط (تم التعديل لتصبح فيسبوك وانستغرام)
    Route::get('links', function () use ($getAdminNav) {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }
        
        $navHtml = $getAdminNav('links');

        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <title>لوحة التحكم | إعدادات الروابط</title>
            <link href='https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;800&display=swap' rel='stylesheet'>
            <style>
                body { background-color: #0B132B; color: #FFFFFF; font-family: 'Cairo', sans-serif; margin: 0; padding: 40px 20px; }
                .admin-container { max-width: 900px; background: #1C2541; margin: 0 auto; padding: 35px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-top: 5px solid #FF9F1C; }
                .admin-nav { display: flex; gap: 15px; margin-bottom: 30px; border-bottom: 2px solid #3A506B; padding-bottom: 15px; align-items: center; }
                .nav-link { text-decoration: none; color: #CDD1D6; font-weight: 600; padding: 10px 20px; border-radius: 8px; }
                .nav-link.active { background-color: #FF9F1C; color: #0B132B; font-weight: 800; }
                .form-control { width: 100%; padding: 12px; background: #0B132B; border: 1.5px solid #3A506B; border-radius: 6px; color: white; margin-bottom: 15px; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
            </style>
        </head>
        <body>
            <div class='admin-container'>
                $navHtml
                <h2>🔗 التحكم بروابط منصات التواصل الاجتماعي</h2>
                <form style='margin-top:20px;'>
                    <label style='color:#FF9F1C; font-weight:bold;'>رابط حساب الفيسبوك (Facebook):</label>
                    <input type='text' class='form-control' value='https://facebook.com/your_page'>
                    
                    <label style='color:#FF9F1C; font-weight:bold;'>رابط حساب الانستغرام (Instagram):</label>
                    <input type='text' class='form-control' value='https://instagram.com/your_username'>
                    
                    <button type='button' style='background:#FF9F1C; color:#0B132B; font-weight:bold; padding:12px 30px; border:none; border-radius:6px; cursor:pointer; font-family:\"Cairo\", sans-serif;'>حفظ التغييرات الجديدة</button>
                </form>
            </div>
        </body>
        </html>";
    })->name('links.index');

    // ➕ صفحة نموذج إضافة مشروع جديد
    Route::get('projects/create', function () {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }

        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <title>لوحة التحكم | إضافة مشروع</title>
            <link href='https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;800&display=swap' rel='stylesheet'>
            <style>
                body { background-color: #0B132B; color: #FFFFFF; font-family: 'Cairo', sans-serif; margin: 0; padding: 40px 20px; }
                .admin-container { max-width: 800px; background: #1C2541; margin: 0 auto; padding: 35px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3); border-top: 5px solid #FF9F1C; }
                .form-group { margin-bottom: 20px; }
                .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #FF9F1C; }
                .form-control { width: 100%; padding: 12px 16px; background-color: #0B132B; border: 1.5px solid #3A506B; border-radius: 8px; color: white; font-family: 'Cairo', sans-serif; box-sizing: border-box; }
                .btn-save { background-color: #FF9F1C; color: #0B132B; border: none; padding: 14px 30px; border-radius: 8px; font-weight: 800; font-size: 1rem; cursor: pointer; width: 100%; font-family: 'Cairo', sans-serif; }
            </style>
        </head>
        <body>
            <div class='admin-container'>
                <h2>➕ إضافة مشروع جديد للنظام</h2>
                <form action='".route('admin.projects.store')."' method='POST' enctype='multipart/form-data'>
                    <input type='hidden' name='_token' value='".csrf_token()."'>
                    <div class='form-group'>
                        <label>عنوان المشروع (بالعربي)</label>
                        <input type='text' name='title_ar' required class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label>عنوان المشروع (بالإنجليزي)</label>
                        <input type='text' name='title_en' required class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label>القسم (Category)</label>
                        <select name='category' required class='form-control'>
                            <option value='web'>تطوير المواقع (Web)</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>وصف المشروع (بالعربي)</label>
                        <textarea name='desc_ar' required class='form-control' rows='4'></textarea>
                    </div>
                    <div class='form-group'>
                        <label>وصف المشروع (بالإنجليزي)</label>
                        <textarea name='desc_en' required class='form-control' rows='4'></textarea>
                    </div>
                    <div class='form-group'>
                        <label>صورة المشروع</label>
                        <input type='file' name='image' accept='image/*' required class='form-control'>
                    </div>
                    <button type='submit' class='btn-save'>حفظ المشروع وإطلاقه 🚀</button>
                </form>
            </div>
        </body>
        </html>";
    })->name('projects.create');

    Route::post('projects', function (Request $request) {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }
        $imagePath = '/uploads/default.png';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads'))) { mkdir(public_path('uploads'), 0777, true); }
            $file->move(public_path('uploads'), $filename);
            $imagePath = '/uploads/' . $filename;
        }

        Project::create([
            'title_ar'  => $request->title_ar,
            'title_en'  => $request->title_en,
            'category'  => $request->category,
            'desc_ar'   => $request->desc_ar,
            'desc_en'   => $request->desc_en,
            'image'     => $imagePath,
        ]);
        return redirect()->route('admin.projects.index');
    })->name('projects.store');

    Route::delete('projects/{id}', function ($id) {
        if (!Session::has('admin_logged_in')) { return redirect('/login'); }
        Project::findOrFail($id)->delete();
        return redirect()->route('admin.projects.index');
    })->name('projects.destroy');
});