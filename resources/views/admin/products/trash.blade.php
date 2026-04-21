@extends('layouts.admin')

@section('title', 'Thùng rác Sản phẩm - Tour Manager')

@section('page_heading', 'Thùng rác Sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thành phần đã xóa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0 text-danger">Sản Phẩm Đã Xóa</h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Quay lại danh sách
                </a>
            </div>

            <table id="trash-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Tour</th>
                        <th>Danh mục</th>
                        <th>Ngày Xóa</th>
                        <th class="no-content">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Khôi phục
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Thùng rác trống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
