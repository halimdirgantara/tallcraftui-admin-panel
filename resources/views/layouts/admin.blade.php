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
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="flex items-center justify-center h-16 px-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ config('app.name', 'Laravel') }}
                </h1>
            </div>
            
            <nav class="mt-6 px-3">
                <x-menu>
                    <x-menu-item href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        <x-icon name="home" class="w-5 h-5 mr-3" />
                        Dashboard
                    </x-menu-item>
                    
                    <x-menu-item href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                        <x-icon name="users" class="w-5 h-5 mr-3" />
                        Users
                    </x-menu-item>
                    
                    <x-menu-item href="{{ route('admin.settings') }}" :active="request()->routeIs('admin.settings')">
                        <x-icon name="cog-6-tooth" class="w-5 h-5 mr-3" />
                        Settings
                    </x-menu-item>
                </x-menu>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center">
                        <button class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <x-icon name="bars-3" class="w-6 h-6" />
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                            <x-icon name="bell" class="w-6 h-6" />
                        </button>
                        
                        <!-- User Menu -->
                        <x-dropdown>
                            @slot('trigger')
                                <div class="flex items-center space-x-3">
                                    <x-avatar>
                                        {{ auth()->user()->name[0] ?? 'U' }}
                                    </x-avatar>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <x-icon name="chevron-down" class="w-4 h-4" />
                                </div>
                            @endslot

                            <x-dropdown-item label="Profile" icon="user" link="{{ route('profile.edit') }}" />
                            <x-dropdown-item label="Update password" icon="key" />
                            <x-dropdown-item label="Settings" icon="cog-6-tooth" link="{{ route('admin.settings') }}" />
                            <x-separator />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-item label="Logout" icon="arrow-right-start-on-rectangle" link="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();" />
                            </form>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @hasSection('header')
                            <div class="mb-6">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    @yield('header')
                                </h1>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html> 