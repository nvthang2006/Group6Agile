<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Giả định đã có ít nhất 1 User tồn tại từ DatabaseSeeder

        if ($user) {
            Post::create([
                'title' => 'Top 5 bãi biển đẹp nhất Việt Nam 2026',
                'slug' => 'top-5-bai-bien-dep-nhat-viet-nam-2026',
                'content' => 'Nội dung chia sẻ kinh nghiệm du lịch biển cực kỳ chi tiết, danh sách này chắc chắn sẽ làm khó việc chọn lựa chuyến đi tiếp theo của bạn.',
                'image' => 'top-5-bien.jpg',
                'user_id' => $user->id,
            ]);
            
            Post::create([
                'title' => 'Cần chuẩn bị gì khi leo núi Fansipan?',
                'slug' => 'can-chuan-bi-gi-khi-leo-nui-fansipan',
                'content' => 'Một bài viết chia sẻ về các dụng cụ và sức khỏe thể lực cần thiết cho chuyến trekking tuyệt vời.',
                'image' => 'chuan-bi-trekking.jpg',
                'user_id' => $user->id,
            ]);
        }
    }
}
