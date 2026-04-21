<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Departure;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FullSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Bắt đầu tạo dữ liệu mẫu...');

        // ──────────────────────────────────────────
        // 1. USERS
        // ──────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@tour.com'],
            ['name' => 'Admin User', 'password' => bcrypt('12345678'), 'role' => 1]
        );

        $customers = [];
        $customerData = [
            ['name' => 'Nguyễn Văn An',  'email' => 'an.nguyen@gmail.com'],
            ['name' => 'Trần Thị Bình',  'email' => 'binh.tran@gmail.com'],
            ['name' => 'Lê Hoàng Cường', 'email' => 'cuong.le@gmail.com'],
            ['name' => 'Phạm Minh Đức',  'email' => 'duc.pham@gmail.com'],
            ['name' => 'Võ Thanh Hà',    'email' => 'ha.vo@gmail.com'],
        ];
        foreach ($customerData as $c) {
            $customers[] = User::firstOrCreate(
                ['email' => $c['email']],
                ['name' => $c['name'], 'password' => bcrypt('12345678'), 'role' => 0]
            );
        }
        $this->command->info('✅ Users: ' . (count($customers) + 1) . ' tài khoản');

        // ──────────────────────────────────────────
        // 2. CATEGORIES
        // ──────────────────────────────────────────
        $categoriesData = [
            ['name' => 'Tour gia đình',           'slug' => 'tour-gia-dinh',         'description' => 'Hành trình dành cho cả gia đình, an toàn và vui vẻ cho mọi lứa tuổi.'],
            ['name' => 'Tour Biển',                'slug' => 'tour-bien',             'description' => 'Các tour du lịch tới các bãi biển đẹp nổi tiếng Việt Nam và quốc tế.'],
            ['name' => 'Tour Núi - Khám Phá',      'slug' => 'tour-nui-kham-pha',     'description' => 'Trải nghiệm du lịch khám phá và leo núi hùng vĩ, chinh phục thiên nhiên.'],
            ['name' => 'Tour Nghỉ Dưỡng Cao Cấp',  'slug' => 'tour-nghi-duong',       'description' => 'Dịch vụ nghỉ dưỡng sang trọng 5 sao tại các điểm đến nổi bật.'],
            ['name' => 'Tour Quốc Tế',             'slug' => 'tour-quoc-te',          'description' => 'Khám phá các quốc gia trên thế giới cùng đội ngũ hướng dẫn viên chuyên nghiệp.'],
        ];
        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
        $this->command->info('✅ Categories: ' . count($categories) . ' danh mục');

        // ──────────────────────────────────────────
        // 3. PRODUCTS (TOURS) — with real Unsplash images
        // ──────────────────────────────────────────
        $productsData = [
            [
                'name' => 'Sầm Sơn 3 Ngày 2 Đêm - Trọn Gói',
                'slug' => 'sam-son-3-ngay-2-dem',
                'price' => 2500000,
                'sale_price' => 1990000,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=600&fit=crop',
                'description' => 'Tour Sầm Sơn 3 ngày 2 đêm cho gia đình. Tắm biển, thưởng thức hải sản tươi sống và trải nghiệm cuộc sống vùng biển thanh bình. Bao gồm khách sạn 3 sao, xe đưa đón và bữa ăn.',
                'category_id' => $categories[0]->id,
            ],
            [
                'name' => 'Phú Quốc Thiên Đường Biển 4N3Đ',
                'slug' => 'phu-quoc-thien-duong-bien',
                'price' => 5500000,
                'sale_price' => 4790000,
                'image' => 'https://images.unsplash.com/photo-1559494007-9f5847c49d94?w=800&h=600&fit=crop',
                'description' => 'Khám phá đảo ngọc Phú Quốc với bãi Sao tuyệt đẹp, lặn ngắm san hô, câu cá và thưởng thức đặc sản. Resort 4 sao ven biển, xe đưa đón sân bay.',
                'category_id' => $categories[1]->id,
            ],
            [
                'name' => 'Trekking Fansipan 2 Ngày 1 Đêm',
                'slug' => 'trekking-fansipan-2n1d',
                'price' => 3200000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&h=600&fit=crop',
                'description' => 'Khám phá nóc nhà Đông Dương cùng hướng dẫn viên bản địa chuyên nghiệp. Leo núi qua rừng nguyên sinh, ngắm mây trên đỉnh Fansipan 3143m. Bao gồm porter, lều trại và bữa ăn.',
                'category_id' => $categories[2]->id,
            ],
            [
                'name' => 'Đà Nẵng - Hội An - Huế 5N4Đ',
                'slug' => 'da-nang-hoi-an-hue-5n4d',
                'price' => 7500000,
                'sale_price' => 6500000,
                'image' => 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800&h=600&fit=crop',
                'description' => 'Hành trình di sản miền Trung. Tham quan Bà Nà Hills, phố cổ Hội An, Đại Nội Huế. Nghỉ resort 4 sao, trải nghiệm ẩm thực miền Trung đặc sắc.',
                'category_id' => $categories[3]->id,
            ],
            [
                'name' => 'Hạ Long Bay Du Thuyền 5 Sao 2N1Đ',
                'slug' => 'ha-long-bay-du-thuyen-5-sao',
                'price' => 8900000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?w=800&h=600&fit=crop',
                'description' => 'Du thuyền sang trọng trên Vịnh Hạ Long - Di sản thiên nhiên thế giới. Kayak khám phá hang động, tắm biển Ti Tốp, thưởng thức hải sản trên thuyền.',
                'category_id' => $categories[3]->id,
            ],
            [
                'name' => 'Sapa Mùa Lúa Chín 3N2Đ',
                'slug' => 'sapa-mua-lua-chin-3n2d',
                'price' => 3800000,
                'sale_price' => 3200000,
                'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&h=600&fit=crop',
                'description' => 'Ngắm ruộng bậc thang mùa lúa chín vàng óng. Trekking bản Tả Van, Cát Cát, homestay cùng đồng bào H\'Mông. Thưởng thức cá suối nướng và rượu táo mèo.',
                'category_id' => $categories[2]->id,
            ],
            [
                'name' => 'Nha Trang Beach Resort 4N3Đ',
                'slug' => 'nha-trang-beach-resort-4n3d',
                'price' => 6200000,
                'sale_price' => 5500000,
                'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&h=600&fit=crop',
                'description' => 'Nghỉ dưỡng tại resort ven biển Nha Trang. Lặn biển ngắm san hô, tham quan Vinpearl Land, tắm bùn khoáng. Bay thẳng khứ hồi và xe đưa đón.',
                'category_id' => $categories[1]->id,
            ],
            [
                'name' => 'Bangkok - Pattaya 5N4Đ Thái Lan',
                'slug' => 'bangkok-pattaya-5n4d',
                'price' => 9500000,
                'sale_price' => 8200000,
                'image' => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=800&h=600&fit=crop',
                'description' => 'Tour Thái Lan trọn gói: Hoàng Cung, Wat Arun, chợ nổi Damnoen Saduak, biển Pattaya, show tiffany. Vé bay, khách sạn 4 sao, visa và bảo hiểm.',
                'category_id' => $categories[4]->id,
            ],
            [
                'name' => 'Đà Lạt Mộng Mơ 3N2Đ',
                'slug' => 'da-lat-mong-mo-3n2d',
                'price' => 2800000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                'description' => 'Thành phố ngàn hoa! Tham quan Hồ Tuyền Lâm, Thung Lũng Tình Yêu, vườn dâu, đồi chè. Thưởng thức cà phê weasel và rượu vang Đà Lạt chính gốc.',
                'category_id' => $categories[0]->id,
            ],
            [
                'name' => 'Côn Đảo Linh Thiêng 3N2Đ',
                'slug' => 'con-dao-linh-thieng-3n2d',
                'price' => 5900000,
                'sale_price' => 5200000,
                'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&h=600&fit=crop',
                'description' => 'Hành trình tâm linh và nghỉ dưỡng tại Côn Đảo. Viếng nghĩa trang Hàng Dương, lặn biển ngắm rùa, khám phá bãi biển hoang sơ. Bay thẳng từ HCM.',
                'category_id' => $categories[1]->id,
            ],
        ];

        $products = [];
        foreach ($productsData as $p) {
            $products[] = Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
        $this->command->info('✅ Products: ' . count($products) . ' tours');

        // ──────────────────────────────────────────
        // 4. DEPARTURES
        // ──────────────────────────────────────────
        $departureCount = 0;
        foreach ($products as $product) {
            for ($i = 1; $i <= 3; $i++) {
                $date = Carbon::now()->addDays(rand(5, 60));
                Departure::firstOrCreate(
                    ['product_id' => $product->id, 'departure_date' => $date->toDateString()],
                    [
                        'departure_time' => sprintf('%02d:00:00', rand(6, 9)),
                        'capacity' => rand(15, 40),
                        'booked_seats' => rand(0, 10),
                        'price' => $product->sale_price ?? $product->price,
                        'status' => 'open',
                    ]
                );
                $departureCount++;
            }
        }
        $this->command->info('✅ Departures: ' . $departureCount . ' lịch khởi hành');

        // ──────────────────────────────────────────
        // 5. POSTS (BLOG) — with real Unsplash images
        // ──────────────────────────────────────────
        $postsData = [
            [
                'title' => 'Top 10 bãi biển đẹp nhất Việt Nam 2026',
                'slug' => 'top-10-bai-bien-dep-nhat-viet-nam-2026',
                'image' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=800&h=600&fit=crop',
                'content' => '<h2>Việt Nam - Thiên đường biển đảo</h2><p>Với đường bờ biển dài hơn 3.260 km, Việt Nam sở hữu vô số bãi biển đẹp mê hồn. Từ <strong>Phú Quốc</strong> với cát trắng mịn như bột cho đến <strong>Mũi Né</strong> với những đụn cát vàng hoang sơ.</p><h3>1. Bãi Dài - Phú Quốc</h3><p>Bãi Dài nằm phía Bắc đảo Phú Quốc, trải dài khoảng 20km với cát trắng mịn và nước biển trong xanh màu ngọc bích.</p><h3>2. An Bàng - Hội An</h3><p>Bãi biển An Bàng từng được bình chọn là một trong những bãi biển đẹp nhất châu Á bởi tạp chí CNNGo.</p><h3>3. Bãi Sao - Phú Quốc</h3><p>Bãi Sao nổi tiếng với cát trắng phau, nước biển xanh ngắt và hàng dừa xanh mát rượi ven bờ.</p><p>Hãy lên kế hoạch cho chuyến đi biển tiếp theo của bạn ngay hôm nay!</p>',
            ],
            [
                'title' => 'Cẩm nang chuẩn bị leo Fansipan cho người mới',
                'slug' => 'cam-nang-leo-fansipan-nguoi-moi',
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&h=600&fit=crop',
                'content' => '<h2>Chinh phục nóc nhà Đông Dương</h2><p>Fansipan với độ cao <strong>3.143m</strong> là đỉnh núi cao nhất Đông Dương. Để có một chuyến leo núi an toàn và thành công, bạn cần chuẩn bị kỹ lưỡng.</p><h3>Trang phục</h3><ul><li>Giày trekking chống trượt</li><li>Áo khoác gió chống nước</li><li>Quần dài co giãn thoải mái</li></ul><h3>Vật dụng cần thiết</h3><ul><li>Balo 30-40L</li><li>Đèn pin đội đầu</li><li>Bình nước 1.5L</li><li>Thuốc chống say độ cao</li></ul><p>Mùa đẹp nhất để leo Fansipan là từ tháng 10 đến tháng 3 năm sau, khi thời tiết khô ráo và có thể ngắm được biển mây tuyệt đẹp.</p>',
            ],
            [
                'title' => 'Ẩm thực đường phố Hội An không thể bỏ lỡ',
                'slug' => 'am-thuc-duong-pho-hoi-an',
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&h=600&fit=crop',
                'content' => '<h2>Hội An - Thủ phủ ẩm thực miền Trung</h2><p>Phố cổ Hội An không chỉ đẹp mà còn là thiên đường ẩm thực. Dưới đây là những món <strong>nhất định phải thử</strong> khi đến đây.</p><h3>Cao lầu</h3><p>Cao lầu là món ăn đặc trưng chỉ có ở Hội An. Sợi mì vàng óng, nước lèo đậm đà, ăn kèm rau sống tươi mát.</p><h3>Mì Quảng</h3><p>Mì Quảng với nước dùng ít nhưng đậm vị tôm cua, ăn cùng bánh tráng giòn rụm và đậu phộng rang.</p><h3>Bánh Mì Phượng</h3><p>Được Anthony Bourdain ca ngợi là "bánh mì ngon nhất thế giới". Vỏ giòn tan, nhân phong phú với nhiều loại thịt và rau.</p>',
            ],
            [
                'title' => '5 mẹo tiết kiệm chi phí khi du lịch Thái Lan',
                'slug' => '5-meo-tiet-kiem-du-lich-thai-lan',
                'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800&h=600&fit=crop',
                'content' => '<h2>Du lịch Thái Lan tiết kiệm</h2><p>Thái Lan là điểm đến phổ biến nhất Đông Nam Á nhờ chi phí hợp lý. Dưới đây là <strong>5 mẹo vàng</strong> giúp bạn tiết kiệm tối đa.</p><h3>1. Đặt vé bay sớm</h3><p>Đặt trước 2-3 tháng để có giá vé rẻ nhất. Các hãng bay giá rẻ như AirAsia, VietJet thường có khuyến mãi.</p><h3>2. Ăn ở chợ đêm</h3><p>Đồ ăn street food Thái chỉ từ 40-80 Baht/phần, ngon và an toàn tại các chợ đêm nổi tiếng.</p><h3>3. Đi BTS/MRT</h3><p>Hệ thống tàu điện Bangkok rẻ và nhanh hơn taxi rất nhiều, tránh kẹt xe giờ cao điểm.</p><h3>4. Mua sắm tại MBK</h3><p>Trung tâm MBK có giá rẻ hơn Siam Paragon rất nhiều, đồ đa dạng và có thể trả giá.</p><h3>5. Mua tour tại chỗ</h3><p>Tour 1 ngày mua tại các agency trên Khao San Road rẻ hơn đặt online 20-30%.</p>',
            ],
            [
                'title' => 'Đà Lạt mùa hoa dã quỳ - Khi nào đẹp nhất?',
                'slug' => 'da-lat-mua-hoa-da-quy',
                'image' => 'https://images.unsplash.com/photo-1490750967868-88aa4f44baee?w=800&h=600&fit=crop',
                'content' => '<h2>Mùa hoa dã quỳ Đà Lạt</h2><p>Mỗi năm vào khoảng <strong>tháng 10 đến tháng 11</strong>, Đà Lạt khoác lên mình tấm áo vàng rực rỡ của hoa dã quỳ. Đây là thời điểm lý tưởng nhất để ghé thăm thành phố sương mù.</p><h3>Địa điểm ngắm đẹp nhất</h3><ul><li><strong>Đèo Mimosa</strong> - Con đường huyền thoại với hoa dã quỳ hai bên</li><li><strong>Hồ Tuyền Lâm</strong> - Phản chiếu sắc vàng trên mặt hồ</li><li><strong>Vườn quốc gia Bidoup</strong> - Hoa nở rộ giữa núi rừng nguyên sinh</li></ul><p>Thời tiết Đà Lạt tháng 10-11 mát mẻ, nhiệt độ 15-22°C, rất thích hợp cho việc chụp ảnh và cắm trại ngoài trời.</p>',
            ],
            [
                'title' => 'Review du thuyền Hạ Long: Có đáng giá tiền?',
                'slug' => 'review-du-thuyen-ha-long',
                'image' => 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=800&h=600&fit=crop',
                'content' => '<h2>Trải nghiệm du thuyền Vịnh Hạ Long</h2><p>Du thuyền qua đêm trên Vịnh Hạ Long là trải nghiệm <strong>đáng đồng tiền bát gạo</strong> mà bất kỳ ai yêu du lịch cũng nên thử một lần.</p><h3>Những điều tuyệt vời</h3><ul><li>Ngắm hoàng hôn và bình minh trên vịnh</li><li>Phòng nghỉ sang trọng với ban công riêng</li><li>Bữa tối hải sản 5 món trên boong tàu</li><li>Kayak khám phá hang luồn, làng chài</li></ul><h3>Mức giá tham khảo</h3><p>Du thuyền 3 sao: 2-3 triệu/người. Du thuyền 5 sao: 5-8 triệu/người. Giá đã bao gồm ăn uống và các hoạt động trên tàu.</p>',
            ],
        ];

        foreach ($postsData as $p) {
            Post::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['user_id' => $admin->id])
            );
        }
        $this->command->info('✅ Posts: ' . count($postsData) . ' bài viết');

        // ──────────────────────────────────────────
        // 6. BANK ACCOUNTS
        // ──────────────────────────────────────────
        $bankData = [
            ['bank_name' => 'Vietcombank',  'account_number' => '1234567890',   'account_name' => 'CONG TY TOUR MANAGER', 'branch' => 'Hồ Chí Minh', 'is_active' => true],
            ['bank_name' => 'MB Bank',      'account_number' => '0987654321',   'account_name' => 'CONG TY TOUR MANAGER', 'branch' => 'Hà Nội',      'is_active' => true],
            ['bank_name' => 'Techcombank',   'account_number' => '1122334455',   'account_name' => 'CONG TY TOUR MANAGER', 'branch' => 'Đà Nẵng',     'is_active' => true],
        ];
        foreach ($bankData as $bank) {
            BankAccount::firstOrCreate(['account_number' => $bank['account_number']], $bank);
        }
        $this->command->info('✅ Bank Accounts: ' . count($bankData) . ' tài khoản');

        // ──────────────────────────────────────────
        // 7. VOUCHERS
        // ──────────────────────────────────────────
        $vouchersData = [
            ['code' => 'CHAOHE2026',  'name' => 'Chào Hè 2026',           'type' => 'percent', 'value' => 10, 'max_discount' => 500000,  'min_order' => 2000000, 'max_uses' => 100, 'starts_at' => '2026-05-01', 'expires_at' => '2026-08-31', 'is_active' => true],
            ['code' => 'GIAM200K',    'name' => 'Giảm 200K đơn từ 3 triệu','type' => 'fixed',   'value' => 200000,                       'min_order' => 3000000, 'max_uses' => 50,  'starts_at' => '2026-04-01', 'expires_at' => '2026-12-31', 'is_active' => true],
            ['code' => 'NEWUSER',     'name' => 'Ưu đãi khách mới',        'type' => 'fixed',   'value' => 100000,                       'min_order' => 1000000, 'max_uses' => 200, 'starts_at' => '2026-01-01', 'expires_at' => '2026-12-31', 'is_active' => true],
            ['code' => 'VIP20',       'name' => 'VIP giảm 20%',            'type' => 'percent', 'value' => 20, 'max_discount' => 1000000, 'min_order' => 5000000, 'max_uses' => 30,  'starts_at' => '2026-04-15', 'expires_at' => '2026-06-30', 'is_active' => true],
            ['code' => 'TETDULICH',   'name' => 'Tết du lịch giảm 15%',    'type' => 'percent', 'value' => 15, 'max_discount' => 800000,  'min_order' => 3000000, 'max_uses' => null, 'starts_at' => '2026-01-15', 'expires_at' => '2026-02-28', 'is_active' => false],
        ];
        foreach ($vouchersData as $v) {
            Voucher::firstOrCreate(['code' => $v['code']], $v);
        }
        $this->command->info('✅ Vouchers: ' . count($vouchersData) . ' mã giảm giá');

        // ──────────────────────────────────────────
        // 8. BOOKINGS
        // ──────────────────────────────────────────
        $departures = Departure::with('product')->where('status', 'open')->get();
        $bookingCount = 0;

        if ($departures->count() > 0) {
            $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            $paymentStatuses = ['unpaid', 'waiting_verify', 'paid'];

            foreach ($customers as $index => $customer) {
                // Each customer gets 2 bookings
                for ($b = 0; $b < 2; $b++) {
                    $departure = $departures->random();
                    $qty = rand(1, 4);
                    $unitPrice = $departure->price;
                    $totalPrice = $unitPrice * $qty;
                    $status = $statuses[array_rand($statuses)];
                    $paymentStatus = $status === 'cancelled' ? 'unpaid' : $paymentStatuses[array_rand($paymentStatuses)];

                    Booking::firstOrCreate(
                        [
                            'user_id' => $customer->id,
                            'departure_id' => $departure->id,
                            'product_id' => $departure->product_id,
                        ],
                        [
                            'quantity' => $qty,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                            'booking_date' => $departure->departure_date,
                            'note' => $b === 0 ? 'Cần phòng view biển' : null,
                            'customer_name' => $customer->name,
                            'customer_email' => $customer->email,
                            'customer_phone' => '09' . rand(10000000, 99999999),
                            'customer_age' => rand(22, 55),
                            'transaction_code' => 'TM' . strtoupper(Str::random(8)),
                            'payment_method' => 'bank_transfer',
                            'payment_status' => $paymentStatus,
                            'status' => $status,
                            'confirmed_at' => in_array($status, ['confirmed', 'completed']) ? now() : null,
                            'paid_at' => $paymentStatus === 'paid' ? now() : null,
                        ]
                    );
                    $bookingCount++;
                }
            }
        }
        $this->command->info('✅ Bookings: ' . $bookingCount . ' đơn đặt tour');

        // ──────────────────────────────────────────
        // 9. NOTIFICATIONS
        // ──────────────────────────────────────────
        $notifCount = 0;
        $bookings = Booking::with('product')->get();
        foreach ($bookings->take(6) as $booking) {
            Notification::firstOrCreate(
                ['user_id' => $booking->user_id, 'booking_id' => $booking->id, 'type' => 'booking_confirmed'],
                [
                    'title' => 'Đơn đặt tour đã được xác nhận',
                    'message' => 'Đơn đặt tour "' . ($booking->product->name ?? 'Tour') . '" (Mã: ' . $booking->transaction_code . ') đã được xác nhận thành công.',
                    'link' => '/bookings/' . $booking->id,
                    'is_read' => (bool) rand(0, 1),
                    'read_at' => rand(0, 1) ? now() : null,
                ]
            );
            $notifCount++;
        }
        $this->command->info('✅ Notifications: ' . $notifCount . ' thông báo');

        $this->command->info('');
        $this->command->info('🎉 Hoàn tất tạo dữ liệu mẫu!');
    }
}
