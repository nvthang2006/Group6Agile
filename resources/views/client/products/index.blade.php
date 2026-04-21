@extends('layouts.app')

@section('title', 'Khám phá Tours - Tour Manager')
@section('meta_description', 'Khám phá bộ sưu tập hàng trăm tour du lịch đa dạng, phong phú. Lọc theo giá, danh mục và dễ dàng tìm được hành trình ưng ý nhất.')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition font-medium">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-slate-900 font-bold">Khám phá Tours</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header & Stats -->
    <div class="mb-8">
        <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-3 tracking-tight">Khám phá Tours</h1>
        <p class="text-slate-500 text-lg">Tìm kiếm và lựa chọn hành trình tuyệt vời tiếp theo của bạn trong số <span class="font-bold text-brand-600">{{ $products->total() }}</span> tours hiện có.</p>
    </div>

    <!-- Features / Filter Sidebar or Topbar -->
    <div class="bg-white p-5 md:p-6 rounded-3xl shadow-sm border border-slate-200 mb-10 relative z-20">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Danh mục Tour</label>
                <div class="relative">
                    <select name="category_id" id="category" class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-2xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all appearance-none">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Khoảng giá</label>
                <div class="relative">
                    <select name="price_range" id="price" class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-2xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all appearance-none">
                        <option value="">Mọi mức giá</option>
                        <option value="under_2m" {{ request('price_range') == 'under_2m' ? 'selected' : '' }}>Dưới 2.000.000đ</option>
                        <option value="2m_5m" {{ request('price_range') == '2m_5m' ? 'selected' : '' }}>2.000.000đ - 5.000.000đ</option>
                        <option value="over_5m" {{ request('price_range') == 'over_5m' ? 'selected' : '' }}>Trên 5.000.000đ</option>
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div>
                <label for="sort" class="block text-sm font-bold text-slate-700 mb-2">Sắp xếp theo</label>
                <div class="relative">
                    <select name="sort" id="sort" class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-2xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all appearance-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-brand-500 text-white font-bold rounded-2xl px-6 py-3 hover:from-brand-700 hover:to-brand-600 shadow-lg shadow-brand-500/30 transition duration-300 flex items-center justify-center gap-2 border border-brand-400/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Lọc kết quả
                </button>
            </div>
        </form>
    </div>

    <!-- Tours Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 mb-12">
        @foreach($products as $tour)
            <x-tour-card :tour="$tour" />
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center w-full overflow-x-auto pb-4">
        {{ $products->links() }}
    </div>

    @else
    <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Rất tiếc! Không tìm thấy Tour nào.</h3>
        <p class="text-lg text-slate-500 font-medium mb-8 max-w-lg mx-auto">Thử thay đổi bộ lọc hoặc tìm kiếm bằng từ khóa khác để xem hàng ngàn hành trình đang chờ đón.</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center bg-brand-50 border border-brand-200 text-brand-700 font-bold rounded-full px-8 py-3 hover:bg-brand-600 hover:text-white transition-all transition-colors duration-300 shadow-sm hover:shadow-lg hover:shadow-brand-500/30">
            Khóa Cài đặt Lọc
        </a>
    </div>
    @endif
</div>
@endsection
