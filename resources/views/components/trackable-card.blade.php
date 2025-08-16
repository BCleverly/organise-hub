@props(['trackable', 'showProgress' => true, 'viewMode' => 'default'])

@php
    $isCompleted = $trackable->isCompletedToday();
    
    // Get colors based on type
    $colors = match ($trackable->type) {
        'HABIT' => [
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-600',
            'border' => 'border-blue-200',
            'hover' => 'hover:bg-blue-100',
        ],
        'SKILL' => [
            'bg' => 'bg-purple-50',
            'text' => 'text-purple-600',
            'border' => 'border-purple-200',
            'hover' => 'hover:bg-purple-100',
        ],
        default => [
            'bg' => 'bg-gray-50',
            'text' => 'text-gray-600',
            'border' => 'border-gray-200',
            'hover' => 'hover:bg-gray-100',
        ],
    };
    
    // Get icon based on type
    $icon = match ($trackable->type) {
        'HABIT' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'SKILL' => 'M13 10V3L4 14h7v7l9-11h-7z',
        default => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
    };
    
    // Get completion color
    $completionColor = $isCompleted ? 'text-green-600 bg-green-50 border-green-200' : 'text-gray-600 bg-gray-50 border-gray-200';
    
    // Get progress percentage and color
    $progressPercentage = $trackable->type === 'SKILL' ? $trackable->progress_percentage : 0;
    $progressColor = match (true) {
        $progressPercentage >= 80 => 'bg-green-500',
        $progressPercentage >= 60 => 'bg-blue-500',
        $progressPercentage >= 40 => 'bg-yellow-500',
        $progressPercentage >= 20 => 'bg-orange-500',
        default => 'bg-red-500',
    };
@endphp

