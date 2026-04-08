@extends('layouts.admin')

@section('title', 'Sửa tài khoản - Tour Manager')
@section('page_heading', 'Tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Chỉnh sửa tài khoản</h3>
                    <p class="text-muted mb-0">Cập nhật thông tin của: <strong>{{ $user->name }}</strong>.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.users._form', ['user' => $user])
        </div>
    </div>
@endsection
