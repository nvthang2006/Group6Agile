@extends('layouts.app')

@section('title', 'Thanh toán đơn #' . $booking->transaction_code . ' - Tour Manager')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('bookings.show', $booking->id) }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại chi tiết đơn
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Thanh toán chuyển khoản</h1>
        <p class="text-gray-500 mt-1">Đơn hàng <strong class="text-gray-700">#{{ $booking->transaction_code }}</strong> — Tổng tiền: <strong class="text-blue-600" id="originalPrice">{{ number_format($booking->total_price, 0, ',', '.') }}đ</strong></p>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            @foreach($errors->all() as $err) <p>{{ $err }}</p> @endforeach
        </div>
    @endif

    <form action="{{ route('bookings.pay', $booking->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
        @csrf
        <input type="hidden" name="payment_method" value="bank_transfer">
        <input type="hidden" name="voucher_code" id="voucherCodeInput" value="">

        {{-- Nhập mã Voucher giảm giá --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Mã giảm giá (Voucher)
            </h3>
            <div class="flex gap-2">
                <input type="text" id="voucherInput" placeholder="Nhập mã voucher..."
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 uppercase tracking-widest font-bold"
                       value="{{ old('voucher_code') }}">
                <button type="button" id="applyVoucherBtn" onclick="applyVoucher()"
                        class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition text-sm">
                    Áp dụng
                </button>
            </div>
            {{-- Kết quả voucher --}}
            <div id="voucherResult" class="mt-3 hidden"></div>
        </div>

        {{-- Tóm tắt thanh toán --}}
        <div id="paymentSummary" class="hidden bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-5 mb-6">
            <h4 class="font-semibold text-green-800 text-sm mb-3">Chi tiết thanh toán</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tổng tiền gốc</span>
                    <span class="font-medium">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                </div>
                <div class="flex justify-between text-green-700">
                    <span>Giảm giá voucher</span>
                    <span class="font-bold" id="discountDisplay">-0đ</span>
                </div>
                <hr class="border-green-200">
                <div class="flex justify-between text-base font-bold">
                    <span class="text-gray-800">Thành tiền</span>
                    <span class="text-green-700" id="finalPriceDisplay">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        {{-- Thông tin tài khoản ngân hàng chính --}}
        @if($primaryBank)
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6 mb-6 shadow-lg">
                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider mb-1">Thông tin chuyển khoản</p>
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div>
                        <p class="text-blue-200 text-xs">Ngân hàng</p>
                        <p class="font-bold text-lg">{{ $primaryBank->bank_name }}</p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs">Số tài khoản</p>
                        <p class="font-bold text-lg tracking-widest">{{ $primaryBank->account_number }}</p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs">Chủ tài khoản</p>
                        <p class="font-semibold">{{ $primaryBank->account_name }}</p>
                    </div>
                    @if($primaryBank->branch)
                    <div>
                        <p class="text-blue-200 text-xs">Chi nhánh</p>
                        <p class="font-semibold">{{ $primaryBank->branch }}</p>
                    </div>
                    @endif
                </div>

                {{-- Số tiền cần chuyển --}}
                <div class="mt-4 bg-white/10 rounded-xl px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-200 text-sm">Số tiền cần chuyển</span>
                        <span class="font-bold text-xl tracking-wide" id="bankAmount">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                {{-- Nội dung chuyển khoản --}}
                <div class="mt-3 bg-white/10 rounded-xl px-4 py-3">
                    <p class="text-blue-200 text-xs mb-1.5">Nội dung chuyển khoản <span class="text-yellow-300">*</span></p>
                    <div class="flex items-center gap-2">
                        <code id="transferContent" class="flex-1 font-bold tracking-wide text-sm bg-white/10 rounded-lg px-3 py-2 select-all break-all">{{ $booking->transfer_content }}</code>
                        <button type="button" onclick="copyTransferContent()" id="copyBtn"
                                class="flex-shrink-0 bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-lg transition text-sm font-semibold flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            <span id="copyText">Copy</span>
                        </button>
                    </div>
                </div>

                @if($primaryBank->qr_code)
                    <div class="mt-4 flex justify-center">
                        <img src="{{ asset('storage/' . $primaryBank->qr_code) }}" alt="QR Code" class="w-32 h-32 bg-white rounded-xl p-1 object-contain">
                    </div>
                @endif
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl text-sm mb-6">
                Chưa có thông tin tài khoản ngân hàng. Vui lòng liên hệ Admin.
            </div>
        @endif

        {{-- Upload ảnh CK (tùy chọn) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-1">Upload ảnh chuyển khoản <span class="text-gray-400 font-normal text-sm">(tùy chọn)</span></h3>
            <p class="text-xs text-gray-400 mb-3">Không bắt buộc — bạn có thể bỏ qua bước này.</p>
            <label class="block cursor-pointer border-2 border-dashed border-gray-300 hover:border-blue-400 rounded-xl p-6 text-center transition" id="uploadLabel">
                <svg class="mx-auto w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <p class="text-sm text-gray-500">Kéo thả hoặc <span class="text-blue-600 font-medium">chọn ảnh</span></p>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP tối đa 5MB</p>
                <input type="file" name="payment_proof" id="proofInput" class="hidden" accept="image/*">
            </label>
            <div id="previewWrap" class="hidden mt-3 relative">
                <img id="previewImg" src="" alt="Preview" class="rounded-xl w-full max-h-64 object-contain border border-gray-100">
                <button type="button" onclick="clearPreview()" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow text-gray-500 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <button type="submit" id="submitBtn" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg transition hover:-translate-y-0.5 text-base">
            Tôi đã chuyển khoản — Xác nhận thanh toán
        </button>
    </form>
</div>

@push('scripts')
<script>
    const proofInput = document.getElementById('proofInput');
    const previewImg = document.getElementById('previewImg');
    const previewWrap = document.getElementById('previewWrap');
    const totalPrice = {{ $booking->total_price }};

    proofInput.addEventListener('change', function () {
        if (this.files[0]) {
            previewImg.src = URL.createObjectURL(this.files[0]);
            previewWrap.classList.remove('hidden');
        }
    });

    function clearPreview() {
        proofInput.value = '';
        previewWrap.classList.add('hidden');
    }

    function copyTransferContent() {
        const content = document.getElementById('transferContent').textContent.trim();
        navigator.clipboard.writeText(content).then(() => {
            const copyText = document.getElementById('copyText');
            const copyBtn = document.getElementById('copyBtn');
            copyText.textContent = 'Đã copy ✓';
            copyBtn.classList.add('bg-green-500/30');
            setTimeout(() => {
                copyText.textContent = 'Copy';
                copyBtn.classList.remove('bg-green-500/30');
            }, 2000);
        });
    }

    // ─── Voucher logic ────────────────────────────
    function applyVoucher() {
        const code = document.getElementById('voucherInput').value.trim();
        const resultDiv = document.getElementById('voucherResult');
        const btn = document.getElementById('applyVoucherBtn');

        if (!code) {
            showVoucherError('Vui lòng nhập mã voucher.');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Đang kiểm tra...';

        fetch(`/api/voucher/check?code=${encodeURIComponent(code)}&total=${totalPrice}`)
            .then(r => r.json())
            .then(data => {
                if (data.valid) {
                    document.getElementById('voucherCodeInput').value = code;
                    const finalPrice = totalPrice - data.discount;

                    resultDiv.className = 'mt-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2';
                    resultDiv.innerHTML = `
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <strong>${data.name}</strong> — ${data.label}<br>
                            <span class="text-green-800 font-bold">Giảm ${formatPrice(data.discount)}đ</span>
                        </div>
                    `;

                    // Show summary
                    document.getElementById('paymentSummary').classList.remove('hidden');
                    document.getElementById('discountDisplay').textContent = '-' + formatPrice(data.discount) + 'đ';
                    document.getElementById('finalPriceDisplay').textContent = formatPrice(finalPrice) + 'đ';

                    // Update bank amount
                    const bankAmt = document.getElementById('bankAmount');
                    if (bankAmt) bankAmt.textContent = formatPrice(finalPrice) + 'đ';
                } else {
                    showVoucherError(data.message);
                    clearVoucher();
                }
            })
            .catch(() => {
                showVoucherError('Có lỗi xảy ra, thử lại sau.');
                clearVoucher();
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Áp dụng';
            });
    }

    function showVoucherError(msg) {
        const resultDiv = document.getElementById('voucherResult');
        resultDiv.className = 'mt-3 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2';
        resultDiv.innerHTML = `
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            ${msg}
        `;
    }

    function clearVoucher() {
        document.getElementById('voucherCodeInput').value = '';
        document.getElementById('paymentSummary').classList.add('hidden');
        const bankAmt = document.getElementById('bankAmount');
        if (bankAmt) bankAmt.textContent = formatPrice(totalPrice) + 'đ';
    }

    function formatPrice(num) {
        return new Intl.NumberFormat('vi-VN').format(num);
    }
</script>
@endpush
@endsection
