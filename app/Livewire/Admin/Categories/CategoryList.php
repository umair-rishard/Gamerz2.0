<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryList extends Component
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
        $cat = Category::findOrFail($id);
        $cat->delete();

        session()->flash('success', 'Category deleted.');
        $this->resetPage();
    }

    public function render()
    {
        $s = trim($this->search);

        $categories = Category::query()
            ->withCount('products') 
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

        return view('livewire.admin.categories.category-list', [
            'categories' => $categories,
        ]);
    }
}
