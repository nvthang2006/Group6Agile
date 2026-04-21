@extends('layouts.app')

@section('title', $post->title . ' - Tour Manager')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('home') }}#tin-tuc" class="hover:text-blue-600 transition">Tin tức</a>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Post Header -->
    <header class="mb-10 text-center">
        <div class="text-blue-600 font-semibold mb-4">{{ $post->created_at->format('d/m/Y') }}</div>
        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">{{ $post->title }}</h1>
        <div class="flex items-center justify-center gap-4 text-gray-500 text-sm">
            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $post->user->name ?? 'Admin' }}</span>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->image_url)
    <div class="w-full aspect-[16/9] md:aspect-[21/9] rounded-3xl overflow-hidden mb-12 shadow-sm bg-gray-100">
        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    <!-- Content -->
    <article class="prose prose-lg prose-blue max-w-none text-gray-700 leading-loose prose-img:rounded-2xl mx-auto">
        {!! $post->content !!}
    </article>

    <!-- Share & Tags (Mockup) -->
    <div class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">#DuLich</span>
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">#TraiNghiem</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-gray-500 font-medium text-sm">Chia sẻ:</span>
            <button class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></button>
        </div>
    </div>
</div>

<!-- Recent Posts Section -->
@if($recentPosts->count() > 0)
<div class="bg-gray-50 py-16 mt-16 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Có thể bạn quan tâm</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($recentPosts as $p)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">
                    <a href="{{ route('posts.detail', $p->slug) }}" class="block aspect-[16/10] bg-gray-100 overflow-hidden">
                            @if($p->image_url)
                                <img src="{{ $p->image_url }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                        @endif
                    </a>
                    <div class="p-5">
                        <div class="text-xs text-blue-600 font-bold mb-2">{{ $p->created_at->format('d/m/Y') }}</div>
                        <h3 class="font-bold text-gray-900 line-clamp-2">
                            <a href="{{ route('posts.detail', $p->slug) }}" class="hover:text-blue-600 transition-colors">{{ $p->title }}</a>
                        </h3>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
