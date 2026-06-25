<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب استشارة مجانية | Future Logic Systems</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { darkBg: '#0B132B', cardBg: '#1C2541', accent: '#FF9F1C', borderColor: '#3A506B', textMuted: '#CDD1D6' }, fontFamily: { cairo: ['Cairo', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-darkBg text-white font-cairo antialiased flex flex-col min-h-screen">

    <header class="border-b border-borderColor bg-darkBg/90">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-800 text-accent">FUTURE LOGIC</a>
            <a href="/" class="border border-borderColor hover:border-accent text-accent px-5 py-2 rounded-lg font-600 transition text-sm">⬅ العودة للرئيسية</a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-6 py-16">
        <div class="max-w-2xl w-full bg-cardBg p-8 md:p-10 rounded-2xl shadow-2xl border border-borderColor">
            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-800 mb-2 text-accent">طلب استشارة برمجية مجانية 💬</h1>
                <p class="text-textMuted text-sm">أرسل لنا تفاصيل فكرتك أو النظام الذي تحتاجه، وسيتواصل معك المهندس حمزة وفريق عمله فوراً</p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-600 mb-2 text-textMuted">الاسم الكريم</label>
                        <input type="text" required class="w-full bg-darkBg border border-borderColor rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent font-cairo">
                    </div>
                    <div>
                        <label class="block text-sm font-600 mb-2 text-textMuted">البريد الإلكتروني أو الواتساب</label>
                        <input type="text" required class="w-full bg-darkBg border border-borderColor rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent font-cairo">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-600 mb-2 text-textMuted">تفاصيل الفكرة أو النظام المطلوب</label>
                    <textarea rows="5" required class="w-full bg-darkBg border border-borderColor rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent font-cairo resize-none" placeholder="اكتب هنا ما تدور حوله فكرتك المتوقعة..."></textarea>
                </div>
                <button type="submit" class="w-full bg-accent text-darkBg font-bold py-3 rounded-xl hover:bg-white transition shadow-lg shadow-accent/10">
                    إرسال الطلب للمناقشة والدراسة 🚀
                </button>
            </form>
        </div>
    </main>

    <footer class="border-t border-borderColor/30 py-6 text-center text-sm text-textMuted bg-cardBg/30">
        <p>© 2026 Future Logic Systems. جميع الحقوق محفوظة.</p>
    </footer>

</body>
</html>