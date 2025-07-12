<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        
        // Prevent deleting Super Admin role
        if ($role->name === 'Super Admin') {
            session()->flash('error', 'Super Admin role cannot be deleted.');
            return;
        }

        // Store role data for logging before deletion
        $roleData = [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->toArray(),
        ];

        $role->delete();

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'deleted_role' => $roleData,
                'deleted_by' => Auth::user()->id,
            ])
            ->log('Role deleted');

        session()->flash('success', 'Role deleted successfully.');
    }

    public function render()
    {
        $query = Role::with('permissions');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $roles = $query->paginate($this->perPage);

        return view('livewire.admin.roles.index', [
            'roles' => $roles,
        ]);
    }
}
