@extends('layouts.app')

@section('title', $product->name . ' - Tour Manager')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('home') }}#tours" class="hover:text-blue-600 transition">Tour</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-800 font-medium">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <!-- Image gallery placeholder -->
            <div class="relative h-[400px] lg:h-full bg-gray-100">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center w-full h-full text-gray-400 font-medium">Không có ảnh</div>
                @endif
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-gray-800 shadow-sm uppercase tracking-wider">
                    {{ $product->category->name ?? 'Tour' }}
                </div>
                @if($product->sale_price)
                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                        Đang giảm giá!
                    </div>
                @endif
            </div>

            <!-- Tour Info -->
            <div class="p-8 lg:p-12 flex flex-col justify-center">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 uppercase tracking-widest font-semibold mb-1">Giá Tour</span>
                        @if($product->sale_price)
                            <div class="flex items-baseline gap-3">
                                <span class="text-3xl font-extrabold text-red-500">{{ number_format($product->sale_price, 0, ',', '.') }}VNĐ</span>
                                <span class="text-lg text-gray-400 line-through">{{ number_format($product->price, 0, ',', '.') }}VNĐ</span>
                            </div>
                        @else
                            <span class="text-3xl font-extrabold text-blue-600">{{ number_format($product->price, 0, ',', '.') }}VNĐ</span>
                        @endif
                    </div>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600 mb-10 leading-relaxed whitespace-pre-line">
                    {{ $product->description }}
                </div>

                <div class="mt-auto bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Mẫu Đặt Tour</h3>
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium border border-green-100">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @auth
                        <form action="{{ route('bookings.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày khởi hành dự kiến</label>
                                <input type="date" name="booking_date" class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3" required min="{{ date('Y-m-d') }}">
                                @error('booking_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Số lượng người</label>
                                <input type="number" name="quantity" class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3" required min="1" value="1">
                                @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú thêm (Tùy chọn)</label>
                                <textarea name="note" rows="2" class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 px-4 py-3" placeholder="Yêu cầu đặc biệt..."></textarea>
                                @error('note') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                Xác nhận Đặt Tour
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-600 mb-4">Vui lòng đăng nhập để đặt Tour.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white font-bold px-8 py-3 rounded-xl shadow hover:bg-blue-700 transition">Đăng nhập ngay</a>
                        </div>
                    @endauth
                    
                    <p class="text-center text-sm text-gray-500 mt-6">Cam kết hỗ trợ nhiệt tình, đổi trả dễ dàng.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Tours -->
    @if($relatedProducts->count() > 0)
    <section>
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Tour Cùng Danh Mục</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $tour)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <a href="{{ route('products.detail', $tour->slug) }}" class="block aspect-[4/3] relative overflow-hidden bg-gray-100">
                    @if($tour->image_url)
                        <img src="{{ $tour->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                    @endif
                </a>
                <div class="p-5 flex flex-col h-full">
                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2"><a href="{{ route('products.detail', $tour->slug) }}" class="hover:text-blue-600">{{ $tour->name }}</a></h3>
                    <div class="mt-auto text-blue-600 font-bold">
                        {{ number_format($tour->sale_price ?? $tour->price, 0, ',', '.') }}VNĐ
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
