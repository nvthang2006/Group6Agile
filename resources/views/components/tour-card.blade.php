@props(['tour'])

<div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group flex flex-col hover:-translate-y-2">
    <div class="relative overflow-hidden aspect-[4/3] m-3 rounded-[2rem]">
        @if($tour->image_url)
            <img src="{{ $tour->image_url }}" 
                loading="lazy"
                alt="{{ $tour->name }}" 
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
        @else
            <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        <!-- Wishlist button -->
        <button class="absolute top-4 right-4 z-20 w-10 h-10 bg-white/70 backdrop-blur-md rounded-full flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-white transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </button>
        <!-- Category Badge -->
        <div class="absolute top-4 left-4 z-20 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-brand-700 shadow-sm uppercase tracking-wider">
            {{ $tour->category->name ?? 'Tour' }}
        </div>
        @if($tour->sale_price)
            <div class="absolute bottom-4 left-4 z-20 bg-rose-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-sm border border-rose-400">
                Tiết kiệm lớn!
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10 pointer-events-none"></div>
    </div>
    <div class="p-6 pt-4 flex-grow flex flex-col">
        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 leading-snug group-hover:text-brand-600 transition-colors">
            <a href="{{ route('products.detail', $tour->slug) }}">{{ $tour->name }}</a>
        </h3>
        <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed flex-grow">{{ strip_tags($tour->description) }}</p>
        
        <div class="flex justify-between items-end mt-auto border-t border-slate-100 pt-5">
            <div class="flex flex-col">
                <span class="text-[11px] text-slate-400 uppercase tracking-widest font-bold mb-1">Giá trọn gói</span>
                @if($tour->sale_price)
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-rose-500">{{ number_format($tour->sale_price, 0, ',', '.') }}đ</span>
                        <span class="text-sm font-medium text-slate-400 line-through">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                    </div>
                @else
                    <span class="text-2xl font-bold text-brand-600">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                @endif
            </div>
            <a href="{{ route('products.detail', $tour->slug) }}" class="inline-flex items-center justify-center bg-brand-50 text-brand-700 font-bold rounded-xl px-4 py-2.5 whitespace-nowrap hover:bg-brand-600 hover:text-white hover:shadow-lg hover:shadow-brand-500/30 transition-all duration-300">
                Chi tiết
            </a>
        </div>
    </div>
</div>
