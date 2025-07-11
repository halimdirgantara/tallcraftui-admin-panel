<div>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <x-card>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Welcome back, {{ auth()->user()->name }}!
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Here's what's happening with your admin panel today.
                </p>
            </div>
        </x-card>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-stat 
                title="Total Users"
                value="{{ $totalUsers }}"
                icon="users"
                trend="+12%"
                trend-up
            />
            
            <x-stat 
                title="Active Sessions"
                value="{{ $activeSessions }}"
                icon="chart-bar"
                trend="+5%"
                trend-up
            />
            
            <x-stat 
                title="System Load"
                value="{{ $systemLoad }}%"
                icon="cpu-chip"
                trend="-2%"
                trend-down
            />
        </div>

        <!-- Quick Actions -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Recent Activity
            </h3>
            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 dark:text-white">{{ $activity['message'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div> 