@extends('layouts.app')

@section('title', 'Trang chủ - Tour Manager')
@section('meta_description', 'Đặt tour du lịch trực tuyến dễ dàng và an toàn. Hàng trăm điểm đến du lịch trong nước và quốc tế với giá cả cực kỳ cạnh tranh và dịch vụ chuyên nghiệp nhất.')
@section('content')
    <!-- Hero Banner Premium -->
    <div class="relative bg-slate-900 h-[85vh] min-h-[600px] flex items-center justify-center text-center overflow-hidden">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 via-slate-900/20 to-slate-900/90 z-10"></div>
        <!-- Hero Image -->
        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80" alt="Travel Header" class="absolute w-full h-full object-cover object-center z-0" loading="lazy">
        
        <div class="relative z-20 max-w-5xl px-4 flex flex-col items-center mt-12 w-full">
            <div class="inline-flex items-center backdrop-blur-md bg-white/10 border border-white/20 rounded-full px-5 py-2 mb-8 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-brand-400 mr-2"></span>
                <span class="text-white text-xs md:text-sm font-semibold tracking-widest uppercase">Mở khóa thế giới bản nguyên</span>
            </div>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-[1.1] drop-shadow-2xl">
                Hành trình vĩ đại <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 via-brand-100 to-white">Bắt đầu từ đây</span>
            </h1>
            <p class="text-lg md:text-2xl text-slate-200 mb-12 max-w-3xl drop-shadow-md font-medium leading-relaxed">
                Khám phá những điểm đến ngoạn mục, trải nghiệm dịch vụ đẳng cấp và lưu giữ những kỷ niệm không thể nào quên.
            </p>
            
            <!-- Modern Glass Search Box -->
            <div class="w-full max-w-4xl bg-white/20 backdrop-blur-2xl border border-white/30 p-3 rounded-full shadow-2xl flex flex-col md:flex-row items-center gap-2 transition-all hover:bg-white/30 hover:border-white/40">
                <form action="{{ route('search') }}" method="GET" class="w-full flex">
                    <div class="flex-1 flex items-center bg-white/95 rounded-full px-6 py-4 shadow-inner">
                        <svg class="w-6 h-6 text-brand-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="q" placeholder="Bạn muốn khám phá nơi nào?" class="w-full bg-transparent border-none focus:ring-0 text-slate-800 text-lg font-medium placeholder-slate-400">
                    </div>
                    <button type="submit" class="hidden md:flex ml-3 items-center justify-center bg-gradient-to-r from-brand-600 to-brand-500 text-white font-bold px-10 py-4 rounded-full shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:scale-105 transition transform duration-300 text-lg border border-brand-400/50">
                        Tìm kiếm
                    </button>
                </form>
            </div>
            
            <!-- Scroll indicator -->
            <a href="#tours" class="absolute -bottom-24 md:-bottom-32 text-white/50 hover:text-white transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Features Section / Why Choose Us -->
    <div class="bg-white py-12 border-b border-slate-100 relative z-30 -mt-8 rounded-t-[3rem] shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-100">
                <div class="p-4 flex flex-col items-center">
                    <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-2">Đa dạng lựa chọn</h3>
                    <p class="text-slate-500 text-sm">Hàng ngàn tour du lịch hấp dẫn trên toàn thế giới chờ bạn khám phá.</p>
                </div>
                <div class="p-4 flex flex-col items-center">
                    <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-2">Giao dịch an toàn</h3>
                    <p class="text-slate-500 text-sm">Hệ thống thanh toán bảo mật tuyệt đối cho mọi chuyến đi.</p>
                </div>
                <div class="p-4 flex flex-col items-center">
                    <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-2">Hỗ trợ 24/7</h3>
                    <p class="text-slate-500 text-sm">Đội ngũ chăm sóc khách hàng luôn đồng hành cùng bạn trên mọi nẻo đường.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        
        <!-- Danh mục Tour -->
        <section class="mb-24">
            <div class="text-center mb-12 flex flex-col items-center">
                <span class="inline-block py-1 px-3 rounded-full bg-brand-50 text-brand-600 font-bold tracking-widest uppercase text-xs mb-3 border border-brand-100">Điểm đến</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Danh mục Khám phá</h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600 mx-auto mt-6 rounded-full opacity-80"></div>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                @forelse($categories as $category)
                    <a href="#" class="px-8 py-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-brand-300 transition-all duration-300 group">
                        <h3 class="font-bold text-slate-800 group-hover:text-brand-600 transition-colors text-lg flex items-center gap-2">
                            {{ $category->name }}
                            <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </h3>
                        <p class="text-sm text-slate-500 mt-1 line-clamp-1 max-w-[200px]">{{ $category->description ?? 'Khám phá ngay' }}</p>
                    </a>
                @empty
                    <p class="text-slate-500 italic">Đang cập nhật danh mục...</p>
                @endforelse
            </div>
        </section>

        <!-- Tour mới nhất -->
        <section id="tours" class="mb-24 scroll-mt-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="inline-block py-1 px-3 rounded-full bg-rose-50 text-rose-600 font-bold tracking-widest uppercase text-xs mb-3 border border-rose-100">Tour Hot</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 block">Tuyển tập Nổi Bật</h2>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600 mt-6 rounded-full opacity-80"></div>
                </div>
                <a href="{{ route('products.index') }}" class="hidden md:inline-flex items-center font-bold text-brand-600 hover:text-brand-800 transition-colors group">
                    Xem tất cả 
                    <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                @forelse($products as $tour)
                    <x-tour-card :tour="$tour" />
                @empty
                    <div class="col-span-full text-center py-20 bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-lg text-slate-500 font-medium">Hệ thống đang cập nhật các Tour mới, bạn chờ xíu nhé!</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-12 md:hidden">
                <a href="{{ route('products.index') }}" class="inline-flex items-center font-bold text-brand-600 hover:text-brand-800 transition-colors bg-brand-50 px-6 py-3 rounded-full">
                    Xem tất cả Tour
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </section>

        <!-- Bài viết mới (Blog) -->
        <section id="tin-tuc" class="scroll-mt-20">
            <div class="flex flex-col items-center text-center mb-12">
                <span class="inline-block py-1 px-3 rounded-full bg-brand-50 text-brand-600 font-bold tracking-widest uppercase text-xs mb-3 border border-brand-100">Bí kíp du lịch</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mt-2">Cẩm Nang Truyền Cảm Hứng</h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600 mx-auto mt-6 rounded-full opacity-80"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group border border-slate-100 flex flex-col hover:-translate-y-2">
                        <a href="{{ route('posts.detail', $post->slug) }}" class="block relative aspect-[16/10] overflow-hidden m-2 mb-0 rounded-[2rem]">
                            @if($post->image_url)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-slate-800 px-3 py-1 rounded-xl text-xs font-bold shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $post->created_at->format('d/m') }}
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 leading-tight group-hover:text-brand-600 transition-colors">
                                <a href="{{ route('posts.detail', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <a href="{{ route('posts.detail', $post->slug) }}" class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors mt-2">Đọc tiếp <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center text-slate-500 py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        Chưa có bài viết nào được xuất bản.
                    </div>
                @endforelse
            </div>
            
            @if($posts->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-full px-8 py-3 hover:border-brand-600 hover:text-brand-600 transition-all shadow-sm hover:shadow-md">
                    Xem toàn bộ bài viết
                </a>
            </div>
            @endif
        </section>

    </div>
@endsection
