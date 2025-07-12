<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user instanceof User ? $user : User::findOrFail($user);
        $this->user->load('roles', 'permissions');
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
