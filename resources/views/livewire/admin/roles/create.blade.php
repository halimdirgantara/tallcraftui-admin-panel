<div>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form wire:submit="save" class="space-y-6">
                <div>
                    <x-input 
                        label="Role Name" 
                        wire:model="name"
                        placeholder="Enter role name"
                        required 
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                        <x-icon name="key" class="w-4 h-4 inline mr-2" />
                        Assign Permissions
                    </label>
                    
                    <div class="space-y-4">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3 capitalize">
                                {{ str_replace('-', ' ', $group) }} Permissions
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($groupPermissions as $permission)
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}" 
                                           class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <div class="ml-2">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                        </span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @error('selectedPermissions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.roles.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md inline-flex items-center">
                        <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                        Cancel
                    </a>
                    <x-button type="submit" class="inline-flex items-center">
                        <x-icon name="plus" class="w-4 h-4 mr-2" />
                        Create Role
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
