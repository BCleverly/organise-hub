<div>

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 lg:mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Today's Habits & Skills</h1>
            <p class="text-sm lg:text-base text-gray-600 mt-1">Track your daily progress and build lasting habits.</p>
        </div>
        <div class="mt-4 lg:mt-0 flex flex-col lg:flex-row items-start lg:items-center space-y-3 lg:space-y-0 lg:space-x-3">
            <!-- Search Bar -->
            <div class="relative">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Search trackables..." 
                    class="w-64 pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Type Filter -->
            <div class="flex items-center bg-gray-100 rounded-lg p-1">
                <button 
                    wire:click="$set('typeFilter', '')"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors cursor-pointer {{ $typeFilter === '' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    title="All types"
                >
                    All
                </button>
                <button 
                    wire:click="$set('typeFilter', 'HABIT')"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors cursor-pointer {{ $typeFilter === 'HABIT' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    title="Habits only"
                >
                    Habits
                </button>
                <button 
                    wire:click="$set('typeFilter', 'SKILL')"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors cursor-pointer {{ $typeFilter === 'SKILL' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    title="Skills only"
                >
                    Skills
                </button>
            </div>

            <!-- Show/Hide Completed Toggle -->
            <button 
                wire:click="toggleShowCompleted"
                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium {{ $showCompleted ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-white text-gray-700 hover:bg-gray-50' }} focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                title="{{ $showCompleted ? 'Hide completed' : 'Show completed' }}"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $showCompleted ? 'Hide Done' : 'Show Done' }}
            </button>

            <!-- Add New Trackable Button -->
            <a 
                href="{{ route('habits.create') }}"
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors"
            >
                Add Trackable
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="mb-6 lg:mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Trackables -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Today -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed Today</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Habits -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Habits</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['habits'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Skills</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['skills'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if($stats['total'] === 0)
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No trackables for today</h3>
            <p class="text-gray-600 mb-6">Create your first habit or skill to start tracking your progress.</p>
            <a 
                href="{{ route('habits.create') }}"
                class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors"
            >
                Create Your First Trackable
            </a>
        </div>
    @else
        <!-- Skills Section -->
        @if($skills->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Skills ({{ $skills->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($skills as $skill)
                        <x-trackable-card :trackable="$skill" :showProgress="true" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Habits Section -->
        @if($habits->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Habits ({{ $habits->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($habits as $habit)
                        <x-trackable-card :trackable="$habit" :showProgress="false" />
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    <!-- Creator Modal removed - now using dedicated create page -->
</div>
