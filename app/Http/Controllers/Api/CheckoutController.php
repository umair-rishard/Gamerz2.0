<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // GET /api/checkout  (auth:sanctum)
    public function summary()
    {
        $userId = Auth::id();

        $cart = Cart::with(['items.product'])
            ->where('user_id', $userId)
            ->first();

        $items = [];
        $itemsTotal = 0;

        if ($cart) {
            foreach ($cart->items as $ci) {
                $product = $ci->product;
                $unit = (float)($ci->price_at_add ?? $ci->price ?? 0);
                $qty  = (int)$ci->quantity;
                $sub  = $unit * $qty;
                $itemsTotal += $sub;

                $items[] = [
                    'cart_item_id' => $ci->id,
                    'product_id'   => $product?->id,
                    'name'         => $product?->name ?? 'Product',
                    'image'        => $product?->image_url ?? $product?->image ?? null, // adjust if your column differs
                    'unit_price'   => $unit,
                    'quantity'     => $qty,
                    'subtotal'     => $sub,
                ];
            }
        }

        $discount = 0;
        $shipping = 0;
        $grand    = max(0, $itemsTotal - $discount + $shipping);

        return response()->json([
            'items'  => $items,
            'totals' => [
                'items_total' => $itemsTotal,
                'discount'    => $discount,
                'shipping'    => $shipping,
                'grand_total' => $grand,
                'currency'    => 'LKR',
            ],
        ]);
    }
}
