@extends('layouts.admin')

@section('title', 'Chi tiết đơn #' . $booking->transaction_code)
@section('page_heading', 'Chi tiết Đơn hàng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Đặt tour</a></li>
    <li class="breadcrumb-item active">#{{ $booking->transaction_code }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Thông tin đơn hàng --}}
    <div class="col-lg-8">

        {{-- Mã giao dịch & Trạng thái --}}
        <div class="widget-content-area mb-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <p class="text-muted mb-1 small">Mã giao dịch</p>
                    <h4 class="fw-bold mb-0">#{{ $booking->transaction_code }}</h4>
                </div>
                <div class="text-end">
                    @if($booking->status == 'cancelled')
                        <span class="badge bg-danger fs-6 px-3 py-2">Đã hủy</span>
                    @elseif($booking->payment_status == 'refunded')
                        <span class="badge bg-info fs-6 px-3 py-2">Hoàn tiền</span>
                    @elseif($booking->payment_status == 'paid')
                        <span class="badge bg-success fs-6 px-3 py-2">Đã thanh toán</span>
                    @elseif($booking->payment_status == 'waiting_verify' || $booking->payment_status == 'refund_pending')
                        <span class="badge bg-warning fs-6 px-3 py-2">Đợi kiểm tra</span>
                    @elseif($booking->status == 'confirmed')
                        <span class="badge bg-success fs-6 px-3 py-2">Đã xác nhận</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2">Chờ xử lý</span>
                    @endif
                </div>
            </div>

            {{-- Timeline --}}
            <div class="d-flex align-items-center gap-0 mb-2 overflow-auto">
                @php
                    $steps = [
                        ['label' => 'Đặt chỗ', 'done' => true],
                        ['label' => 'Chờ xác nhận', 'done' => in_array($booking->status, ['confirmed', 'completed'])],
                        ['label' => 'Đã thanh toán', 'done' => $booking->payment_status === 'paid'],
                    ];
                @endphp
                @if($booking->status === 'cancelled')
                    <div class="alert alert-danger py-2 px-3 w-100 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-times-circle"></i>
                        <div>
                            <strong>Đơn hàng đã hủy</strong>
                            @if($booking->cancelled_reason)
                                <br><small>Lý do: {{ $booking->cancelled_reason }}</small>
                            @endif
                        </div>
                    </div>
                @else
                    @foreach($steps as $i => $step)
                        <div class="text-center" style="flex:1;min-width:80px;">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold small"
                                 style="width:36px;height:36px;background:{{ $step['done'] ? '#4361ee' : '#e2e8f0' }};color:{{ $step['done'] ? '#fff' : '#94a3b8' }}">
                                {{ $i + 1 }}
                            </div>
                            <p class="small mt-1 mb-0 {{ $step['done'] ? 'fw-semibold text-primary' : 'text-muted' }}">{{ $step['label'] }}</p>
                        </div>
                        @if($i < count($steps) - 1)
                            <div style="flex:1;height:2px;background:{{ $step['done'] ? '#4361ee' : '#e2e8f0' }};margin-top:-18px;"></div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Chi tiết tour --}}
        <div class="widget-content-area mb-4">
            <h6 class="fw-bold mb-3">Thông tin Tour</h6>
            <table class="table table-sm">
                <tr><td class="text-muted w-40">Tour</td><td class="fw-semibold">{{ $booking->product->name ?? 'N/A' }}</td></tr>
                <tr><td class="text-muted">Ngày khởi hành</td><td>{{ $booking->departure ? \Carbon\Carbon::parse($booking->departure->departure_date)->format('d/m/Y') : 'N/A' }}</td></tr>
                <tr><td class="text-muted">Số người</td><td>{{ $booking->quantity }} người</td></tr>
                <tr><td class="text-muted">Đơn giá</td><td>{{ number_format($booking->unit_price, 0, ',', '.') }}đ / người</td></tr>
                <tr><td class="text-muted fw-semibold">Tổng tiền</td><td class="fw-bold text-primary fs-5">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td></tr>
                @if($booking->note)
                    <tr><td class="text-muted">Ghi chú</td><td class="fst-italic">{{ $booking->note }}</td></tr>
                @endif
            </table>
        </div>

        {{-- Thanh toán --}}
        <div class="widget-content-area mb-4">
            <h6 class="fw-bold mb-3">Thông tin Thanh toán</h6>
            <table class="table table-sm">
                <tr><td class="text-muted w-40">Phương thức</td><td>{{ $booking->paymentMethodLabel() }}</td></tr>

                @if($booking->payment_method === 'bank_transfer')
                    <tr>
                        <td class="text-muted">Nội dung CK cần kiểm tra</td>
                        <td>
                            <code class="bg-light text-primary fw-bold px-2 py-1 rounded-2 d-inline-block" style="word-break:break-all; font-size: 0.85rem;">{{ $booking->transfer_content }}</code>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Số tiền cần nhận</td>
                        <td class="fw-bold text-success">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
                    </tr>
                @endif
                @if($booking->confirmed_at)
                    <tr><td class="text-muted">Xác nhận lúc</td><td>{{ $booking->confirmed_at->format('d/m/Y H:i') }}</td></tr>
                @endif
                @if($booking->paid_at)
                    <tr><td class="text-muted">Thanh toán lúc</td><td>{{ $booking->paid_at->format('d/m/Y H:i') }}</td></tr>
                @endif
            </table>

            @if($booking->payment_proof)
                <div class="mt-3">
                    <p class="small fw-semibold text-muted mb-2">Ảnh xác nhận chuyển khoản:</p>
                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                             alt="Chứng minh thanh toán"
                             class="img-fluid rounded-3 border"
                             style="max-height:280px;object-fit:contain;">
                    </a>
                </div>
            @elseif($booking->payment_method === 'bank_transfer')
                <div class="alert alert-warning py-2 px-3 mt-3">
                    <small><i class="fas fa-exclamation-triangle me-1"></i> Khách chưa upload ảnh chuyển khoản.</small>
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar: Thông tin khách + Actions --}}
    <div class="col-lg-4">

        {{-- Thông tin khách --}}
        <div class="widget-content-area mb-4">
            <h6 class="fw-bold mb-3">Khách hàng</h6>
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->user->name ?? 'U') }}&background=4361ee&color=fff"
                     class="rounded-circle" width="48" height="48" alt="avatar">
                <div>
                    <p class="fw-bold mb-0">{{ $booking->user->name ?? 'N/A' }}</p>
                    <p class="text-muted small mb-0">{{ $booking->user->email ?? '' }}</p>
                </div>
            </div>
            <small class="text-muted">Đặt lúc: {{ $booking->created_at->format('d/m/Y H:i') }}</small>
        </div>

        {{-- Actions --}}
        @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
            <div class="widget-content-area mb-4">
                <h6 class="fw-bold mb-3">Hành động</h6>

                @if($booking->status !== 'confirmed')
                    <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 fw-semibold"
                            onclick="return confirm('Xác nhận đơn hàng #{{ $booking->transaction_code }} và đánh dấu đã thanh toán?')">
                            <svg class="feather feather-check-circle me-1" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Xác nhận & Đánh dấu Đã TT
                        </button>
                    </form>
                @endif

                <button type="button" class="btn btn-outline-danger w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <svg class="feather feather-x-circle me-1" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    Từ chối / Hủy đơn
                </button>
            </div>
        @endif

        {{-- Metadata --}}
        <div class="widget-content-area">
            <h6 class="fw-bold mb-3">Thông tin thêm</h6>
            <div class="small text-muted">
                <p class="mb-1"><span class="fw-semibold text-dark">ID đơn:</span> #{{ $booking->id }}</p>
                <p class="mb-1"><span class="fw-semibold text-dark">Ngày đặt:</span> {{ $booking->created_at->format('d/m/Y') }}</p>
                <p class="mb-0"><span class="fw-semibold text-dark">Cập nhật:</span> {{ $booking->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal từ chối --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3">
            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">Từ chối đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Vui lòng nhập lý do từ chối đơn <strong>#{{ $booking->transaction_code }}</strong>.</p>
                    <div class="form-group">
                        <label class="form-label fw-semibold">Lý do <span class="text-danger">*</span></label>
                        <textarea name="cancelled_reason" rows="3" class="form-control" required
                                  placeholder="Nhập lý do..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4">Xác nhận từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
