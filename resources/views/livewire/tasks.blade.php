<div>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 lg:mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Task Manager</h1>
            <p class="text-sm lg:text-base text-gray-600 mt-1">Manage your daily tasks easily.</p>
        </div>
        <div class="mt-4 lg:mt-0 flex flex-col lg:flex-row items-start lg:items-center space-y-3 lg:space-y-0 lg:space-x-3">
            <!-- Search Bar -->
            <div class="relative">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Search tasks..." 
                    class="w-64 pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="flex items-center space-x-2">
                <!-- Tag Filter -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        {{ count($tagFilters) > 0 ? count($tagFilters) . ' tag' . (count($tagFilters) > 1 ? 's' : '') : 'Filter by tags' }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    >
                        <div class="p-3">
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide px-2 py-1 mb-2">Available Tags</div>
                            
                            <!-- Selected Tags Display -->
                            @if(count($tagFilters) > 0)
                                <div class="mb-3 p-2 bg-gray-50 rounded-md">
                                    <div class="text-xs font-medium text-gray-600 mb-2">Selected:</div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tagFilters as $selectedTag)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $selectedTag }}
                                                <button 
                                                    wire:click="removeTagFilter('{{ $selectedTag }}')"
                                                    class="ml-1 text-blue-600 hover:text-blue-800"
                                                    title="Remove {{ $selectedTag }}"
                                                >
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Available Tags List -->
                            <div class="max-h-48 overflow-y-auto">
                                @forelse($availableTags as $tag)
                                    <button 
                                        wire:click="addTagFilter('{{ $tag->name }}')"
                                        @click="open = false"
                                        class="w-full text-left px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors {{ in_array($tag->name, $tagFilters) ? 'bg-blue-50 text-blue-700' : '' }}"
                                    >
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mr-2">
                                            {{ $tag->name }}
                                        </span>
                                        @if(in_array($tag->name, $tagFilters))
                                            <span class="text-blue-600 text-xs">✓ Selected</span>
                                        @endif
                                    </button>
                                @empty
                                    <div class="px-2 py-2 text-sm text-gray-500">No tags available</div>
                                @endforelse
                            </div>
                            
                            @if(count($tagFilters) > 0)
                                <div class="border-t border-gray-200 mt-3 pt-3">
                                    <button 
                                        wire:click="$set('tagFilters', [])"
                                        @click="open = false"
                                        class="w-full text-left px-2 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"
                                    >
                                        Clear all tag filters
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Clear All Filters -->
                @if($search || $statusFilter || $priorityFilter || count($tagFilters) > 0)
                    <button 
                        wire:click="clearFilters"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        title="Clear all filters"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L6 6l12 12"></path>
                        </svg>
                        Clear
                    </button>
                @endif
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center bg-gray-100 rounded-lg p-1">
                <button 
                    wire:click="$set('viewMode', 'detailed')"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors cursor-pointer {{ $viewMode === 'detailed' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    title="Detailed view"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button>
                <button 
                    wire:click="$set('viewMode', 'minimal')"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors cursor-pointer {{ $viewMode === 'minimal' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    title="Minimal view"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            

            <a 
                href="{{ route('tasks.create') }}" 
                wire:navigate
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors"
            >
                Add task
            </a>
        </div>
    </div>

    <!-- Task Overview Section -->
    <div class="mb-6 lg:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Task Overview</h2>
            <button 
                wire:click="$toggle('showOverview')"
                class="text-gray-600 hover:text-gray-900 transition-colors cursor-pointer"
                title="{{ $showOverview ? 'Hide overview' : 'Show overview' }}"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($showOverview)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    @endif
                </svg>
            </button>
        </div>
        
        @if($showOverview)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Tasks Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Tasks</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $taskStats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-green-600">{{ $taskStats['completed'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- In Progress Tasks Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">In Progress</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $taskStats['in_progress'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Tasks Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $taskStats['pending'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- To Do Column -->
        <div 
            class="bg-gray-50 rounded-lg p-4 min-h-[400px]"
            x-data
            @dragover.prevent="$el.classList.add('bg-blue-50', 'border-2', 'border-blue-200')"
            @dragleave="$el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200')"
            @drop.prevent="
                $el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200');
                const taskId = $event.dataTransfer.getData('text/plain');
                if (taskId) {
                    $wire.updateTaskStatus(taskId, 'todo');
                }
            "
        >
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">To Do</h3>
                <a 
                    href="{{ route('tasks.create', ['status' => 'todo']) }}" 
                    wire:navigate
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                    title="Add task to To Do"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
            
            <!-- Task Cards -->
            <div class="space-y-3">
                @forelse($tasks['todo'] ?? [] as $task)
                    <x-task-card :task="$task" currentStatus="todo" :viewMode="$viewMode" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p class="text-sm">No tasks in this column</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- In Progress Column -->
        <div 
            class="bg-gray-50 rounded-lg p-4 min-h-[400px]"
            x-data
            @dragover.prevent="$el.classList.add('bg-blue-50', 'border-2', 'border-blue-200')"
            @dragleave="$el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200')"
            @drop.prevent="
                $el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200');
                const taskId = $event.dataTransfer.getData('text/plain');
                if (taskId) {
                    $wire.updateTaskStatus(taskId, 'in_progress');
                }
            "
        >
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">In Progress</h3>
                <a 
                    href="{{ route('tasks.create', ['status' => 'in_progress']) }}" 
                    wire:navigate
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                    title="Add task to In Progress"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
            
            <!-- Task Cards -->
            <div class="space-y-3">
                @forelse($tasks['in_progress'] ?? [] as $task)
                    <x-task-card :task="$task" currentStatus="in_progress" :viewMode="$viewMode" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p class="text-sm">No tasks in this column</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Awaiting Column -->
        <div 
            class="bg-gray-50 rounded-lg p-4 min-h-[400px]"
            x-data
            @dragover.prevent="$el.classList.add('bg-blue-50', 'border-2', 'border-blue-200')"
            @dragleave="$el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200')"
            @drop.prevent="
                $el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200');
                const taskId = $event.dataTransfer.getData('text/plain');
                if (taskId) {
                    $wire.updateTaskStatus(taskId, 'awaiting');
                }
            "
        >
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Awaiting</h3>
                <a 
                    href="{{ route('tasks.create', ['status' => 'awaiting']) }}" 
                    wire:navigate
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                    title="Add task to Awaiting"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
            
            <!-- Task Cards -->
            <div class="space-y-3">
                @forelse($tasks['awaiting'] ?? [] as $task)
                    <x-task-card :task="$task" currentStatus="awaiting" :viewMode="$viewMode" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p class="text-sm">No tasks in this column</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Column -->
        <div 
            class="bg-gray-50 rounded-lg p-4 min-h-[400px]"
            x-data
            @dragover.prevent="$el.classList.add('bg-blue-50', 'border-2', 'border-blue-200')"
            @dragleave="$el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200')"
            @drop.prevent="
                $el.classList.remove('bg-blue-50', 'border-2', 'border-blue-200');
                const taskId = $event.dataTransfer.getData('text/plain');
                if (taskId) {
                    $wire.updateTaskStatus(taskId, 'completed');
                }
            "
        >
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Completed</h3>
                <a 
                    href="{{ route('tasks.create', ['status' => 'completed']) }}" 
                    wire:navigate
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                    title="Add task to Completed"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
            
            <!-- Task Cards -->
            <div class="space-y-3">
                @forelse($tasks['completed'] ?? [] as $task)
                    <x-task-card :task="$task" currentStatus="completed" :viewMode="$viewMode" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p class="text-sm">No tasks in this column</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
