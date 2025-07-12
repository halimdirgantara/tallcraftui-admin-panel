<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Activity Log</h2>
                <p class="mt-1 text-sm text-gray-600">Monitor and track user activities across the system</p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-2">
                @can('delete activity logs')
                    <x-button 
                        color="red" 
                        wire:click="clearAllLogs"
                        wire:confirm="Are you sure you want to clear all activity logs? This action cannot be undone."
                    >
                        <x-icon name="trash" class="w-4 h-4 mr-2" />
                        Clear All Logs
                    </x-button>
                @endcan
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <x-input 
                        label="Search" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search activities..."
                        icon="magnifying-glass"
                    />
                </div>

                <!-- Log Name Filter -->
                <div>
                    <x-select 
                        label="Log Type" 
                        wire:model.live="filterLogName"
                        placeholder="All Types"
                    >
                        <option value="">All Types</option>
                        @foreach($logNames as $logName)
                            <option value="{{ $logName }}">{{ ucfirst($logName) }}</option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Event Filter -->
                <div>
                    <x-select 
                        label="Event" 
                        wire:model.live="filterEvent"
                        placeholder="All Events"
                    >
                        <option value="">All Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event }}">{{ ucfirst($event) }}</option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Date Filter -->
                <div>
                    <x-input 
                        label="Date" 
                        wire:model.live="filterDate"
                        type="date"
                    />
                </div>
            </div>

            <!-- Clear Filters -->
            <div class="mt-4 flex justify-end">
                <x-button 
                    color="gray" 
                    wire:click="clearFilters"
                    size="sm"
                >
                    <x-icon name="x-mark" class="w-4 h-4 mr-2" />
                    Clear Filters
                </x-button>
            </div>
        </div>

        <!-- Activity Log Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activity
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($activities as $activity)
                                <<tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $activity->description }}
                                        </div>
                                        @if($activity->subject)
                                            <div class="text-sm text-gray-500">
                                                {{ class_basename($activity->subject_type) }}: {{ $activity->subject->id ?? 'N/A' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity->causer)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $activity->causer->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $activity->causer->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">System</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($activity->log_name) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $activity->event === 'created' ? 'bg-green-100 text-green-800' : 
                                               ($activity->event === 'updated' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($activity->event === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($activity->event) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $activity->created_at->format('M j, Y g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <x-button 
                                                size="sm" 
                                                color="gray"
                                                wire:click="showActivityDetails({{ $activity->id }})"
                                            >
                                                <x-icon name="eye" class="w-4 h-4" />
                                            </x-button>
                                            @can('delete activity logs')
                                                <x-button 
                                                    size="sm" 
                                                    color="red"
                                                    wire:click="deleteActivity({{ $activity->id }})"
                                                    wire:confirm="Are you sure you want to delete this activity log?"
                                                >
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <x-icon name="document-text" class="mx-auto h-12 w-12 text-gray-400" />
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No activities found</h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                No activity logs match your current filters.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden">
                @forelse($activities as $activity)
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($activity->causer)
                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $activity->causer->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $activity->causer->email }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">System</span>
                                    @endif
                                </div>
                                
                                <div class="text-sm text-gray-900 mb-2">
                                    {{ $activity->description }}
                                </div>
                                
                                @if($activity->subject)
                                    <div class="text-xs text-gray-500 mb-2">
                                        {{ class_basename($activity->subject_type) }}: {{ $activity->subject->id ?? 'N/A' }}
                                    </div>
                                @endif
                                
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($activity->log_name) }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $activity->event === 'created' ? 'bg-green-100 text-green-800' : 
                                           ($activity->event === 'updated' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($activity->event === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($activity->event) }}
                                    </span>
                                </div>
                                
                                <div class="text-xs text-gray-500">
                                    {{ $activity->created_at->format('M j, Y g:i A') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                <x-button 
                                    size="xs" 
                                    color="gray"
                                    wire:click="showActivityDetails({{ $activity->id }})"
                                >
                                    <x-icon name="eye" class="w-3 h-3" />
                                </x-button>
                                @can('delete activity logs')
                                    <x-button 
                                        size="xs" 
                                        color="red"
                                        wire:click="deleteActivity({{ $activity->id }})"
                                        wire:confirm="Are you sure you want to delete this activity log?"
                                    >
                                        <x-icon name="trash" class="w-3 h-3" />
                                    </x-button>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-gray-500">
                            <x-icon name="document-text" class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No activities found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                No activity logs match your current filters.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Activity Details Modal -->
    <x-modal wire:model="showDetails" xl dismissible class="z-90">
        @if($selectedActivity)
            <!-- Modal header -->
            <div class="flex items-center justify-between pb-3 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 capitalize dark:text-white">
                    Activity Details
                </h3>
            </div>

            <!-- Modal body -->
            <div class="pt-5">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $selectedActivity->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Log Type</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($selectedActivity->log_name) }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($selectedActivity->event) }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Causer</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedActivity->causer ? $selectedActivity->causer->name . ' (' . $selectedActivity->causer->email . ')' : 'System' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $selectedActivity->created_at->format('M j, Y g:i:s A') }}</p>
                        </div>
                    </div>
                    
                    @if($selectedActivity->subject)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ class_basename($selectedActivity->subject_type) }} (ID: {{ $selectedActivity->subject->id ?? 'N/A' }})
                            </p>
                        </div>
                    @endif
                    
                    @if($selectedActivity->properties && $selectedActivity->properties->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Properties</label>
                            <div class="mt-1 bg-gray-50 dark:bg-gray-700 rounded-md p-3">
                                @if(str_contains(strtolower($selectedActivity->description), 'login') || str_contains(strtolower($selectedActivity->description), 'logout'))
                                    <div class="space-y-2">
                                        @if($selectedActivity->properties->get('ip_address'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">IP Address:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">{{ $selectedActivity->properties->get('ip_address') }}</span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('browser'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Browser:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">{{ $selectedActivity->properties->get('browser') }} {{ $selectedActivity->properties->get('browser_version') }}</span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('platform'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Platform:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">{{ $selectedActivity->properties->get('platform') }}</span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('device'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Device:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">{{ $selectedActivity->properties->get('device') }}</span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('is_mobile') !== null)
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Device Type:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">
                                                    @if($selectedActivity->properties->get('is_mobile'))
                                                        Mobile
                                                    @elseif($selectedActivity->properties->get('is_tablet'))
                                                        Tablet
                                                    @else
                                                        Desktop
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('referer'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Referer:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100">{{ $selectedActivity->properties->get('referer') }}</span>
                                            </div>
                                        @endif
                                        @if($selectedActivity->properties->get('session_id'))
                                            <div class="flex justify-between">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Session ID:</span>
                                                <span class="text-xs text-gray-900 dark:text-gray-100 font-mono">{{ $selectedActivity->properties->get('session_id') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <pre class="text-xs text-gray-900 dark:text-gray-100 overflow-x-auto">{{ json_encode($selectedActivity->properties->toArray(), JSON_PRETTY_PRINT) }}</pre>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    @if($selectedActivity->changes && $selectedActivity->changes->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Changes</label>
                            <div class="mt-1 bg-gray-50 dark:bg-gray-700 rounded-md p-3">
                                <pre class="text-xs text-gray-900 dark:text-gray-100 overflow-x-auto">{{ json_encode($selectedActivity->changes->toArray(), JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="mt-6 flex justify-end">
                    <x-button 
                        color="gray"
                        wire:click="closeDetails"
                    >
                        Close
                    </x-button>
                </div>
            </div>
        @endif
    </x-modal>
</div> 