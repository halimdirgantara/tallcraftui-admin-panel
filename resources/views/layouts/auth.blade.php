<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    @yield('subtitle', 'Welcome back')
                </p>
            </div>

            <!-- Auth Card -->
            <x-card class="p-8">
                @yield('content')
            </x-card>

            <!-- Footer Links -->
            <div class="text-center">
                @yield('footer')
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html> 