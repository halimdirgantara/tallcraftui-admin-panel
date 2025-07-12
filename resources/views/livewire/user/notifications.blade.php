<div class="relative">
    <button @click="open = !open" class="relative focus:outline-none">
        <x-icon name="bell" class="w-6 h-6" />
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 shadow-lg rounded-lg z-50">
        <div class="p-4 border-b font-semibold">Notifications</div>
        <ul class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <li class="p-4 border-b last:border-b-0 {{ $notification->read_at ? '' : 'bg-blue-50 dark:bg-blue-900' }}">
                    {{ $notification->data['message'] ?? '' }}
                    <div class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">No notifications</li>
            @endforelse
        </ul>
    </div>
</div> 