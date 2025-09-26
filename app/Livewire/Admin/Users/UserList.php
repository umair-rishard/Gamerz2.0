<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        if ($user = User::find($id)) {
            $name = $user->name;
            $user->delete();

            // show toast
            $this->dispatch('notify', message: "User {$name} deleted.");

            // simple + safe: reset paginator to avoid `$page` property errors
            $this->resetPage();
        }
    }

    public function render()
    {
        $users = User::query()
            ->withCount('orders') // gives $user->orders_count
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalUsers = User::count();

        return view('livewire.admin.users.user-list', compact('users', 'totalUsers'));
    }
}
