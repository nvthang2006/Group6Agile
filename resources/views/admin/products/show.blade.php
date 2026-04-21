@extends('layouts.admin')

@section('title', 'Chi tiết Sản phẩm - Tour Manager')

@section('page_heading', 'Chi tiết Sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Thông tin Sản phẩm (Tour)</h3>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                    <a href="{{ route('admin.products.departures.index', $product->id) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Lịch khởi hành
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-center rounded" style="height: 200px;">
                            <span class="text-muted">Không có ảnh</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Tên Tour</th>
                            <td><strong>{{ $product->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td><span class="badge badge-light-primary">{{ $product->category->name ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <th>Giá gốc</th>
                            <td>{{ number_format($product->price) }} VNĐ</td>
                        </tr>
                        <tr>
                            <th>Giá khuyến mãi</th>
                            <td>
                                @if($product->sale_price)
                                    <strong class="text-danger">{{ number_format($product->sale_price) }} VNĐ</strong>
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $product->slug }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h5>Mô tả chi tiết:</h5>
                <div class="p-3 bg-light rounded border">
                    {!! nl2br(e(strip_tags($product->description))) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
