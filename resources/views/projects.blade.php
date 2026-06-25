<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معرض أعمالنا المتميزة</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #0B132B; color: #FFFFFF; font-family: 'Cairo', sans-serif; margin: 0; padding: 40px 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .top-nav { display: flex; justify-content: space-between; items-center; margin-bottom: 40px; border-b: 1px solid #3A506B; padding-bottom: 15px; }
        .back-home-btn { background: transparent; color: #FF9F1C; border: 1.5px solid #FF9F1C; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; }
        .back-home-btn:hover { background: #FF9F1C; color: #0B132B; }
        .page-title { text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px; color: #FFFFFF; }
        .tabs-container { display: flex; justify-content: center; gap: 15px; margin-bottom: 50px; }
        .tab-btn { background: #1C2541; color: #CDD1D6; border: 1.5px solid #3A506B; padding: 10px 25px; border-radius: 30px; font-size: 1rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; }
        .tab-btn:hover, .tab-btn.active { background-color: #FF9F1C; color: #0B132B; border-color: #FF9F1C; font-weight: 800; }
        .projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; }
        .project-card { background: #1C2541; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); border-top: 4px solid #3A506B; transition: 0.3s; }
        .project-card:hover { transform: translateY(-5px); border-color: #FF9F1C; }
        .project-img { width: 100%; height: 250px; object-fit: cover; object-position: center; display: block; border-bottom: 2px solid #3A506B; }
        .project-info { padding: 25px; }
        .project-category { display: inline-block; font-size: 0.8rem; font-weight: 800; color: #FF9F1C; text-transform: uppercase; margin-bottom: 10px; background: rgba(255, 159, 28, 0.1); padding: 4px 12px; border-radius: 4px; }
        .project-card-title { font-size: 1.4rem; font-weight: 800; margin: 0 0 12px 0; color: #FFFFFF; }
        .project-desc { font-size: 0.95rem; color: #CDD1D6; line-height: 1.6; margin: 0; }
        .no-projects { text-align: center; grid-column: 1 / -1; padding: 50px; color: #CDD1D6; }
    </style>
</head>
<body>

    <div class="container">
        <!-- شريط علوي للرجوع السلس والتنقل الاحترافي -->
        <div class="top-nav">
            <a href="/" class="back-home-btn">⬅ العودة للصفحة الرئيسية</a>
            <div>
                @if(Session::has('admin_logged_in'))
                    <a href="/admin/projects" style="color: #FF9F1C; text-decoration: none; font-weight: bold;">لوحة التحكم ⚙️</a>
                @endif
            </div>
        </div>

        <h1 class="page-title">معرض أعمالنا المتميزة</h1>

        <div class="tabs-container">
            <a href="{{ route('projects.index') }}" class="tab-btn {{ !$category ? 'active' : '' }}">الكل</a>
            <a href="{{ route('projects.index', 'web') }}" class="tab-btn {{ $category == 'web' ? 'active' : '' }}">تطوير المواقع</a>
        </div>

        <div class="projects-grid">
            @forelse($projects as $project)
                <div class="project-card">
                    <img src="{{ $project->image }}" alt="{{ $project->title_ar }}" class="project-img">
                    <div class="project-info">
                        <span class="project-category">تطوير المواقع</span>
                        <h3 class="project-card-title">{{ $project->title_ar }}</h3>
                        <p class="project-desc">{{ $project->desc_ar }}</p>
                    </div>
                </div>
            @empty
                <div class="no-projects">🚀 لا توجد مشاريع مضافة في هذا القسم حالياً.</div>
            @endforelse
        </div>
    </div>

</body>
</html>