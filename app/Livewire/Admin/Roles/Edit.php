<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public Role $role;
    public $name = '';
    public $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'selectedPermissions' => 'array',
    ];

    public function mount($role)
    {
        $this->role = $role instanceof Role ? $role : Role::findOrFail($role);
        $this->role->load('permissions');
        $this->name = $this->role->name;
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'selectedPermissions' => 'array',
        ]);

        $oldData = [
            'name' => $this->role->name,
            'permissions' => $this->role->permissions->pluck('name')->toArray(),
        ];

        $this->role->update(['name' => $this->name]);

        // Sync permissions
        $this->role->syncPermissions($this->selectedPermissions);

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($this->role)
            ->withProperties([
                'old_data' => $oldData,
                'new_data' => [
                    'name' => $this->name,
                    'permissions' => $this->selectedPermissions,
                ],
                'updated_by' => Auth::user()->id,
            ])
            ->log('Role updated');

        session()->flash('success', 'Role updated successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'other';
        });
        
        return view('livewire.admin.roles.edit', [
            'permissions' => $permissions,
        ]);
    }
}
