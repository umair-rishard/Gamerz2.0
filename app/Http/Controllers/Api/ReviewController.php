<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Public: list reviews for a product
     */
    public function index($productId)
    {
        $pid = (int) $productId;

        $reviews = Review::where('product_id', $pid)
            ->orderBy('created_at', 'desc')
            ->orderBy('_id', 'desc')
            ->get();

        // Cast MongoDB _id to string
        $reviews->transform(function ($review) {
            $review->_id = (string) $review->_id;
            return $review;
        });

        return response()->json($reviews);
    }

    /**
     * Auth: get logged-in user’s review for a product
     */
    public function myReview($productId)
    {
        $review = Review::where('product_id', (int) $productId)
            ->where('user_id', Auth::id())
            ->first();

        if ($review) {
            $review->_id = (string) $review->_id; // always string for frontend
        }

        return response()->json($review);
    }

    /**
     * Auth: create a review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => ['required', 'integer'],
            'order_item_id' => ['required', 'integer', 'exists:order_items,id'],
            'rating'        => ['required', 'integer', 'min:1', 'max:5'],
            'text'          => ['required', 'string', 'max:1000'],
        ]);

        $user   = $request->user();
        $avatar = $user->profile_photo_url ?? ($user->avatar ?? null);

        $review = Review::create([
            'user_id'        => $user->id,
            'user_name'      => $user->name ?? 'Anonymous',
            'user_avatar'    => $avatar,
            'product_id'     => (int) $request->product_id,
            'order_item_id'  => (int) $request->order_item_id,
            'rating'         => (int) $request->rating,
            'comment'        => $request->text,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Mark MySQL order_item as reviewed
        if ($orderItem = OrderItem::find($request->order_item_id)) {
            $orderItem->reviewed = true;
            $orderItem->save();
        }

        $review->_id = (string) $review->_id;

        return response()->json([
            'message' => 'Review added successfully',
            'review'  => $review,
        ], 201);
    }

    /**
     * Auth: update own review
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'text'   => ['nullable', 'string', 'max:1000'],
        ]);

        $review = Review::findOrFail($id);

        if ((int) $review->user_id !== (int) Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->update([
            'rating'     => $request->filled('rating') ? (int) $request->rating : $review->rating,
            'comment'    => $request->filled('text')   ? $request->text        : $review->comment,
            'updated_at' => now(),
        ]);

        $review->_id = (string) $review->_id;

        return response()->json([
            'message' => 'Review updated successfully',
            'review'  => $review
        ]);
    }

    /**
     * Auth: delete own review
     *
     * Accepts optional request body "order_item_id" so we can reset MySQL even
     * if older Mongo docs don't have order_item_id stored.
     */
    public function destroy($id, Request $request)
    {
        $review = Review::findOrFail($id);

        if ((int) $review->user_id !== (int) Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Prefer the value stored in Mongo, else the one provided by client
        $orderItemId = $review->order_item_id ?? (int) $request->input('order_item_id');

        if ($orderItemId) {
            if ($orderItem = OrderItem::find($orderItemId)) {
                $orderItem->reviewed = false;
                $orderItem->save();
            }
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }
}
