<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use GeoSot\EnvEditor\Facades\EnvEditor;

class Settings extends Component
{
    public $activeTab = 'general';
    public $appName = '';
    public $appUrl = '';
    public $appEmail = '';
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
        'appUrl' => 'required|url',
        'appEmail' => 'required|string',
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
        // Load settings from .env file using env-editor
        $this->appName = EnvEditor::getKey('APP_NAME', 'TallCraftUI Admin Panel');
        $this->appUrl = EnvEditor::getKey('APP_URL', url('/'));
        $this->appEmail = EnvEditor::getKey('MAIL_FROM_ADDRESS', 'admin@example.com');
        $this->timezone = EnvEditor::getKey('APP_TIMEZONE', 'UTC');
        $this->locale = EnvEditor::getKey('APP_LOCALE', 'en');
        $this->maintenanceMode = app()->isDownForMaintenance();
        $this->debugMode = EnvEditor::getKey('APP_DEBUG', 'false') === 'true';
        $this->registrationEnabled = EnvEditor::getKey('AUTH_REGISTRATION_ENABLED', 'true') === 'true';
        $this->emailVerification = EnvEditor::getKey('AUTH_EMAIL_VERIFICATION', 'true') === 'true';
        $this->twoFactorAuth = EnvEditor::getKey('AUTH_TWO_FACTOR', 'false') === 'true';
        $this->sessionTimeout = (int) EnvEditor::getKey('SESSION_LIFETIME', '120');
        $this->maxLoginAttempts = (int) EnvEditor::getKey('AUTH_MAX_ATTEMPTS', '5');
        $this->passwordMinLength = (int) EnvEditor::getKey('AUTH_PASSWORD_MIN_LENGTH', '8');
        $this->passwordRequireSpecial = EnvEditor::getKey('AUTH_PASSWORD_REQUIRE_SPECIAL', 'true') === 'true';
        $this->passwordRequireNumbers = EnvEditor::getKey('AUTH_PASSWORD_REQUIRE_NUMBERS', 'true') === 'true';
        $this->passwordRequireUppercase = EnvEditor::getKey('AUTH_PASSWORD_REQUIRE_UPPERCASE', 'true') === 'true';
    }

    public function saveGeneralSettings()
    {
        $this->validate([
            'appName' => 'required|string|max:255',
            'appUrl' => 'required|url',
            'appEmail' => 'required|string',
            'timezone' => 'required|string',
            'locale' => 'required|string',
        ]);

        try {
            // Save settings to .env file
            EnvEditor::editKey('APP_NAME', $this->appName);
            EnvEditor::editKey('APP_URL', $this->appUrl);
            EnvEditor::editKey('MAIL_FROM_ADDRESS', $this->appEmail);
            EnvEditor::editKey('APP_TIMEZONE', $this->timezone);
            EnvEditor::editKey('APP_LOCALE', $this->locale);

            session()->flash('success', 'General settings updated successfully in .env file.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update .env file: ' . $e->getMessage());
        }
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

        try {
            // Save security settings to .env file
            EnvEditor::editKey('APP_DEBUG', $this->debugMode ? 'true' : 'false');
            EnvEditor::editKey('AUTH_REGISTRATION_ENABLED', $this->registrationEnabled ? 'true' : 'false');
            EnvEditor::editKey('AUTH_EMAIL_VERIFICATION', $this->emailVerification ? 'true' : 'false');
            EnvEditor::editKey('AUTH_TWO_FACTOR', $this->twoFactorAuth ? 'true' : 'false');
            EnvEditor::editKey('SESSION_LIFETIME', (string) $this->sessionTimeout);
            EnvEditor::editKey('AUTH_MAX_ATTEMPTS', (string) $this->maxLoginAttempts);
            EnvEditor::editKey('AUTH_PASSWORD_MIN_LENGTH', (string) $this->passwordMinLength);
            EnvEditor::editKey('AUTH_PASSWORD_REQUIRE_SPECIAL', $this->passwordRequireSpecial ? 'true' : 'false');
            EnvEditor::editKey('AUTH_PASSWORD_REQUIRE_NUMBERS', $this->passwordRequireNumbers ? 'true' : 'false');
            EnvEditor::editKey('AUTH_PASSWORD_REQUIRE_UPPERCASE', $this->passwordRequireUppercase ? 'true' : 'false');

            session()->flash('success', 'Security settings updated successfully in .env file.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update .env file: ' . $e->getMessage());
        }
    }

    public function toggleMaintenanceMode()
    {
        try {
            if ($this->maintenanceMode) {
                // Enable maintenance mode
                EnvEditor::editKey('APP_MAINTENANCE_MODE', 'true');
                session()->flash('success', 'Maintenance mode enabled.');
            } else {
                // Disable maintenance mode
                EnvEditor::editKey('APP_MAINTENANCE_MODE', 'false');
                session()->flash('success', 'Maintenance mode disabled.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update maintenance mode: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            Cache::flush();
            session()->flash('success', 'Application cache cleared successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to clear cache: ' . $e->getMessage());
        }
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