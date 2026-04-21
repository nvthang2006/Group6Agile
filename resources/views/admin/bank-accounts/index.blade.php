@extends('layouts.admin')

@section('title', 'Quản lý Tài khoản Ngân hàng')
@section('page_heading', 'Tài khoản Ngân hàng')

@section('breadcrumb')
    <li class="breadcrumb-item active">Tài khoản Ngân hàng</li>
@endsection

@section('content')
<div class="row">

    {{-- Form thêm mới --}}
    <div class="col-lg-5">
        <div class="widget-content-area mb-4">
            <h6 class="fw-bold mb-4">Thêm Tài khoản Mới</h6>
            <form action="{{ route('admin.bank-accounts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên ngân hàng <span class="text-danger">*</span></label>
                    <input type="text" name="bank_name" class="form-control" placeholder="Vd: Vietcombank, MB Bank" required value="{{ old('bank_name') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số tài khoản <span class="text-danger">*</span></label>
                    <input type="text" name="account_number" class="form-control" placeholder="Nhập số tài khoản" required value="{{ old('account_number') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên chủ tài khoản <span class="text-danger">*</span></label>
                    <input type="text" name="account_name" class="form-control" placeholder="Nhập tên chủ tài khoản" required value="{{ old('account_name') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Chi nhánh</label>
                    <input type="text" name="branch" class="form-control" placeholder="Vd: Hà Nội" value="{{ old('branch') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ảnh QR thanh toán</label>
                    <input type="file" name="qr_code" class="form-control" accept="image/*">
                    <small class="text-muted">JPG, PNG, WebP. Tối đa 2MB.</small>
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                        <label class="form-check-label fw-semibold" for="isActive">Kích hoạt</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    Thêm Tài khoản
                </button>
            </form>
        </div>
    </div>

    {{-- Danh sách tài khoản --}}
    <div class="col-lg-7">
        <div class="widget-content-area">
            <h6 class="fw-bold mb-4">Danh sách Tài khoản</h6>

            @if($accounts->isEmpty())
                <div class="text-center py-5 text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" class="mb-3 opacity-25" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <p>Chưa có tài khoản nào.</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($accounts as $account)
                        <div class="border rounded-3 p-4 {{ $account->is_active ? ($account->is_primary ? 'border-success border-2' : 'border-primary') : 'border-danger opacity-75' }}">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0">{{ $account->bank_name }}</h6>
                                        @if($account->is_primary)
                                            <span class="badge bg-success small">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                TK Chính
                                            </span>
                                        @endif
                                        <span class="badge {{ $account->is_active ? 'bg-primary' : 'bg-danger' }} small">
                                            {{ $account->is_active ? 'Đang dùng' : 'Tắt' }}
                                        </span>
                                    </div>
                                    <p class="mb-1 small"><span class="text-muted">STK:</span> <strong>{{ $account->account_number }}</strong></p>
                                    <p class="mb-1 small"><span class="text-muted">Chủ TK:</span> {{ $account->account_name }}</p>
                                    @if($account->branch)
                                        <p class="mb-0 small text-muted">{{ $account->branch }}</p>
                                    @endif
                                </div>
                                @if($account->qr_code)
                                    <img src="{{ asset('storage/' . $account->qr_code) }}" alt="QR" class="rounded-2 border" style="width:80px;height:80px;object-fit:contain;">
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-2 mt-3 pt-3 border-top">
                                @if(!$account->is_primary && $account->is_active)
                                    <form action="{{ route('admin.bank-accounts.set-primary', $account->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            Chọn làm TK chính
                                        </button>
                                    </form>
                                @endif
                                <button class="btn btn-sm btn-outline-primary fw-semibold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $account->id }}">
                                    Sửa
                                </button>
                                <form action="{{ route('admin.bank-accounts.destroy', $account->id) }}" method="POST"
                                      onsubmit="return confirm('Xóa tài khoản {{ $account->bank_name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold">Xóa</button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $account->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-3">
                                    <form action="{{ route('admin.bank-accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Sửa Tài khoản</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tên ngân hàng</label>
                                                <input type="text" name="bank_name" class="form-control" value="{{ $account->bank_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Số tài khoản</label>
                                                <input type="text" name="account_number" class="form-control" value="{{ $account->account_number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tên chủ tài khoản</label>
                                                <input type="text" name="account_name" class="form-control" value="{{ $account->account_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Chi nhánh</label>
                                                <input type="text" name="branch" class="form-control" value="{{ $account->branch }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Thay ảnh QR</label>
                                                <input type="file" name="qr_code" class="form-control" accept="image/*">
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="ia{{ $account->id }}" value="1" {{ $account->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ia{{ $account->id }}">Kích hoạt</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-4">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
