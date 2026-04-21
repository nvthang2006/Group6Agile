@extends('layouts.app')

@section('title', 'Tin tức & Bài viết - Tour Manager')

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
                    <span class="text-gray-900 font-medium">Tin tức</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Tin tức & Bài viết</h1>
        <p class="text-lg text-gray-600 max-w-2xl">Khám phá những câu chuyện du lịch, cẩm nang và tin tức mới nhất từ chúng tôi.</p>
    </div>

    <form action="{{ route('posts.index') }}" method="GET" class="mb-10 flex gap-3">
        <div class="relative flex-grow max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Tìm bài viết..." class="w-full rounded-xl border border-gray-300 pl-10 pr-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
        </div>
        <button class="rounded-xl bg-blue-600 px-6 py-3 font-bold text-white hover:bg-blue-700 shadow-sm transition">
            Tìm kiếm
        </button>
    </form>

    <!-- Post Grid -->
    @if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
        @foreach($posts as $p)
        <article class="bg-white rounded-2xl flex flex-col overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group border border-gray-100">
            <a href="{{ route('posts.detail', $p->slug) }}" class="block aspect-[16/10] bg-gray-100 overflow-hidden relative">
                @if($p->image_url)
                    <img src="{{ $p->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                        <svg class="w-12 h-12 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-bold text-blue-600 uppercase tracking-wider shadow-sm">Blog</span>
                </div>
            </a>
            <div class="p-6 flex flex-col flex-grow">
                <div class="text-xs text-gray-500 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $p->created_at->format('d/m/Y') }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 line-clamp-2 mb-4 group-hover:text-blue-600 transition-colors leading-snug">
                    <a href="{{ route('posts.detail', $p->slug) }}">{{ $p->title }}</a>
                </h3>
                <div class="mt-auto pt-5 border-t border-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-600 uppercase">
                            {{ substr($p->user->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-xs text-gray-600 font-medium">{{ $p->user->name ?? 'Admin' }}</span>
                    </div>
                    <a href="{{ route('posts.detail', $p->slug) }}" class="text-sm text-blue-600 font-bold hover:text-blue-800 transition flex items-center gap-1 group">
                        Đọc tiếp
                        <svg class="w-4 h-4 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-12">
        {{ $posts->links() }}
    </div>
    @else
    <div class="text-center py-24 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900">Chưa có bài viết nào</h3>
        <p class="mt-2 text-gray-500">Hãy quay lại sau để cập nhật những tin tức mới nhất từ chúng tôi.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition shadow-md">
            Về trang chủ
        </a>
    </div>
    @endif
</div>
@endsection
