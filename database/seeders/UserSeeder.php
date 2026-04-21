<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default admin account
        User::firstOrCreate(
            ['email' => 'admin@tour.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
                'role' => 1,
            ]
        );

        // Default customer account
        User::firstOrCreate(
            ['email' => 'customer@tour.com'],
            [
                'name' => 'Customer User',
                'password' => bcrypt('12345678'),
                'role' => 0,
            ]
        );
    }
}
