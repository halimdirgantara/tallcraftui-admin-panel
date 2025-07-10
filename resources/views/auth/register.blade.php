@extends('layouts.auth')

@section('subtitle', 'Create your account')

@section('footer')
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Already have an account? 
        <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-dark">
            Sign in
        </a>
    </p>
@endsection

@section('content')
    @livewire('auth.register')
@endsection 