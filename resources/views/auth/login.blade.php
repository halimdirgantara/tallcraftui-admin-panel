@extends('layouts.auth')

@section('subtitle', 'Sign in to your account')

@section('footer')
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Don't have an account? 
        <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary-dark">
            Sign up
        </a>
    </p>
@endsection

@section('content')
    @livewire('auth.login')
@endsection 