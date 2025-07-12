<div>
    <form wire:submit="login" class="space-y-6">
        <!-- Email Field -->
        <div>
            <x-input 
                label="Email Address"
                wire:model="email"
                type="email"
                placeholder="Enter your email"
                autocomplete="email"
                autofocus
            />
        </div>

        <!-- Password Field -->
        <div>
            <x-password 
                label="Password"
                wire:model="password"
                placeholder="Enter your password"
                autocomplete="current-password"
            />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <x-checkbox 
                label="Remember me"
                wire:model="remember"
            />
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-[#f53003] dark:text-[#FF4433] hover:underline">
                    Forgot your password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-button 
            type="submit"
            class="w-full"
        >
            Sign in
        </x-button>
    </form>
</div> 