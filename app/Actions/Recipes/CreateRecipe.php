<?php

namespace App\Actions\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateRecipe
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(User $user, array $data): Recipe
    {
        // Validate the data
        Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prep_time' => ['nullable', 'integer', 'min:0'],
            'cook_time' => ['nullable', 'integer', 'min:0'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'category' => ['required', 'string', 'in:main_course,appetizer,dessert,breakfast,snacks'],
            'is_public' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity' => ['nullable', 'string', 'max:50'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:50'],
            'ingredients.*.notes' => ['nullable', 'string', 'max:255'],
            'ingredients.*.group' => ['nullable', 'string', 'max:100'],
            'instructions' => ['nullable', 'array'],
            'instructions.*.instruction' => ['required', 'string'],
            'instructions.*.estimated_time' => ['nullable', 'integer', 'min:0'],
            'instructions.*.step_type' => ['nullable', 'string', 'max:50'],
            'instructions.*.notes' => ['nullable', 'string', 'max:255'],
        ])->validate();

        // Extract related data from data
        $tags = $data['tags'] ?? [];
        $ingredients = $data['ingredients'] ?? [];
        $instructions = $data['instructions'] ?? [];

        unset($data['tags'], $data['ingredients'], $data['instructions']);

        // Create the recipe
        /** @var Recipe $recipe */
        $recipe = $user->recipes()->create($data);

        // Ensure the recipe is saved and has an ID
        if (!$recipe->exists) {
            throw new \Exception('Failed to create recipe');
        }

        // Add tags if provided
        if (! empty($tags)) {
            $recipe->syncTags($tags);
        }

        // Add ingredients if provided
        if (! empty($ingredients)) {
            $recipe->attachIngredients($ingredients);
        }

        // Add instructions if provided
        if (! empty($instructions)) {
            $recipe->attachInstructions($instructions);
        }

        /** @var Recipe $freshRecipe */
        $freshRecipe = $recipe->fresh()->load(['tags', 'ingredients', 'instructions']);

        return $freshRecipe;
    }
}
