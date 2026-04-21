@extends('layouts.admin')

@section('title', 'Chi tiết Danh mục - Tour Manager')

@section('page_heading', 'Chi tiết Danh mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Thông tin Danh mục</h3>
                <div>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <th>Tên Danh mục</th>
                        <td><strong>{{ $category->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $category->description ?? 'Không có mô tả' }}</td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Cập nhật cuối</th>
                        <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <h4 class="mt-5 mb-3">Sản phẩm thuộc danh mục này ({{ $category->products->count() }})</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price) }}đ</td>
                            <td>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info text-white">Xem</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
