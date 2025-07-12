<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = ['notificationReceived' => 'notificationReceived'];

    public function mount()
    {
        $this->notificationReceived();
    }

    public function notificationReceived($notification = null)
    {
        $user = Auth::user();
        $this->notifications = $user->unreadNotifications()->latest()->limit(10)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
        $this->dispatch('notifications-updated');
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        $this->notificationReceived();
    }

    public function clearAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        $this->notificationReceived();
    }

    public function render()
    {
        return view('livewire.user.notifications');
    }
} 