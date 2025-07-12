<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->latest()->limit(10)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.user.notifications');
    }
} 