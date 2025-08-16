<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientGroupingTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipe_can_have_grouped_ingredients(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        // Create ingredients with different groups
        $flour = Ingredient::factory()->create(['name' => 'All-purpose flour']);
        $sugar = Ingredient::factory()->create(['name' => 'Granulated sugar']);
        $eggs = Ingredient::factory()->create(['name' => 'Large eggs']);
        $vanilla = Ingredient::factory()->create(['name' => 'Vanilla extract']);
        $chocolate = Ingredient::factory()->create(['name' => 'Chocolate chips']);

        // Attach ingredients with groups
        $recipe->ingredients()->attach($flour->id, [
            'quantity' => '2',
            'unit' => 'cups',
            'group' => 'Main Ingredients',
            'group_order' => 0,
            'order' => 0,
        ]);

        $recipe->ingredients()->attach($sugar->id, [
            'quantity' => '1',
            'unit' => 'cup',
            'group' => 'Main Ingredients',
            'group_order' => 1,
            'order' => 1,
        ]);

        $recipe->ingredients()->attach($eggs->id, [
            'quantity' => '2',
            'unit' => 'large',
            'group' => 'Main Ingredients',
            'group_order' => 2,
            'order' => 2,
        ]);

        $recipe->ingredients()->attach($vanilla->id, [
            'quantity' => '1',
            'unit' => 'teaspoon',
            'group' => 'Flavoring',
            'group_order' => 0,
            'order' => 3,
        ]);

        $recipe->ingredients()->attach($chocolate->id, [
            'quantity' => '2',
            'unit' => 'cups',
            'group' => 'Add-ins',
            'group_order' => 0,
            'order' => 4,
        ]);

        // Test grouped ingredients
        $groupedIngredients = $recipe->grouped_ingredients;

        expect($groupedIngredients)->toHaveCount(3);
        expect($groupedIngredients->keys())->toContain('Main Ingredients', 'Flavoring', 'Add-ins');

        // Test Main Ingredients group
        $mainIngredients = $groupedIngredients->get('Main Ingredients');
        expect($mainIngredients['ingredients'])->toHaveCount(3);
        expect($mainIngredients['ingredients'][0]->name)->toBe('All-purpose flour');
        expect($mainIngredients['ingredients'][1]->name)->toBe('Granulated sugar');
        expect($mainIngredients['ingredients'][2]->name)->toBe('Large eggs');

        // Test Flavoring group
        $flavoring = $groupedIngredients->get('Flavoring');
        expect($flavoring['ingredients'])->toHaveCount(1);
        expect($flavoring['ingredients'][0]->name)->toBe('Vanilla extract');

        // Test Add-ins group
        $addIns = $groupedIngredients->get('Add-ins');
        expect($addIns['ingredients'])->toHaveCount(1);
        expect($addIns['ingredients'][0]->name)->toBe('Chocolate chips');
    }

    public function test_ingredients_without_group_default_to_main_ingredients(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $flour = Ingredient::factory()->create(['name' => 'All-purpose flour']);
        $sugar = Ingredient::factory()->create(['name' => 'Granulated sugar']);

        // Attach ingredients without group
        $recipe->ingredients()->attach($flour->id, [
            'quantity' => '2',
            'unit' => 'cups',
            'group' => null,
            'group_order' => 0,
            'order' => 0,
        ]);

        $recipe->ingredients()->attach($sugar->id, [
            'quantity' => '1',
            'unit' => 'cup',
            'group' => null,
            'group_order' => 1,
            'order' => 1,
        ]);

        $groupedIngredients = $recipe->grouped_ingredients;

        expect($groupedIngredients)->toHaveCount(1);
        expect($groupedIngredients->keys())->toContain('Main Ingredients');

        $mainIngredients = $groupedIngredients->get('Main Ingredients');
        expect($mainIngredients['ingredients'])->toHaveCount(2);
        expect($mainIngredients['ingredients'][0]->name)->toBe('All-purpose flour');
        expect($mainIngredients['ingredients'][1]->name)->toBe('Granulated sugar');
    }

    public function test_ingredients_are_ordered_within_groups(): void
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $ingredient1 = Ingredient::factory()->create(['name' => 'First ingredient']);
        $ingredient2 = Ingredient::factory()->create(['name' => 'Second ingredient']);
        $ingredient3 = Ingredient::factory()->create(['name' => 'Third ingredient']);

        // Attach ingredients with different group orders
        $recipe->ingredients()->attach($ingredient2->id, [
            'quantity' => '1',
            'unit' => 'cup',
            'group' => 'Test Group',
            'group_order' => 1,
            'order' => 1,
        ]);

        $recipe->ingredients()->attach($ingredient1->id, [
            'quantity' => '1',
            'unit' => 'cup',
            'group' => 'Test Group',
            'group_order' => 0,
            'order' => 0,
        ]);

        $recipe->ingredients()->attach($ingredient3->id, [
            'quantity' => '1',
            'unit' => 'cup',
            'group' => 'Test Group',
            'group_order' => 2,
            'order' => 2,
        ]);

        $groupedIngredients = $recipe->grouped_ingredients;
        $testGroup = $groupedIngredients->get('Test Group');

        expect($testGroup['ingredients'])->toHaveCount(3);
        expect($testGroup['ingredients'][0]->name)->toBe('First ingredient');
        expect($testGroup['ingredients'][1]->name)->toBe('Second ingredient');
        expect($testGroup['ingredients'][2]->name)->toBe('Third ingredient');
    }
}
