<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | USER ENDPOINTS
    |----------------------------------------------------------------------
    */

    // GET /api/products → User list
    public function userIndex(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);

        $products = Product::with('category')
            ->orderByDesc('created_at')
            ->paginate(max(1, $perPage));

        return response()->json($products->through(function ($p) {
            return [
                'id'           => $p->id,
                'name'         => $p->name,
                'description'  => $p->description,
                'price'        => (float) $p->price,
                'stock'        => $p->stock,
                'category_id'  => $p->category_id,
                'category'     => $p->category?->name,
                'image_url'    => $p->image_path ? asset('storage/' . $p->image_path) : null,
                'specs'        => $p->specs ? json_decode($p->specs, true) : null,
                'extra_images' => $p->extra_images ? json_decode($p->extra_images, true) : [], // ✅ NEW
            ];
        }));
    }

    // GET /api/products/{id} → User detail
    public function userShow($id)
    {
        $p = Product::with('category')->findOrFail($id);

        return response()->json([
            'id'           => $p->id,
            'name'         => $p->name,
            'description'  => $p->description,
            'price'        => (float) $p->price,
            'stock'        => $p->stock,
            'category_id'  => $p->category_id,
            'category'     => $p->category?->name,
            'image_url'    => $p->image_path ? asset('storage/' . $p->image_path) : null,
            'specs'        => $p->specs ? json_decode($p->specs, true) : null,
            'extra_images' => $p->extra_images ? json_decode($p->extra_images, true) : [], // ✅ NEW
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | ADMIN ENDPOINTS
    |----------------------------------------------------------------------
    */

    // GET /api/admin-products → List
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);
        $q       = trim((string) $request->query('q', ''));
        $cat     = $request->query('category'); // expects ID

        $query = Product::with('category')->orderByDesc('created_at');

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                if (is_numeric($q)) {
                    $w->orWhere('id', (int) $q);
                }
                $w->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"));
            });
        }

        if (!is_null($cat) && $cat !== '') {
            if (is_numeric($cat)) {
                $query->where('category_id', (int) $cat);
            }
        }

        $products = $query->paginate(max(1, $perPage));

        return response()->json($products->through(function ($p) {
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'description' => $p->description,
                'price'       => number_format($p->price, 2), 
                'stock'       => $p->stock,
                'category_id' => $p->category_id,
                'category'    => $p->category?->name,
                'image_url'   => $p->image_path ? asset('storage/' . $p->image_path) : null,
            ];
        }));
    }

    // GET /api/admin-products/{id} → Show single
    public function show($id)
    {
        $p = Product::with('category')->findOrFail($id);

        return response()->json([
            'id'          => $p->id,
            'name'        => $p->name,
            'description' => $p->description,
            'price'       => number_format($p->price, 2),
            'stock'       => $p->stock,
            'category_id' => $p->category_id,
            'category'    => $p->category?->name,
            'image_url'   => $p->image_path ? asset('storage/' . $p->image_path) : null,
        ]);
    }

    // POST /api/admin-products → Create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if (isset($validated['price'])) {
            $validated['price'] = (float) str_replace(',', '', $validated['price']);
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created',
            'product' => $product
        ], 201);
    }

    // PATCH /api/admin-products/{product} → Update
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required',
            'stock'       => 'sometimes|required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if (isset($validated['price'])) {
            $validated['price'] = (float) str_replace(',', '', $validated['price']);
        }

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated',
            'product' => $product->fresh()
        ]);
    }

    // DELETE /api/admin-products/{product} → Delete
    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
