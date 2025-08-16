<?php

namespace App\Livewire\Recipes;

use App\Actions\Recipes\CreateRecipe as CreateRecipeAction;
use App\Livewire\Forms\RecipeForm;
use App\Models\Recipe;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CreateRecipe extends Component
{
    public RecipeForm $form;

    // Locked properties for sensitive data
    #[Locked]
    public int $userId;

    public function mount(): void
    {
        $this->userId = (int) (auth()->id() ?? 0);
    }

    public function save(array $formData): mixed
    {
        // Validate the incoming data using Laravel's Validator
        $validator = \Illuminate\Support\Facades\Validator::make($formData, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:main_course,appetizer,dessert,breakfast,snacks',
            'difficulty' => 'required|string|in:easy,medium,hard',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'tags' => 'array',
            'tags.*' => 'string|max:50',
            'ingredients' => 'array',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'nullable|string|max:50',
            'ingredients.*.unit' => 'nullable|string|max:50',
            'ingredients.*.notes' => 'nullable|string|max:255',
            'ingredients.*.group' => 'nullable|string|max:100',
            'instructions' => 'array',
            'instructions.*.instruction' => 'required|string',
            'instructions.*.estimated_time' => 'nullable|integer|min:0',
            'instructions.*.step_type' => 'nullable|string|max:50',
            'instructions.*.notes' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Recipe title is required.',
            'category.required' => 'Please select a category.',
            'difficulty.required' => 'Please select a difficulty level.',
            'ingredients.*.name.required' => 'Ingredient name is required.',
            'instructions.*.instruction.required' => 'Instruction text is required.',
        ]);

        if ($validator->fails()) {
            $this->addError('validation', $validator->errors()->first());

            return null;
        }

        try {
            $this->authorize('create', Recipe::class);
            $recipe = app(CreateRecipeAction::class)->handle(auth()->user(), $formData);
            session()->flash('message', 'Recipe created successfully!');

            return redirect()->route('recipes.show', $recipe);
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating recipe: '.$e->getMessage());

            return null;
        }
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

        $stepTypes = [
            'prep' => 'Preparation',
            'cook' => 'Cooking',
            'rest' => 'Resting',
            'serve' => 'Serving',
            'bake' => 'Baking',
            'chill' => 'Chilling',
            'garnish' => 'Garnishing',
        ];

        $commonUnits = [
            'grams', 'kg', 'ml', 'litres', 'cups', 'tablespoons', 'teaspoons',
            'pieces', 'whole', 'pinch', 'dash', 'slices', 'cloves', 'bunches',
        ];

        $commonGroups = [
            'Main Ingredients',
            'Sauce',
            'Marinade',
            'Garnish',
            'Dressing',
            'Filling',
            'Topping',
            'Base',
            'Seasoning',
        ];

        return view('livewire.recipes.create-recipe', [
            'categories' => $categories,
            'difficulties' => $difficulties,
            'stepTypes' => $stepTypes,
            'commonUnits' => $commonUnits,
            'commonGroups' => $commonGroups,
        ]);
    }
}
