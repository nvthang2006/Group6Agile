@extends('layouts.app')

@section('title', 'Trang chủ - Tour Manager')

@section('content')
    <!-- Hero Banner -->
    <div class="relative bg-blue-600 h-[80vh] min-h-[500px] flex items-center justify-center text-center overflow-hidden">
        <!-- Chèn ảnh nền mờ -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70 z-10"></div>
        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80" alt="Travel Header" class="absolute w-full h-full object-cover object-center z-0 animate-[pulse_10s_ease-in-out_infinite_alternate]">
        
        <div class="relative z-20 max-w-4xl px-4 flex flex-col items-center">
            <span class="text-blue-300 font-semibold tracking-wider uppercase mb-3 text-sm md:text-base">Mở khóa thế giới</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight drop-shadow-lg">Hành trình của bạn <br/><span class="text-blue-400">Bắt đầu từ đây</span></h1>
            <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl drop-shadow">Trải nghiệm những chuyến đi đáng nhớ tới hàng ngàn điểm đến tuyệt đẹp cùng dịch vụ tiện ích hàng đầu.</p>
            <a href="#tours" class="inline-flex items-center justify-center bg-white text-blue-600 font-bold px-8 py-4 rounded-full shadow-lg hover:shadow-2xl hover:bg-blue-50 hover:-translate-y-1 transition transform duration-300 text-lg">
                Xem Tour Nổi Bật
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        
        <!-- Danh mục Tour -->
        <section class="mb-24">
            <div class="text-center mb-12">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Điểm đến</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2">Danh mục Tour</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto mt-6 rounded-full opacity-80"></div>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                @forelse($categories as $category)
                    <a href="#" class="px-8 py-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-blue-300 transition-all duration-300 group">
                        <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors text-lg">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-1 max-w-[200px]">{{ $category->description ?? 'Khám phá ngay' }}</p>
                    </a>
                @empty
                    <p class="text-gray-500 italic">Đang cập nhật danh mục...</p>
                @endforelse
            </div>
        </section>

        <!-- Tour mới nhất -->
        <section id="tours" class="mb-24 scroll-mt-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Tour Hot</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2">Tour Ưu Đãi & Nổi Bật</h2>
                    <div class="w-20 h-1.5 bg-blue-600 mt-6 rounded-full opacity-80"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                @forelse($products as $tour)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 group flex flex-col">
                        <div class="relative overflow-hidden aspect-[4/3]">
                            @if($tour->image)
                                <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-gray-800 shadow-sm uppercase tracking-wider">
                                {{ $tour->category->name ?? 'Tour' }}
                            </div>
                            @if($tour->sale_price)
                                <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    Giảm giá!
                                </div>
                            @endif
                        </div>
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('products.detail', $tour->slug) }}">{{ $tour->name }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">{{ $tour->description }}</p>
                            
                            <div class="flex justify-between items-center mt-auto border-t border-gray-100 pt-6">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Giá từ</span>
                                    @if($tour->sale_price)
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-xl font-extrabold text-red-500">{{ number_format($tour->sale_price, 0, ',', '.') }}đ</span>
                                            <span class="text-sm text-gray-400 line-through">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                                        </div>
                                    @else
                                        <span class="text-xl font-extrabold text-blue-600">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.detail', $tour->slug) }}" class="inline-flex items-center justify-center bg-gray-50 text-blue-600 font-bold rounded-xl px-5 py-2.5 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                    Chi tiết <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-lg text-gray-500 font-medium">Hệ thống đang cập nhật các Tour mới, bạn vui lòng quay lại sau nhé!</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Bài viết mới (Blog) -->
        <section id="tin-tuc" class="scroll-mt-20">
            <div class="text-center mb-12">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Blog</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2">Cẩm Nang Du Lịch</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto mt-6 rounded-full opacity-80"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                        <a href="{{ route('posts.detail', $post->slug) }}" class="block relative aspect-[16/10] overflow-hidden">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 bg-blue-600 text-white px-3 py-1 m-4 rounded-lg text-xs font-bold shadow">
                                {{ $post->created_at->format('d/m') }}
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 leading-tight">
                                <a href="{{ route('posts.detail', $post->slug) }}" class="hover:text-blue-600 transition-colors">{{ $post->title }}</a>
                            </h3>
                            <a href="{{ route('posts.detail', $post->slug) }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">Đọc tiếp <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12 bg-gray-50 rounded-2xl">
                        Chưa có bài viết nào được xuất bản.
                    </div>
                @endforelse
            </div>
            
            @if($posts->count() > 0)
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-full px-8 py-3 hover:border-blue-600 hover:text-blue-600 transition-colors transition-all">
                    Xem toàn bộ bài viết
                </a>
            </div>
            @endif
        </section>

    </div>
@endsection
