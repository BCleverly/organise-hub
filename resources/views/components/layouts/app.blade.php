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
<body class="font-sans antialiased bg-gray-50 dark:bg-neutral-900 {{ ($userPreferences['compactMode'] ?? 'false') === 'true' ? 'compact-mode' : '' }} {{ ($userPreferences['sidebarCollapsed'] ?? 'false') === 'true' ? 'sidebar-collapsed' : '' }}">
    <div class="flex h-screen">
        <!-- Navigation Toggle for Mobile -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-gray-800 border border-gray-800 text-white text-sm font-medium rounded-lg shadow-2xs align-middle hover:bg-gray-950 focus:outline-hidden focus:bg-gray-900 dark:bg-white dark:text-neutral-800 dark:hover:bg-neutral-200 dark:focus:bg-neutral-200" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-mobile" aria-label="Toggle navigation" data-hs-overlay="#hs-sidebar-mobile">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6"></line>
                    <line x1="3" x2="21" y1="12" y2="12"></line>
                    <line x1="3" x2="21" y1="18" y2="18"></line>
                </svg>
                Menu
            </button>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
            <div class="flex flex-col flex-grow bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700 relative">
                <!-- Sidebar Toggle Button -->
                <button 
                    type="button" 
                    class="sidebar-toggle-btn absolute -right-3 top-4 w-6 h-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm z-10"
                    onclick="window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: !document.body.classList.contains('sidebar-collapsed') } }))"
                    title="Toggle sidebar"
                >
                    <svg class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <!-- Header -->
                <header class="p-4">
                    <a class="flex-none font-semibold text-xl text-black focus:outline-hidden focus:opacity-80 dark:text-white" href="{{ route('dashboard') }}" aria-label="OrganiseH">
                        <div class="flex items-center space-x-3">
                            <div class="flex flex-col space-y-1">
                                <div class="flex space-x-1">
                                    <div class="w-3 h-0.5 bg-black dark:bg-white"></div>
                                    <div class="w-2 h-0.5 bg-black dark:bg-white"></div>
                                    <div class="w-1 h-0.5 bg-black dark:bg-white"></div>
                                </div>
                                <div class="w-4 h-0.5 bg-black dark:bg-white"></div>
                                <div class="w-3 h-0.5 bg-black dark:bg-white"></div>
                            </div>
                            <span class="text-lg font-bold">OrganiseH</span>
                        </div>
                    </a>
                </header>

                <!-- Body -->
                <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <div class="hs-accordion-group pb-0 px-2 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                        <ul class="space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('dashboard') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6zM14 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V6zM4 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2zM14 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('tasks*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('tasks') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 1 2 2h2a2 2 0 0 1 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"></path>
                                    </svg>
                                    Tasks
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('recipes*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('recipes') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-6m6 0V9a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v4.01"></path>
                                    </svg>
                                    Recipes
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('habits*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('habits') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                                    </svg>
                                    Habits
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="#" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4z"></path>
                                    </svg>
                                    Progress
                                </a>
                            </li>
                        </ul>

                        <!-- Preferences Section -->
                        <div class="mt-8">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider px-2.5 mb-2">Settings</h3>
                            <ul class="space-y-1">
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('preferences*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('preferences') }}" wire:navigate.hover>
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                        </svg>
                                        Preferences
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- User Profile Section -->
                        <div class="mt-auto pt-8 border-t border-gray-200 dark:border-neutral-700">
                            <div class="px-2.5 py-2">
                                <div class="flex items-center gap-x-3">
                                    <div class="w-8 h-8 bg-gray-200 dark:bg-neutral-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 truncate">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="relative">
                                        <livewire:auth.logout />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Mobile Sidebar -->
        <div id="hs-sidebar-mobile" class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform h-full hidden fixed top-0 start-0 bottom-0 z-60 w-64 lg:hidden" role="dialog" tabindex="-1" aria-label="Sidebar">
            <div class="flex flex-col h-full bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
                <!-- Header -->
                <header class="p-4 flex justify-between items-center gap-x-2">
                    <a class="flex-none font-semibold text-xl text-black focus:outline-hidden focus:opacity-80 dark:text-white" href="{{ route('dashboard') }}" aria-label="OrganiseH">
                        <div class="flex items-center space-x-3">
                            <div class="flex flex-col space-y-1">
                                <div class="flex space-x-1">
                                    <div class="w-3 h-0.5 bg-black dark:bg-white"></div>
                                    <div class="w-2 h-0.5 bg-black dark:bg-white"></div>
                                    <div class="w-1 h-0.5 bg-black dark:bg-white"></div>
                                </div>
                                <div class="w-4 h-0.5 bg-black dark:bg-white"></div>
                                <div class="w-3 h-0.5 bg-black dark:bg-white"></div>
                            </div>
                            <span class="text-lg font-bold">OrganiseH</span>
                        </div>
                    </a>
                    <div class="-me-2">
                        <!-- Close Button -->
                        <button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200" data-hs-overlay="#hs-sidebar-mobile">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                </header>

                <!-- Body -->
                <nav class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <div class="px-2 pb-4 w-full flex flex-col">
                        <ul class="space-y-1">
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('dashboard') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6zM14 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V6zM4 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2zM14 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('tasks*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('tasks') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 1 2 2h2a2 2 0 0 1 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"></path>
                                    </svg>
                                    Tasks
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('recipes*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('recipes') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-6m6 0V9a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v4.01"></path>
                                    </svg>
                                    Recipes
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('habits*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('habits') }}" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                                    </svg>
                                    Habits
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="#" wire:navigate.hover>
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4z"></path>
                                    </svg>
                                    Progress
                                </a>
                            </li>
                        </ul>

                        <!-- Preferences Section -->
                        <div class="mt-8">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider px-2.5 mb-2">Settings</h3>
                            <ul class="space-y-1">
                                <li>
                                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('preferences*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700/50' }} text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700/50" href="{{ route('preferences') }}" wire:navigate.hover>
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                        </svg>
                                        Preferences
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- User Profile Section -->
                        <div class="mt-auto pt-8 border-t border-gray-200 dark:border-neutral-700">
                            <div class="px-2.5 py-2">
                                <div class="flex items-center gap-x-3">
                                    <div class="w-8 h-8 bg-gray-200 dark:bg-neutral-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 truncate">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="relative">
                                        <livewire:auth.logout />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:ml-64 flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto p-4 lg:p-8 bg-gray-50 dark:bg-neutral-900">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-700/30 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500 dark:text-green-400" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-700/30 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-red-500 dark:text-red-400" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        // Initialize Preline components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize HSOverlay for sidebar
            if (typeof HSCore !== 'undefined') {
                HSCore.components.HSOverlay.init();
            }
        });
    </script>
</body>
</html>
