<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptops = Category::where('slug', 'laptops')->first();
        $keyboards = Category::where('slug', 'keyboards')->first();

        if ($laptops) {
            Product::updateOrCreate(
                ['slug' => 'gaming-laptop'],
                [
                    'name' => 'Gaming Laptop',
                    'description' => 'High performance laptop for gaming.',
                    'price' => 1500.00,
                    'stock' => 10,
                    'image' => 'laptop.png',
                    'category_id' => $laptops->id,
                ]
            );
        }

        if ($keyboards) {
            Product::updateOrCreate(
                ['slug' => 'mechanical-keyboard'],
                [
                    'name' => 'Mechanical Keyboard',
                    'description' => 'RGB backlit mechanical keyboard.',
                    'price' => 120.00,
                    'stock' => 25,
                    'image' => 'keyboard.png',
                    'category_id' => $keyboards->id,
                ]
            );
        }
    }
}
