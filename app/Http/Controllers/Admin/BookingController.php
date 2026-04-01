<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends AdminBaseController
{
    /**
     * Hiển thị danh sách các Đơn Đặt Tour cho Admin
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'product'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Cập nhật trạng thái duyệt đơn hàng
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.bookings.index')->with('success', 'Trạng thái đơn hàng #' . $booking->id . ' đã chuyển thành ' . strtoupper($request->status));
    }
}
