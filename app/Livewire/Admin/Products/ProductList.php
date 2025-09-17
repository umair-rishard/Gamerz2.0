<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;

    protected $queryString = [
        'search'  => ['except' => ''],
        'page'    => ['except' => 1],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
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
            ->when($s !== '', function ($q) use ($s) {
                $q->where(function ($w) use ($s) {
                    if (is_numeric($s)) {
                        $w->orWhere('id', (int) $s);
                    }
                    $w->orWhere('name', 'like', "%{$s}%")
                      ->orWhere('description', 'like', "%{$s}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.products.product-list', [
            'products' => $products,
        ]);
    }
}
