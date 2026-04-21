<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\Departure;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Tạo đơn đặt tour từ trang chi tiết sản phẩm.
     */
    public function store(Request $request, Product $product)
    {
        $cutoffHours = Departure::bookingCutoffHours();

        // Giới hạn chống Spam: Tối đa 2 đơn chưa thanh toán
        $unpaidCount = Booking::where('user_id', auth()->id())
            ->where('payment_status', 'unpaid')
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
            
        if ($unpaidCount >= 2) {
            return back()->withErrors(['limit' => 'Bạn đang có 2 đơn đặt tour chưa thanh toán. Vui lòng thanh toán hoặc hủy đơn cũ trước khi tiếp tục (Anti-Spam).'])->withInput();
        }

        $request->validate([
            'departure_id' => 'required|integer|exists:departures,id',
            'quantity'     => 'required|integer|min:1|max:50',
            'note'         => 'nullable|string|max:1000',
        ], [
            'departure_id.required' => 'Vui lòng chọn lịch khởi hành.',
            'departure_id.exists'   => 'Lịch khởi hành không hợp lệ.',
            'quantity.required'     => 'Vui lòng nhập số lượng người.',
            'quantity.min'          => 'Số lượng người phải lớn hơn 0.',
        ]);

        $booking = null;

        try {
            DB::transaction(function () use ($request, $product, $cutoffHours, &$booking) {
                $departure = Departure::where('id', $request->integer('departure_id'))
                    ->where('product_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if (!$departure) {
                    throw new \RuntimeException('departure_invalid');
                }

                if (!$departure->isBookable($cutoffHours)) {
                    throw new \RuntimeException('departure_cutoff');
                }

                $quantity  = $request->integer('quantity');
                $available = $departure->capacity - $departure->booked_seats;
                if ($available < $quantity) {
                    throw new \RuntimeException('departure_full');
                }

                $unitPrice  = (float) $departure->price;
                $totalPrice = $unitPrice * $quantity;

                $booking = Booking::create([
                    'user_id'        => auth()->id(),
                    'product_id'     => $product->id,
                    'departure_id'   => $departure->id,
                    'quantity'       => $quantity,
                    'unit_price'     => $unitPrice,
                    'total_price'    => $totalPrice,
                    'booking_date'   => $departure->departure_date,
                    'note'           => $request->note,
                    'status'         => 'pending',
                    'payment_status' => 'unpaid',
                ]);

                $booking->update([
                    'transaction_code' => Booking::generateTransactionCode($booking->id),
                ]);

                $departure->increment('booked_seats', $quantity);
            });
        } catch (\RuntimeException $exception) {
            $key = $exception->getMessage();
            if ($key === 'departure_full') {
                return back()->withErrors(['departure_id' => 'Lịch khởi hành đã hết chỗ trống.'])->withInput();
            }

            if ($key === 'departure_cutoff') {
                return back()->withErrors([
                    'departure_id' => "Lịch khởi hành này đã quá thời gian đóng sổ ({$cutoffHours} giờ trước giờ đi). Vui lòng chọn lịch khác.",
                ])->withInput();
            }

            if (in_array($key, ['departure_invalid', 'departure_unavailable'], true)) {
                return back()->withErrors(['departure_id' => 'Lịch khởi hành không khả dụng.'])->withInput();
            }

            throw $exception;
        }

        // Thông báo cho tất cả Admin
        $admins = \App\Models\User::where('role', 1)->pluck('id');
        foreach ($admins as $adminId) {
            \App\Models\Notification::send(
                $adminId,
                'new_booking',
                'Đơn đặt tour mới',
                "Có đơn đặt tour mới: {$product->name} (Mã GD: #{$booking->transaction_code}).",
                route('admin.bookings.show', $booking->id),
                $booking->id
            );
        }

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Đặt tour thành công! Vui lòng chọn phương thức thanh toán.');
    }

    /**
     * Xem chi tiết đơn hàng của khách hàng.
     */
    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $booking->load(['product', 'departure', 'user']);
        $primaryBank = BankAccount::primary();

        return view('client.bookings.show', compact('booking', 'primaryBank'));
    }

    /**
     * Cập nhật thông tin khách hàng đi tour trước khi thanh toán
     */
    public function updateCustomerInfo(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(!$booking->isPayable(), 403, 'Đơn hàng không ở trạng thái cho phép cập nhật thông tin.');

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_age'   => 'nullable|integer|min:1|max:120',
            'note'           => 'nullable|string|max:1000',
        ], [
            'customer_name.required'  => 'Vui lòng nhập họ tên người liên hệ.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_email.required' => 'Vui lòng nhập địa chỉ email hợp lệ.',
        ]);

        $booking->update([
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_age'   => $request->customer_age,
            'note'           => $request->note,
        ]);

        // Trả về trang thanh toán ngay sau khi update thành công
        return redirect()->route('bookings.payment', $booking->id);
    }

    /**
     * Hiển thị trang thanh toán.
     */
    public function paymentPage(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(!$booking->isPayable(), 403, 'Đơn hàng này không thể thanh toán.');

        if (!$booking->customer_name || !$booking->customer_phone || !$booking->customer_email) {
            return redirect()->route('bookings.show', $booking->id)
                ->withErrors(['customer_info' => 'Vui lòng lưu thông tin người đại diện trước khi thanh toán.']);
        }

        $booking->load(['product', 'departure']);
        $primaryBank = BankAccount::primary();

        return view('client.bookings.payment', compact('booking', 'primaryBank'));
    }

    /**
     * Khách chọn phương thức thanh toán.
     */
    public function submitPayment(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(!$booking->isPayable(), 403, 'Đơn hàng này không thể thanh toán.');

        $request->validate([
            'payment_method' => 'required|in:bank_transfer',
            'payment_proof'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'voucher_code'   => 'nullable|string|max:30',
        ], [
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_proof.image'     => 'File phải là ảnh.',
            'payment_proof.max'       => 'Ảnh tối đa 5MB.',
        ]);

        $bookingData = [
            'payment_method' => $request->payment_method,
        ];

        $voucher = null;
        $discount = 0;

        DB::transaction(function () use ($request, $booking, &$bookingData, &$voucher, &$discount) {
            // Xử lý voucher giảm giá trong cùng transaction với booking
            if ($request->filled('voucher_code')) {
                $voucherCode = strtoupper(trim($request->voucher_code));

                $voucher = \App\Models\Voucher::where('code', $voucherCode)
                    ->lockForUpdate()
                    ->first();

                if ($voucher && $voucher->isValid() && $voucher->meetsMinOrder($booking->total_price)) {
                    $discount = $voucher->calculateDiscount($booking->total_price);
                    $bookingData['voucher_id'] = $voucher->id;
                    $bookingData['discount_amount'] = $discount;
                }
            }

            // Chuyển khoản ngân hàng — luôn chuyển sang waiting_verify
            $bookingData['payment_status'] = 'waiting_verify';

            // Upload ảnh CK là tùy chọn
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
                $bookingData['payment_proof'] = $path;
            }

            $booking->update($bookingData);

            if ($voucher && $discount > 0) {
                $voucher->incrementUsage();
            }
        });

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Xác nhận chuyển khoản thành công! Chúng tôi sẽ kiểm tra và phản hồi trong vòng 24 giờ.');
    }

    /**
     * Khách upload thêm ảnh chuyển khoản.
     */
    public function uploadProof(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(!$booking->canUploadProof(), 403, 'Đơn hàng này không thể cập nhật chứng từ thanh toán.');

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($booking->payment_proof) {
            Storage::disk('public')->delete($booking->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $booking->update([
            'payment_proof'  => $path,
            'payment_status' => 'waiting_verify',
            'payment_method' => 'bank_transfer',
        ]);

        return back()->with('success', 'Đã cập nhật bằng chứng thanh toán!');
    }

    /**
     * Khách hủy đơn (khi còn pending và chưa thanh toán).
     */
    public function cancel(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(!$booking->isClientCancellable(), 403, 'Không thể hủy đơn hàng này.');

        $request->validate([
            'cancelled_reason' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $booking) {
            $departure = $booking->departure()->lockForUpdate()->first();

            $booking->update([
                'status'           => 'cancelled',
                'cancelled_reason' => $request->cancelled_reason ?? 'Khách hàng tự hủy.',
            ]);

            if ($departure) {
                $departure->booked_seats = max(0, $departure->booked_seats - $booking->quantity);
                $departure->save();
            }
        });

        return redirect()->route('bookings.history')
            ->with('success', 'Đã hủy đơn #' . $booking->transaction_code . ' thành công.');
    }

    /**
     * Lịch sử đặt tour của khách hàng.
     */
    public function history()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['product.category', 'departure'])
            ->latest()
            ->get();

        return view('client.bookings.history', compact('bookings'));
    }
}
