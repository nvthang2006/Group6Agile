@extends('layouts.admin')

@section('title', 'Sửa Voucher')
@section('page_heading', 'Sửa Voucher: ' . $voucher->code)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
    <li class="breadcrumb-item active">Sửa</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="widget-content-area">
            <h6 class="fw-bold mb-4">Chỉnh sửa Voucher</h6>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err) <p class="mb-0">{{ $err }}</p> @endforeach
                </div>
            @endif

            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.vouchers._form', ['voucher' => $voucher])
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary fw-semibold px-5">Lưu thay đổi</button>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
