<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Logic Systems | الرئيسية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { darkBg: '#0B132B', cardBg: '#1C2541', accent: '#FF9F1C', borderColor: '#3A506B', textMuted: '#CDD1D6' }, fontFamily: { cairo: ['Cairo', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-darkBg text-white font-cairo antialiased">

    <header class="border-b border-borderColor bg-darkBg/90 sticky top-0 z-50 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-800 text-accent tracking-wider">FUTURE LOGIC</a>
            <nav class="hidden md:flex gap-6">
                <a href="/" class="text-accent font-700">الرئيسية</a>
                <a href="{{ route('projects.index') }}" class="hover:text-accent transition font-600">معرض الأعمال</a>
                <a href="{{ route('about') }}" class="hover:text-accent transition font-600">من نحن</a>
                <a href="{{ route('consultation') }}" class="hover:text-accent transition font-600">طلب استشارة</a>
            </nav>
              <div class="flex items-center gap-4">
    <!-- الفرز الأمني الذكي والمخفي بالكامل -->
    @if(Session::has('admin_logged_in'))
        <!-- الآدمن فقط من يرى لوحة التحكم وزر الخروج -->
        <a href="/admin/projects" class="bg-accent text-darkBg px-5 py-2 rounded-lg font-bold hover:bg-white transition text-sm">لوحة التحكم ⚙️</a>
        <a href="{{ route('logout') }}" class="text-sm text-red-400 hover:underline">خروج</a>
    @elseif(Session::has('user_logged_in'))
        <!-- العميل العادي: تختفي أزرار الدخول تماماً ولا يظهر له أي زر يشوه الواجهة -->
    @else
        <!-- الزائر الجديد: يظهر له زر دخول النظام فقط -->
        <a href="/login" class="border border-borderColor hover:border-accent px-5 py-2 rounded-lg font-600 transition text-sm">دخول النظام</a>
    @endif
</div>
            
        </div>
    </header>

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

    <footer class="border-t border-borderColor/30 py-12 text-center text-textMuted bg-cardBg/30">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-6">
            <h4 class="text-sm font-bold text-white tracking-widest">// تابعنا على منصات التواصل الاجتماعي</h4>
            
            <div class="flex gap-4">
                <a href="#" class="w-11 h-11 rounded-full bg-cardBg border border-borderColor flex items-center justify-center text-textMuted hover:bg-accent hover:text-darkBg hover:border-accent transition"><i class="fab fa-whatsapp text-lg"></i></a>
                <a href="#" class="w-11 h-11 rounded-full bg-cardBg border border-borderColor flex items-center justify-center text-textMuted hover:bg-accent hover:text-darkBg hover:border-accent transition"><i class="fab fa-instagram text-lg"></i></a>
                <a href="#" class="w-11 h-11 rounded-full bg-cardBg border border-borderColor flex items-center justify-center text-textMuted hover:bg-accent hover:text-darkBg hover:border-accent transition"><i class="fab fa-linkedin-in text-lg"></i></a>
                <a href="#" class="w-11 h-11 rounded-full bg-cardBg border border-borderColor flex items-center justify-center text-textMuted hover:bg-accent hover:text-darkBg hover:border-accent transition"><i class="fab fa-github text-lg"></i></a>
            </div>
            <p class="text-sm mt-4">© 2026 Future Logic Systems. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

</body>
</html>