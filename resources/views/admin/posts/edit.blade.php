@extends('layouts.admin')

@section('title', 'Sửa bài viết - Tour Manager')
@section('page_heading', 'Bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Chỉnh sửa bài viết</h3>
                    <p class="text-muted mb-0">Cập nhật nội dung cho bài viết: <strong>{{ $post->title }}</strong>.</p>
                </div>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.posts._form', ['post' => $post])
        </div>
    </div>
@endsection
