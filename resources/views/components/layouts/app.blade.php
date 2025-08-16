<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $userPreferences['theme'] ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#1f2937">
    <meta name="msapplication-TileColor" content="#1f2937">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- User Preferences -->
    @if(isset($userPreferences))
    <script>
        window.userPreferences = @json($userPreferences);
    </script>
    @endif
</head>
<body class="font-sans antialiased {{ ($userPreferences['compactMode'] ?? 'false') === 'true' ? 'compact-mode' : '' }} {{ ($userPreferences['sidebarCollapsed'] ?? 'false') === 'true' ? 'sidebar-collapsed' : '' }}">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col h-screen sticky top-0 relative">
            <!-- Floating Sidebar Toggle Button -->
            <button 
                onclick="window.userPreferencesManager?.toggleSidebar()"
                class="sidebar-toggle-btn absolute -right-3 top-6 w-6 h-6 bg-gray-800 border-2 border-gray-600 rounded-full flex items-center justify-center hover:bg-gray-700 hover:border-gray-500 transition-all duration-200 z-50 shadow-lg" 
                data-tooltip="Toggle Sidebar"
                title="Toggle Sidebar"
            >
                <svg class="w-3 h-3 text-gray-300 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <div class="p-6 flex-1">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8 sidebar-item" data-tooltip="OrganizeH">
                    <div class="flex flex-col space-y-1">
                        <div class="flex space-x-1">
                            <div class="w-3 h-0.5 bg-white"></div>
                            <div class="w-2 h-0.5 bg-white"></div>
                            <div class="w-1 h-0.5 bg-white"></div>
                        </div>
                        <div class="w-4 h-0.5 bg-white"></div>
                        <div class="w-3 h-0.5 bg-white"></div>
                    </div>
                    <span class="text-lg font-bold sidebar-text">OrganizeH</span>
                </div>

                                       <!-- Primary Navigation -->
                       <nav class="space-y-2 mb-8">
                           <a href="{{ route('dashboard') }}" wire:navigate.hover wire:current="bg-black text-white" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Dashboard">
                               <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                               </svg>
                               <span class="sidebar-text">Dashboard</span>
                           </a>
                           <a href="{{ route('tasks') }}" wire:navigate.hover wire:current="bg-black text-white" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Tasks">
                               <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                               </svg>
                               <span class="sidebar-text">Tasks</span>
                           </a>
                           <a href="{{ route('recipes') }}" wire:navigate.hover wire:current="bg-black text-white" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Recipes">
                               <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                               </svg>
                               <span class="sidebar-text">Recipes</span>
                           </a>
                           <a href="{{ route('habits') }}" wire:navigate.hover wire:current="bg-black text-white" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Habits">
                               <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                               </svg>
                               <span class="sidebar-text">Habits</span>
                           </a>

                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Progress">
                        <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        <span class="sidebar-text">Progress</span>
                    </a>
                </nav>

                <!-- Preferences Link -->
                <div class="mb-8">
                    <nav class="space-y-2">
                        <a href="{{ route('preferences') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors sidebar-item" data-tooltip="Preferences">
                            <svg class="w-5 h-5 sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="sidebar-text">Preferences</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile -->
            <div class="border-t border-gray-700 p-6 user-profile-section" x-data="{ userMenuOpen: false }">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center user-profile-avatar">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0 user-profile-text">
                        <div class="text-sm font-medium truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="relative">
                        <!-- Three dots button -->
                        <button 
                            @click="userMenuOpen = !userMenuOpen"
                            @click.away="userMenuOpen = false"
                            class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-600 transition-colors user-menu-button"
                            title="User menu"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </button>

                        <!-- Drop-up menu -->
                        <div 
                            x-show="userMenuOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                            class="absolute bottom-full right-0 mb-2 w-56 bg-gray-700 rounded-lg shadow-lg border border-gray-600 z-50 user-menu-dropup"
                            style="display: none;"
                        >
                            <!-- Profile Section -->
                            <div class="px-4 py-3 border-b border-gray-600">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-1">
                                <a href="{{ route('preferences') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Preferences</span>
                                </a>
                                <div class="border-t border-gray-600 my-1"></div>
                                <livewire:auth.logout />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</body>
</html>
