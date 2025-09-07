<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show current user's cart
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        return $cart->load('items.product');
    }

    // Add product to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = $cart->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price_at_add' => Product::find($request->product_id)->price,
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }

    // Update cart item quantity
    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart item updated']);
    }

    // Remove item from cart
    public function destroy(CartItem $item)
    {
        $item->delete();
        return response()->json(['message' => 'Cart item removed']);
    }
}
