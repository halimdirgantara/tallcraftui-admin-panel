<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = ['notificationReceived' => 'refreshNotifications'];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications($notification = null)
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->latest()->limit(10)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
        $this->dispatch('notifications-updated');
    }

    public function render()
    {
        return view('livewire.user.notifications');
    }
} 