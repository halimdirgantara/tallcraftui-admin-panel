@extends('layouts.auth')

@section('title', 'Register')
@section('subtitle', 'Create your account')

@section('content')
    @livewire('auth.register')
@endsection

@section('footer')
    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline font-medium">
            Sign in
        </a>
    </p>
@endsection 