<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    public $activeTab = 'general';
    public $appName = '';
    public $appDescription = '';
    public $appUrl = '';
    public $appEmail = '';
    public $appPhone = '';
    public $appAddress = '';
    public $timezone = '';
    public $locale = '';
    public $maintenanceMode = false;
    public $debugMode = false;
    public $registrationEnabled = true;
    public $emailVerification = true;
    public $twoFactorAuth = false;
    public $sessionTimeout = 120;
    public $maxLoginAttempts = 5;
    public $passwordMinLength = 8;
    public $passwordRequireSpecial = true;
    public $passwordRequireNumbers = true;
    public $passwordRequireUppercase = true;

    protected $rules = [
        'appName' => 'required|string|max:255',
        'appDescription' => 'nullable|string|max:500',
        'appUrl' => 'required|url',
        'appEmail' => 'required|email',
        'appPhone' => 'nullable|string|max:20',
        'appAddress' => 'nullable|string|max:500',
        'timezone' => 'required|string',
        'locale' => 'required|string',
        'maintenanceMode' => 'boolean',
        'debugMode' => 'boolean',
        'registrationEnabled' => 'boolean',
        'emailVerification' => 'boolean',
        'twoFactorAuth' => 'boolean',
        'sessionTimeout' => 'required|integer|min:15|max:480',
        'maxLoginAttempts' => 'required|integer|min:1|max:10',
        'passwordMinLength' => 'required|integer|min:6|max:20',
        'passwordRequireSpecial' => 'boolean',
        'passwordRequireNumbers' => 'boolean',
        'passwordRequireUppercase' => 'boolean',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Load settings from config or database
        $this->appName = config('app.name', 'TallCraftUI Admin Panel');
        $this->appDescription = config('app.description', 'A modern admin panel built with Laravel and TallCraftUI');
        $this->appUrl = config('app.url', url('/'));
        $this->appEmail = config('mail.from.address', 'admin@example.com');
        $this->appPhone = config('app.phone', '');
        $this->appAddress = config('app.address', '');
        $this->timezone = config('app.timezone', 'UTC');
        $this->locale = config('app.locale', 'en');
        $this->maintenanceMode = app()->isDownForMaintenance();
        $this->debugMode = config('app.debug', false);
        $this->registrationEnabled = config('auth.registration_enabled', true);
        $this->emailVerification = config('auth.email_verification', true);
        $this->twoFactorAuth = config('auth.two_factor', false);
        $this->sessionTimeout = config('session.lifetime', 120);
        $this->maxLoginAttempts = config('auth.max_attempts', 5);
        $this->passwordMinLength = config('auth.password_min_length', 8);
        $this->passwordRequireSpecial = config('auth.password_require_special', true);
        $this->passwordRequireNumbers = config('auth.password_require_numbers', true);
        $this->passwordRequireUppercase = config('auth.password_require_uppercase', true);
    }

    public function saveGeneralSettings()
    {
        $this->validate([
            'appName' => 'required|string|max:255',
            'appDescription' => 'nullable|string|max:500',
            'appUrl' => 'required|url',
            'appEmail' => 'required|email',
            'appPhone' => 'nullable|string|max:20',
            'appAddress' => 'nullable|string|max:500',
            'timezone' => 'required|string',
            'locale' => 'required|string',
        ]);

        // Save general settings
        Cache::put('app.name', $this->appName, 86400);
        Cache::put('app.description', $this->appDescription, 86400);
        Cache::put('app.url', $this->appUrl, 86400);
        Cache::put('app.email', $this->appEmail, 86400);
        Cache::put('app.phone', $this->appPhone, 86400);
        Cache::put('app.address', $this->appAddress, 86400);
        Cache::put('app.timezone', $this->timezone, 86400);
        Cache::put('app.locale', $this->locale, 86400);

        session()->flash('success', 'General settings updated successfully.');
    }

    public function saveSecuritySettings()
    {
        $this->validate([
            'maintenanceMode' => 'boolean',
            'debugMode' => 'boolean',
            'registrationEnabled' => 'boolean',
            'emailVerification' => 'boolean',
            'twoFactorAuth' => 'boolean',
            'sessionTimeout' => 'required|integer|min:15|max:480',
            'maxLoginAttempts' => 'required|integer|min:1|max:10',
            'passwordMinLength' => 'required|integer|min:6|max:20',
            'passwordRequireSpecial' => 'boolean',
            'passwordRequireNumbers' => 'boolean',
            'passwordRequireUppercase' => 'boolean',
        ]);

        // Save security settings
        Cache::put('app.maintenance_mode', $this->maintenanceMode, 86400);
        Cache::put('app.debug_mode', $this->debugMode, 86400);
        Cache::put('auth.registration_enabled', $this->registrationEnabled, 86400);
        Cache::put('auth.email_verification', $this->emailVerification, 86400);
        Cache::put('auth.two_factor', $this->twoFactorAuth, 86400);
        Cache::put('session.lifetime', $this->sessionTimeout, 86400);
        Cache::put('auth.max_attempts', $this->maxLoginAttempts, 86400);
        Cache::put('auth.password_min_length', $this->passwordMinLength, 86400);
        Cache::put('auth.password_require_special', $this->passwordRequireSpecial, 86400);
        Cache::put('auth.password_require_numbers', $this->passwordRequireNumbers, 86400);
        Cache::put('auth.password_require_uppercase', $this->passwordRequireUppercase, 86400);

        session()->flash('success', 'Security settings updated successfully.');
    }

    public function clearCache()
    {
        Cache::flush();
        session()->flash('success', 'Application cache cleared successfully.');
    }

    public function render()
    {
        $timezones = [
            'UTC' => 'UTC',
            'America/New_York' => 'Eastern Time',
            'America/Chicago' => 'Central Time',
            'America/Denver' => 'Mountain Time',
            'America/Los_Angeles' => 'Pacific Time',
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
            'Asia/Tokyo' => 'Tokyo',
            'Asia/Shanghai' => 'Shanghai',
            'Australia/Sydney' => 'Sydney',
        ];

        $locales = [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'ja' => 'Japanese',
            'zh' => 'Chinese',
            'ar' => 'Arabic',
        ];

        return view('livewire.admin.settings', [
            'timezones' => $timezones,
            'locales' => $locales,
        ]);
    }
} 