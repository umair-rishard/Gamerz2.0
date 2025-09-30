<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * GET /api/cart
     * Return the user's cart with items + products
     */
    public function index(): JsonResponse
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product');

        // Return a consistent shape with top-level "items" for easier clients
        return response()->json([
            'id'    => $cart->id,
            'items' => $cart->items->map(function (CartItem $i) {
                return [
                    'id'       => $i->id,
                    'quantity' => $i->quantity,
                    'product'  => [
                        'id'        => $i->product->id,
                        'name'      => $i->product->name,
                        'price'     => $i->product->price,
                        'stock'     => $i->product->stock,
                        'image_url' => method_exists($i->product, 'getImageUrlAttribute')
                            ? $i->product->image_url
                            : (property_exists($i->product, 'image_url') ? $i->product->image_url : null),
                    ],
                ];
            })->values(),
        ]);
    }

    /**
     * POST /api/cart
     * Add product to cart (quantity must be positive)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $item = $cart->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'   => $request->product_id,
                'quantity'     => $request->quantity,
                'price_at_add' => Product::find($request->product_id)->price,
            ]);
        }

        return response()->json(['message' => 'Product added to cart'], 201);
    }

    /**
     * PATCH /api/cart/{item}
     * Set exact quantity for a cart item (>=1).
     * Route-model binding provides the CartItem ($item).
     */
    public function update(Request $request, CartItem $item): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ownership guard
        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart item updated']);
    }

    /**
     * DELETE /api/cart/{item}
     * Remove item from cart (with ownership guard)
     */
    public function destroy(CartItem $item): JsonResponse
    {
        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item->delete();

        return response()->json(['message' => 'Cart item removed']);
    }
}
