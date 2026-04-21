@extends('layouts.app')

@section('title', 'Lịch sử Đặt Tour - Tour Manager')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Lịch sử Đặt Tour</h1>
            <p class="text-gray-500 mt-2">Theo dõi các chuyến đi bạn đã đăng ký</p>
        </div>
        <a href="{{ route('home') }}#tours" class="mt-4 md:mt-0 text-blue-600 hover:text-blue-800 font-semibold items-center inline-flex">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại tìm Tour
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-3xl overflow-hidden border border-gray-100">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4 font-semibold">Tên Tour</th>
                            <th class="px-6 py-4 font-semibold">Ngày Đi</th>
                            <th class="px-6 py-4 font-semibold text-center">Số người</th>
                            <th class="px-6 py-4 font-semibold">Tổng Tiền</th>
                            <th class="px-6 py-4 font-semibold">Trạng thái</th>
                            <th class="px-6 py-4 font-semibold">Ngày Đặt</th>
                            <th class="px-6 py-4 font-semibold text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="font-bold text-gray-900 hover:text-blue-600 line-clamp-1 block max-w-xs transition">
                                        {{ $booking->product->name ?? 'Tour đã bị xóa' }}
                                    </a>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm">
                                    {{ \Carbon\Carbon::parse($booking->departure->departure_date ?? $booking->booking_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5 text-center font-bold text-gray-900">
                                    {{ $booking->quantity }}
                                </td>
                                <td class="px-6 py-5 font-bold text-blue-600 whitespace-nowrap">
                                    {{ number_format($booking->total_price, 0, ',', '.') }}đ
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm">
                                    @if($booking->status == 'cancelled')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            Đã hủy
                                        </span>
                                    @elseif($booking->payment_status == 'refunded')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            Hoàn tiền
                                        </span>
                                    @elseif($booking->payment_status == 'paid')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            Đã thanh toán
                                        </span>
                                    @elseif(in_array($booking->payment_status, ['waiting_verify', 'refund_pending']))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            Đợi kiểm tra
                                        </span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            Đã xác nhận
                                        </span>
                                    @elseif($booking->status == 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                            Hoàn thành
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                            Chờ xử lý
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $booking->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($booking->isPayable())
                                            <a href="{{ route('bookings.payment', $booking->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                Thanh toán chuyển khoản
                                            </a>
                                        @endif
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="text-gray-600 hover:text-blue-600 font-bold py-2 px-4 border border-gray-200 hover:border-blue-200 rounded-xl transition bg-white shadow-sm">
                                            Chi tiết
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-24">
                <svg class="mx-auto h-20 w-20 text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Chưa có chuyến đi nào</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Bạn chưa đặt bất kỳ tour du lịch nào. Hãy bắt đầu khám phá và lưu lại những trải nghiệm tuyệt vời cùng chúng tôi!</p>
                <a href="{{ route('home') }}#tours" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-2xl text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                    Khám phá Tour Ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
