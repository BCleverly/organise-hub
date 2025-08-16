<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $recipe->title }}</h1>
            @if($recipe->description)
                <p class="text-gray-600 mt-2">{{ $recipe->description }}</p>
            @endif
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('recipes') }}" wire:navigate.hover class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            @if(auth()->id() === $recipe->user_id)
                <a 
                    href="{{ route('recipes.edit', $recipe) }}" wire:navigate.hover
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Edit
                </a>
                <button 
                    wire:click="$set('showDeleteConfirmation', true)"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                >
                    Delete
                </button>
            @endif
        </div>
    </div>

    <!-- Recipe Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Prep Time</p>
                    <p class="font-semibold">{{ $recipe->prep_time ? $recipe->prep_time . ' min' : 'Not specified' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Cook Time</p>
                    <p class="font-semibold">{{ $recipe->cook_time ? $recipe->cook_time . ' min' : 'Not specified' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Total Time</p>
                    <p class="font-semibold">{{ $this->totalTime() }}m</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Servings</p>
                    <p class="font-semibold">{{ $recipe->servings ? $recipe->servings . ' servings' : 'Not specified' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Difficulty</p>
                    <p class="font-semibold">{{ ucfirst($recipe->difficulty) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="font-semibold">{{ ucwords(str_replace('_', ' ', $recipe->category)) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tags -->
    @if($recipe->tags->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($recipe->tags as $tag)
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Ingredients and Instructions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Ingredients -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ingredients</h3>
            @if($recipe->ingredients->count() > 0)
                <div class="space-y-6">
                    @foreach($recipe->grouped_ingredients as $group)
                        <div class="space-y-3">
                            <h4 class="text-md font-medium text-gray-700 border-b border-gray-200 pb-2">{{ $group['name'] }}</h4>
                            <ul class="space-y-3">
                                @foreach($group['ingredients'] as $ingredient)
                                    <li class="flex items-start">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                        <div class="flex-1">
                                            <span class="font-medium">{{ $ingredient->name }}</span>
                                            @if($ingredient->pivot->quantity || $ingredient->pivot->unit)
                                                <span class="text-gray-600 ml-2">
                                                    {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}
                                                </span>
                                            @endif
                                            @if($ingredient->pivot->notes)
                                                <div class="text-sm text-gray-500 mt-1">{{ $ingredient->pivot->notes }}</div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No ingredients specified.</p>
            @endif
        </div>

        <!-- Instructions -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Instructions</h3>
            @if($recipe->instructions->count() > 0)
                <ol class="space-y-4">
                    @foreach($recipe->instructions as $instruction)
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                {{ $instruction->step_number }}
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-900">{{ $instruction->instruction }}</p>
                                @if($instruction->estimated_time || $instruction->step_type || $instruction->notes)
                                    <div class="flex items-center gap-2 mt-2">
                                        @if($instruction->estimated_time)
                                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                {{ $instruction->estimated_time }}m
                                            </span>
                                        @endif
                                        @if($instruction->step_type)
                                            <span class="text-sm text-gray-500 bg-blue-100 px-2 py-1 rounded">
                                                {{ ucfirst($instruction->step_type) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($instruction->notes)
                                        <div class="text-sm text-gray-500 mt-1 italic">{{ $instruction->notes }}</div>
                                    @endif
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="text-gray-500">No instructions specified.</p>
            @endif
        </div>
    </div>

    <!-- Recipe Meta -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-between text-sm text-gray-500">
            <div class="flex items-center space-x-4">
                <span>Created by {{ $recipe->user->name }}</span>
                <span>{{ $recipe->created_at->format('M j, Y') }}</span>
                @if($recipe->is_public)
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Public</span>
                @else
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Private</span>
                @endif
            </div>
            @if($recipe->rating)
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span>{{ $recipe->formatted_rating }}</span>
                </div>
            @else
                <span class="text-sm text-gray-500">No ratings</span>
            @endif
        </div>
    </div>

    <!-- Reactions Section -->
    @if($recipe->is_public)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Like Button -->
                    <button 
                        wire:click="toggleLike"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-colors {{ $this->isLikedByCurrentUser() ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                    >
                        @if($this->isLikedByCurrentUser())
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        @endif
                        <span class="font-medium">{{ $this->likeCount() }}</span>
                        <span class="text-sm">{{ $this->likeCount() === 1 ? 'like' : 'likes' }}</span>
                    </button>

                    <!-- Reaction Summary -->
                    @if($this->likeCount() > 0)
                        <div class="text-sm text-gray-500">
                            {{ $this->likeCount() }} {{ $this->likeCount() === 1 ? 'person' : 'people' }} {{ $this->likeCount() === 1 ? 'likes' : 'like' }} this recipe
                        </div>
                    @endif
                </div>

                <!-- Share Button (placeholder for future functionality) -->
                <button class="flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                    </svg>
                    <span>Share</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteConfirmation)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Delete Recipe</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete "{{ $recipe->title }}"? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button 
                        wire:click="$set('showDeleteConfirmation', false)"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        wire:click="deleteRecipe"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
