@extends('layouts.admin')

@section('title', 'Chi tiết Tài khoản - Tour Manager')

@section('page_heading', 'Chi tiết Tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Thông tin Tài khoản</h3>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Sửa</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID Người dùng</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Họ tên</th>
                        <td><strong>{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Vai trò</th>
                        <td>
                            @if($user->role == 1)
                                <span class="badge badge-danger">Administrator</span>
                            @else
                                <span class="badge badge-primary">Khách hàng</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tham gia</th>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            @if($user->role != 1)
                <div class="mt-4 alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Tài khoản khách hàng có thể đặt tour và viết đánh giá.
                </div>
            @endif
        </div>
    </div>
@endsection
