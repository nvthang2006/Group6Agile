@extends('layouts.admin')

@section('title', 'Thêm danh mục - Tour Manager')
@section('page_heading', 'Danh mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Thêm danh mục mới</h3>
                    <p class="text-muted mb-0">Nhập tên và mô tả để tạo một nhóm sản phẩm rõ ràng hơn.</p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.categories._form')
        </div>
    </div>
@endsection
