@php
use App\Models\Recipe;
use Livewire\Attributes\{Validate, Rule, Layout};

new class extends Livewire\Component {
    public Recipe $recipe;
    public bool $showDetails = false;
    
    #[Validate('required|string|max:255')]
    public string $comment = '';
    
    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }
    
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    
    public function addComment()
    {
        $this->validate();
        
        // Add comment logic here
        $this->comment = '';
        $this->dispatch('comment-added');
    }
    
    public function favourite()
    {
        // Toggle favourite logic
        $this->dispatch('recipe-favourited', recipeId: $this->recipe->id);
    }
};
@endphp

<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-xl font-semibold text-gray-900">{{ $recipe->title }}</h3>
            <p class="text-sm text-gray-600">by {{ $recipe->user->name }}</p>
        </div>
        
        <div class="flex space-x-2">
            <button 
                wire:click="favourite"
                class="text-gray-400 hover:text-red-500 transition-colors"
                title="Add to favourites"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
            
            <button 
                wire:click="toggleDetails"
                class="text-gray-400 hover:text-blue-500 transition-colors"
                title="Toggle details"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>
    
    @if($recipe->description)
        <p class="text-gray-700 mb-4">{{ Str::limit($recipe->description, 150) }}</p>
    @endif
    
    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
        @if($recipe->prep_time)
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Prep: {{ $recipe->prep_time }}min
            </span>
        @endif
        
        @if($recipe->cook_time)
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cook: {{ $recipe->cook_time }}min
            </span>
        @endif
        
        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
            {{ ucfirst($recipe->difficulty) }}
        </span>
    </div>
    
    @if($showDetails)
        <div class="border-t pt-4 space-y-4">
            @if($recipe->ingredients->count() > 0)
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Ingredients</h4>
                    <div class="text-sm text-gray-700 space-y-2">
                        @php
                            $ingredientCount = 0;
                            $maxIngredients = 5;
                        @endphp
                        @foreach($recipe->grouped_ingredients as $group)
                            @if($ingredientCount < $maxIngredients)
                                <div class="space-y-1">
                                    <div class="font-medium text-gray-800 text-xs uppercase tracking-wide">{{ $group['name'] }}</div>
                                    <ul class="space-y-1 ml-2">
                                        @foreach($group['ingredients'] as $ingredient)
                                            @if($ingredientCount < $maxIngredients)
                                                <li class="flex items-center">
                                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-2"></span>
                                                    {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }} {{ $ingredient->name }}
                                                </li>
                                                @php $ingredientCount++; @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                        @if($recipe->ingredients->count() > $maxIngredients)
                            <li class="text-gray-500 italic">... and {{ $recipe->ingredients->count() - $maxIngredients }} more</li>
                        @endif
                    </div>
                </div>
            @endif
            
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Add a comment</h4>
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        wire:model="comment"
                        placeholder="Share your thoughts..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button 
                        wire:click="addComment"
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:opacity-50"
                    >
                        <span wire:loading.remove>Comment</span>
                        <span wire:loading>Adding...</span>
                    </button>
                </div>
                @error('comment') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @endif
    
    <div class="flex justify-between items-center mt-4 pt-4 border-t">
        <div class="flex space-x-2">
            @foreach($recipe->tags->take(3) as $tag)
                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
        
        <a 
            href="{{ route('recipes.show', $recipe) }}"
            wire:navigate.hover
            class="text-blue-500 hover:text-blue-700 font-medium text-sm"
        >
            View Recipe →
        </a>
    </div>
</div>
