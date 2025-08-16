<?php

namespace App\Actions\Recipes;

use App\Models\Recipe;
use Illuminate\Support\Facades\Validator;

class UpdateRecipe
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Recipe $recipe, array $data): Recipe
    {
        // Validate the data
        Validator::make($data, [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prep_time' => ['nullable', 'integer', 'min:0'],
            'cook_time' => ['nullable', 'integer', 'min:0'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['sometimes', 'required', 'string', 'in:easy,medium,hard'],
            'category' => ['sometimes', 'required', 'string', 'in:main_course,appetizer,dessert,breakfast,snacks'],
            'is_public' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity' => ['nullable', 'max:50'],
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
        $tags = $data['tags'] ?? null;
        $ingredients = $data['ingredients'] ?? null;
        $instructions = $data['instructions'] ?? null;

        unset($data['tags'], $data['ingredients'], $data['instructions']);

        // Update the recipe
        $recipe->update($data);

        // Update tags if provided
        if ($tags !== null) {
            $recipe->syncTags($tags);
        }

        // Update ingredients if provided
        if ($ingredients !== null) {
            // Clear existing ingredients and add new ones
            $recipe->ingredients()->detach();
            if (! empty($ingredients)) {
                $recipe->attachIngredients($ingredients);
            }
        }

        // Update instructions if provided
        if ($instructions !== null) {
            // Clear existing instructions and add new ones
            $recipe->instructions()->delete();
            if (! empty($instructions)) {
                $recipe->attachInstructions($instructions);
            }
        }

        return $recipe->load(['tags', 'ingredients', 'instructions']);
    }
}
