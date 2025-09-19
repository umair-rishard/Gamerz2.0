<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // GET /products
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return response()->json($products->through(function ($p) {
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'description' => $p->description,
                'price'       => number_format($p->price, 2),
                'stock'       => $p->stock,
                'category'    => $p->category?->name,
                'image_url'   => $p->image_path 
                                   ? asset('storage/' . $p->image_path) 
                                   : null,
            ];
        }));
    }

    // GET /products/{id}
    public function show($id)
    {
        $p = Product::with('category')->findOrFail($id);

        return response()->json([
            'id'          => $p->id,
            'name'        => $p->name,
            'description' => $p->description,
            'price'       => number_format($p->price, 2),
            'stock'       => $p->stock,
            'category'    => $p->category?->name,
            'image_url'   => $p->image_path 
                               ? asset('storage/' . $p->image_path) 
                               : null,
        ]);
    }
}
