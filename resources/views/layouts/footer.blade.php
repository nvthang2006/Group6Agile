    <footer class="bg-gray-900 text-gray-300 py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4">🌍 Tour Manager</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Khám phá thế giới cùng những hành trình tuyệt vời. Chúng tôi mang đến những trải nghiệm du lịch không giới hạn với dịch vụ chuyên nghiệp nhất.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Liên kết nhanh</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Tour nổi bật</a></li>
                    <li><a href="{{ route('client.categories.index') }}" class="hover:text-white transition">Danh mục tour</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-white transition">Tin tức du lịch</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Đăng nhập / Đăng ký</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Thông tin liên hệ</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2"><span>📍</span> <span>123 Đường Điện Biên Phủ, Phường 15, Bình Thạnh, TP.HCM</span></li>
                    <li class="flex items-center gap-2"><span>📞</span> <span>1900 1234 56</span></li>
                    <li class="flex items-center gap-2"><span>📧</span> <span>contact@tourmanager.com</span></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} Tour Manager. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white transition">Facebook</a>
                <a href="#" class="hover:text-white transition">Instagram</a>
                <a href="#" class="hover:text-white transition">Twitter</a>
            </div>
        </div>
    </footer>
