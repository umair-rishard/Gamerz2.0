<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;

    /** Category filter: /admin/products?category=ID */
    public ?int $category = null;

    protected $queryString = [
        'search'   => ['except' => ''],
        'page'     => ['except' => 1],
        'perPage'  => ['except' => 10],
        'category' => ['except' => null],
    ];

    public function mount(): void
    {
        // read /admin/products?category=ID on first load
        $this->category = request()->integer('category') ?: null;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function clearCategory(): void
    {
        $this->category = null;
        $this->resetPage();
        $this->dispatch('category-cleared');
    }

    public function delete(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted.');
        $this->resetPage();
    }

    public function render()
    {
        $s = trim($this->search);

        $products = Product::with('category')
            ->when($this->category, fn ($q) => $q->where('category_id', $this->category))
            ->when($s !== '', function ($q) use ($s) {
                $q->where(function ($w) use ($s) {
                    if (is_numeric($s)) {
                        $w->orWhere('id', (int) $s);
                    }
                    $w->orWhere('name', 'like', "%{$s}%")
                      ->orWhere('description', 'like', "%{$s}%")
                      ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$s}%"));
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        $selectedCategory = $this->category
            ? Category::select('id', 'name')->find($this->category)
            : null;

        return view('livewire.admin.products.product-list', [
            'products'         => $products,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
