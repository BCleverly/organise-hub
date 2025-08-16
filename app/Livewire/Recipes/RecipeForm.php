<?php

namespace App\Livewire\Recipes;

use App\Actions\Recipes\CreateRecipe;
use App\Actions\Recipes\UpdateRecipe;
use App\Models\Recipe;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RecipeForm extends Component
{
    public ?Recipe $recipe = null;

    public string $title = '';

    public ?string $description = '';

    public $ingredients = '';

    public $instructions = '';

    public ?int $prep_time = null;

    public ?int $cook_time = null;

    public ?int $servings = null;

    public string $difficulty = 'medium';

    public string $category = 'main_course';

    public bool $is_public = false;

    /** @var array<int, string> */
    public array $tags = [];

    public string $newTag = '';

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ingredients' => ['nullable'],
            'instructions' => ['nullable'],
            'prep_time' => ['nullable', 'integer', 'min:0'],
            'cook_time' => ['nullable', 'integer', 'min:0'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'category' => ['required', 'string', 'in:main_course,appetizer,dessert,breakfast,snacks'],
            'is_public' => ['boolean'],
            'tags.*' => ['string', 'max:50'],
        ];
    }

    public function mount(?Recipe $recipe = null): void
    {
        if ($recipe) {
            $this->recipe = $recipe;
            $this->fill($recipe->toArray());
            $this->tags = $recipe->tags->pluck('name')->toArray();
        }
    }

    public function addTag(): void
    {
        if (! empty($this->newTag) && ! in_array($this->newTag, $this->tags)) {
            $this->tags[] = $this->newTag;
            $this->newTag = '';
        }
    }

    public function removeTag(int $index): void
    {
        if (isset($this->tags[$index])) {
            unset($this->tags[$index]);
            $this->tags = array_values($this->tags);
        }
    }

    public function save(CreateRecipe $createRecipe, UpdateRecipe $updateRecipe): void
    {
        $validated = $this->validate();

        // Convert string ingredients and instructions to array format
        if (is_string($validated['ingredients'] ?? null)) {
            $validated['ingredients'] = $this->convertIngredientsStringToArray($validated['ingredients']);
        }

        if (is_string($validated['instructions'] ?? null)) {
            $validated['instructions'] = $this->convertInstructionsStringToArray($validated['instructions']);
        }

        if ($this->recipe) {
            // Update existing recipe
            $updateRecipe->handle($this->recipe, $validated);
            session()->flash('message', 'Recipe updated successfully!');
        } else {
            // Create new recipe
            try {
                $recipe = $createRecipe->handle(auth()->user(), $validated);
                session()->flash('message', 'Recipe created successfully!');
                $this->reset(['title', 'description', 'ingredients', 'instructions', 'prep_time', 'cook_time', 'servings', 'difficulty', 'category', 'is_public', 'tags']);
            } catch (\Exception $e) {
                session()->flash('error', 'Error creating recipe: '.$e->getMessage());

                return;
            }
        }

        $this->dispatch('recipe-saved');
    }

    /**
     * Convert ingredients string to array format
     */
    private function convertIngredientsStringToArray(string $ingredientsString): array
    {
        if (empty($ingredientsString)) {
            return [];
        }

        // Split by commas and clean up
        $ingredients = array_map('trim', explode(',', $ingredientsString));
        
        $result = [];
        foreach ($ingredients as $ingredient) {
            if (!empty($ingredient)) {
                $result[] = [
                    'name' => $ingredient,
                    'quantity' => null,
                    'unit' => null,
                    'notes' => null,
                    'group' => 'Main Ingredients',
                ];
            }
        }

        return $result;
    }

    /**
     * Convert instructions string to array format
     */
    private function convertInstructionsStringToArray(string $instructionsString): array
    {
        if (empty($instructionsString)) {
            return [];
        }

        // Split by numbered steps or periods
        $instructions = preg_split('/\d+\.\s*|\.\s*(?=\d+\.)/', $instructionsString);
        
        $result = [];
        foreach ($instructions as $index => $instruction) {
            $instruction = trim($instruction);
            if (!empty($instruction)) {
                $result[] = [
                    'instruction' => $instruction,
                    'estimated_time' => null,
                    'step_type' => 'preparation',
                    'notes' => null,
                ];
            }
        }

        return $result;
    }

    public function render(): \Illuminate\View\View
    {
        $categories = [
            'main_course' => 'Main Course',
            'appetizer' => 'Appetizer',
            'dessert' => 'Dessert',
            'breakfast' => 'Breakfast',
            'snacks' => 'Snacks',
        ];

        $difficulties = [
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard',
        ];

        return view('livewire.recipes.recipe-form', [
            'categories' => $categories,
            'difficulties' => $difficulties,
        ]);
    }
}
