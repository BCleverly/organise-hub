<div>
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 lg:mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Recipe Book</h1>
            <p class="text-sm lg:text-base text-gray-600 dark:text-gray-400 mt-1">
                @if($viewMode === 'my')
                    Discover and organise your favourite recipes.
                @elseif($viewMode === 'favourites')
                    Your liked recipes from the community.
                @else
                    Get inspired by recipes shared by our community.
                @endif
            </p>
        </div>
        <div class="mt-4 lg:mt-0 flex items-center space-x-3">
            <button class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                </svg>
            </button>
            <a href="{{ route('recipes.create') }}" wire:navigate class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-start bg-blue-600 border border-blue-600 text-white text-sm font-medium rounded-lg shadow-sm align-middle hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add recipe
            </a>
        </div>
    </div>

    <!-- View Mode Toggle -->
    <div class="mb-6 lg:mb-8">
        <div class="flex space-x-1 bg-gray-100 dark:bg-gray-700 p-1 rounded-lg w-fit">
            <button 
                wire:click="$set('viewMode', 'my')" 
                class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewMode === 'my' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
            >
                My Recipes
            </button>
            <button 
                wire:click="$set('viewMode', 'discover')" 
                class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewMode === 'discover' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
            >
                Discover
            </button>
            @if(auth()->check())
                <button 
                    wire:click="$set('viewMode', 'favourites')" 
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewMode === 'favourites' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Favourites
                </button>
            @endif
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6 lg:mb-8">
        <div class="relative">
            <input 
                wire:model.live.debounce.300ms="search"
                type="text" 
                placeholder="Search recipes..." 
                class="w-full pl-4 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
            >
            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recipe Categories -->
    <div class="mb-6 lg:mb-8">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white mb-4">Categories</h2>
        <div class="flex flex-wrap gap-3">
            <button 
                wire:click="$set('categoryFilter', '')" 
                class="px-4 py-2 {{ $categoryFilter === '' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-lg transition-colors"
            >
                All Categories
            </button>
            @foreach($categories as $key => $label)
                <button 
                    wire:click="$set('categoryFilter', '{{ $key }}')" 
                    class="px-4 py-2 {{ $categoryFilter === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-lg transition-colors"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Difficulty Filter -->
    <div class="mb-6 lg:mb-8">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white mb-4">Difficulties</h2>
        <div class="flex flex-wrap gap-3">
            <button 
                wire:click="$set('difficultyFilter', '')" 
                class="px-4 py-2 {{ $difficultyFilter === '' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-lg transition-colors"
            >
                All Difficulties
            </button>
            @foreach($difficulties as $key => $label)
                <button 
                    wire:click="$set('difficultyFilter', '{{ $key }}')" 
                    class="px-4 py-2 {{ $difficultyFilter === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-lg transition-colors"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Recipe Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($recipes as $recipe)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm bg-{{ $recipe->category === 'dessert' ? 'orange' : ($recipe->category === 'main_course' ? 'blue' : ($recipe->category === 'appetizer' ? 'green' : ($recipe->category === 'breakfast' ? 'yellow' : 'purple'))) }}-100 text-{{ $recipe->category === 'dessert' ? 'orange' : ($recipe->category === 'main_course' ? 'blue' : ($recipe->category === 'appetizer' ? 'green' : ($recipe->category === 'breakfast' ? 'yellow' : 'purple'))) }}-700 dark:bg-{{ $recipe->category === 'dessert' ? 'orange' : ($recipe->category === 'main_course' ? 'blue' : ($recipe->category === 'appetizer' ? 'green' : ($recipe->category === 'breakfast' ? 'yellow' : 'purple'))) }}-900/20 dark:text-{{ $recipe->category === 'dessert' ? 'orange' : ($recipe->category === 'main_course' ? 'blue' : ($recipe->category === 'appetizer' ? 'green' : ($recipe->category === 'breakfast' ? 'yellow' : 'purple'))) }}-300 rounded-full">
                        {{ $categories[$recipe->category] ?? ucfirst($recipe->category) }}
                    </span>
                    <div class="flex items-center space-x-2">
                        @if($viewMode === 'my')
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-700">
                                    <div class="py-1">
                                        <button wire:click="$dispatch('open-modal', { component: 'recipes.recipe-form', arguments: { recipe: {{ $recipe->id }} }})" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            Edit Recipe
                                        </button>
                                        <button wire:click="$dispatch('open-modal', { component: 'recipes.delete-confirmation', arguments: { recipe: {{ $recipe->id }} }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            Delete Recipe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($recipe->is_public)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-300 rounded">Public</span>
                        @endif
                    </div>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $recipe->title }}</h3>
                @if($recipe->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($recipe->description, 120) }}</p>
                @endif
                
                @if($viewMode === 'discover')
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-2">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ substr($recipe->user->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">by {{ $recipe->user->name }}</span>
                    </div>
                @endif
                
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        @if($recipe->rating)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $recipe->formatted_rating }}</span>
                        @else
                            <span class="text-sm text-gray-500 dark:text-gray-500">No ratings</span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($recipe->total_time)
                            <span class="text-sm text-gray-500 dark:text-gray-500">{{ $recipe->formatted_total_time }}</span>
                        @endif
                        @if($recipe->is_public && auth()->check())
                            @php
                                $isLiked = $recipe->isReactBy(auth()->user());
                                $likeCount = $recipe->reaction_summary['like'] ?? 0;
                            @endphp
                            <button 
                                wire:click="toggleLike({{ $recipe->id }})"
                                class="flex items-center space-x-1 text-sm transition-colors {{ $isLiked ? 'text-red-500' : 'text-gray-400 dark:text-gray-500 hover:text-red-500' }}"
                            >
                                @if($isLiked)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                @endif
                                @if($likeCount > 0)
                                    <span>{{ $likeCount }}</span>
                                @endif
                            </button>
                        @endif
                    </div>
                </div>
                
                @if($recipe->tags->count() > 0)
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($recipe->tags as $tag)
                            <span class="px-2 py-1 text-xs bg-purple-100 text-purple-700 dark:bg-purple-900/20 dark:text-purple-300 rounded">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex space-x-2">
                    <a href="{{ route('recipes.show', $recipe) }}" wire:navigate.hover class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm text-center">
                        View Recipe
                    </a>
                    @if($viewMode === 'my')
                        <a href="{{ route('recipes.edit', $recipe) }}" wire:navigate.hover class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Edit
                        </a>
                    @else
                        <button class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Save to My Recipes
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    @if($viewMode === 'my')
                        No recipes found
                    @elseif($viewMode === 'favourites')
                        No favourite recipes found
                    @else
                        No public recipes found
                    @endif
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">
                    @if($viewMode === 'my')
                        Start by creating your first recipe!
                    @elseif($viewMode === 'favourites')
                        Like some recipes to see them here!
                    @else
                        Try adjusting your search or filters.
                    @endif
                </p>
                @if($viewMode === 'my')
                    <a href="{{ route('recipes.create') }}" wire:navigate class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Recipe
                    </a>
                @elseif($viewMode === 'favourites')
                    <button wire:click="$set('viewMode', 'discover')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Discover Recipes
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($recipes->hasPages())
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    @endif
</div>
