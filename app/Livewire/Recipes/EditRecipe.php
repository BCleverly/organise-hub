<?php

namespace App\Livewire\Recipes;

use App\Actions\Recipes\UpdateRecipe as UpdateRecipeAction;
use App\Livewire\Forms\RecipeForm;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeInstruction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.app')]
class EditRecipe extends Component
{
    public Recipe $recipe;

    public RecipeForm $form;

    // Locked properties for sensitive data
    #[Locked]
    public int $userId;

    public function mount(Recipe $recipe): void
    {
        $this->recipe = $recipe;
        $this->userId = (int) (auth()->id() ?? 0);

        // Check if user owns this recipe
        if ($this->recipe->user_id !== $this->userId) {
            abort(403, 'You can only edit your own recipes.');
        }

        // Fill the form with existing data
        $this->form->title = $recipe->title;
        $this->form->description = $recipe->description;
        $this->form->prep_time = $recipe->prep_time;
        $this->form->cook_time = $recipe->cook_time;
        $this->form->servings = $recipe->servings;
        $this->form->difficulty = $recipe->difficulty;
        $this->form->category = $recipe->category;
        $this->form->is_public = $recipe->is_public;
        $this->form->tags = $recipe->tags->pluck('name')->toArray();

        // Load ingredients
        /** @var \Illuminate\Database\Eloquent\Collection<int, Ingredient> $ingredients */
        $ingredients = $recipe->ingredients;
        $this->form->ingredients = $ingredients->map(function (Ingredient $ingredient) {
            /** @var RecipeIngredient $pivot */
            $pivot = $ingredient->pivot;

            return [
                'name' => $ingredient->name,
                'quantity' => $pivot->quantity,
                'unit' => $pivot->unit,
                'group' => $pivot->group ?? 'Main Ingredients',
                'notes' => $pivot->notes,
            ];
        })->toArray();

        // Load instructions
        /** @var \Illuminate\Database\Eloquent\Collection<int, RecipeInstruction> $instructions */
        $instructions = $recipe->instructions;
        $this->form->instructions = $instructions->map(function (RecipeInstruction $instruction) {
            return [
                'instruction' => $instruction->instruction,
                'estimated_time' => $instruction->estimated_time,
                'step_type' => $instruction->step_type,
                'notes' => $instruction->notes,
            ];
        })->toArray();
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
            'is_public' => 'nullable|boolean',
            'tags' => 'array',
            'tags.*' => 'string|max:50',
            'ingredients' => 'array',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'nullable|max:50',
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
            throw new \Exception($validator->errors()->first());
        }

        try {
            $recipe = app(UpdateRecipeAction::class)->handle($this->recipe, $formData);
            session()->flash('message', 'Recipe updated successfully!');

            return redirect()->route('recipes.show', $recipe);
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating recipe: '.$e->getMessage());
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

        return view('livewire.recipes.edit-recipe', [
            'categories' => $categories,
            'difficulties' => $difficulties,
            'stepTypes' => $stepTypes,
            'commonUnits' => $commonUnits,
            'commonGroups' => $commonGroups,
        ]);
    }
}