<div class="bg-white rounded-lg border {{ $colors['border'] }} shadow-sm hover:shadow-md transition-all duration-200 {{ $colors['hover'] }}">
    <div class="p-4">
        <!-- Header -->
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center space-x-2 flex-1">
                <!-- Type Icon -->
                <div class="w-8 h-8 {{ $colors['bg'] }} rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                    </svg>
                </div>
                
                <!-- Title and Description -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-medium text-gray-900 text-sm leading-tight">{{ $trackable->title }}</h3>
                    @if($trackable->description)
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $trackable->description }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $completionColor }}">
                    @if($isCompleted)
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Done
                    @else
                        Pending
                    @endif
                </span>
            </div>
        </div>

        <!-- Progress Bar for Skills -->
        @if($trackable->type === 'SKILL' && $showProgress)
            <div class="mb-3">
                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                    <span>Progress</span>
                    <span>{{ $progressPercentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full {{ $progressColor }} transition-all duration-300" 
                         style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>
        @endif

        <!-- Streak Info for Habits -->
        @if($trackable->type === 'HABIT' && $trackable->current_streak > 0)
            <div class="mb-3">
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>{{ $trackable->current_streak }} day{{ $trackable->current_streak > 1 ? 's' : '' }} streak</span>
                    @if($trackable->longest_streak > $trackable->current_streak)
                        <span class="ml-2">(Best: {{ $trackable->longest_streak }})</span>
                    @endif
                </div>
            </div>
        @endif

        <!-- Interactive Element based on goal_metric -->
        <div class="mt-4">
            @switch($trackable->goal_metric)
                @case('checkbox')
                    <!-- Checkbox for yes/no goals -->
                    <button 
                        wire:click="{{ $isCompleted ? 'markIncomplete(' . $trackable->id . ')' : 'markCompleted(' . $trackable->id . ')' }}"
                        class="w-full flex items-center justify-center px-4 py-2 rounded-lg border-2 transition-all duration-200 {{ $isCompleted ? 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100' : 'bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100' }}"
                    >
                        @if($isCompleted)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Completed
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Mark Complete
                        @endif
                    </button>
                    @break

                @case('duration')
                    <!-- Timer for duration-based goals -->
                    <div class="space-y-2">
                        @if($isCompleted)
                            <div class="text-center py-2 bg-green-50 border border-green-200 rounded-lg">
                                <div class="text-sm font-medium text-green-700">
                                    {{ $trackable->getTodayDuration() }} minutes completed
                                </div>
                                <button 
                                    wire:click="markIncomplete({{ $trackable->id }})"
                                    class="text-xs text-green-600 hover:text-green-800 mt-1"
                                >
                                    Reset
                                </button>
                            </div>
                        @else
                            <div class="flex space-x-2">
                                <button 
                                    wire:click="markCompleted({{ $trackable->id }}, 1, {{ $trackable->target_duration_minutes ?? 30 }})"
                                    class="flex-1 px-3 py-2 bg-blue-50 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-sm"
                                >
                                    {{ $trackable->target_duration_minutes ?? 30 }}min
                                </button>
                                <button 
                                    wire:click="markCompleted({{ $trackable->id }}, 1, 15)"
                                    class="flex-1 px-3 py-2 bg-gray-50 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors text-sm"
                                >
                                    15min
                                </button>
                            </div>
                        @endif
                    </div>
                    @break

                @case('count')
                    <!-- Counter for numeric goals -->
                    <div class="space-y-2">
                        @if($isCompleted)
                            <div class="text-center py-2 bg-green-50 border border-green-200 rounded-lg">
                                <div class="text-sm font-medium text-green-700">
                                    {{ $trackable->getTodayCount() }} completed
                                </div>
                                <button 
                                    wire:click="markIncomplete({{ $trackable->id }})"
                                    class="text-xs text-green-600 hover:text-green-800 mt-1"
                                >
                                    Reset
                                </button>
                            </div>
                        @else
                            <div class="flex items-center space-x-2">
                                <button 
                                    wire:click="markCompleted({{ $trackable->id }}, {{ max(1, ($trackable->target_count ?? 1) - 1) }})"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                
                                <span class="flex-1 text-center text-sm font-medium text-gray-700">
                                    {{ $trackable->target_count ?? 1 }}
                                </span>
                                
                                <button 
                                    wire:click="markCompleted({{ $trackable->id }}, {{ ($trackable->target_count ?? 1) + 1 }})"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <button 
                                wire:click="markCompleted({{ $trackable->id }}, {{ $trackable->target_count ?? 1 }})"
                                class="w-full px-3 py-2 bg-blue-50 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-sm"
                            >
                                Complete Target
                            </button>
                        @endif
                    </div>
                    @break

                @default
                    <!-- Fallback -->
                    <div class="text-center py-2 text-gray-500 text-sm">
                        Unknown goal type
                    </div>
            @endswitch
        </div>

        <!-- Parent Skill Link -->
        @if($trackable->type === 'HABIT' && $trackable->parentSkill)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Part of: {{ $trackable->parentSkill->title }}</span>
                </div>
            </div>
        @endif

        <!-- Child Habits for Skills -->
        @if($trackable->type === 'SKILL' && $trackable->childHabits->count() > 0)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <div class="text-xs text-gray-500 mb-2">
                    {{ $trackable->childHabits->filter(fn($habit) => $habit->isCompletedToday())->count() }} of {{ $trackable->childHabits->count() }} habits completed today
                </div>
                <div class="space-y-1">
                    @foreach($trackable->childHabits->take(3) as $habit)
                        <div class="flex items-center text-xs">
                            <div class="w-2 h-2 rounded-full mr-2 {{ $habit->isCompletedToday() ? 'bg-green-400' : 'bg-gray-300' }}"></div>
                            <span class="text-gray-600 truncate">{{ $habit->title }}</span>
                        </div>
                    @endforeach
                    @if($trackable->childHabits->count() > 3)
                        <div class="text-xs text-gray-400">
                            +{{ $trackable->childHabits->count() - 3 }} more
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>