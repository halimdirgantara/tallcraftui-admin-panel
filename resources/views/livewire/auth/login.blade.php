<div>
    <form wire:submit="login" class="space-y-6">
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
                autofocus
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
                placeholder="Enter your password"
                autocomplete="current-password"
            >
            @error('password')
                <p class="mt-1 text-sm text-[#f53003] dark:text-[#F61500]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    wire:model="remember"
                    class="w-4 h-4 text-[#1b1b18] dark:text-[#EDEDEC] bg-white dark:bg-[#161615] border-[#e3e3e0] dark:border-[#3E3E3A] rounded focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:ring-2"
                >
                <span class="ml-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-[#f53003] dark:text-[#FF4433] hover:underline">
                    Forgot your password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-[#1b1b18] dark:bg-[#3E3E3A] text-white py-2 px-4 rounded-md hover:bg-black dark:hover:bg-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:ring-offset-2 transition-colors font-medium"
        >
            Sign in
        </button>
    </form>
</div> 