@extends('layouts.auth')

@section('subtitle', 'Reset your password')

@section('content')
<div>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Reset Password
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Enter your new password below.
        </p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">
        
        <x-input 
            label="Email Address" 
            name="email" 
            type="email"
            :value="$email ?? old('email')"
            placeholder="Enter your email"
            required 
        />
        
        <x-password 
            label="New Password" 
            name="password"
            placeholder="Enter your new password"
            required 
        />
        
        <x-password 
            label="Confirm New Password" 
            name="password_confirmation"
            placeholder="Confirm your new password"
            required 
        />
        
        <x-button type="submit" class="w-full">
            Reset Password
        </x-button>
    </form>
    
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            Back to Login
        </a>
    </div>
</div>
@endsection

@section('footer')
<div class="text-center">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Remember your password? 
        <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-dark">
            Sign in here
        </a>
    </p>
</div>
@endsection 