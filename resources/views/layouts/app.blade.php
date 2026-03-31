<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tour Manager - Hệ thống quản lý Tour')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Header / Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-blue-600">🌍 Tour Manager</span>
                </a>

                <!-- Navigation Links & Search -->
                <nav class="hidden md:flex space-x-6 items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium pb-1 {{ request()->routeIs('home') ? 'border-b-2 border-blue-600 text-blue-600' : '' }}">Trang chủ</a>
                    <a href="{{ route('home') }}#tours" class="text-gray-600 hover:text-blue-600 font-medium pb-1">Tours</a>
                    <a href="{{ route('home') }}#tin-tuc" class="text-gray-600 hover:text-blue-600 font-medium pb-1">Tin tức</a>
                    
                    <form action="{{ route('search') }}" method="GET" class="relative hidden lg:block border rounded-full overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                        <input type="text" name="q" placeholder="Hạ Long, Đà Lạt..." class="bg-gray-50 border-none text-sm w-48 focus:w-64 transition-all duration-300 px-4 py-2 focus:bg-white focus:outline-none focus:ring-0">
                        <button type="submit" class="absolute right-0 top-0 bottom-0 px-3 text-gray-500 hover:text-blue-600 hover:bg-gray-100 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </nav>

                <!-- Auth / Admin Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role == 1)
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-red-600 border border-red-600 px-4 py-2 rounded-lg hover:bg-red-50 hover:border-red-700 transition">🛡️ Quản trị</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow-sm transition transform hover:-translate-y-0.5">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4">🌍 Tour Manager</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Khám phá thế giới cùng những hành trình tuyệt vời. Chúng tôi mang đến những trải nghiệm du lịch không giới hạn với dịch vụ chuyên nghiệp nhất.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Liên kết nhanh</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}#tours" class="hover:text-white transition">Tour nổi bật</a></li>
                    <li><a href="{{ route('home') }}#tin-tuc" class="hover:text-white transition">Tin tức du lịch</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Đăng nhập / Đăng ký</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Thông tin liên hệ</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2"><span>📍</span> <span>123 Đường Điện Biên Phủ, Phường 15, Bình Thạnh, TP.HCM</span></li>
                    <li class="flex items-center gap-2"><span>📞</span> <span>1900 1234 56</span></li>
                    <li class="flex items-center gap-2"><span>📧</span> <span>contact@tourmanager.com</span></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} Tour Manager. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white transition">Facebook</a>
                <a href="#" class="hover:text-white transition">Instagram</a>
                <a href="#" class="hover:text-white transition">Twitter</a>
            </div>
        </div>
    </footer>

</body>
</html>
