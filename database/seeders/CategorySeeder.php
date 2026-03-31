<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Tour Biển',
            'slug' => 'tour-bien',
            'description' => 'Các tour du lịch tới các bãi biển đẹp nổi tiếng.',
        ]);

        Category::create([
            'name' => 'Tour Núi - Khám Phá',
            'slug' => 'tour-nui-kham-pha',
            'description' => 'Trải nghiệm du lịch khám phá và leo núi hùng vĩ.',
        ]);
    }
}
