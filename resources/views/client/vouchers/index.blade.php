@extends('layouts.app')

@section('title', 'Voucher của tôi - Tour Manager')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Hóa đơn điện tử của tôi</h1>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Chưa có hóa đơn nào</h3>
            <p class="text-gray-500 mb-6">Bạn chưa có đơn hàng nào được thanh toán thành công để nhận voucher.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition">
                Khám phá Tour ngay
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-32 bg-blue-600 relative p-6 flex flex-col justify-between overflow-hidden">
                        <!-- BG Pattern -->
                        <svg class="absolute right-0 bottom-0 text-white/10 w-32 h-32 transform translate-x-8 translate-y-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 3.8l7.2 14.4H4.8L12 5.8z"/></svg>
                        
                        <div class="relative z-10 flex justify-between items-start">
                            <span class="text-blue-100 font-medium text-sm border border-blue-400/50 rounded-full px-3 py-1 bg-blue-700/50 backdrop-blur-sm">INVOICE</span>
                            <span class="text-white font-bold tracking-widest">{{ $booking->voucher_code ?? 'PENDING' }}</span>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-white font-bold text-lg truncate">{{ $booking->product->name }}</h3>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between border-b border-gray-50 pb-2">
                                <span class="text-gray-500">Mã giao dịch</span>
                                <span class="font-medium text-gray-900">#{{ $booking->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 pb-2">
                                <span class="text-gray-500">Ngày đi</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->departure->departure_date)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 pb-2">
                                <span class="text-gray-500">Số lượng</span>
                                <span class="font-medium text-gray-900">{{ $booking->quantity }} khách</span>
                            </div>
                        </div>

                        <a href="{{ route('bookings.voucher', $booking->id) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-semibold rounded-xl transition duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Tải Hóa đơn PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
