<div>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input 
                            label="Name" 
                            wire:model="name"
                            placeholder="Enter user name"
                            required 
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <x-input 
                            label="Email" 
                            wire:model="email"
                            type="email"
                            placeholder="Enter user email"
                            required 
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-password 
                            label="Password" 
                            wire:model="password"
                            placeholder="Enter password"
                            required 
                        />
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <x-password 
                            label="Confirm Password" 
                            wire:model="password_confirmation"
                            placeholder="Confirm password"
                            required 
                        />
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <x-icon name="shield-check" class="w-4 h-4 inline mr-2" />
                        Assign Roles
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($roles as $role)
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}" 
                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $role->permissions->count() }} permissions</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('selectedRoles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md inline-flex items-center">
                        <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                        Cancel
                    </a>
                    <x-button type="submit" class="inline-flex items-center">
                        <x-icon name="user-plus" class="w-4 h-4 mr-2" />
                        Create User
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
