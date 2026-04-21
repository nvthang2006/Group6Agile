@extends('layouts.admin')

@section('title', 'Thùng rác Bài viết - Tour Manager')

@section('page_heading', 'Thùng rác Bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thành phần đã xóa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0 text-danger">Bài Viết Đã Xóa</h3>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    Quay lại danh sách
                </a>
            </div>

            <table id="trash-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Ngày Xóa</th>
                        <th class="no-content">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Khôi phục
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.posts.force-delete', $post->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn bài viết này?')">
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
                            <td colspan="4" class="text-center">Thùng rác trống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
