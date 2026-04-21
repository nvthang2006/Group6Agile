<header class="glass-nav sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex-1 flex justify-start">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-brand-500/30 group-hover:-translate-y-1 group-hover:shadow-brand-500/50 transition-all duration-300 transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-slate-800 to-brand-700 tracking-tight hidden lg:block">TourManager</span>
                    </a>
                </div>

                <!-- Navigation Links & Search -->
                <nav class="hidden md:flex justify-center xl:space-x-2 items-center">
                    <a href="{{ route('home') }}" class="relative px-3 whitespace-nowrap py-2 text-[15px] font-semibold tracking-wide {{ request()->routeIs('home') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition-colors group">
                        Trang chủ
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-brand-600 rounded-full transition-all duration-300 {{ request()->routeIs('home') ? 'opacity-100' : 'opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('products.index') }}" class="relative px-3 whitespace-nowrap py-2 text-[15px] font-semibold tracking-wide {{ request()->routeIs('products.*') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition-colors group">
                        Khám phá Tours
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-brand-600 rounded-full transition-all duration-300 {{ request()->routeIs('products.*') ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('client.categories.index') }}" class="relative px-3 whitespace-nowrap py-2 text-[15px] font-semibold tracking-wide {{ request()->routeIs('client.categories.*') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition-colors group">
                        Danh mục
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-brand-600 rounded-full transition-all duration-300 {{ request()->routeIs('client.categories.*') ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('posts.index') }}" class="relative px-3 whitespace-nowrap py-2 text-[15px] font-semibold tracking-wide {{ request()->routeIs('posts.*') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition-colors group">
                        Cẩm nang & Tin tức
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-brand-600 rounded-full transition-all duration-300 {{ request()->routeIs('posts.*') ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-100 group-hover:scale-x-100' }}"></span>
                    </a>
                </nav>

                <!-- Auth / Admin Links -->
                <div class="flex-1 flex items-center justify-end space-x-2 xl:space-x-3">
                    @auth
                        @if(auth()->user()->role == 1)
                            <a href="{{ route('admin.dashboard') }}" class="hidden lg:inline-flex items-center justify-center text-sm font-bold text-slate-700 bg-slate-100/80 px-3 py-2 rounded-xl whitespace-nowrap hover:bg-slate-200 hover:text-slate-900 transition-all duration-300 shadow-sm border border-slate-200/50 gap-2">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="hidden xl:inline">Quản trị</span>
                            </a>
                        @endif
                        
                        <!-- Notifications Bell -->
                        @php
                            $unreadCount = auth()->user()->notifications()->unread()->count();
                        @endphp
                        <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-500 hover:text-brand-600 transition-colors mr-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                        
                        <div class="relative group ml-1">
                            <button class="flex items-center gap-2 justify-center font-semibold text-slate-700 hover:text-brand-600 transition-colors bg-white/50 px-2 py-1.5 rounded-full border border-slate-200/50 hover:border-brand-200 hover:shadow-md hover:shadow-brand-500/10">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand-100 to-brand-200 flex items-center justify-center text-brand-700 border border-brand-200 font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden lg:block text-sm mr-1">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-500 transition-transform duration-300 group-hover:rotate-180 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute right-0 w-56 mt-3 origin-top-right bg-white rounded-2xl shadow-xl ring-1 ring-slate-900/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50">
                                <div class="p-2">
                                    <div class="px-3 py-2 border-b border-slate-100 mb-1">
                                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tài khoản</p>
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Thông tin cá nhân
                                    </a>
                                    <a href="{{ route('bookings.history') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                                        Lịch sử đặt tour
                                    </a>
                                    <a href="{{ route('vouchers.index') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Hóa đơn của tôi
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-[15px] font-semibold text-slate-600 hover:text-brand-600 px-2 lg:px-4 py-2 transition-colors whitespace-nowrap">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="text-[15px] font-semibold text-white bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-700 hover:to-brand-600 px-4 lg:px-6 py-2 lg:py-2.5 rounded-full shadow-lg shadow-brand-500/30 transition-all duration-300 transform hover:-translate-y-0.5 border border-transparent whitespace-nowrap">
                            Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
