<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- تحديث اسم المتصفح ليتطابق مع طلبك محركات البحث -->
    <title>Future Logic Systems</title>
    
    <!-- أيقونة التبويب للمتصفح (Favicon) معدلة لتقرأ الصورة مباشرة -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- استدعاء الإصدار المستقر والأحدث من FontAwesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { darkBg: '#0B132B', cardBg: '#1C2541', accent: '#FF9F1C', borderColor: '#3A506B', textMuted: '#CDD1D6' }, fontFamily: { cairo: ['Cairo', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-darkBg text-white font-cairo antialiased">
        
          <!-- 🖥️ رأس الشاشة (Header) - الشعار يمين كبير جداً والكتابة أقصى اليسار -->
<header class="border-b border-borderColor bg-darkBg/90 sticky top-0 z-60 backdrop-blur">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <!-- 1️⃣ أقصى اليمين: الشعار كبير وضخم كما طلبت في الصورة -->
        <a href="/" class="block order-first">
            <img src="{{ asset('logo.png') }}" alt="Future Logic Logo" class="h-24 w-auto object-contain transition hover:scale-110 block">
        </a>

        <!-- 2️⃣ المنتصف: روابط التنقل بين الصفحات -->
        <nav class="hidden md:flex gap-6 items-center">
            <a href="/" class="text-accent font-700">الرئيسية</a>
            <a href="{{ route('projects.index') }}" class="hover:text-accent transition font-600">معرض الأعمال</a>
            <a href="{{ route('about') }}" class="hover:text-accent transition font-600">من نحن</a>
            <a href="{{ route('consultation') }}" class="hover:text-accent transition font-600">طلب استشارة</a>
        </nav>
        
        <!-- 3️⃣ أقصى اليسار: النص البرمجي الفخم وأزرار النظام -->
        <div class="flex items-center gap-6">
            <!-- النص في اليسار تماماً -->
            <span class="text-2xl font-800 text-accent tracking-wider hidden sm:block">FUTURE LOGIC SYSTEMS</span>
            
            <!-- أزرار الدخول ولوحة التحكم -->
            <div class="flex items-center gap-4">
                @if(Session::has('admin_logged_in'))
                    <a href="/admin/projects" class="bg-accent text-darkBg px-5 py-2 rounded-lg font-bold hover:bg-white transition text-sm">لوحة التحكم ⚙️</a>
                    <a href="{{ route('logout') }}" class="text-sm text-red-400 hover:underline">خروج</a>
                @elseif(Session::has('user_logged_in'))
                @else
                    <a href="/login" class="border border-borderColor hover:border-accent px-5 py-2 rounded-lg font-600 transition text-sm">دخول النظام</a>
                @endif
            </div>
        </div>
        
    </div>
</header>
    
    <!-- قسم الترحيب (Hero Section) -->
    <section class="max-w-5xl mx-auto px-6 py-28 text-center">
        <h1 class="text-4xl md:text-6xl font-800 mb-8 leading-[1.5] tracking-wide">
            نبتكر الحلول الرقمية لتبسيط <br> <span class="text-accent">أعمالك المستقبلية</span>
        </h1>
        <p class="text-textMuted text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
            نحن هنا لنمكّن مشروعك ونقوده نحو النجاح من خلال خدمات برمجية احترافية، مخصصة، ومبنية بأحدث التقنيات العالمية.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('projects.index') }}" class="bg-accent text-darkBg px-8 py-3 rounded-xl font-bold hover:bg-white transition shadow-lg shadow-accent/20">تصفح مشاريعنا البرمجية 💼</a>
            <a href="{{ route('consultation') }}" class="border border-borderColor hover:border-accent px-8 py-3 rounded-xl font-600 transition">طلب استشارة مجانية 🤝</a>
        </div>
    </section>

    <!-- أقسام التميز والخدمات -->
    <section class="max-w-7xl mx-auto px-6 py-16 border-t border-borderColor/50">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-800 mb-3">مجال تميزنا وإبداعنا 🎯</h2>
            <p class="text-textMuted">نركز كل طاقاتنا وخبراتنا لنقدم خدمات برمجية لا مثيل لها</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-cardBg p-8 rounded-2xl border-t-4 border-accent shadow-xl">
                <div class="text-4xl mb-4">💻</div>
                <h3 class="text-xl font-bold mb-3 text-accent">تطوير المواقع الإلكترونية (Web Development)</h3>
                <p class="text-textMuted text-sm leading-relaxed">
                    بناء مواقع إنترنت متكاملة، سريعة، ومتجاوبة مع كافة الشاشات باستخدام أحدث تقنيات الويب لضمان تجربة مستخدم فخمة وسلسة.
                </p>
            </div>
            <div class="bg-cardBg p-8 rounded-2xl border-t-4 border-borderColor shadow-xl">
                <div class="text-4xl mb-4">🛡️</div>
                <h3 class="text-xl font-bold mb-3 text-white">تطوير تطبيقات الويب والأنظمة الذكية</h3>
                <p class="text-textMuted text-sm leading-relaxed">
                    تصميم وبرمجة لوحات تحكم متقدمة، وأنظمة إدارة بيانات داخلية مبنية خصيصاً لتلبية احتياجات الشركات والمشاريع مع توفير حماية عالية.
                </p>
            </div>
        </div>
    </section>
      
         <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-borderColor/30 text-center">
    <div class="mb-6">
        <p class="text-accent font-600 tracking-wide">// تابعنا على منصات التواصل الاجتماعي</p>
        
        <div class="flex justify-center gap-6 mt-5">
            
            <a href="{{ \DB::table('settings')->where('key', 'facebook_link')->value('value') ?? '#' }}" target="_blank" class="w-14 h-14 rounded-full bg-white flex items-center justify-center p-0 overflow-hidden transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-accent/20">
                <img src="{{ asset('facebook.png') }}" alt="Facebook" class="w-full h-full object-cover">
            </a>
            
            <a href="{{ \DB::table('settings')->where('key', 'instagram_link')->value('value') ?? '#' }}" target="_blank" class="w-14 h-14 rounded-full bg-white flex items-center justify-center p-0 overflow-hidden transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-accent/20">
                <img src="{{ asset('instagram.png') }}" alt="Instagram" class="w-full h-full object-cover">
            </a>
            
        </div>
    </div>

    <p class="text-textMuted text-sm mt-8">
        &copy; 2026 <span class="text-accent font-bold">فيوتشر لوجك (Future Logic)</span>. جميع الحقوق محفوظة.
    </p>
</footer>
   
</body>
</html>