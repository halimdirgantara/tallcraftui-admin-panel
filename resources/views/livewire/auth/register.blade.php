<div>
    <form wire:submit="register" class="space-y-6">
        <!-- Name Field -->
        <div>
            <x-input 
                label="Full Name"
                wire:model="name"
                placeholder="Enter your full name"
                autocomplete="name"
                autofocus
            />
        </div>

        <!-- Email Field -->
        <div>
            <x-input 
                label="Email Address"
                wire:model="email"
                type="email"
                placeholder="Enter your email"
                autocomplete="email"
            />
        </div>

        <!-- Password Field -->
        <div>
            <x-password 
                label="Password"
                wire:model="password"
                placeholder="Create a password"
                autocomplete="new-password"
            />
        </div>

        <!-- Confirm Password Field -->
        <div>
            <x-password 
                label="Confirm Password"
                wire:model="password_confirmation"
                placeholder="Confirm your password"
                autocomplete="new-password"
            />
        </div>

        <!-- Submit Button -->
        <x-button 
            type="submit"
            class="w-full"
        >
            Create Account
        </x-button>
    </form>
</div> 