<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Danh sách voucher của khách
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->whereIn('payment_status', ['paid'])
            ->orWhere('status', 'completed')
            ->where('user_id', auth()->id())
            ->with(['product', 'departure'])
            ->latest()
            ->paginate(12);

        return view('client.vouchers.index', compact('bookings'));
    }

    /**
     * Download voucher as PDF
     */
    public function download(Booking $booking)
    {
        // Require booking to belong to user and be paid/completed
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->payment_status !== 'paid' && $booking->status !== 'completed', 403, 'Chưa thể xuất voucher cho đơn hàng này.');

        // Generate voucher_code if missing
        if (!$booking->voucher_code) {
            $booking->update([
                'voucher_code' => 'VOU-' . strtoupper(str()->random(8))
            ]);
        }

        $booking->load(['product', 'departure', 'user']);

        $pdf = Pdf::loadView('client.pdf.voucher', compact('booking'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('Voucher_' . $booking->transaction_code . '.pdf');
    }
}
