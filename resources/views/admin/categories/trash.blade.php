@extends('layouts.admin')

@section('title', 'Thùng rác Danh mục - Tour Manager')

@section('page_heading', 'Thùng rác Danh mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thành phần đã xóa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0 text-danger">Danh Mục Đã Xóa</h3>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Quay lại danh sách
                </a>
            </div>

            <table id="trash-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Ngày Xóa</th>
                        <th class="no-content">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('categories.restore', $category->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Khôi phục">
                                            Khôi phục
                                        </button>
                                    </form>
                                    <form action="{{ route('categories.force-delete', $category->id) }}" method="POST" onsubmit="return confirm('CẢNH BÁO: Hành động này không thể hoàn tác. Bạn có chắc muốn xóa vĩnh viễn?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa vĩnh viễn">
                                            Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Thùng rác trống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
