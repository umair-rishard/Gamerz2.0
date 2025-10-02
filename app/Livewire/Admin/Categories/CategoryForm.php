<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CategoryForm extends Component
{
    use WithFileUploads;

    public ?Category $category = null;
    public ?int $categoryId = null;

    // Form fields
    public string $name = '';
    public ?string $description = null;
    public bool $status = true;
    public $image;                
    public ?string $existingImage = null; 

    
    public function mount($category = null): void
    {
        if ($category instanceof Category && $category->exists) {
            $this->category      = $category;
            $this->categoryId    = $category->id;
            $this->name          = (string) $category->name;
            $this->description   = $category->description;
            $this->status        = (bool) $category->status;
            $this->existingImage = $category->image_path;
        }
    }

    protected function rules(): array
    {
        return [
            'name'        => ['required','string','max:100', Rule::unique('categories','name')->ignore($this->categoryId)],
            'description' => ['nullable','string','max:1000'],
            'status'      => ['required','boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp,avif','max:2048'],
        ];
    }

    public function updated($field): void
    {
        $this->validateOnly($field);
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['image_path'] = $this->existingImage; 

        // Upload new image 
        if ($this->image) {
            $path = $this->image->store('categories', 'public');
            $data['image_path'] = $path;

            //  delete old one only AFTER saving new path
            if ($this->existingImage && $this->existingImage !== $path) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $this->existingImage = $path; 
        }

        if ($this->categoryId) {
            $this->category->update([
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => (bool) $data['status'],
                'image_path'  => $data['image_path'],
            ]);
            session()->flash('success', 'Category updated.');
        } else {
            $this->category = Category::create([
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => (bool) $data['status'],
                'image_path'  => $data['image_path'],
            ]);
            $this->categoryId = $this->category->id;
            session()->flash('success', 'Category created.');
        }

        // Back to list
        redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.categories.category-form');
    }
}
