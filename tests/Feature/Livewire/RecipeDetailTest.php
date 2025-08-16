<?php

use App\Livewire\Recipes\RecipeDetail;
use App\Models\Recipe;
use App\Models\User;

test('recipe detail component can be rendered', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('recipe detail requires authentication', function () {
    $recipe = Recipe::factory()->create();

    // Authentication is handled at the route level
    $response = $this->get("/recipes/{$recipe->id}");
    $response->assertRedirect('/login');
});

test('shows recipe basic information', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Recipe',
        'description' => 'A delicious test recipe',
        'prep_time' => 15,
        'cook_time' => 30,
        'servings' => 4,
        'difficulty' => 'medium',
        'category' => 'main_course',
        'rating' => null, // Ensure no rating
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Test Recipe')
        ->assertSee('A delicious test recipe')
        ->assertSee('45m') // 15 + 30
        ->assertSee('4 servings')
        ->assertSee('Medium')
        ->assertSee('Main Course');
});

test('shows recipe ingredients', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $ingredient = \App\Models\Ingredient::factory()->create(['name' => 'Flour']);
    $recipe->ingredients()->attach($ingredient->id, [
        'quantity' => '2',
        'unit' => 'cups',
        'notes' => 'All-purpose',
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Flour')
        ->assertSee('2 cups')
        ->assertSee('All-purpose');
});

test('shows recipe instructions', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $instruction = \App\Models\RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'instruction' => 'Mix ingredients thoroughly',
        'estimated_time' => 5,
        'step_type' => 'prep',
        'notes' => 'Use a whisk for best results',
        'step_number' => 1,
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Mix ingredients thoroughly')
        ->assertSee('5m')
        ->assertSee('Prep')
        ->assertSee('Use a whisk for best results');
});

test('shows recipe tags', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $recipe->attachTag('vegetarian');
    $recipe->attachTag('quick');

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('vegetarian')
        ->assertSee('quick');
});

test('shows public badge for public recipes', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->public()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Public');
});

test('shows private badge for private recipes', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->private()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Private');
});

test('shows edit button for recipe owner', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('Edit')
        ->assertSee('Delete');
});

test('does not show edit button for non owner', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $recipe = Recipe::factory()->public()->create(['user_id' => $user1->id]);

    $component = Livewire::actingAs($user2)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);

    // Check if showDeleteConfirmation is false
    expect($component->get('showDeleteConfirmation'))->toBeFalse();

    // Check that the Edit and Delete buttons are not visible in the header
    $component->assertDontSee('Edit')
        ->assertDontSee('Delete Recipe');
});

test('computed properties work correctly', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'prep_time' => 15,
        'cook_time' => 30,
    ]);

    $component = Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);

    expect($component->get('totalTime'))->toBe(45);
});

test('is owner computed property', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user1->id]);

    // Test for owner
    $component1 = Livewire::actingAs($user1)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);
    expect($component1->get('isOwner'))->toBeTrue();

    // Test for non-owner
    $component2 = Livewire::actingAs($user2)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);
    expect($component2->get('isOwner'))->toBeFalse();
});

test('can edit computed property', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $component = Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);

    expect($component->get('canEdit'))->toBeTrue();
});

test('can delete computed property', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $component = Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);

    expect($component->get('canDelete'))->toBeTrue();
});

test('delete recipe requires authorization', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user1->id]);

    Livewire::actingAs($user2)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->call('deleteRecipe')
        ->assertForbidden();
});

test('can delete own recipe', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->call('deleteRecipe')
        ->assertRedirect(route('recipes'));
});

test('shows recipe author', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('by John Doe');
});

test('shows recipe rating', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->highlyRated()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee($recipe->formatted_rating);
});

test('shows no rating for unrated recipes', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'rating' => null, // Ensure no rating
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee('No ratings');
});

test('handles recipes without description', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'description' => null,
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('handles recipes without times', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'prep_time' => null,
        'cook_time' => null,
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('handles recipes without servings', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'servings' => null,
    ]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('handles recipes without ingredients', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('handles recipes without instructions', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('handles recipes without tags', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertStatus(200)
        ->assertSee($recipe->title);
});

test('user id is locked and cannot be tampered', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $component = Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe]);

    expect($component->get('userId'))->toBe($user->id);

    // Attempting to set a locked property should throw an exception
    expect(fn () => $component->set('userId', 999))->toThrow(\Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException::class);
});

test('recipe model is properly bound', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSet('recipe.id', $recipe->id)
        ->assertSet('recipe.title', $recipe->title);
});

test('shows recipe creation date', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee($recipe->created_at->format('M j, Y'));
});

test('shows recipe update date if different from creation', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    // Update the recipe
    $recipe->update(['title' => 'Updated Title']);

    Livewire::actingAs($user)
        ->test(RecipeDetail::class, ['recipe' => $recipe])
        ->assertSee($recipe->updated_at->format('M j, Y'));
});

test('handles public recipes for guests', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->public()->create(['user_id' => $user->id]);

    // Test as guest (no authentication) - should redirect to login
    $response = $this->get("/recipes/{$recipe->id}");
    $response->assertRedirect('/login');
});

test('handles private recipes for guests', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->private()->create(['user_id' => $user->id]);

    // Test as guest (no authentication) - should redirect to login
    $response = $this->get("/recipes/{$recipe->id}");
    $response->assertRedirect('/login');
});
