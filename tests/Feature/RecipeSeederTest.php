<?php

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeInstruction;
use App\Models\User;
use Database\Seeders\RecipeSeeder;

test('recipe seeder creates users and recipes', function () {
    // Run the seeder
    $this->seed(RecipeSeeder::class);

    // Check that users were created
    expect(User::count())->toBe(4);

    // Check that recipes were created
    expect(Recipe::count())->toBeGreaterThan(0);

    // Check specific users exist
    expect(User::where('name', 'Chef Sarah')->exists())->toBeTrue();
    expect(User::where('name', 'Chef Michael')->exists())->toBeTrue();

    // Check that recipes have the correct relationships
    $sarah = User::where('email', 'sarah@example.com')->first();
    expect($sarah->recipes()->count())->toBeGreaterThan(0);

    $michael = User::where('email', 'michael@example.com')->first();
    expect($michael->recipes()->count())->toBeGreaterThan(0);

    // Check that ingredients were created
    expect(Ingredient::count())->toBeGreaterThan(0);

    // Check that recipes have ingredients
    $recipeWithIngredients = Recipe::has('ingredients')->count();
    expect($recipeWithIngredients)->toBeGreaterThan(0);

    // Check that recipes have instructions
    $recipeWithInstructions = Recipe::has('instructions')->count();
    expect($recipeWithInstructions)->toBeGreaterThan(0);

    // Check that some recipes are public
    $publicRecipes = Recipe::where('is_public', true)->count();
    expect($publicRecipes)->toBeGreaterThan(0);

    // Check that recipes have tags
    $recipesWithTags = Recipe::has('tags')->count();
    expect($recipesWithTags)->toBeGreaterThan(0);
});

test('recipe categories are distributed', function () {
    $this->seed(RecipeSeeder::class);

    $categories = Recipe::selectRaw('category, count(*) as count')
        ->groupBy('category')
        ->pluck('count', 'category')
        ->toArray();

    // Check that we have recipes in multiple categories
    expect(count($categories))->toBeGreaterThan(1);

    // Check that we have recipes in expected categories
    $expectedCategories = ['main_course', 'dessert', 'breakfast', 'appetizer', 'snacks'];
    foreach ($expectedCategories as $category) {
        if (isset($categories[$category])) {
            expect($categories[$category])->toBeGreaterThan(0);
        }
    }
});

test('recipe difficulties are distributed', function () {
    $this->seed(RecipeSeeder::class);

    $difficulties = Recipe::selectRaw('difficulty, count(*) as count')
        ->groupBy('difficulty')
        ->pluck('count', 'difficulty')
        ->toArray();

    // Check that we have recipes of different difficulties
    expect(count($difficulties))->toBeGreaterThan(1);

    // Check that we have recipes in expected difficulties
    $expectedDifficulties = ['easy', 'medium', 'hard'];
    foreach ($expectedDifficulties as $difficulty) {
        if (isset($difficulties[$difficulty])) {
            expect($difficulties[$difficulty])->toBeGreaterThan(0);
        }
    }
});

test('users can access their recipes', function () {
    $this->seed(RecipeSeeder::class);

    $sarah = User::where('email', 'sarah@example.com')->first();
    $michael = User::where('email', 'michael@example.com')->first();

    // Check that users can see their own recipes
    $sarahRecipes = Recipe::where('user_id', $sarah->id)->get();
    $michaelRecipes = Recipe::where('user_id', $michael->id)->get();

    expect($sarahRecipes->count())->toBeGreaterThan(0);
    expect($michaelRecipes->count())->toBeGreaterThan(0);

    // Check that recipes have proper data
    $firstRecipe = $sarahRecipes->first();
    expect($firstRecipe->title)->not->toBeEmpty();

    // Check that recipe has ingredients
    expect($firstRecipe->ingredients()->count())->toBeGreaterThan(0);

    // Check that recipe has instructions
    expect($firstRecipe->instructions()->count())->toBeGreaterThan(0);
});

test('recipe tags are properly attached', function () {
    $this->seed(RecipeSeeder::class);

    // Check that recipes have tags
    $recipesWithTags = Recipe::has('tags')->count();
    expect($recipesWithTags)->toBeGreaterThan(0);

    // Check specific recipe tags
    $chocolateChipCookies = Recipe::where('title', 'Classic Chocolate Chip Cookies')->first();
    expect($chocolateChipCookies)->not->toBeNull();
    expect($chocolateChipCookies->hasTag('chocolate'))->toBeTrue();
    expect($chocolateChipCookies->hasTag('cookies'))->toBeTrue();

    $blueberryPancakes = Recipe::where('title', 'Blueberry Pancakes')->first();
    expect($blueberryPancakes)->not->toBeNull();
    expect($blueberryPancakes->hasTag('breakfast'))->toBeTrue();
    expect($blueberryPancakes->hasTag('pancakes'))->toBeTrue();
});

