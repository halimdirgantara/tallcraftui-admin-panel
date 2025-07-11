<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Show extends Component
{
    public Role $role;

    public function mount($role)
    {
        $this->role = $role instanceof Role ? $role : Role::findOrFail($role);
        $this->role->load('permissions');
    }

    public function render()
    {
        return view('livewire.admin.roles.show');
    }
}
