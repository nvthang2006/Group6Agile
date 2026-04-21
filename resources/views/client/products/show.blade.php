@extends('layouts.app')

@section('title', $product->name . ' - Tour Manager')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 150))
@section('meta_image', $product->image_url ?? asset('images/default-banner.png'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition font-medium">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('products.index') }}" class="hover:text-brand-600 transition font-medium">Khám phá Tours</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-slate-800 font-bold line-clamp-1 break-all">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left Column: Media & Content -->
        <div class="lg:col-span-8">
            <!-- Header section for Mobile mainly, but nice to have above images -->
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="bg-brand-50 text-brand-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-brand-100">{{ $product->category->name ?? 'Tour' }}</span>
                    @if($product->sale_price)
                        <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-rose-100 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            Khuyến mãi
                        </span>
                    @endif
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 leading-tight mb-4">{{ $product->name }}</h1>
            </div>

            <!-- Image Gallery (Main Image + Grid) -->
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 mb-8 relative group cursor-pointer" onclick="openGallery()">
                <!-- Main Image -->
                <div class="relative h-[300px] sm:h-[450px] overflow-hidden bg-slate-900">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="absolute inset-0 w-full h-full object-cover opacity-40 blur-2xl group-hover:opacity-50 transition-all duration-700">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="relative w-full h-full object-contain z-10 drop-shadow-2xl p-4 scale-95 group-hover:scale-100 transition-transform duration-500">
                    @else
                        <div class="flex items-center justify-center w-full h-full text-slate-400 font-medium z-10">Không có ảnh</div>
                    @endif
                    <!-- Gallery View button -->
                    <div class="absolute bottom-6 right-6 z-20">
                        <button class="bg-white/90 backdrop-blur-md hover:bg-white text-slate-800 font-bold px-4 py-2.5 rounded-xl shadow-lg border border-white/50 transition-all duration-300 flex items-center gap-2 hover:-translate-y-1">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Xem thư viện ảnh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Tabs -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden" id="tour-details-container">
                <div class="flex overflow-x-auto border-b border-slate-100 bg-slate-50/50 pt-2 px-2 no-scrollbar">
                    <button class="tab-btn active px-6 py-4 text-sm font-bold text-brand-600 border-b-2 border-brand-600 whitespace-nowrap transition-colors" data-target="tab-overview">Tổng quan</button>
                    <button class="tab-btn px-6 py-4 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent hover:border-slate-300 whitespace-nowrap transition-colors" data-target="tab-itinerary">Lịch trình (Itinerary)</button>
                    <button class="tab-btn px-6 py-4 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent hover:border-slate-300 whitespace-nowrap transition-colors" data-target="tab-rules">Quy định & Chính sách</button>
                    <button class="tab-btn px-6 py-4 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent hover:border-slate-300 whitespace-nowrap transition-colors" data-target="tab-reviews">Đánh giá khách hàng</button>
                </div>
                
                <div class="p-8">
                    <!-- Tab Overview -->
                    <div id="tab-overview" class="tab-content active prose prose-slate max-w-none text-slate-600 leading-relaxed whitespace-pre-line animate-fade-in-up">
                        <h3 class="text-2xl font-bold text-slate-900 mb-4 mt-0">Điểm nhấn Hành trình</h3>
                        {{ strip_tags($product->description) }}
                    </div>
                    
                    <!-- Tab Itinerary (Mock) -->
                    <div id="tab-itinerary" class="tab-content hidden animate-fade-in-up">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Lịch trình dự kiến</h3>
                        <div class="relative border-l-2 border-brand-200 ml-3 md:ml-4 space-y-8">
                            <div class="relative pl-8">
                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-500 border-4 border-white shadow"></div>
                                <h4 class="font-bold text-lg text-slate-900">Ngày 1: Bắt đầu hành trình</h4>
                                <p class="text-slate-600 mt-2 leading-relaxed">Đón khách tại điểm hẹn. Di chuyển đến tham quan các địa điểm nổi bật. Nhận phòng và nghỉ ngơi tự do khám phá về đêm.</p>
                            </div>
                            <div class="relative pl-8">
                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-500 border-4 border-white shadow"></div>
                                <h4 class="font-bold text-lg text-slate-900">Ngày 2: Chinh phục thiên nhiên</h4>
                                <p class="text-slate-600 mt-2 leading-relaxed">Thưởng thức bữa sáng đặc sản. Khám phá các vẻ đẹp tại địa phương, tham gia các hoạt động ngoài trời. Chiều tự do mua sắm.</p>
                            </div>
                            <div class="relative pl-8">
                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-slate-300 border-4 border-white shadow"></div>
                                <h4 class="font-bold text-lg text-slate-900">Ngày 3: Trở về</h4>
                                <p class="text-slate-600 mt-2 leading-relaxed">Trả phòng. Tham quan một số điểm đến cuối cùng trước khi quay về điểm đón ban đầu. Kết thúc chương trình.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Rules (Mock) -->
                    <div id="tab-rules" class="tab-content hidden animate-fade-in-up">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Chính sách & Quy định</h3>
                        <div class="space-y-6">
                            <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100">
                                <h4 class="font-bold text-amber-900 flex items-center gap-2 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Lưu ý quan trọng</h4>
                                <ul class="list-disc list-inside text-amber-800 text-sm space-y-1">
                                    <li>Thời gian xuất phát có thể thay đổi phụ thuộc vào điều kiện thời tiết.</li>
                                    <li>Mang theo giấy tờ tùy thân bảo đảm hiệu lực.</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-2">Chính sách hoàn hủy</h4>
                                <p class="text-slate-600 text-sm leading-relaxed">Hủy tour trước 7 ngày khởi hành: Hoàn 100% chi phí. Hủy trong vòng 3-7 ngày: Hoàn 50%. Hủy dưới 3 ngày: Không được hoàn tiền theo điều lệ hiện hành của Tour Manager.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Reviews (Mock) -->
                    <div id="tab-reviews" class="tab-content hidden animate-fade-in-up">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-slate-900">Đánh giá (4.8/5)</h3>
                            <div class="flex text-amber-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <!-- Single review item -->
                            <div class="border-b border-slate-100 pb-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-brand-100 text-brand-600 font-bold rounded-full flex items-center justify-center">HA</div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm">Hoàng Anh</h5>
                                        <span class="text-xs text-slate-400">Tham gia tour tháng 3, 2026</span>
                                    </div>
                                </div>
                                <p class="text-slate-600 text-sm">Tour tổ chức chuyên nghiệp, hướng dẫn viên nhiệt tình vui vẻ. Các điểm đến đẹp như mong đợi. Rất đáng tiền!</p>
                            </div>
                            <div class="text-center pt-2">
                                <button class="text-brand-600 font-bold text-sm hover:underline">Xem tất cả đánh giá</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sticky Booking Widget -->
        <div class="lg:col-span-4 relative">
            <!-- Sticky container -->
            <div class="sticky top-28 bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-slate-100 p-6 lg:p-8">
                
                <!-- Pricing Header -->
                <div class="border-b border-slate-100 pb-6 mb-6">
                    <p class="text-sm font-semibold text-slate-500 mb-1 uppercase tracking-wider">Mức giá xuất phát</p>
                    <div class="flex flex-col">
                        @if($product->sale_price)
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-4xl font-bold text-rose-500">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                <span class="text-lg text-slate-400 font-medium line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="inline-flex">
                                <span class="bg-rose-100 text-rose-700 text-xs font-bold px-2 py-1 rounded">Tiết kiệm {{ number_format($product->price - $product->sale_price, 0, ',', '.') }}đ</span>
                            </div>
                        @else
                            <span class="text-4xl font-bold text-brand-600">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                </div>

                <!-- Booking Form -->
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                    Thiết lập đặt Tour
                </h3>
                
                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold border border-emerald-100 flex items-start gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->has('limit'))
                    <div class="mb-4 bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-bold border border-rose-100 flex items-start gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ $errors->first('limit') }}
                    </div>
                @endif
                
                @auth
                    <form action="{{ route('bookings.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-5 relative">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Lịch khởi hành</label>
                            <div class="relative">
                                <select name="departure_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 shadow-inner focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 px-4 py-3.5 appearance-none font-medium text-slate-700 transition-all cursor-pointer" required>
                                    <option value="">-- Chọn lịch có sẵn --</option>
                                    @foreach($product->departures as $departure)
                                        @php($remainingSeats = max(0, $departure->capacity - $departure->booked_seats))
                                        <option value="{{ $departure->id }}" @selected(old('departure_id') == $departure->id)>
                                            🗓️ {{ \Carbon\Carbon::parse($departure->departure_date)->format('d/m/Y') }}
                                            ({{ \Carbon\Carbon::parse($departure->departure_time)->format('H:i') }}) — Còn {{ $remainingSeats }} chỗ
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('departure_id') <span class="text-rose-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                            @if($product->departures->isEmpty())
                                <div class="bg-amber-50 text-amber-700 border border-amber-200 p-3 rounded-xl mt-2 text-xs flex items-start gap-1">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span>Tuyến này hiện chưa có lịch mở bán (đã áp dụng đóng sổ trước {{ \App\Models\Departure::bookingCutoffHours() }} giờ).</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Số lượng khách</label>
                            <div class="flex items-center">
                                <button type="button" class="w-12 h-[52px] bg-slate-100 border border-slate-200 border-r-0 rounded-l-2xl text-slate-500 hover:bg-slate-200 transition-colors font-bold flex items-center justify-center cursor-pointer" onclick="document.getElementById('qty_input').stepDown()">-</button>
                                <input type="number" id="qty_input" name="quantity" class="w-full h-[52px] border-y border-slate-200 border-x-0 bg-slate-50 focus:ring-0 focus:border-brand-500 text-center font-bold text-lg text-slate-800" required min="1" value="1">
                                <button type="button" class="w-12 h-[52px] bg-slate-100 border border-slate-200 border-l-0 rounded-r-2xl text-slate-500 hover:bg-slate-200 transition-colors font-bold flex items-center justify-center cursor-pointer" onclick="document.getElementById('qty_input').stepUp()">+</button>
                            </div>
                            @error('quantity') <span class="text-rose-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ghi chú thêm (Tùy chọn)</label>
                            <textarea name="note" rows="2" class="w-full rounded-2xl border border-slate-200 bg-slate-50 shadow-inner focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 placeholder-slate-400 px-4 py-3 font-medium transition-all" placeholder="Yêu cầu hỗ trợ xe lăn, ăn chay..."></textarea>
                            @error('note') <span class="text-rose-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-700 hover:to-brand-600 text-white font-bold py-4 rounded-2xl shadow-xl shadow-brand-500/30 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-2 group disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none" @disabled($product->departures->isEmpty())>
                            <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Xác nhận Đặt Ngay
                        </button>
                    </form>
                @else
                    <div class="text-center py-6 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-slate-600 mb-4 font-medium px-4">Hãy đăng nhập để có thể chuẩn bị cho hành trình của bạn.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-brand-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-all transform hover:-translate-y-0.5">Đăng nhập tài khoản</a>
                    </div>
                @endauth
                
                <div class="flex items-center justify-center gap-1 mt-6 text-sm text-slate-500 font-medium">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Hỗ trợ thủ tục và đổi trả an toàn 100%
                </div>
            </div>
        </div>
    </div>

    <!-- Related Tours -->
    @if($relatedProducts->count() > 0)
    <section class="mt-16 pt-16 border-t border-slate-100 relative">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-slate-900">Tour Tương Tự Bạn Nhé</h2>
            <a href="{{ route('client.categories.index') }}" class="hidden md:inline-flex items-center text-brand-600 font-bold hover:text-brand-800 transition-colors group">
                Xem thêm
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $tour)
            <x-tour-card :tour="$tour" />
            @endforeach
        </div>
    </section>
    @endif
