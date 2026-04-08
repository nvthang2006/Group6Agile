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
    <header class="bg-white/90 backdrop-blur-lg border-b border-gray-100/50 shadow-[0_4px_30px_rgba(0,0,0,0.03)] sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:shadow-blue-500/30 group-hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 tracking-tight">TourManager</span>
                </a>

                <!-- Navigation Links & Search -->
                <nav class="hidden md:flex flex-1 justify-center space-x-1 lg:space-x-4 items-center">
                    <a href="{{ route('home') }}" class="relative px-4 py-2 text-sm font-semibold {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600' }} transition-colors group">
                        Trang chủ
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-blue-600 rounded-full transition-all duration-300 {{ request()->routeIs('home') ? 'opacity-100' : 'opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('home') }}#tours" class="relative px-4 py-2 text-sm font-semibold text-gray-600 hover:text-blue-600 transition-colors group">
                        Khám phá Tours
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-blue-600 rounded-full transition-all duration-300 opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100"></span>
                    </a>
                    <a href="{{ route('home') }}#tin-tuc" class="relative px-4 py-2 text-sm font-semibold text-gray-600 hover:text-blue-600 transition-colors group">
                        Cẩm nang & Tin tức
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-blue-600 rounded-full transition-all duration-300 opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100"></span>
                    </a>
                    
                    <div class="pl-4 border-l border-gray-200 hidden lg:block">
                        <form action="{{ route('search') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="q" placeholder="Bạn muốn đi đâu?" class="block w-48 pl-10 pr-3 py-2 border border-transparent rounded-full leading-5 bg-gray-100/50 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:w-64 transition-all duration-300 sm:text-sm shadow-inner">
                        </form>
                    </div>
                </nav>

                <!-- Auth / Admin Links -->
                <div class="flex items-center space-x-3">
                    @auth
                        @if(auth()->user()->role == 1)
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center justify-center text-sm font-bold text-gray-700 bg-gray-100/80 px-4 py-2 rounded-full hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 shadow-sm border border-gray-200/50 gap-2">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Bảng Quản trị
                            </a>
                        @endif
                        
                        <div class="relative group ml-2">
                            <button class="flex items-center gap-2 justify-center font-semibold text-gray-700 hover:text-blue-600 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 border border-blue-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden sm:block text-sm">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-xl shadow-xl ring-1 ring-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 translate-y-2 group-hover:translate-y-0">
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors font-medium">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600 px-3 py-2 transition-colors">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 px-5 py-2.5 rounded-full shadow-md hover:shadow-xl hover:shadow-blue-500/20 transition-all duration-300 transform hover:-translate-y-0.5 border border-transparent">
                            Đăng ký ngay
                        </a>
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
