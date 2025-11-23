<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - نظام إدارة المبيعات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light-theme.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Cairo', sans-serif;
            background: #0a0a0a;
            min-height: 100vh;
        }
        .glass-effect {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
        }
        .stat-card {
            background: linear-gradient(135deg, rgba(30, 30, 35, 0.8) 0%, rgba(20, 20, 25, 0.9) 100%);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen">
    @include('partials.sidebar')
    @include('partials.topbar')

    <div class="mr-64 mt-16 p-6">
        @yield('content')
    </div>

    <script>
        const themeBtn = document.getElementById('globalThemeBtn');
        const body = document.body;
        
        const currentTheme = localStorage.getItem('theme') || 'dark';
        if (currentTheme === 'light') {
            body.classList.add('light-mode');
        }
        
        themeBtn.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            const theme = body.classList.contains('light-mode') ? 'light' : 'dark';
            localStorage.setItem('theme', theme);
        });
    </script>
</body>
</html>