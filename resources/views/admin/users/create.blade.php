@extends('layouts.admin')

@section('title', 'Thêm tài khoản - Tour Manager')
@section('page_heading', 'Tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h3 class="mb-1">Thêm tài khoản mới</h3>
                    <p class="text-muted mb-0">Tạo tài khoản admin hoặc user cho hệ thống.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>

            @include('admin.users._form')
        </div>
    </div>
@endsection
