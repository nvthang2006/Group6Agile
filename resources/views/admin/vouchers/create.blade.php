@extends('layouts.admin')

@section('title', 'Tạo Voucher mới')
@section('page_heading', 'Tạo Voucher mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
    <li class="breadcrumb-item active">Tạo mới</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="widget-content-area">
            <h6 class="fw-bold mb-4">Thông tin Voucher</h6>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err) <p class="mb-0">{{ $err }}</p> @endforeach
                </div>
            @endif

            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf
                @include('admin.vouchers._form')
                <button type="submit" class="btn btn-primary fw-semibold px-5 mt-3">Tạo Voucher</button>
            </form>
        </div>
    </div>
</div>
@endsection
