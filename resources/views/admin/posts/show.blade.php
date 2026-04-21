@extends('layouts.admin')

@section('title', 'Chi tiết Bài viết - Tour Manager')

@section('page_heading', 'Chi tiết Bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 20) }}</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Xem trước bài viết</h3>
                <div>
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">Sửa</a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>

            <div class="card mb-4">
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" class="card-img-top" style="max-height: 400px; object-fit: cover;" alt="{{ $post->title }}">
                @endif
                <div class="card-body">
                    <h1 class="card-title text-primary">{{ $post->title }}</h1>
                    <div class="mb-3">
                        <span class="badge badge-light-info">Tác giả: {{ $post->user->name ?? 'Ẩn danh' }}</span>
                        <span class="badge badge-light-secondary ms-2">Ngày đăng: {{ $post->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <hr>
                    <div class="post-content mt-4 prose max-w-none">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
