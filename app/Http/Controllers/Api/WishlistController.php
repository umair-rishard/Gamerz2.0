<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * GET /api/wishlist
     * Show current user's wishlist with product details
     */
    public function index()
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'wishlist' => $wishlist
        ]);
    }

    /**
     * POST /api/wishlist
     * Add a product to the wishlist
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $validated['product_id'],
        ]);

        return response()->json([
            'message'  => 'Product added to wishlist',
            'wishlist' => $wishlist->load('product')
        ], 201);
    }

    /**
     * DELETE /api/wishlist/{id}
     * Remove a product from the wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'message' => 'Wishlist item not found'
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'message' => 'Product removed from wishlist'
        ]);
    }
}
