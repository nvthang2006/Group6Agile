@extends('layouts.admin')

@section('title', 'Thùng rác Tài khoản - Tour Manager')

@section('page_heading', 'Thùng rác Tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thành phần đã xóa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0 text-danger">Tài Khoản Đã Xóa</h3>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Quay lại danh sách
                </a>
            </div>

            <table id="trash-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Ngày Xóa</th>
                        <th class="no-content">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Khôi phục
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn tài khoản này?')">
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

            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
@endsection
