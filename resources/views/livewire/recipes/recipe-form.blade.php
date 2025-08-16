<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ $recipe ? 'Edit Recipe' : 'Create New Recipe' }}
            </h2>
            <button wire:click="$dispatch('close-modal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form wire:submit="save" class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Recipe Title *</label>
                <input 
                    wire:model="title"
                    type="text" 
                    id="title"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter recipe title"
                >
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea 
                    wire:model="description"
                    id="description"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Brief description of the recipe"
                ></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Category and Difficulty -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select 
                        wire:model="category"
                        id="category"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty *</label>
                    <select 
                        wire:model="difficulty"
                        id="difficulty"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        @foreach($difficulties as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('difficulty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Time and Servings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="prep_time" class="block text-sm font-medium text-gray-700 mb-2">Prep Time (minutes)</label>
                    <input 
                        wire:model="prep_time"
                        type="number" 
                        id="prep_time"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="15"
                    >
                    @error('prep_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="cook_time" class="block text-sm font-medium text-gray-700 mb-2">Cook Time (minutes)</label>
                    <input 
                        wire:model="cook_time"
                        type="number" 
                        id="cook_time"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="30"
                    >
                    @error('cook_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">Servings</label>
                    <input 
                        wire:model="servings"
                        type="number" 
                        id="servings"
                        min="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="4"
                    >
                    @error('servings') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Ingredients -->
            <div>
                <label for="ingredients" class="block text-sm font-medium text-gray-700 mb-2">Ingredients</label>
                <textarea 
                    wire:model="ingredients"
                    id="ingredients"
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="List all ingredients with quantities..."
                ></textarea>
                <p class="text-sm text-gray-500 mt-1">Enter ingredients with quantities (e.g., "2 cups flour, 1 tsp salt")</p>
                @error('ingredients') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Instructions -->
            <div>
                <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">Instructions</label>
                <textarea 
                    wire:model="instructions"
                    id="instructions"
                    rows="8"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Step-by-step cooking instructions..."
                ></textarea>
                @error('instructions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($tags as $index => $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                            {{ $tag }}
                            <button 
                                type="button"
                                wire:click="removeTag({{ $index }})"
                                class="ml-2 text-blue-600 hover:text-blue-800"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                </div>
                <div class="flex gap-2">
                    <input 
                        wire:model="newTag"
                        type="text" 
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Add a tag"
                        wire:keydown.enter.prevent="addTag"
                    >
                    <button 
                        type="button"
                        wire:click="addTag"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Add
                    </button>
                </div>
                @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Public/Private Toggle -->
            <div class="flex items-center">
                <input 
                    wire:model="is_public"
                    type="checkbox" 
                    id="is_public"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="is_public" class="ml-2 block text-sm text-gray-700">
                    Make this recipe public (visible to other users)
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <button 
                    type="button"
                    wire:click="$dispatch('close-modal')"
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    {{ $recipe ? 'Update Recipe' : 'Create Recipe' }}
                </button>
            </div>
        </form>
    </div>
</div>
