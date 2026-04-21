<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingPaidMail;

class BookingController extends AdminBaseController
{
    /**
     * Danh sách tất cả đơn hàng + bộ lọc.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'product', 'departure'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $bookings = $query->get();

        $stats = [
            'pending'        => Booking::where('status', 'pending')->count(),
            'confirmed'      => Booking::where('status', 'confirmed')->count(),
            'cancelled'      => Booking::where('status', 'cancelled')->count(),
            'waiting_verify' => Booking::where('payment_status', 'waiting_verify')->count(),
            'revenue'        => Booking::where('payment_status', 'paid')->sum('total_price'),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Xem chi tiết một đơn hàng.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'product', 'departure']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Xác nhận đơn hàng.
     */
    public function confirm(Request $request, Booking $booking)
    {
        abort_if($booking->status === 'confirmed', 403, 'Đơn hàng đã được xác nhận.');

        DB::transaction(function () use ($booking) {
            $departure = $booking->departure()->lockForUpdate()->first();

            // Nếu trước đó đơn bị hủy, cần lock lại chỗ
            if ($booking->status === 'cancelled' && $departure) {
                $available = $departure->capacity - $departure->booked_seats;
                if ($available < $booking->quantity || $departure->status !== 'open') {
                    throw new \RuntimeException('departure_not_available');
                }
                $departure->increment('booked_seats', $booking->quantity);
            }

            $booking->update([
                'status'         => 'confirmed',
                'confirmed_at'   => now(),
            ]);

            if ($booking->payment_method === 'bank_transfer') {
                $booking->update([
                    'payment_status' => 'paid',
                    'paid_at'        => now(),
                ]);
            }

            Notification::send(
                $booking->user_id,
                'booking_confirmed',
                'Xác nhận đơn hàng & Thanh toán thành công',
                "Đơn hàng #{$booking->transaction_code} của bạn đã được Admin xác nhận. Bạn có thể xem vé điện tử ngay bây giờ.",
                route('bookings.show', $booking->id),
                $booking->id
            );

            // Only send paid-mail when the order is actually marked as paid.
            if ($booking->payment_method === 'bank_transfer') {
                try {
                    Mail::to($booking->user->email)->send(new BookingPaidMail($booking));
                } catch (\Exception $e) {
                    // Log or ignore if smtp fails in development
                    \Log::error('Mail sending failed: ' . $e->getMessage());
                }
            }
        });

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Đã xác nhận đơn #' . $booking->transaction_code . ' và đánh dấu đã thanh toán!');
    }

    /**
     * Từ chối / Hủy đơn hàng với lý do.
     */
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'cancelled_reason' => 'required|string|max:500',
        ], [
            'cancelled_reason.required' => 'Vui lòng nhập lý do từ chối.',
        ]);

        abort_if($booking->status === 'cancelled', 403, 'Đơn hàng đã bị hủy.');

        DB::transaction(function () use ($request, $booking) {
            $departure = $booking->departure()->lockForUpdate()->first();

            if ($booking->status !== 'cancelled' && $departure) {
                $departure->booked_seats = max(0, $departure->booked_seats - $booking->quantity);
                $departure->save();
            }

            $booking->update([
                'status'           => 'cancelled',
                'payment_status'   => $this->nextCancelledPaymentStatus($booking->payment_status),
                'cancelled_reason' => $request->cancelled_reason,
            ]);

            Notification::send(
                $booking->user_id,
                'booking_cancelled',
                'Đơn hàng đã bị hủy',
                "Đơn hàng #{$booking->transaction_code} đã bị hủy bởi Admin. Lý do: {$request->cancelled_reason}",
                route('bookings.show', $booking->id),
                $booking->id
            );
        });

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Đã từ chối đơn #' . $booking->transaction_code . '.');
    }

    /**
     * Cập nhật trạng thái đơn.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $newStatus = $request->input('status');
        $oldStatus = $booking->status;

        if ($newStatus === $oldStatus) {
            return redirect()->route('admin.bookings.index')
                ->with('success', 'Trạng thái đơn hàng không thay đổi.');
        }

        try {
            DB::transaction(function () use ($booking, $newStatus, $oldStatus) {
                $departure = $booking->departure()->lockForUpdate()->first();

                if ($departure) {
                    if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                        $departure->booked_seats = max(0, $departure->booked_seats - $booking->quantity);
                        $departure->save();
                    }

                    if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                        $available = $departure->capacity - $departure->booked_seats;
                        if ($available < $booking->quantity || $departure->status !== 'open') {
                            throw new \RuntimeException('departure_not_available');
                        }
                        $departure->booked_seats += $booking->quantity;
                        $departure->save();
                    }
                }

                $updateData = ['status' => $newStatus];

                if ($newStatus === 'confirmed') {
                    $updateData['confirmed_at']   = now();
                    if ($booking->payment_method === 'bank_transfer') {
                        $updateData['payment_status'] = 'paid';
                        $updateData['paid_at']        = now();
                    }
                }

                if ($newStatus === 'cancelled') {
                    $updateData['payment_status'] = $this->nextCancelledPaymentStatus($booking->payment_status);
                }

                $booking->update($updateData);

                if ($newStatus === 'confirmed') {
                    Notification::send(
                        $booking->user_id,
                        'booking_confirmed',
                        'Xác nhận đơn hàng',
                        "Đơn hàng #{$booking->transaction_code} đã được Admin xác nhận thành công.",
                        route('bookings.show', $booking->id),
                        $booking->id
                    );

                    if ($booking->payment_method === 'bank_transfer') {
                        // Send Email notification
                        try {
                            Mail::to($booking->user->email)->send(new BookingPaidMail($booking));
                        } catch (\Exception $e) {
                            \Log::error('Mail sending failed: ' . $e->getMessage());
                        }
                    }
                } elseif ($newStatus === 'cancelled') {
                    Notification::send(
                        $booking->user_id,
                        'booking_cancelled',
                        'Đơn hàng đã bị hủy',
                        "Đơn hàng #{$booking->transaction_code} đã bị cập nhật sang trạng thái hủy.",
                        route('bookings.show', $booking->id),
                        $booking->id
                    );
                }
            });
        } catch (\RuntimeException $exception) {
            return back()->withErrors([
                'status' => 'Không thể đổi trạng thái vì lịch khởi hành không còn chỗ hợp lệ.',
            ]);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Cập nhật trạng thái đơn #' . $booking->transaction_code . ' thành công.');
    }



    private function nextCancelledPaymentStatus(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            'paid' => 'refunded',
            'waiting_verify' => 'refund_pending',
            default => 'unpaid',
        };
    }
}
