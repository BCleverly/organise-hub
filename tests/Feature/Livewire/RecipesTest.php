<?php

use App\Livewire\Recipes;
use App\Models\Recipe;
use App\Models\User;

test('recipes component can be rendered', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertStatus(200);
});

test('recipes shows recipe book title', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('Recipe Book');
});

test('recipes shows categories section', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('Categories')
        ->assertSee('All Categories')
        ->assertSee('Main Course')
        ->assertSee('Appetizer')
        ->assertSee('Dessert');
});

test('recipes requires authentication', function () {
    $response = $this->get('/recipes');
    $response->assertRedirect('/login');
});

test('user can only see their own recipes in my view', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $recipe1 = Recipe::factory()->create(['user_id' => $user1->id]);
    $recipe2 = Recipe::factory()->create(['user_id' => $user2->id]);

    Livewire::actingAs($user1)
        ->test(Recipes::class)
        ->set('viewMode', 'my')
        ->assertSee($recipe1->title)
        ->assertDontSee($recipe2->title);
});

test('user can see public recipes in discover view', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $publicRecipe = Recipe::factory()->public()->create(['user_id' => $user1->id]);
    $privateRecipe = Recipe::factory()->private()->create(['user_id' => $user1->id]);

    Livewire::actingAs($user2)
        ->test(Recipes::class)
        ->set('viewMode', 'discover')
        ->assertSee($publicRecipe->title)
        ->assertDontSee($privateRecipe->title);
});

test('view mode toggle works', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSet('viewMode', 'my')
        ->set('viewMode', 'discover')
        ->assertSet('viewMode', 'discover');
});

test('search functionality works', function () {
    $user = User::factory()->create();

    $recipe1 = Recipe::factory()->create([
        'user_id' => $user->id,
        'title' => 'Chocolate Cake',
    ]);

    $recipe2 = Recipe::factory()->create([
        'user_id' => $user->id,
        'title' => 'Pasta Primavera',
    ]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->set('search', 'chocolate')
        ->assertSee('Chocolate Cake')
        ->assertDontSee('Pasta Primavera');
});

test('category filter works', function () {
    $user = User::factory()->create();

    $mainCourse = Recipe::factory()->create([
        'user_id' => $user->id,
        'category' => 'main_course',
        'title' => 'Pasta',
    ]);

    $dessert = Recipe::factory()->create([
        'user_id' => $user->id,
        'category' => 'dessert',
        'title' => 'Cake',
    ]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->set('categoryFilter', 'main_course')
        ->assertSee('Pasta')
        ->assertDontSee('Cake');
});

test('difficulty filter works', function () {
    $user = User::factory()->create();

    $easyRecipe = Recipe::factory()->easy()->create([
        'user_id' => $user->id,
        'title' => 'Easy Recipe',
    ]);

    $hardRecipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'difficulty' => 'hard',
        'title' => 'Hard Recipe',
    ]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->set('difficultyFilter', 'easy')
        ->assertSee('Easy Recipe')
        ->assertDontSee('Hard Recipe');
});

test('recipes can have tags', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $recipe->attachTag('vegetarian');
    $recipe->attachTag('quick');

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('vegetarian')
        ->assertSee('quick');
});

test('public recipes show user attribution', function () {
    $user1 = User::factory()->create(['name' => 'John Doe']);
    $user2 = User::factory()->create();

    $publicRecipe = Recipe::factory()->public()->create(['user_id' => $user1->id]);

    Livewire::actingAs($user2)
        ->test(Recipes::class)
        ->set('viewMode', 'discover')
        ->assertSee('by John Doe');
});

test('public badge shows for public recipes', function () {
    $user = User::factory()->create();
    $publicRecipe = Recipe::factory()->public()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('Public');
});

test('empty state is shown when no recipes', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('No recipes found');
});

test('empty state for discover view', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->set('viewMode', 'discover')
        ->assertSee('No public recipes found');
});

test('recipe rating display', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->highlyRated()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee($recipe->formatted_rating);
});

test('recipe time display', function () {
    $user = User::factory()->create();

    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'prep_time' => 15,
        'cook_time' => 30,
    ]);

    Livewire::actingAs($user)
        ->test(Recipes::class)
        ->assertSee('45m'); // 15 + 30 = 45 minutes
});

// These tests were removed as they test functionality that doesn't exist in the current Recipes component
// The component uses route-based navigation instead of modal-based forms
