<div>
    <form wire:submit="register" class="space-y-6">
        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Full Name
            </label>
            <input 
                type="text" 
                id="name"
                wire:model="name"
                class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent transition-colors @error('name') border-[#f53003] dark:border-[#F61500] @enderror"
                placeholder="Enter your full name"
                autocomplete="name"
                autofocus
            >
            @error('name')
                <p class="mt-1 text-sm text-[#f53003] dark:text-[#F61500]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Email Address
            </label>
            <input 
                type="email" 
                id="email"
                wire:model="email"
                class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent transition-colors @error('email') border-[#f53003] dark:border-[#F61500] @enderror"
                placeholder="Enter your email"
                autocomplete="email"
            >
            @error('email')
                <p class="mt-1 text-sm text-[#f53003] dark:text-[#F61500]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Password
            </label>
            <input 
                type="password" 
                id="password"
                wire:model="password"
                class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent transition-colors @error('password') border-[#f53003] dark:border-[#F61500] @enderror"
                placeholder="Create a password"
                autocomplete="new-password"
            >
            @error('password')
                <p class="mt-1 text-sm text-[#f53003] dark:text-[#F61500]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Confirm Password
            </label>
            <input 
                type="password" 
                id="password_confirmation"
                wire:model="password_confirmation"
                class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent transition-colors"
                placeholder="Confirm your password"
                autocomplete="new-password"
            >
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-[#1b1b18] dark:bg-[#3E3E3A] text-white py-2 px-4 rounded-md hover:bg-black dark:hover:bg-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:ring-offset-2 transition-colors font-medium"
        >
            Create Account
        </button>
    </form>
</div> 