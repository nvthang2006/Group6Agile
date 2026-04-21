<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tour Bien Dao',
                'description' => 'Kham pha cac bai bien dep va dao hoang so.',
                'slug' => Str::slug('Tour Bien Dao'),
            ],
            [
                'name' => 'Tour Vung Nui',
                'description' => 'Trai nghiem leo nui, san may, va hoa minh vao thien nhien.',
                'slug' => Str::slug('Tour Vung Nui'),
            ],
            [
                'name' => 'Nghi Duong Cao Cap',
                'description' => 'Dich vu nghi duong chat luong cao tai cac diem den noi bat.',
                'slug' => Str::slug('Nghi Duong Cao Cap'),
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        $bienDaoId = Category::where('slug', Str::slug('Tour Bien Dao'))->first()->id;
        $vungNuiId = Category::where('slug', Str::slug('Tour Vung Nui'))->first()->id;
        $nghiDuongId = Category::where('slug', Str::slug('Nghi Duong Cao Cap'))->first()->id;

        $products = [
            [
                'name' => 'Ky Nghi Con Dao 3 Ngay 2 Dem',
                'slug' => Str::slug('Ky Nghi Con Dao 3 Ngay 2 Dem'),
                'price' => 3500000,
                'sale_price' => 2990000,
                'image' => 'https://picsum.photos/seed/condao/800/600',
                'description' => 'Tam bien va kham pha lich su, thien nhien tai Con Dao.',
                'category_id' => $bienDaoId,
            ],
            [
                'name' => 'Kham Pha Phu Quoc Mui Nai',
                'slug' => Str::slug('Kham Pha Phu Quoc Mui Nai'),
                'price' => 4500000,
                'sale_price' => null,
                'image' => 'https://picsum.photos/seed/phuquoc/800/600',
                'description' => 'Thuong thuc hai san, tam bien va nghi duong tai Phu Quoc.',
                'category_id' => $bienDaoId,
            ],
            [
                'name' => 'San May Ta Xua Moc Chau',
                'slug' => Str::slug('San May Ta Xua Moc Chau'),
                'price' => 2200000,
                'sale_price' => 1890000,
                'image' => 'https://picsum.photos/seed/taxua/800/600',
                'description' => 'Hanh trinh san may va kham pha cao nguyen Moc Chau.',
                'category_id' => $vungNuiId,
            ],
            [
                'name' => 'Leo Nui Fansipan Sapa',
                'slug' => Str::slug('Leo Nui Fansipan Sapa'),
                'price' => 3800000,
                'sale_price' => 3500000,
                'image' => 'https://picsum.photos/seed/sapa/800/600',
                'description' => 'Chinh phuc Fansipan va trai nghiem van hoa vung cao.',
                'category_id' => $vungNuiId,
            ],
            [
                'name' => 'Nghi Duong InterContinental Da Nang',
                'slug' => Str::slug('Nghi Duong InterContinental Da Nang'),
                'price' => 15000000,
                'sale_price' => 13500000,
                'image' => 'https://picsum.photos/seed/intercon/800/600',
                'description' => 'Nghi duong cao cap voi dich vu chuan quoc te tai Da Nang.',
                'category_id' => $nghiDuongId,
            ],
            [
                'name' => 'Du Thuyen Vinh Ha Long 5 Sao',
                'slug' => Str::slug('Du Thuyen Vinh Ha Long 5 Sao'),
                'price' => 8500000,
                'sale_price' => null,
                'image' => 'https://picsum.photos/seed/halong/800/600',
                'description' => 'Trai nghiem du thuyen sang trong tren Vinh Ha Long.',
                'category_id' => $nghiDuongId,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
