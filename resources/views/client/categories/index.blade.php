@extends('layouts.app')

@section('title', 'Danh mục tour')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Danh mục tour</h1>
            <p class="text-gray-500 mt-2">Tìm kiếm và chọn danh mục phù hợp.</p>
        </div>
        <form action="{{ route('client.categories.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Tìm danh mục..." class="w-64 rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            <button class="rounded-xl bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">Tìm</button>
        </form>
    </div>

    @if($categories->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900">{{ $category->name }}</h2>
                    <p class="mt-2 text-sm text-gray-500">{{ $category->description ?: 'Chưa có mô tả.' }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-semibold text-blue-600">{{ $category->products_count }} tour</span>
                        <a href="{{ route('search', ['category' => $category->id]) }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600">Xem tour</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-500">Không tìm thấy danh mục phù hợp.</div>
    @endif
</div>
@endsection
