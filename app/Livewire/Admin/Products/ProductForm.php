<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Component
{
    use WithFileUploads;

    public ?Product $product = null;
    public ?int $productId = null;

    // Form fields
    public string $name = '';
    public ?string $description = null;
    public float $price = 0;
    public int $stock = 0;
    public ?int $category_id = null;
    public $image;                 // Livewire temp file
    public ?string $existingImage = null; // store old image path

    public function mount($product = null): void
    {
        if ($product instanceof Product && $product->exists) {
            $this->product       = $product;
            $this->productId     = $product->id;
            $this->name          = $product->name;
            $this->description   = $product->description;
            $this->price         = $product->price;
            $this->stock         = $product->stock;
            $this->category_id   = $product->category_id;
            $this->existingImage = $product->image;
        }
    }

    protected function rules(): array
    {
        return [
            'name'        => ['required','string','max:150'],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        // handle image upload
        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $data['image'] = $path;

            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
        } else {
            $data['image'] = $this->existingImage;
        }

        // Save product
        if ($this->productId) {
            $this->product->update($data);
            session()->flash('success', 'Product updated successfully.');
        } else {
            $this->product = Product::create($data);
            $this->productId = $this->product->id;
            session()->flash('success', 'Product created successfully.');
        }

        redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.product-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