</div>

<!-- Modal Gallery Template (Vanilla JS Logic Added Below) -->
<div id="gallery-modal" class="fixed inset-0 z-[100] bg-slate-900/95 backdrop-blur-xl hidden flex-col transition-opacity duration-300 opacity-0">
    <div class="flex justify-between items-center p-4 md:p-6 bg-gradient-to-b from-black/50 to-transparent">
        <div class="text-white font-bold text-lg hidden md:block">{{ $product->name }}</div>
        <button onclick="closeGallery()" class="text-white hover:text-rose-400 focus:outline-none transition-colors w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full ml-auto cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    <div class="flex-1 flex items-center justify-center relative px-4 md:px-16 overflow-hidden">
        <!-- Previous Arrow -->
        <button onclick="prevGalleryImage()" class="absolute left-2 md:left-8 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center backdrop-blur-md transition-all shadow-lg hover:scale-110 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        
        <!-- Image Container -->
        <div class="w-full max-w-6xl max-h-[80vh] flex items-center justify-center relative">
            <img id="modal-main-img" src="{{ $product->image_url }}" alt="Gallery Full" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl transition-all duration-300 transform scale-95">
        </div>
        
        <!-- Next Arrow -->
        <button onclick="nextGalleryImage()" class="absolute right-2 md:right-8 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center backdrop-blur-md transition-all shadow-lg hover:scale-110 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    
    <div class="p-4 bg-gradient-to-t from-black/50 to-transparent flex justify-center gap-2 overflow-x-auto pb-8">
        <!-- Thumbnails -->
        <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-brand-500 opacity-100 cursor-pointer shadow-lg shrink-0 thumbnail-img">
            <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
        </div>
        <!-- Mock secondary image -->
        <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent opacity-50 hover:opacity-100 cursor-pointer transition-all thumbnail-img">
            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" loading="lazy">
        </div>
        <!-- Mock third image -->
        <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent opacity-50 hover:opacity-100 cursor-pointer transition-all thumbnail-img">
            <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" loading="lazy">
        </div>
    </div>
