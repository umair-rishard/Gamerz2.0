<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Component
{
    use WithFileUploads;

    public ?Product $product = null;
    public ?int $productId = null;

    public string $name = '';
    public ?string $description = null;
    public float $price = 0.00;   // float, not int
    public int $stock = 0;
    public ?int $category_id = null;
    public $image;
    public ?string $existingImage = null;

    public function mount($product = null): void
    {
        if ($product instanceof Product && $product->exists) {
            $this->product       = $product;
            $this->productId     = $product->id;
            $this->name          = (string) $product->name;
            $this->description   = $product->description;
            $this->price         = (float) $product->price;
            $this->stock         = (int) $product->stock;
            $this->category_id   = $product->category_id;
            $this->existingImage = $product->image_path; 
        }
    }

    protected function rules(): array
    {
        return [
            'name'        => ['required','string','max:150'],
            'description' => ['nullable','string'],
            // allow decimals
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ];
    }

    public function updated($prop): void
    {
        $this->validateOnly($prop);
    }

    public function save(): void
    {
        $data = $this->validate();

        // Normalize price: replace commas with dots
        $normalizedPrice = str_replace(',', '.', $this->price);

        $payload = [
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => (float) $normalizedPrice, // store as float with 2 decimals
            'stock'       => $this->stock,
            'category_id' => $this->category_id,
            'image_path'  => $this->existingImage, 
        ];

        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $payload['image_path'] = $path;

            if ($this->existingImage && $this->existingImage !== $path) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $this->existingImage = $path;
        }

        if ($this->productId) {
            $this->product->update($payload);
            session()->flash('success', 'Product updated successfully.');
        } else {
            $this->product = Product::create($payload);
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
