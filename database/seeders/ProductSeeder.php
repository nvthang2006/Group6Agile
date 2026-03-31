<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryBien = Category::where('slug', 'tour-bien')->first();
        
        if ($categoryBien) {
            Product::create([
                'name' => 'Tour Vịnh Hạ Long 3 Ngày 2 Đêm',
                'slug' => 'tour-vinh-ha-long-3-ngay-2-dem',
                'price' => 2500000,
                'sale_price' => 2100000,
                'description' => 'Trọn gói ăn siêu xịn sò kèm dịch vụ chèo thuyền trên vịnh.',
                'image' => 'ha-long.jpg',
                'category_id' => $categoryBien->id,
            ]);
        }

        $categoryNui = Category::where('slug', 'tour-nui-kham-pha')->first();

        if ($categoryNui) {
            Product::create([
                'name' => 'Trekking Fansipan 2 Ngày 1 Đêm',
                'slug' => 'trekking-fansipan-2-ngay-1-dem',
                'price' => 3500000,
                'sale_price' => null,
                'description' => 'Khám phá nóc nhà Đông Dương cùng hướng dẫn viên bản địa chuyên nghiệp.',
                'image' => 'fansipan.jpg',
                'category_id' => $categoryNui->id,
            ]);
        }
    }
}
