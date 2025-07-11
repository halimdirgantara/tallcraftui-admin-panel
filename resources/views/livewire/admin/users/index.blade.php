<div>
    <div class="space-y-6">
        <!-- Header with Create Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    All Users
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage user accounts, roles, and permissions
                </p>
            </div>
            
            @can('create users')
            <a href="{{ route('admin.users.create') }}" 
               class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <x-icon name="user-plus" class="w-4 h-4 mr-2" />
                Add User
            </a>
            @endcan
        </div>

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Search Users
                    </label>
                    <div class="relative">
                        <x-icon name="magnifying-glass" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input type="text" wire:model.live.debounce.300ms="search" id="search"
                               placeholder="Search by name or email..."
                               class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <label for="roleFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Filter by Role
                    </label>
                    <select wire:model.live="roleFilter" id="roleFilter"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Per Page
                    </label>
                    <select wire:model.live="perPage" id="perPage"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Roles
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <x-avatar>
                                            {{ $user->name[0] ?? 'U' }}
                                        </x-avatar>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $role->name }}
                                    </span>
                                    @endforeach
                                    @if($user->roles->isEmpty())
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No roles</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @can('view users')
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="text-primary hover:text-primary-dark inline-flex items-center">
                                        <x-icon name="eye" class="w-4 h-4 mr-1" />
                                        View
                                    </a>
                                    @endcan
                                    
                                    @can('edit users')
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 inline-flex items-center">
                                        <x-icon name="pencil-square" class="w-4 h-4 mr-1" />
                                        Edit
                                    </a>
                                    @endcan
                                    
                                    @can('delete users')
                                    @if($user->id !== auth()->id())
                                    <button wire:click="deleteUser({{ $user->id }})" 
                                            wire:confirm="Are you sure you want to delete this user?"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center">
                                        <x-icon name="trash" class="w-4 h-4 mr-1" />
                                        Delete
                                    </button>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center py-8">
                                    <x-icon name="users" class="w-12 h-12 text-gray-400 mb-4" />
                                    <p class="text-lg font-medium">No users found</p>
                                    <p class="text-sm">Try adjusting your search or filter criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div class="md:hidden">
                @forelse($users as $user)
                <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <x-avatar class="w-10 h-10">
                                {{ $user->name[0] ?? 'U' }}
                            </x-avatar>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @can('view users')
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="text-primary hover:text-primary-dark p-1">
                                <x-icon name="eye" class="w-4 h-4" />
                            </a>
                            @endcan
                            
                            @can('edit users')
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1">
                                <x-icon name="pencil-square" class="w-4 h-4" />
                            </a>
                            @endcan
                            
                            @can('delete users')
                            @if($user->id !== auth()->id())
                            <button wire:click="deleteUser({{ $user->id }})" 
                                    wire:confirm="Are you sure you want to delete this user?"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1">
                                <x-icon name="trash" class="w-4 h-4" />
                            </button>
                            @endif
                            @endcan
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <x-icon name="calendar" class="w-4 h-4 mr-2" />
                            Created: {{ $user->created_at->format('M d, Y') }}
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Roles:</div>
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                <span class="text-sm text-gray-500 dark:text-gray-400">No roles assigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center">
                        <x-icon name="users" class="w-12 h-12 text-gray-400 mb-4" />
                        <p class="text-lg font-medium">No users found</p>
                        <p class="text-sm">Try adjusting your search or filter criteria.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
    <div class="fixed bottom-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="fixed bottom-4 right-4 z-50">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    </div>
    @endif
</div>
