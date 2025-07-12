<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserNotificationSetting;

class NotificationSettings extends Component
{
    public $via_app;
    public $via_email;
    public $via_telegram;
    public $via_whatsapp;

    public function mount()
    {
        $settings = Auth::user()->notificationSettings;
        $this->via_app = $settings->via_app ?? true;
        $this->via_email = $settings->via_email ?? true;
        $this->via_telegram = $settings->via_telegram ?? false;
        $this->via_whatsapp = $settings->via_whatsapp ?? false;
    }

    public function save()
    {
        $user = Auth::user();
        $user->notificationSettings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'via_app' => $this->via_app,
                'via_email' => $this->via_email,
                'via_telegram' => $this->via_telegram,
                'via_whatsapp' => $this->via_whatsapp,
            ]
        );
        session()->flash('success', 'Notification settings updated!');
    }

    public function render()
    {
        return view('livewire.user.notification-settings');
    }
} 