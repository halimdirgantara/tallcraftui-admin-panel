<div>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="via_app">
                <span>App Notifications</span>
            </label>
        </div>
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="via_email">
                <span>Email Notifications</span>
            </label>
        </div>
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="via_telegram">
                <span>Telegram Notifications</span>
            </label>
        </div>
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="via_whatsapp">
                <span>WhatsApp Notifications</span>
            </label>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        @if (session()->has('success'))
            <div class="text-green-600 mt-2">{{ session('success') }}</div>
        @endif
    </form>
</div> 