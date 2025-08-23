<div>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Welcome to OrganiseHub!</h1>
                <p class="mt-2 text-gray-600 dark:text-neutral-400">Manage your tasks, recipes, and habits all in one place.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-x-2 py-2 px-3 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    All Systems Active
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tasks -->
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
            <div class="h-full p-4 md:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="inline-flex justify-center items-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="grow ml-5">
                        <div class="flex items-center gap-x-1">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Tasks</h3>
                        </div>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-neutral-200">5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Recipes -->
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
            <div class="h-full p-4 md:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="inline-flex justify-center items-center w-8 h-8 rounded-lg bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="grow ml-5">
                        <div class="flex items-center gap-x-1">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-neutral-400">Active Recipes</h3>
                        </div>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-neutral-200">12</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Habits Tracked -->
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
            <div class="h-full p-4 md:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="inline-flex justify-center items-center w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="grow ml-5">
                        <div class="flex items-center gap-x-1">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-neutral-400">Habits Tracked</h3>
                        </div>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-neutral-200">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
            <div class="h-full p-4 md:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="inline-flex justify-center items-center w-8 h-8 rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="grow ml-5">
                        <div class="flex items-center gap-x-1">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-neutral-400">Completion Rate</h3>
                        </div>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-neutral-200">85%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Focus Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white">Today's Focus</h2>
            <a href="{{ route('habits') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                View All
            </a>
        </div>
        
        <!-- Habit Tracker Card -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="inline-flex justify-center items-center w-12 h-12 rounded-lg bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Habit Tracker</h3>
                            <p class="text-sm text-gray-600 dark:text-neutral-400">Track your daily goals and build better habits</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('habits') }}" class="inline-flex justify-center items-center gap-x-2 py-2 px-4 text-sm font-medium text-gray-800 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Tracking
                        </a>
                        <a href="{{ route('habits.create') }}" class="inline-flex justify-center items-center gap-x-2 py-2 px-4 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Habit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white">Quick Actions</h2>
            <a href="{{ route('tasks') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                View All Tasks
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Add Task -->
            <a href="{{ route('tasks.create') }}" class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
                <div class="h-full p-4 md:p-5">
                    <div class="flex justify-center items-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 group-hover:bg-blue-200 transition dark:bg-blue-900 dark:group-hover:bg-blue-800">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition dark:text-white dark:group-hover:text-blue-400">Add Task</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Create a new task</p>
                    </div>
                </div>
            </a>
            
            <!-- Add Recipe -->
            <a href="{{ route('recipes.create') }}" class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
                <div class="h-full p-4 md:p-5">
                    <div class="flex justify-center items-center w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 group-hover:bg-green-200 transition dark:bg-green-900 dark:group-hover:bg-green-800">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-green-600 transition dark:text-white dark:group-hover:text-green-400">Add Recipe</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Save a new recipe</p>
                    </div>
                </div>
            </a>
            
            <!-- Track Habit -->
            <a href="{{ route('habits') }}" class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
                <div class="h-full p-4 md:p-5">
                    <div class="flex justify-center items-center w-12 h-12 bg-yellow-100 rounded-lg mx-auto mb-4 group-hover:bg-yellow-200 transition dark:bg-yellow-900 dark:group-hover:bg-yellow-800">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-yellow-600 transition dark:text-white dark:group-hover:text-yellow-400">Track Habit</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Monitor your habits</p>
                    </div>
                </div>
            </a>
            
            <!-- View Tasks -->
            <a href="{{ route('tasks') }}" class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-800 dark:border-neutral-700">
                <div class="h-full p-4 md:p-5">
                    <div class="flex justify-center items-center w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 group-hover:bg-purple-200 transition dark:bg-purple-900 dark:group-hover:bg-purple-800">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-purple-600 transition dark:text-white dark:group-hover:text-purple-400">View Tasks</h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">See all your tasks</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
