@extends('layouts.admin')

@section('title', 'Quản lý Voucher')
@section('page_heading', 'Quản lý Voucher')

@section('breadcrumb')
    <li class="breadcrumb-item active">Voucher</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="widget-content-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Danh sách Voucher giảm giá</h6>
                <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary fw-semibold">
                    + Tạo Voucher mới
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($vouchers->isEmpty())
                <div class="text-center py-5 text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" class="mb-3 opacity-25" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <p>Chưa có voucher nào.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Giảm giá</th>
                                <th>Đã dùng</th>
                                <th>Thời hạn</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vouchers as $voucher)
                                <tr>
                                    <td>
                                        <code class="fw-bold text-primary">{{ $voucher->code }}</code>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $voucher->name }}</span>
                                        @if($voucher->min_order > 0)
                                            <br><small class="text-muted">Đơn tối thiểu: {{ number_format($voucher->min_order, 0, ',', '.') }}đ</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $voucher->discountLabel() }}</span>
                                    </td>
                                    <td>
                                        {{ $voucher->used_count }}{{ $voucher->max_uses ? '/' . $voucher->max_uses : '' }}
                                    </td>
                                    <td class="small">
                                        @if($voucher->starts_at || $voucher->expires_at)
                                            {{ $voucher->starts_at?->format('d/m/Y') ?? '...' }}
                                            → {{ $voucher->expires_at?->format('d/m/Y') ?? '...' }}
                                        @else
                                            <span class="text-muted">Không giới hạn</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $status = $voucher->statusLabel(); @endphp
                                        <span class="badge {{ match($status) {
                                            'Đang hoạt động' => 'bg-success',
                                            'Đã tắt' => 'bg-secondary',
                                            'Đã hết lượt' => 'bg-warning text-dark',
                                            'Đã hết hạn' => 'bg-danger',
                                            'Chưa bắt đầu' => 'bg-info text-dark',
                                            default => 'bg-secondary'
                                        } }}">{{ $status }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Xóa voucher {{ $voucher->code }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $vouchers->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
