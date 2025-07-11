<div>
    <div class="space-y-6">
        <!-- Role Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center">
                    <x-icon name="shield-check" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $role->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $role->permissions->count() }} permissions assigned</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <x-icon name="shield-check" class="w-5 h-5 inline mr-2" />
                        Role Information
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role Name</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $role->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Permissions Count</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $role->permissions->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $role->created_at->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $role->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <x-icon name="key" class="w-5 h-5 inline mr-2" />
                        Assigned Permissions
                    </h3>
                    
                    <div class="space-y-2">
                        @if($role->permissions->isNotEmpty())
                            @foreach($role->permissions->groupBy(function ($permission) {
                                return explode(' ', $permission->name)[1] ?? 'other';
                            }) as $group => $permissions)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 capitalize">
                                    {{ str_replace('-', ' ', $group) }} Permissions
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($permissions as $permission)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No permissions assigned to this role.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.roles.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md inline-flex items-center">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Back to Roles
            </a>
            
            @can('edit roles')
            <a href="{{ route('admin.roles.edit', $role) }}" 
               class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <x-icon name="pencil-square" class="w-4 h-4 mr-2" />
                Edit Role
            </a>
            @endcan
        </div>
    </div>
</div>
