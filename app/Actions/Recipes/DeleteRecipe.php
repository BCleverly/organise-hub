<?php

namespace App\Actions\Recipes;

use App\Models\Recipe;

class DeleteRecipe
{
    public function handle(Recipe $recipe): void
    {
        // Delete the recipe (this will also delete related tags due to cascade)
        $recipe->delete();
    }
}
