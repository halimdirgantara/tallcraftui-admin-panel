<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRoles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
        'selectedRoles' => 'array',
    ];

    public function mount($user)
    {
        $this->user = $user instanceof User ? $user : User::findOrFail($user);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->selectedRoles = $this->user->roles->pluck('name')->toArray();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'selectedRoles' => 'array',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $this->user->update(['password' => Hash::make($this->password)]);
        }

        // Sync roles
        $this->user->syncRoles($this->selectedRoles);

        session()->flash('success', 'User updated successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.admin.users.edit', [
            'roles' => $roles,
        ]);
    }
}
