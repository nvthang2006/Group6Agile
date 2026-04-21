@extends('layouts.admin')

@section('title', 'Quản lý Đặt Tour - Tour Manager')

@section('page_heading', 'Đặt Tour')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Đặt Tour</li>
@endsection

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
@endsection

@section('content')
    {{-- Thống kê nhanh --}}
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="widget-content-area text-center py-3">
                <p class="fw-bold fs-4 text-warning mb-1">{{ $stats['pending'] }}</p>
                <p class="text-muted small mb-0">Chờ xác nhận</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="widget-content-area text-center py-3">
                <p class="fw-bold fs-4 text-info mb-1">{{ $stats['waiting_verify'] }}</p>
                <p class="text-muted small mb-0">Chờ duyệt TT</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="widget-content-area text-center py-3">
                <p class="fw-bold fs-4 text-success mb-1">{{ $stats['confirmed'] }}</p>
                <p class="text-muted small mb-0">Đã xác nhận</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="widget-content-area text-center py-3">
                <p class="fw-bold fs-4 text-primary mb-1">{{ number_format($stats['revenue'] / 1000000, 1) }}M</p>
                <p class="text-muted small mb-0">Doanh thu (đã TT)</p>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3 flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">Danh sách đơn đặt tour</h5>
                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-primary btn-sm fw-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Quản lý TK Ngân hàng
                </a>
            </div>

            {{-- Filter Panel --}}
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2 mb-4 align-items-end">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label small fw-semibold">Trạng thái đơn</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label small fw-semibold">Thanh toán</label>
                    <select name="payment_status" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Chưa TT</option>
                        <option value="waiting_verify" {{ request('payment_status') === 'waiting_verify' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="refund_pending" {{ request('payment_status') === 'refund_pending' ? 'selected' : '' }}>Chờ hoàn tiền</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Đã TT</option>
                        <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold">Từ ngày</label>
                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold">Đến ngày</label>
                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                </div>
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold flex-1">Lọc</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm fw-semibold">Reset</a>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success mx-0 alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mx-0">{{ $errors->first() }}</div>
            @endif

            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Mã giao dịch</th>
                        <th>Khách hàng</th>
                        <th>Tour</th>
                        <th>Ngày đi</th>
                        <th>Tổng tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="no-content text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="fw-bold text-primary">
                                    {{ $booking->transaction_code ?? '#' . $booking->id }}
                                </a>
                                <small class="d-block text-muted">{{ $booking->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $booking->user->name ?? 'User Deleted' }}</div>
                                <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold" style="max-width: 180px;">{{ $booking->product->name ?? 'Tour Deleted' }}</div>
                                <small class="text-muted">{{ $booking->quantity }} người</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->departure->departure_date ?? $booking->booking_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                <strong class="text-primary">{{ number_format($booking->total_price, 0, ',', '.') }}đ</strong>
                            </td>
                            <td class="text-center">
                                @if($booking->status == 'cancelled')
                                    <span class="badge badge-light-danger">Đã hủy</span>
                                @elseif($booking->payment_status == 'refunded')
                                    <span class="badge badge-light-info">Hoàn tiền</span>
                                @elseif($booking->payment_status == 'paid')
                                    <span class="badge badge-light-success">Đã thanh toán</span>
                                @elseif($booking->payment_status == 'waiting_verify' || $booking->payment_status == 'refund_pending')
                                    <span class="badge badge-light-warning">Đợi kiểm tra</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-light-success">Đã xác nhận</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge badge-light-primary">Hoàn thành</span>
                                @else
                                    <span class="badge badge-light-secondary">Chờ xử lý</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                   class="btn btn-sm btn-outline-primary fw-semibold">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Không có đơn đặt tour nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{ asset('cork/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Hiển thị trang _PAGE_ / _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Tìm kiếm...",
            "sLengthMenu": "Hiển thị: _MENU_",
        },
        "order": [],
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10
        });
    </script>
@endsection