test('recipe time calculations work', function () {
    $this->seed(RecipeSeeder::class);

    $recipe = Recipe::first();
    expect($recipe)->not->toBeNull();

    // Test total time calculation
    if ($recipe->prep_time && $recipe->cook_time) {
        $expectedTotal = $recipe->prep_time + $recipe->cook_time;
        expect($expectedTotal)->toBe($recipe->total_time);
    }

    // Test formatted time
    if ($recipe->total_time) {
        expect($recipe->formatted_total_time)->not->toBeEmpty();
    }
});

test('recipe scopes work correctly', function () {
    $this->seed(RecipeSeeder::class);

    // Test public scope
    $publicRecipes = Recipe::public()->get();
    expect($publicRecipes->count())->toBeGreaterThan(0);
    expect($publicRecipes->every(fn ($recipe) => $recipe->is_public))->toBeTrue();

    // Test category scope
    $dessertRecipes = Recipe::withCategory('dessert')->get();
    expect($dessertRecipes->count())->toBeGreaterThan(0);
    expect($dessertRecipes->every(fn ($recipe) => $recipe->category === 'dessert'))->toBeTrue();

    // Test difficulty scope
    $easyRecipes = Recipe::withDifficulty('easy')->get();
    expect($easyRecipes->count())->toBeGreaterThan(0);
    expect($easyRecipes->every(fn ($recipe) => $recipe->difficulty === 'easy'))->toBeTrue();
});

test('recipe factory creates valid recipes', function () {
    $user = User::factory()->create();

    // Test basic factory
    $recipe = Recipe::factory()->for($user)->create();
    expect($recipe)->not->toBeNull();
    expect($recipe->user_id)->toBe($user->id);
    expect($recipe->title)->not->toBeEmpty();

    // Test public factory state
    $publicRecipe = Recipe::factory()->public()->for($user)->create();
    expect($publicRecipe->is_public)->toBeTrue();

    // Test private factory state
    $privateRecipe = Recipe::factory()->private()->for($user)->create();
    expect($privateRecipe->is_public)->toBeFalse();

    // Test easy factory state
    $easyRecipe = Recipe::factory()->easy()->for($user)->create();
    expect($easyRecipe->difficulty)->toBe('easy');
    expect($easyRecipe->prep_time)->toBeLessThanOrEqual(20);
    expect($easyRecipe->cook_time)->toBeLessThanOrEqual(45);

    // Test highly rated factory state
    $ratedRecipe = Recipe::factory()->highlyRated()->for($user)->create();
    expect($ratedRecipe->rating)->toBeGreaterThanOrEqual(4.0);
    expect($ratedRecipe->rating)->toBeLessThanOrEqual(5.0);
    expect($ratedRecipe->review_count)->toBeGreaterThanOrEqual(10);
});

test('seeder can be run multiple times', function () {
    // Run seeder twice to ensure it handles duplicates properly
    $this->seed(RecipeSeeder::class);
    $firstRunCount = Recipe::count();

    $this->seed(RecipeSeeder::class);
    $secondRunCount = Recipe::count();

    // Should have the same number of recipes after second run
    expect($firstRunCount)->toBe($secondRunCount);

    // Should still have the same users
    expect(User::count())->toBe(4);
});

test('ingredient system works correctly', function () {
    $this->seed(RecipeSeeder::class);

    // Check that ingredients were created
    expect(Ingredient::count())->toBeGreaterThan(0);

    // Check that recipes have ingredients
    $recipeWithIngredients = Recipe::has('ingredients')->count();
    expect($recipeWithIngredients)->toBeGreaterThan(0);

    // Check specific recipe ingredients
    $chocolateChipCookies = Recipe::where('title', 'Classic Chocolate Chip Cookies')->first();
    expect($chocolateChipCookies)->not->toBeNull();

    $flourIngredient = $chocolateChipCookies->ingredients()->where('name', 'all-purpose flour')->first();
    expect($flourIngredient)->not->toBeNull();
    expect($flourIngredient->pivot->quantity)->toBe(2.25);
    expect($flourIngredient->pivot->unit)->toBe('cups');

    // Check ingredient categories
    $dairyIngredients = Ingredient::inCategory('dairy')->count();
    expect($dairyIngredients)->toBeGreaterThan(0);

    $pantryIngredients = Ingredient::inCategory('pantry')->count();
    expect($pantryIngredients)->toBeGreaterThan(0);

    // Check ingredient reuse (same ingredient in multiple recipes)
    $flourIngredient = Ingredient::where('name', 'all-purpose flour')->first();
    expect($flourIngredient)->not->toBeNull();
    expect($flourIngredient->recipes()->count())->toBeGreaterThan(1);
});

