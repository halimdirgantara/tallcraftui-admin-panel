<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRoles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'selectedRoles' => 'array',
    ];

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if (!empty($this->selectedRoles)) {
            $user->assignRole($this->selectedRoles);
        }

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'roles' => $this->selectedRoles,
                'created_by' => Auth::user()->id,
            ])
            ->log('User created');

        session()->flash('success', 'User created successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.admin.users.create', [
            'roles' => $roles,
        ]);
    }
}
