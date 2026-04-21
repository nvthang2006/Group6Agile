@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm - Tour Manager')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Tìm kiếm Tour Du Lịch</h1>
        <p class="text-gray-500">Khám phá các tour hấp dẫn phù hợp với yêu cầu của bạn</p>
    </div>

    <!-- Thanh công cụ lọc -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-10">
        <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nhập tên tour, keyword..." class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3 px-4">
            </div>
            <div class="w-full md:w-64 relative">
                <select name="category" class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3 px-4 text-gray-700 font-medium">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                Tìm Kiếm
            </button>
        </form>
    </div>

    <!-- Kết quả -->
    <div class="mb-6 flex justify-between items-center text-gray-600">
        <span>Tìm thấy <b class="text-blue-600 text-lg">{{ $results->total() }}</b> kết quả phù hợp{{ request('q') ? ' cho từ khóa "'.request('q').'"' : '' }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        @forelse($results as $tour)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative overflow-hidden aspect-[4/3]">
                    @if($tour->image_url)
                        <img src="{{ $tour->image_url }}" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">Không có ảnh</div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-gray-800 shadow-sm uppercase tracking-wider">
                        {{ $tour->category->name ?? 'Tour' }}
                    </div>
                </div>
                <div class="p-8 flex-grow flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                        <a href="{{ route('products.detail', $tour->slug) }}">{{ $tour->name }}</a>
                    </h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow">{{ strip_tags($tour->description) }}</p>
                    
                    <div class="flex justify-between items-center mt-auto border-t border-gray-100 pt-6">
                        <div class="flex flex-col">
                            @if($tour->sale_price)
                                <span class="text-xl font-bold text-red-500">{{ number_format($tour->sale_price, 0, ',', '.') }}đ</span>
                                <span class="text-sm font-semibold text-gray-400 line-through">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                            @else
                                <span class="text-xl font-bold text-blue-600">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                        <a href="{{ route('products.detail', $tour->slug) }}" class="inline-flex items-center justify-center bg-gray-50 text-blue-600 font-bold rounded-xl px-5 py-2.5 hover:bg-blue-600 hover:text-white transition-all duration-300">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Không tìm thấy kết quả</h3>
                <p class="text-gray-500 mb-6">Thử thay đổi từ khóa hoặc bộ lọc để tìm kiếm lại nhé.</p>
                <a href="{{ route('search') }}" class="inline-block bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold px-6 py-2 rounded-lg transition">Xóa bộ lọc</a>
            </div>
        @endforelse
    </div>

    <!-- Phân trang -->
    @if($results->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $results->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
