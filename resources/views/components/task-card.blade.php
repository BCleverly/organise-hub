@props(['task', 'currentStatus', 'viewMode' => 'detailed'])

@if($viewMode === 'detailed')
    <div 
        class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700 cursor-move hover:shadow-md transition-shadow"
        draggable="true"
        wire:key="task-{{ $task->id }}"
        ondragstart="
            event.dataTransfer.setData('text/plain', '{{ $task->id }}');
            this.classList.add('opacity-50', 'scale-95');
        "
        ondragend="this.classList.remove('opacity-50', 'scale-95')"
    >
    <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $task->title }}</h4>
    @if($task->description)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($task->description, 100) }}</p>
    @endif
    <div class="flex items-center justify-between mb-3">
        @if($currentStatus === 'completed' && $task->completed_at)
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $task->completed_at->format('Y-m-d') }}</span>
        @elseif($task->due_date)
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $task->due_date->format('Y-m-d') }}</span>
        @endif
        <div class="flex space-x-2">
            @if($task->priority === 'high')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full border border-orange-200 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-700/30">High</span>
            @elseif($task->priority === 'medium')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700/30">Medium</span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full border border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-700/30">Low</span>
            @endif
            @if($currentStatus === 'todo')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">Pending</span>
            @elseif($currentStatus === 'in_progress')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full border border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700/30">Working</span>
            @elseif($currentStatus === 'awaiting')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full border border-orange-200 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-700/30">Waiting</span>
            @elseif($currentStatus === 'completed')
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full border border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-700/30">Done</span>
            @endif
        </div>
    </div>
    @if($task->tags->count() > 0)
        <div class="flex flex-wrap gap-1.5 mb-3">
            @foreach($task->tags as $tag)
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full border border-purple-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-700/30">{{ $tag->name }}</span>
            @endforeach
        </div>
    @endif
    
    <!-- Quick Action Buttons -->
    <div class="flex space-x-2 mb-3">
        @if($currentStatus === 'todo')
            <button 
                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                class="flex-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 py-1.5 rounded-md border border-blue-200 hover:bg-blue-50 dark:border-blue-700/30 dark:hover:bg-blue-900/20 transition-colors"
                title="Move to In Progress"
            >
                →
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                class="flex-1 text-xs font-medium text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 py-1.5 rounded-md border border-orange-200 hover:bg-orange-50 dark:border-orange-700/30 dark:hover:bg-orange-900/20 transition-colors"
                title="Move to Awaiting"
            >
                ⏸
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'completed')"
                class="flex-1 text-xs font-medium text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 py-1.5 rounded-md border border-green-200 hover:bg-green-50 dark:border-green-700/30 dark:hover:bg-green-900/20 transition-colors"
                title="Mark as Completed"
            >
                ✓
            </button>
        @elseif($currentStatus === 'in_progress')
            <button 
                wire:click="moveTask({{ $task->id }}, 'todo')"
                class="flex-1 text-xs font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 py-1.5 rounded-md border border-gray-200 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
                title="Move back to To Do"
            >
                ←
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                class="flex-1 text-xs font-medium text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 py-1.5 rounded-md border border-orange-200 hover:bg-orange-50 dark:border-orange-700/30 dark:hover:bg-orange-900/20 transition-colors"
                title="Move to Awaiting"
            >
                ⏸
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'completed')"
                class="flex-1 text-xs font-medium text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 py-1.5 rounded-md border border-green-200 hover:bg-green-50 dark:border-green-700/30 dark:hover:bg-green-900/20 transition-colors"
                title="Mark as Completed"
            >
                ✓
            </button>
        @elseif($currentStatus === 'awaiting')
            <button 
                wire:click="moveTask({{ $task->id }}, 'todo')"
                class="flex-1 text-xs font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 py-1.5 rounded-md border border-gray-200 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
                title="Move back to To Do"
            >
                ←
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                class="flex-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 py-1.5 rounded-md border border-blue-200 hover:bg-blue-50 dark:border-blue-700/30 dark:hover:bg-blue-900/20 transition-colors"
                title="Move to In Progress"
            >
                →
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'completed')"
                class="flex-1 text-xs font-medium text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 py-1.5 rounded-md border border-green-200 hover:bg-green-50 dark:border-green-700/30 dark:hover:bg-green-900/20 transition-colors"
                title="Mark as Completed"
            >
                ✓
            </button>
        @elseif($currentStatus === 'completed')
            <button 
                wire:click="moveTask({{ $task->id }}, 'todo')"
                class="flex-1 text-xs font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 py-1.5 rounded-md border border-gray-200 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
                title="Move back to To Do"
            >
                ←
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                class="flex-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 py-1.5 rounded-md border border-blue-200 hover:bg-blue-50 dark:border-blue-700/30 dark:hover:bg-blue-900/20 transition-colors"
                title="Move to In Progress"
            >
                →
            </button>
            <button 
                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                class="flex-1 text-xs font-medium text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 py-1.5 rounded-md border border-orange-200 hover:bg-orange-50 dark:border-orange-700/30 dark:hover:bg-orange-900/20 transition-colors"
                title="Move to Awaiting"
            >
                ⏸
            </button>
        @endif
    </div>
    
    <a 
        href="{{ route('tasks.edit', $task) }}" 
        wire:navigate
        class="w-full text-sm font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 py-1.5 rounded-md border border-gray-200 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors block text-center"
    >
        Edit
    </a>
