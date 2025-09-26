<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // pick a random existing user
        $user = User::inRandomOrder()->first();

        // pick a random existing product
        $product = Product::inRandomOrder()->first();

        // create 5 dummy orders
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'status'  => ['pending', 'confirmed', 'cancelled'][array_rand([0,1,2])],
                'total'   => $product->price * rand(1,3),
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => rand(1,3),
                'price'      => $product->price,
            ]);
        }
    }
}
