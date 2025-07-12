<div>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <x-card>
            <div class="flex items-center justify-between p-4">
                <div class="text-center flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Welcome back, {{ auth()->user()->name }}!
                    </h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Here's what's happening with your admin panel today.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <x-button 
                        size="sm" 
                        color="gray" 
                        variant="outline"
                        wire:click="refreshStats"
                        wire:loading.attr="disabled"
                    >
                        <x-icon name="arrow-path" class="w-4 h-4 mr-2" wire:loading.remove />
                        <x-spinner wire:loading />
                        Refresh
                    </x-button>
                </div>
            </div>
        </x-card>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-stat 
                icon="users" 
                title="Total Users" 
                number="{{ number_format($totalUsers) }}"
                tooltip="{{ $userStatTooltip }}"
            />
            
            <x-stat 
                icon="chart-bar" 
                title="Active Sessions" 
                number="{{ number_format($activeSessions) }}"
                tooltip="{{ $sessionStatTooltip }}"
            />
            
            <x-stat 
                icon="cpu-chip" 
                title="System Load" 
                number="{{ $systemLoad }}%"
                tooltip="{{ $loadStatTooltip }}"
            />
        </div>

        <!-- Quick Actions -->
        <x-card>
            <h3 class="text-lg font-semibold p-4 text-gray-900 dark:text-white mb-4">
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 p-4 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-button variant="outline" class="w-full">
                    <x-icon name="user-plus" class="w-4 h-4 mr-2" />
                    Add User
                </x-button>
                
                <x-button variant="outline" class="w-full">
                    <x-icon name="wrench" class="w-4 h-4 mr-2" />
                    Settings
                </x-button>
                
                <x-button variant="outline" class="w-full">
                    <x-icon name="chart-bar-square" class="w-4 h-4 mr-2" />
                    Reports
                </x-button>
                
                <x-button variant="outline" class="w-full">
                    <x-icon name="question-mark-circle" class="w-4 h-4 mr-2" />
                    Help
                </x-button>
            </div>
        </x-card>

        <!-- Recent Activity -->
        <x-card>
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Recent Activity
                </h3>
                <x-button 
                    size="sm" 
                    color="gray" 
                    variant="outline"
                    link="{{ route('admin.activity-log') }}"
                >
                    View All
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </x-button>
            </div>
            <div class="p-4">
                @if($recentActivity->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <!-- Activity Type Indicator -->
                                <div class="flex-shrink-0 mt-1">
                                    @switch($activity['type'])
                                        @case('login')
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            @break
                                        @case('logout')
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            @break
                                        @case('create')
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                            @break
                                        @case('update')
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                            @break
                                        @case('delete')
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            @break
                                        @default
                                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                                    @endswitch
                                </div>
                                
                                <!-- Activity Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $activity['message'] }}
                                        </p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 flex-shrink-0">
                                            {{ $activity['time'] }}
                                        </span>
                                    </div>
                                    
                                    @if($activity['causer'])
                                        <div class="flex items-center mt-1">
                                            <div class="w-5 h-5 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mr-2">
                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                                    {{ strtoupper(substr($activity['causer']->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $activity['causer']->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Device Info for Login/Logout -->
                                    @if(in_array($activity['type'], ['login', 'logout']) && $activity['properties'])
                                        @if($activity['properties']->get('ip_address') || $activity['properties']->get('browser'))
                                            <div class="mt-1 flex items-center space-x-2">
                                                @if($activity['properties']->get('ip_address'))
                                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                                        <x-icon name="computer-desktop" class="w-3 h-3 inline mr-1" />
                                                        {{ $activity['properties']->get('ip_address') }}
                                                    </span>
                                                @endif
                                                @if($activity['properties']->get('browser'))
                                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                                        <x-icon name="globe-alt" class="w-3 h-3 inline mr-1" />
                                                        {{ $activity['properties']->get('browser') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <x-icon name="document-text" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No recent activity</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Activity logs will appear here once users start using the system.
                        </p>
                    </div>
                @endif
            </div>
        </x-card>
    </div>
</div> 