</div>

<script>
    // --- Tabs Logic ---
    document.addEventListener('DOMContentLoaded', () => {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                
                // Reset all tabs
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'text-brand-600', 'border-brand-600');
                    b.classList.add('text-slate-500', 'border-transparent');
                });
                tabContents.forEach(c => c.classList.add('hidden'));
                
                // Activate clicked tab
                btn.classList.add('active', 'text-brand-600', 'border-brand-600');
                btn.classList.remove('text-slate-500', 'border-transparent');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });
    });

    // --- Gallery Modal Logic ---
    const modal = document.getElementById('gallery-modal');
    const mainModalImg = document.getElementById('modal-main-img');
    const thumbnails = document.querySelectorAll('.thumbnail-img');
    let currentImageIndex = 0;

    const mockImages = [
        "{{ $product->image_url }}",
        "https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
        "https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
    ];

    function openGallery() {
        if(!modal.classList.contains('hidden')) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            mainModalImg.classList.remove('scale-95');
            mainModalImg.classList.add('scale-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeGallery() {
        modal.classList.add('opacity-0');
        mainModalImg.classList.remove('scale-100');
        mainModalImg.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    function updateGalleryView() {
        mainModalImg.src = mockImages[currentImageIndex];
        thumbnails.forEach((thumb, idx) => {
            if (idx === currentImageIndex) {
                thumb.classList.remove('border-transparent', 'opacity-50');
                thumb.classList.add('border-brand-500', 'opacity-100');
            } else {
                thumb.classList.remove('border-brand-500', 'opacity-100');
                thumb.classList.add('border-transparent', 'opacity-50');
            }
        });
    }

    function nextGalleryImage() {
        mainModalImg.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            currentImageIndex = (currentImageIndex + 1) % mockImages.length;
            updateGalleryView();
            mainModalImg.classList.remove('opacity-0', 'scale-95');
        }, 200);
    }

    function prevGalleryImage() {
        mainModalImg.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            currentImageIndex = (currentImageIndex - 1 + mockImages.length) % mockImages.length;
            updateGalleryView();
            mainModalImg.classList.remove('opacity-0', 'scale-95');
        }, 200);
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeGallery();
        if (e.key === 'ArrowRight') nextGalleryImage();
        if (e.key === 'ArrowLeft') prevGalleryImage();
    });

    // Thumbnails click
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            if(currentImageIndex !== index) {
                mainModalImg.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    currentImageIndex = index;
                    updateGalleryView();
                    mainModalImg.classList.remove('opacity-0', 'scale-95');
                }, 200);
            }
        });
    });
</script>

<style>
    /* Custom animation for modal/tabs */
    .animate-fade-in-up {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Hide scrollbar for tabs */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
