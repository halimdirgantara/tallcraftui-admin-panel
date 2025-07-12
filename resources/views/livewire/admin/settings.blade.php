<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Application Settings
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Configure your application settings and preferences
                </p>
            </div>
        </div>

        <!-- Settings Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button wire:click="$set('activeTab', 'general')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'general' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <x-icon name="cog-6-tooth" class="w-4 h-4 inline mr-2" />
                        General
                    </button>
                    <button wire:click="$set('activeTab', 'security')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'security' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <x-icon name="shield-check" class="w-4 h-4 inline mr-2" />
                        Security
                    </button>
                    <button wire:click="$set('activeTab', 'maintenance')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'maintenance' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <x-icon name="wrench-screwdriver" class="w-4 h-4 inline mr-2" />
                        Maintenance
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- General Settings -->
                @if($activeTab === 'general')
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            General Application Settings
                        </h3>
                        
                        <form wire:submit="saveGeneralSettings" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input 
                                        label="Application Name" 
                                        wire:model="appName"
                                        placeholder="Enter application name"
                                        required 
                                    />
                                    @error('appName')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <x-input 
                                        label="Application URL" 
                                        wire:model="appUrl"
                                        type="url"
                                        placeholder="https://example.com"
                                        required 
                                    />
                                    @error('appUrl')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input 
                                        label="Contact Email" 
                                        wire:model="appEmail"
                                        placeholder="admin@example.com"
                                        required 
                                    />
                                    @error('appEmail')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Timezone
                                    </label>
                                    <select wire:model="timezone" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                        @foreach($timezones as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('timezone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Language
                                    </label>
                                    <select wire:model="locale" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                        @foreach($locales as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('locale')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <x-button type="submit" class="inline-flex items-center">
                                    <x-icon name="check" class="w-4 h-4 mr-2" />
                                    Save General Settings
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Security Settings -->
                @if($activeTab === 'security')
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Security Settings
                        </h3>
                        
                        <form wire:submit="saveSecuritySettings" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-checkbox 
                                        label="Enable User Registration" 
                                        wire:model="registrationEnabled"
                                    />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Allow new users to register accounts
                                    </p>
                                </div>
                                
                                <div>
                                    <x-checkbox 
                                        label="Email Verification Required" 
                                        wire:model="emailVerification"
                                    />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Require email verification for new accounts
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-checkbox 
                                        label="Two-Factor Authentication" 
                                        wire:model="twoFactorAuth"
                                    />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Enable 2FA for enhanced security
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Session Timeout (minutes)
                                    </label>
                                    <input type="number" wire:model="sessionTimeout" 
                                           min="15" max="480"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                    @error('sessionTimeout')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Max Login Attempts
                                    </label>
                                    <input type="number" wire:model="maxLoginAttempts" 
                                           min="1" max="10"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                    @error('maxLoginAttempts')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Minimum Password Length
                                    </label>
                                    <input type="number" wire:model="passwordMinLength" 
                                           min="6" max="20"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                    @error('passwordMinLength')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Password Requirements</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-checkbox 
                                            label="Require Special Characters" 
                                            wire:model="passwordRequireSpecial"
                                        />
                                    </div>
                                    
                                    <div>
                                        <x-checkbox 
                                            label="Require Numbers" 
                                            wire:model="passwordRequireNumbers"
                                        />
                                    </div>
                                    
                                    <div>
                                        <x-checkbox 
                                            label="Require Uppercase Letters" 
                                            wire:model="passwordRequireUppercase"
                                        />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <x-button type="submit" class="inline-flex items-center">
                                    <x-icon name="check" class="w-4 h-4 mr-2" />
                                    Save Security Settings
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Maintenance Settings -->
                @if($activeTab === 'maintenance')
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Maintenance & Debug Settings
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-checkbox 
                                        label="Maintenance Mode" 
                                        wire:model="maintenanceMode"
                                        wire:change="toggleMaintenanceMode"
                                    />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Put the application in maintenance mode
                                    </p>
                                </div>
                                
                                <div>
                                    <x-checkbox 
                                        label="Debug Mode" 
                                        wire:model="debugMode"
                                    />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Enable debug mode for development
                                    </p>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Cache Management</h4>
                                
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <div class="flex">
                                        <x-icon name="exclamation-triangle" class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" />
                                        <div>
                                            <h5 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                Cache Management
                                            </h5>
                                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                                Clearing the cache will remove all cached data and may temporarily slow down the application.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <x-button wire:click="clearCache" variant="outline" class="inline-flex items-center">
                                        <x-icon name="trash" class="w-4 h-4 mr-2" />
                                        Clear Application Cache
                                    </x-button>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Environment File</h4>
                                
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="flex">
                                        <x-icon name="information-circle" class="w-5 h-5 text-blue-400 mr-3 mt-0.5" />
                                        <div>
                                            <h5 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                                .env File Management
                                            </h5>
                                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                                Settings are now saved directly to your .env file using the env-editor package. Changes will persist across application restarts.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
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