@extends('layouts.admin')

@section('title', 'Thêm bài viết - Tour Manager')
@section('page_heading', 'Bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Đăng bài viết mới</h3>
                    <p class="text-muted mb-0">Tiêu đề và slug sẽ được đồng bộ tự động khi lưu.</p>
                </div>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.posts._form')
        </div>
    </div>
@endsection
