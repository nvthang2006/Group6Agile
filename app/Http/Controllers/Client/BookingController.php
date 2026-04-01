<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Xử lý gửi Form Đặt Tour
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:50',
            'booking_date' => 'required|date|after_or_equal:today',
            'note' => 'nullable|string|max:1000'
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng người',
            'quantity.min' => 'Số lượng người phải lớn hơn 0',
            'booking_date.required' => 'Vui lòng chọn ngày khởi hành',
            'booking_date.after_or_equal' => 'Ngày đi không hợp lệ (phải từ hôm nay trở đi)'
        ]);

        $price = $product->sale_price ?? $product->price;
        $totalPrice = $price * $request->quantity;

        Booking::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'booking_date' => $request->booking_date,
            'note' => $request->note,
            'status' => 'pending' // Chờ admin xác nhận
        ]);

        return redirect()->route('bookings.history')->with('success', 'Đặt Tour thành công! Chúng tôi sẽ liên hệ trong thời gian sớm nhất.');
    }

    /**
     * Hiển thị Lịch sử Đặt Tour của Guest
     */
    public function history()
    {
        // Lấy toàn bộ lịch sử của User đang đăng nhập, hiển thị tour mới đặt nhất ở trên
        $bookings = Booking::where('user_id', auth()->id())
            ->with('product.category') // kèm theo Data Tour & Category
            ->latest()
            ->get();
            
        return view('client.bookings.history', compact('bookings'));
    }
}
