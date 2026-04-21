@extends('layouts.app')

@section('title', 'Đơn hàng #' . $booking->transaction_code . ' - Tour Manager')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('customer_info'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $errors->first('customer_info') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-sm text-gray-500 mb-1">Mã giao dịch</p>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">#{{ $booking->transaction_code }}</h1>
        </div>
        <a href="{{ route('bookings.history') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Lịch sử đặt tour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-700 mb-5">Trạng thái đơn hàng</h2>
        @php
            $steps = [
                ['label' => 'Đặt chỗ', 'done' => true],
                ['label' => 'Chờ xác nhận', 'done' => in_array($booking->status, ['confirmed', 'completed'])],
                ['label' => 'Đã thanh toán', 'done' => $booking->payment_status === 'paid'],
            ];
            $isCancelled = $booking->status === 'cancelled';
        @endphp

        @if($isCancelled)
            <div class="flex items-center gap-3 bg-red-50 text-red-700 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0"/></svg>
                <div>
                    <p class="font-semibold">Đơn hàng đã bị hủy</p>
                    @if($booking->cancelled_reason)
                        <p class="text-sm">Lý do: {{ $booking->cancelled_reason }}</p>
                    @endif
                </div>
            </div>
        @else
            <div class="flex items-center gap-0">
                @foreach($steps as $i => $step)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $step['done'] ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400' }} transition-all text-sm font-bold">
                            {{ $i + 1 }}
                        </div>
                        <p class="text-xs font-medium mt-2 text-center {{ $step['done'] ? 'text-blue-600' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                    </div>
                    @if($i < count($steps) - 1)
                        <div class="flex-1 h-0.5 mx-1 mt-[-22px] {{ $step['done'] ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-700 mb-4">Thông tin tour</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tour</span>
                    <span class="font-semibold text-gray-900 text-right max-w-[60%]">{{ $booking->product->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ngày khởi hành</span>
                    <span class="font-medium">{{ $booking->departure ? \Carbon\Carbon::parse($booking->departure->departure_date)->format('d/m/Y') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Số người</span>
                    <span class="font-medium">{{ $booking->quantity }} người</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Đơn giá</span>
                    <span class="font-medium">{{ number_format($booking->unit_price, 0, ',', '.') }}đ / người</span>
                </div>
                <hr class="border-gray-100">
                <div class="flex justify-between text-base font-bold">
                    <span class="text-gray-700">Tổng tiền</span>
                    <span class="{{ $booking->discount_amount > 0 ? 'text-gray-400 line-through text-sm font-normal' : 'text-blue-600' }}">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                </div>
                @if($booking->discount_amount > 0)
                    <div class="flex justify-between text-sm text-green-600 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            Voucher {{ $booking->voucher?->code }}
                        </span>
                        <span class="font-semibold">-{{ number_format($booking->discount_amount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="flex justify-between text-base font-bold mt-1">
                        <span class="text-gray-700">Thành tiền</span>
                        <span class="text-blue-600">{{ number_format($booking->finalPrice(), 0, ',', '.') }}đ</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-semibold text-gray-700 mb-4">Thanh toán</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Phương thức</span>
                    <span class="font-medium">{{ $booking->paymentMethodLabel() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Trạng thái TT</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{
                        match($booking->payment_status) {
                            'paid' => 'bg-green-100 text-green-800',
                            'waiting_verify' => 'bg-yellow-100 text-yellow-800',
                            'refund_pending' => 'bg-orange-100 text-orange-800',
                            'refunded' => 'bg-blue-100 text-blue-800',
                            default => 'bg-gray-100 text-gray-600'
                        }
                    }}">{{ $booking->paymentStatusLabel() }}</span>
                </div>
                @if($booking->payment_proof)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ảnh CK</span>
                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-medium">Xem ảnh →</a>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Ngày đặt</span>
                    <span>{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($booking->note)
                    <div>
                        <p class="text-gray-500 mb-1">Ghi chú</p>
                        <p class="text-gray-700 text-xs bg-gray-50 p-2 rounded-lg">{{ $booking->note }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Form nhập thông tin khách hàng trước khi tính tiền --}}
    @if($booking->isPayable())
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 mb-6 border-l-4 border-l-blue-500">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                Thông tin người liên hệ / Đại diện
                <span class="text-[10px] uppercase font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">Bắt buộc</span>
            </h2>
            <form action="{{ route('bookings.update_info', $booking->id) }}" method="POST" id="customerInfoForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                        <input type="text" name="customer_name" id="c_name" value="{{ old('customer_name', $booking->customer_name ?? $booking->user->name) }}" required class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-3 border shadow-sm transition">
                        @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email liên hệ *</label>
                        <input type="email" name="customer_email" id="c_email" value="{{ old('customer_email', $booking->customer_email ?? $booking->user->email) }}" required class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-3 border shadow-sm transition">
                        @error('customer_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                        <input type="text" name="customer_phone" id="c_phone" value="{{ old('customer_phone', $booking->customer_phone ?? $booking->user->phone) }}" required class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-3 border shadow-sm transition">
                        @error('customer_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tuổi (tùy chọn)</label>
                        <input type="number" name="customer_age" value="{{ old('customer_age', $booking->customer_age) }}" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-3 border shadow-sm transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú thêm</label>
                    <textarea name="note" rows="2" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 px-3 border shadow-sm transition">{{ old('note', $booking->note) }}</textarea>
                </div>
                
                <div class="mt-5 flex justify-end">
                    <button type="submit" id="btnContinuePayment" disabled class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed transition-all duration-300">
                        Tiếp tục Thanh toán
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    @else
        @if($booking->customer_name)
        <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-200 p-5 mb-6">
            <h2 class="text-sm font-bold text-gray-700 mb-3">Thông tin người đại diện</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div><span class="text-gray-500 block text-xs">Họ tên</span> <strong>{{ $booking->customer_name }}</strong></div>
                <div><span class="text-gray-500 block text-xs">SĐT</span> <strong>{{ $booking->customer_phone }}</strong></div>
                <div><span class="text-gray-500 block text-xs">Email</span> {{ $booking->customer_email }}</div>
                <div><span class="text-gray-500 block text-xs">Tuổi</span> {{ $booking->customer_age ?? 'N/A' }}</div>
            </div>
        </div>
        @endif
    @endif

    <div class="flex flex-wrap gap-3">

        {{-- Thông báo đang chờ duyệt --}}
        @if($booking->payment_status === 'waiting_verify')
            <div class="inline-flex items-center gap-2 px-5 py-3 bg-yellow-50 border border-yellow-200 text-yellow-700 font-medium rounded-xl text-sm">
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Đang chờ Admin xác nhận thanh toán
            </div>
        @endif

        {{-- Upload ảnh CK (khi đã chọn bank_transfer) --}}
        @if($booking->canUploadProof())
            <form action="{{ route('bookings.proof', $booking->id) }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                @csrf
                <label class="cursor-pointer px-5 py-3 border-2 border-dashed border-gray-300 hover:border-blue-400 text-gray-600 font-medium rounded-xl transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ $booking->payment_proof ? 'Cập nhật ảnh CK' : 'Upload ảnh chuyển khoản' }}
                    <input type="file" name="payment_proof" class="hidden" accept="image/*" onchange="this.closest('form').submit()">
                </label>
            </form>
        @endif

        {{-- Thông báo COD --}}
        @if($booking->payment_method === 'cod' && $booking->payment_status === 'unpaid')
            <div class="inline-flex items-center gap-2 px-5 py-3 bg-gray-50 border border-gray-200 text-gray-600 font-medium rounded-xl text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Thanh toán khi đón — chờ Admin xác nhận
            </div>
        @endif

        {{-- Khi đã thanh toán hoặc hoàn thành -> Hiện PDF & Zalo --}}
        @if($booking->payment_status === 'paid' || $booking->status === 'completed')
            <a href="{{ route('bookings.voucher', $booking->id) }}"
               class="inline-flex items-center gap-2 px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl shadow-sm transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Tải hóa đơn (PDF)
            </a>

            <a href="https://zalo.me/0123456789" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-3 bg-blue-50 border border-blue-200 text-blue-700 hover:bg-blue-100 font-medium rounded-xl transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Liên hệ Zalo hỗ trợ
            </a>
        @endif

        @if($booking->isClientCancellable())
            <button onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-5 py-3 border border-red-300 text-red-600 hover:bg-red-50 font-medium rounded-xl transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Hủy đơn
            </button>
        @endif
    </div>

    @if($booking->isClientCancellable())
        <div id="cancelModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Xác nhận hủy đơn?</h3>
                <p class="text-sm text-gray-500 mb-5">Bạn có chắc muốn hủy đơn <strong>#{{ $booking->transaction_code }}</strong>? Hành động này không thể hoàn tác.</p>
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                    @csrf
                    <textarea name="cancelled_reason" rows="2" placeholder="Lý do hủy (tùy chọn)"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-red-300"></textarea>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 rounded-xl font-medium hover:bg-gray-50 transition text-sm">
                            Quay lại
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition text-sm">
                            Xác nhận hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('customerInfoForm');
        if (!form) return;
        
        const btn = document.getElementById('btnContinuePayment');
        const inputs = [
            document.getElementById('c_name'), 
            document.getElementById('c_email'), 
            document.getElementById('c_phone')
        ];

        function checkForm() {
            let isValid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                }
            });
            btn.disabled = !isValid;
        }

        inputs.forEach(input => {
            input.addEventListener('input', checkForm);
        });
        
        // Initial check in case browser auto-fills
        checkForm();
    });
</script>
@endpush