test('ingredient pivot data is correct', function () {
    $this->seed(RecipeSeeder::class);

    $recipe = Recipe::with('ingredients')->first();
    expect($recipe)->not->toBeNull();

    foreach ($recipe->ingredients as $ingredient) {
        // Check that pivot data exists
        expect($ingredient->pivot)->not->toBeNull();
        expect($ingredient->pivot->order)->not->toBeNull();

        // Check that ingredient has proper data
        expect($ingredient->name)->not->toBeEmpty();
        expect($ingredient->category)->not->toBeNull();
    }
});

test('ingredient factory creates valid ingredients', function () {
    // Test basic factory
    $ingredient = Ingredient::factory()->create();
    expect($ingredient)->not->toBeNull();
    expect($ingredient->name)->not->toBeEmpty();
    expect($ingredient->category)->not->toBeNull();

    // Test allergen factory state
    $allergen = Ingredient::factory()->allergen()->create();
    expect($allergen->is_allergen)->toBeTrue();

    // Test non-allergen factory state
    $nonAllergen = Ingredient::factory()->nonAllergen()->create();
    expect($nonAllergen->is_allergen)->toBeFalse();

    // Test category factory states
    $dairy = Ingredient::factory()->dairy()->create();
    expect($dairy->category)->toBe('dairy');

    $produce = Ingredient::factory()->produce()->create();
    expect($produce->category)->toBe('produce');
});

test('instruction system works correctly', function () {
    $this->seed(RecipeSeeder::class);

    // Check that instructions were created
    expect(RecipeInstruction::count())->toBeGreaterThan(0);

    // Check that recipes have instructions
    $recipeWithInstructions = Recipe::has('instructions')->count();
    expect($recipeWithInstructions)->toBeGreaterThan(0);

    // Check specific recipe instructions
    $chocolateChipCookies = Recipe::where('title', 'Classic Chocolate Chip Cookies')->first();
    expect($chocolateChipCookies)->not->toBeNull();

    $firstInstruction = $chocolateChipCookies->instructions()->first();
    expect($firstInstruction)->not->toBeNull();
    expect($firstInstruction->step_number)->toBe(1);
    expect($firstInstruction->instruction)->not->toBeEmpty();
    expect($firstInstruction->step_type)->not->toBeNull();

    // Check instruction step types
    $prepInstructions = RecipeInstruction::ofType('prep')->count();
    expect($prepInstructions)->toBeGreaterThan(0);

    $cookInstructions = RecipeInstruction::ofType('cook')->count();
    expect($cookInstructions)->toBeGreaterThan(0);

    $bakeInstructions = RecipeInstruction::ofType('bake')->count();
    expect($bakeInstructions)->toBeGreaterThan(0);
});

test('instruction pivot data is correct', function () {
    $this->seed(RecipeSeeder::class);

    $recipe = Recipe::with('instructions')->first();
    expect($recipe)->not->toBeNull();

    foreach ($recipe->instructions as $instruction) {
        // Check that instruction data exists
        expect($instruction->step_number)->not->toBeNull();
        expect($instruction->instruction)->not->toBeEmpty();
        expect($instruction->step_type)->not->toBeNull();

        // Check that step numbers are sequential
        expect($instruction->step_number)->toBeGreaterThan(0);
    }

    // Check that instructions are ordered correctly
    $stepNumbers = $recipe->instructions->pluck('step_number')->toArray();
    expect($stepNumbers)->toBe(range(1, count($stepNumbers)));
});

test('instruction factory creates valid instructions', function () {
    $recipe = Recipe::factory()->create();

    // Test basic factory with explicit step number
    $instruction = RecipeInstruction::factory()->for($recipe)->create([
        'step_number' => 1
    ]);
    expect($instruction)->not->toBeNull();
    expect($instruction->recipe_id)->toBe($recipe->id);
    expect($instruction->instruction)->not->toBeEmpty();
    expect($instruction->step_type)->not->toBeNull();

    // Test prep factory state with unique step number
    $prepInstruction = RecipeInstruction::factory()->prep()->for($recipe)->create([
        'step_number' => 2
    ]);
    expect($prepInstruction->step_type)->toBe('prep');
    expect($prepInstruction->estimated_time)->toBeLessThanOrEqual(30);

    // Test cook factory state with unique step number
    $cookInstruction = RecipeInstruction::factory()->cook()->for($recipe)->create([
        'step_number' => 3
    ]);
    expect($cookInstruction->step_type)->toBe('cook');
    expect($cookInstruction->estimated_time)->toBeGreaterThanOrEqual(5);
    expect($cookInstruction->estimated_time)->toBeLessThanOrEqual(45);
});
