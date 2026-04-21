<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Khám phá thế giới cùng Tour Manager. Hệ thống đặt tour du lịch cao cấp, uy tín với hàng ngàn hành trình hấp dẫn.')">
    <meta name="keywords" content="@yield('meta_keywords', 'du lịch, đặt tour, tour quốc tế, tour nội địa, tour ngỉ dưỡng, tour manager')">
    <meta name="author" content="Tour Manager">
    <title>@yield('title', 'Tour Manager - Hệ thống quản lý và đặt Tour du lịch trực tuyến')</title>
    <!-- Open Graph (Facebook SEO) -->
    <meta property="og:title" content="@yield('title', 'Tour Manager')">
    <meta property="og:description" content="@yield('meta_description', 'Khám phá thế giới cùng Tour Manager')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('meta_image', asset('images/default-banner.png'))">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        heading: ['Outfit', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff4ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#4361ee', // Primary admin color
                            700: '#3a53c4',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; scroll-behavior: smooth; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', system-ui, sans-serif !important; letter-spacing: -0.02em; }
        /* Global Client Animations */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 flex flex-col min-h-screen selection:bg-brand-600 selection:text-white">@include('layouts.header')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>

