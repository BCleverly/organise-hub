<x-layouts.app>
    <div>
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 lg:mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Task Manager</h1>
                <p class="text-sm lg:text-base text-gray-600 mt-1">Manage your daily tasks easily.</p>
            </div>
            <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </button>
                <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                    Add task
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-6 lg:mb-8">
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search recipes..." 
                    class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- To Do Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">To Do</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Task Cards -->
                <div class="space-y-3">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Grocery Shopping</h4>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">2023-10-15</span>
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">High</span>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Pending</span>
                            </div>
                        </div>
                        <button class="w-full text-sm text-gray-600 hover:text-gray-800 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">In Progress</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Task Cards -->
                <div class="space-y-3">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Finish report</h4>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">2023-10-12</span>
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Medium</span>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Working</span>
                            </div>
                        </div>
                        <button class="w-full text-sm text-gray-600 hover:text-gray-800 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Awaiting Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Awaiting</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Task Cards -->
                <div class="space-y-3">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Client feedback</h4>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">2023-10-10</span>
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Medium</span>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Waiting</span>
                            </div>
                        </div>
                        <button class="w-full text-sm text-gray-600 hover:text-gray-800 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                            Edit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Completed Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Completed</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Task Cards -->
                <div class="space-y-3">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Plan vacation</h4>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">2023-10-01</span>
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Low</span>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Done</span>
                            </div>
                        </div>
                        <button class="w-full text-sm text-gray-600 hover:text-gray-800 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                            Edit
                        </button>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Read a book</h4>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">2023-09-28</span>
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Low</span>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Done</span>
                            </div>
                        </div>
                        <button class="w-full text-sm text-gray-600 hover:text-gray-800 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe Cards Section -->
        <div class="mt-8 lg:mt-12">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Recipe Book</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Chocolate Cake Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Chocolate Cake</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 text-sm bg-orange-100 text-orange-700 rounded-full">Dessert</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            View
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Save
                        </button>
                    </div>
                </div>

                <!-- Pasta Primavera Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pasta Primavera</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full">Main Course</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            View
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Save
                        </button>
                    </div>
                </div>

                <!-- Caesar Salad Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Caesar Salad</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">Appetizer</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            View
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
