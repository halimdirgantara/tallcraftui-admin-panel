<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Edit extends Component
{
    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public $via_app;
    public $via_email;
    public $via_telegram;
    public $via_whatsapp;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->via_app = $user->notificationSettings->via_app ? true: false;
        $this->via_email = $user->notificationSettings->via_email ? true: false;
        $this->via_telegram = $user->notificationSettings->via_telegram ? true: false;
        $this->via_whatsapp = $user->notificationSettings->via_whatsapp ? true: false;

        

        // dd($this->via_app, $this->via_email, $this->via_telegram, $this->via_whatsapp);
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        session()->flash('success', 'Profile updated successfully!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }
        $user->update([
            'password' => Hash::make($this->password),
        ]);
        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('success', 'Password updated successfully!');
    }

    public function updateNotificationSettings()
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
        session()->flash('success', 'Notification settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile.edit')->layout('layouts.admin');
    }
} 