</div>
@else
    <!-- Minimal View -->
    <div 
        class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700 cursor-move hover:shadow-md transition-shadow"
        draggable="true"
        wire:key="task-{{ $task->id }}"
        ondragstart="
            event.dataTransfer.setData('text/plain', '{{ $task->id }}');
            this.classList.add('opacity-50', 'scale-95');
        "
        ondragend="this.classList.remove('opacity-50', 'scale-95')"
    >
        <div class="flex items-center justify-between">
            <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate flex-1">{{ $task->title }}</h4>
            
            <!-- Dropdown Menu -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 p-1 rounded cursor-pointer"
                    title="Task actions"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
                
                <!-- Dropdown Content -->
                <div 
                    x-show="open" 
                    x-cloak
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-10"
                >
                    <div class="py-1">
                        <!-- Move Actions -->
                        @if($currentStatus === 'todo')
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                                class="w-full text-left px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                            >
                                → Move to In Progress
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                                class="w-full text-left px-4 py-2 text-sm text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20"
                            >
                                ⏸ Move to Awaiting
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'completed')"
                                class="w-full text-left px-4 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20"
                            >
                                ✓ Mark as Completed
                            </button>
                        @elseif($currentStatus === 'in_progress')
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'todo')"
                                class="w-full text-left px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                            >
                                ← Move to To Do
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                                class="w-full text-left px-4 py-2 text-sm text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20"
                            >
                                ⏸ Move to Awaiting
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'completed')"
                                class="w-full text-left px-4 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20"
                            >
                                ✓ Mark as Completed
                            </button>
                        @elseif($currentStatus === 'awaiting')
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'todo')"
                                class="w-full text-left px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                            >
                                ← Move to To Do
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                                class="w-full text-left px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                            >
                                → Move to In Progress
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'completed')"
                                class="w-full text-left px-4 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20"
                            >
                                ✓ Mark as Completed
                            </button>
                        @elseif($currentStatus === 'completed')
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'todo')"
                                class="w-full text-left px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                            >
                                ← Move to To Do
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'in_progress')"
                                class="w-full text-left px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                            >
                                → Move to In Progress
                            </button>
                            <button 
                                wire:click="moveTask({{ $task->id }}, 'awaiting')"
                                class="w-full text-left px-4 py-2 text-sm text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20"
                            >
                                ⏸ Move to Awaiting
                            </button>
                        @endif
                        
                        <div class="border-t border-gray-100 dark:border-gray-600 my-1"></div>
                        
                        <!-- Edit Action -->
                        <a 
                            href="{{ route('tasks.edit', $task) }}" 
                            wire:navigate
                            class="block w-full text-left px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            ✏️ Edit Task
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Priority Badge -->
        <div class="mt-2">
            @if($task->priority === 'high')
                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 dark:bg-orange-900/20 dark:text-orange-300 rounded">High</span>
            @elseif($task->priority === 'medium')
                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300 rounded">Medium</span>
            @else
                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-300 rounded">Low</span>
            @endif
        </div>
    </div>
@endif
