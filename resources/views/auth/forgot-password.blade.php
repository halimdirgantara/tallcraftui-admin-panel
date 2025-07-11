@extends('layouts.auth')

@section('subtitle', 'Forgot your password?')

@section('content')
<div>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Forgot Password
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Enter your email address and we'll send you a link to reset your password.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        
        <x-input 
            label="Email Address" 
            name="email" 
            type="email"
            placeholder="Enter your email"
            required 
        />
        
        <x-button type="submit" class="w-full">
            Send Password Reset Link
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