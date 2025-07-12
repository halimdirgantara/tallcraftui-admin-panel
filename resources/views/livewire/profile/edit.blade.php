<div class="space-y-6">
    <x-card class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <x-icon name="user" class="w-5 h-5 mr-2" />
            Profile Information
        </h3>
        <form wire:submit.prevent="updateProfile" class="space-y-4">
            <x-input label="Name" name="name" icon="user" wire:model.defer="name" required />
            <x-input label="Email" name="email" icon="envelope" wire:model.defer="email" required />
            <div class="flex justify-end">
                <x-button type="submit" color="primary">
                    <x-icon name="arrow-up-tray" class="w-4 h-4 mr-1" />
                    Update Profile
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <x-icon name="key" class="w-5 h-5 mr-2" />
            Change Password
        </h3>
        <form wire:submit.prevent="updatePassword" class="space-y-4">
            <x-password label="Current Password" name="current_password" wire:model.defer="current_password" required />
            <x-password label="New Password" name="password" wire:model.defer="password" required />
            <x-password label="Confirm New Password" name="password_confirmation"
                wire:model.defer="password_confirmation" required />
            <div class="flex justify-end">
                <x-button type="submit" color="primary">
                    <x-icon name="key" class="w-4 h-4 mr-1" />
                    Change Password
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <x-icon name="key" class="w-5 h-5 mr-2" />
            Notification Settings
        </h3>
        <form wire:submit.prevent="updateNotificationSettings" class="space-y-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Notification Settings</h2>
            <x-toggle label="App Notifications" wire:model="via_app" class="dark:text-white" />
            <x-toggle label="Email Notifications" wire:model="via_email" class="dark:text-white" />
            <x-toggle label="Telegram Notifications" wire:model="via_telegram"
                class="dark:text-white" />
            <x-toggle label="WhatsApp Notifications" wire:model="via_whatsapp"
                class="dark:text-white" />
            <x-button type="submit" color="primary" class="w-full">
                Save
            </x-button>
        </form>
    </x-card>
    @if (session()->has('success'))
        <div class="text-green-600 dark:text-green-400 mt-2 text-center">{{ session('success') }}</div>
    @endif
</div>
