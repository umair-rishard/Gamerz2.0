<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfile extends Component
{
    public $admin;

    // Profile fields
    public $name = '';
    public $email = '';

    // Password fields
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    // Delete account confirmation
    public $confirm_password_for_delete = '';

    public function mount()
    {
        // Try to get the admin via session guard. If there is no session,
        // we still render the page (Axios token flow keeps working).
        $this->admin = Auth::guard('admin')->user();

        if (! $this->admin) {
            // Leave fields empty; the UI will still load.
            $this->name  = '';
            $this->email = '';
            return;
        }

        $this->name  = $this->admin->name ?? '';
        $this->email = $this->admin->email ?? '';
    }

    public function updateProfile()
    {
        if (! $this->admin) {
            session()->flash('error_profile', 'Not logged in.');
            return;
        }

        $this->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('admins', 'email')->ignore($this->admin->id),
            ],
        ]);

        $this->admin->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success_profile', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        if (! $this->admin) {
            session()->flash('error_password', 'Not logged in.');
            return;
        }

        $this->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($this->current_password, $this->admin->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $this->admin->update([
            'password' => Hash::make($this->password),
        ]);

        // Clear fields
        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('success_password', 'Password changed successfully.');
    }

    public function deleteAccount()
    {
        if (! $this->admin) {
            session()->flash('error_delete', 'Not logged in.');
            return;
        }

        $this->validate([
            'confirm_password_for_delete' => ['required'],
        ]);

        if (! Hash::check($this->confirm_password_for_delete, $this->admin->password)) {
            $this->addError('confirm_password_for_delete', 'Incorrect password.');
            return;
        }

        // Log out and delete
        Auth::guard('admin')->logout();
        $id = $this->admin->id;

        $this->admin->delete();

        // End session and redirect
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', "Admin account #{$id} deleted.");
    }

    public function render()
    {
        return view('livewire.admin-profile');
    }
}
