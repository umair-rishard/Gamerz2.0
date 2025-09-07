<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
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
        $cart = Cart::with('items.product')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total' => $cart->items->sum(fn($item) => $item->quantity * $item->price_at_add),
            ]);

            // Move items from cart to order_items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_add,
                ]);
            }

            // Clear the cart
            $cart->items()->delete();

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }
}
