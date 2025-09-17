<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // POST /api/categories
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100','unique:categories,name'],
            'description' => ['nullable','string','max:1000'],
            'status'      => ['required','boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        }

        $category = new Category();
        $category->name        = $data['name'];
        $category->description = $data['description'] ?? null;
        $category->status      = (bool) $data['status'];
        $category->image_path  = $path;
        $category->save();

        return response()->json(['message' => 'Category created', 'data' => $category], 201);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name'         => ['sometimes','required','string','max:100', Rule::unique('categories','name')->ignore($category->id)],
            'description'  => ['nullable','string','max:1000'],
            'status'       => ['sometimes','required','boolean'],
            'image'        => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
            'remove_image' => ['sometimes','boolean'],
        ]);

        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('categories', 'public');
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $category->image_path = $newPath;
        } elseif (!empty($data['remove_image']) && $category->image_path) {
            Storage::disk('public')->delete($category->image_path);
            $category->image_path = null;
        }

        if (array_key_exists('name', $data))        $category->name = $data['name'];
        if (array_key_exists('description', $data)) $category->description = $data['description'];
        if (array_key_exists('status', $data))      $category->status = (bool) $data['status'];

        $category->save();

        return response()->json(['message' => 'Category updated', 'data' => $category]);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
