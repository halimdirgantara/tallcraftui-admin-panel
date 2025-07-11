<div>
    <div class="space-y-6">
        <!-- User Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center space-x-4 mb-6">
                <x-avatar class="w-16 h-16">
                    {{ $user->name[0] ?? 'U' }}
                </x-avatar>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <x-icon name="user" class="w-5 h-5 inline mr-2" />
                        User Information
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <x-icon name="shield-check" class="w-5 h-5 inline mr-2" />
                        Roles & Permissions
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Roles</dt>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                <span class="text-sm text-gray-500 dark:text-gray-400">No roles assigned</span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Direct Permissions</dt>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->permissions as $permission)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ $permission->name }}
                                </span>
                                @endforeach
                                @if($user->permissions->isEmpty())
                                <span class="text-sm text-gray-500 dark:text-gray-400">No direct permissions</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md inline-flex items-center">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Back to Users
            </a>
            
            @can('edit users')
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <x-icon name="pencil-square" class="w-4 h-4 mr-2" />
                Edit User
            </a>
            @endcan
        </div>
    </div>
</div>
