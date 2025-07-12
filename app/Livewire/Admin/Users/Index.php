<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        // Store user data for logging before deletion
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
        ];

        $user->delete();

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'deleted_user' => $userData,
                'deleted_by' => Auth::user()->id,
            ])
            ->log('User deleted');

        session()->flash('success', 'User deleted successfully.');
    }

    public function render()
    {
        $query = User::with('roles');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->roleFilter);
            });
        }

        $users = $query->paginate($this->perPage);
        $roles = Role::all();

        return view('livewire.admin.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
