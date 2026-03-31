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
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <h3 class="mb-0">Báo cáo Đơn đặt Tour</h3>
            </div>

            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách hàng</th>
                        <th>Tên Tour</th>
                        <th>Ngày Đi & Số Người</th>
                        <th>Tổng Tiền</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="no-content text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            <td>
                                <div class="fw-bold">{{ $booking->user->name ?? 'User Deleted' }}</div>
                                <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold" style="max-width: 200px;">{{ $booking->product->name ?? 'Tour Deleted' }}</div>
                                @if($booking->note)
                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;" title="{{ $booking->note }}">Ghi chú: {{ $booking->note }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $booking->quantity }} người</small>
                            </td>
                            <td>
                                <strong class="text-primary">{{ number_format($booking->total_price, 0, ',', '.') }}đ</strong>
                            </td>
                            <td class="text-center">
                                @if($booking->status == 'pending')
                                    <span class="badge badge-light-warning">Chờ Duyệt</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-light-success">Đã Xác Nhận</span>
                                @else
                                    <span class="badge badge-light-danger">Đã Hủy</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm" style="width: auto; display: inline-block; font-size: 12px;" onchange="this.form.submit()">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Chờ duyệt</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>✅ Xác nhận</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌ Hủy bỏ</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox mb-2 text-muted"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                                <p class="text-muted mb-0">Không có đơn đặt tour nào trong hệ thống lúc này.</p>
                            </td>
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
               "sLengthMenu": "Hiển thị :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        });
    </script>
@endsection
