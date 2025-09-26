<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Show current user's orders
    public function index()
    {
        return Order::with('items.product')
            ->where('user_id', Auth::id())
            ->get();
    }

    // Place a new order from cart
    public function store(Request $request)
    {
        $userId = Auth::id();
        $cart = Cart::with('items')->where('user_id', $userId)->first(); // no eager load product to avoid stale data

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            // Calculate total and validate stock
            $total = 0;
            foreach ($cart->items as $item) {
                $product = Product::find($item->product_id); // fetch fresh from DB

                if (!$product) {
                    throw new \Exception("Product not found for cart item.");
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for {$product->name}. Available: {$product->stock}, Requested: {$item->quantity}");
                }

                $total += $item->quantity * $item->price_at_add;
            }

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'status'  => 'pending',
                'total'   => $total,
            ]);

            // Move items from cart to order_items and decrement stock
            foreach ($cart->items as $item) {
                $product = Product::find($item->product_id); // always fresh

                if ($product) {
                    // Decrement stock safely
                    $product->decrement('stock', $item->quantity);

                    // Create order item
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->price_at_add,
                    ]);
                }
            }

            // Clear the cart
            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'order'   => $order->load('items.product')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }
}
