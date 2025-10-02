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
use Barryvdh\DomPDF\Facade\Pdf;   

class OrderController extends Controller
{
    /**
     * Show current user's orders (with items + products)
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->get();

        //  Add reviewed field explicitly
        $orders->each(function ($order) {
            $order->items->each(function ($item) {
                $item->reviewed = (bool) $item->reviewed;
            });
        });

        return response()->json($orders);
    }

    /**
     * Place a new order from the cart
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $cart = Cart::with('items')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            // Calculate total and validate stock
            $total = 0;
            foreach ($cart->items as $item) {
                $product = Product::find($item->product_id);

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
                'shipping_name'    => $request->shipping_name ?? 'N/A',
                'shipping_phone'   => $request->shipping_phone ?? 'N/A',
                'shipping_address' => $request->shipping_address ?? 'N/A',
                'shipping_city'    => $request->shipping_city ?? 'N/A',
                'shipping_postal'  => $request->shipping_postal ?? 'N/A',
                'payment_method'   => $request->payment_method ?? 'N/A',
            ]);

            // Move items from cart → order_items + update stock
            foreach ($cart->items as $item) {
                $product = Product::find($item->product_id);

                if ($product) {
                    $product->decrement('stock', $item->quantity);

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->price_at_add,
                        'reviewed'   => false, 
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

    /**
     * Show a single order (only if belongs to the user)
     */
    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        //  Add reviewed field explicitly
        $order->items->each(function ($item) {
            $item->reviewed = (bool) $item->reviewed;
        });

        return response()->json($order);
    }

    /**
     * Download Receipt as PDF
     */
    public function downloadReceipt($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('orders.receipt-pdf', compact('order'));

        return $pdf->download("order-{$order->id}-receipt.pdf");
    }
}
