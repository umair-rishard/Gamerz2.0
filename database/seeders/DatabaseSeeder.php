<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories, products, and orders
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class, // ✅ add this line
        ]);

        // Demo user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Admin with 2FA capability
        Admin::updateOrCreate(
            ['email' => 'umairrishard54@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(), // required by Jetstream/Sanctum
            ]
        );
    }
}
