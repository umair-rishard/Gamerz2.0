<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptops = Category::where('slug', 'laptops')->first();
        $keyboards = Category::where('slug', 'keyboards')->first();

        Product::create([
            'name' => 'Gaming Laptop',
            'slug' => 'gaming-laptop',
            'description' => 'High performance laptop for gaming.',
            'price' => 1500.00,
            'stock' => 10,
            'image' => 'laptop.png',
            'category_id' => $laptops->id,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'slug' => 'mechanical-keyboard',
            'description' => 'RGB backlit mechanical keyboard.',
            'price' => 120.00,
            'stock' => 25,
            'image' => 'keyboard.png',
            'category_id' => $keyboards->id,
        ]);
    }
}
