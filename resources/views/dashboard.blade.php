<x-layouts.app>
    <div>
        <!-- Header -->
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6 lg:mb-8">Welcome to OrganizeHub!</h1>

        <!-- Today's Focus Section -->
        <div class="mb-6 lg:mb-8">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900 mb-4">Today's Focus</h2>
            
            <!-- Habit Tracker Card -->
            <div class="bg-gray-100 rounded-lg p-4 lg:p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-3 lg:space-x-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-lg font-semibold text-gray-900">Habit Tracker</h3>
                            <p class="text-sm lg:text-base text-gray-600">Daily Goals</p>
                        </div>
                    </div>
                    <button class="w-full lg:w-auto bg-white text-gray-900 px-4 lg:px-6 py-2 rounded-lg hover:bg-gray-50 transition-colors border border-gray-300">
                        Start Tracking
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div>
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 lg:gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-3">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-gray-900">Add Task</span>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-3">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-gray-900">Add Recipe</span>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-3">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-gray-900">Track Habit</span>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-3">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-gray-900">View</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
