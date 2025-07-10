@extends('layouts.auth')

@section('title', 'Login')
@section('subtitle', 'Sign in to your account')

@section('content')
    @livewire('auth.login')
@endsection

@section('footer')
    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline font-medium">
            Sign up
        </a>
    </p>
@endsection 