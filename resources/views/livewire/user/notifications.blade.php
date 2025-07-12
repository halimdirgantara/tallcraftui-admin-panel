<div x-data="{ open: false }" x-init="if (window.Laravel && window.Laravel.userId) {
    window.Echo.private('App.Models.User.' + window.Laravel.userId)
        .notification((notification) => {
            $wire.notificationReceived(notification);

            if (window.Notification && Notification.permission === 'granted') {
                new Notification('New Notification', {
                    body: notification.message,
                    icon: '/favicon.ico'
                });
            } else if (window.Notification && Notification.permission !== 'denied') {
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        new Notification('New Notification', {
                            body: notification.message,
                            icon: '/favicon.ico'
                        });
                    }
                });
            }
        });
}

$wire.on('notifications-updated', () => {
    // Optional: Add animation or sound
});">

    <button @click="open = !open" class="relative focus:outline-none">
        <x-icon name="bell" class="w-5 h-5 sm:w-6 sm:h-6  dark:text-white" />
        @if ($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-3 w-72 sm:w-80 bg-white dark:bg-gray-800 shadow-2xl rounded-xl z-50 border border-gray-200 dark:border-gray-700 transition-all duration-200">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-700">
            <span class="font-semibold text-base dark:text-white">Notifications</span>
            @if($notifications->count())
                <button wire:click="clearAll" class="text-xs text-red-500 hover:underline focus:outline-none">Clear all</button>
            @endif
        </div>
        <ul class="max-h-60 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($notifications as $notification)
                <li class="flex flex-col gap-1 px-5 py-3 bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                    <span class="text-sm text-gray-800 dark:text-gray-100">{{ $notification->data['message'] ?? '' }}</span>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                        <button wire:click="markAsRead('{{ $notification->id }}')"
                            class="text-xs text-blue-600 hover:underline focus:outline-none">Mark as read</button>
                    </div>
                </li>
            @empty
                <li class="px-5 py-6 text-center text-gray-400 dark:text-gray-400 text-sm">No notifications</li>
            @endforelse
        </ul>
    </div>
</div>
