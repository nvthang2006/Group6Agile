<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tài khoản Admin
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@tour.com'],
            [
                'name' => 'Quản Trị Viên',
                'password' => bcrypt('12345678'),
                'role' => 1,
            ]
        );

        // Tài khoản Khách hàng
        \App\Models\User::firstOrCreate(
            ['email' => 'customer@tour.com'],
            [
                'name' => 'Khách Hàng',
                'password' => bcrypt('12345678'),
                'role' => 0,
            ]
        );
    }
}
