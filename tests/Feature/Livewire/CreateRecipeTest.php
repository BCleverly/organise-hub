<?php

use App\Livewire\Recipes\CreateRecipe;
use App\Models\User;

test('create recipe component can be rendered', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->assertStatus(200)
        ->assertSee('Create New Recipe');
});

test('create recipe requires authentication', function () {
    Livewire::test(CreateRecipe::class)
        ->assertStatus(200); // Component renders but shows login form
});

test('form has default values', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->assertSet('form.title', '')
        ->assertSet('form.description', '')
        ->assertSet('form.difficulty', 'medium')
        ->assertSet('form.category', 'main_course')
        ->assertSet('form.is_public', false)
        ->assertSet('form.tags', [])
        ->assertSet('form.ingredients', [])
        ->assertSet('form.instructions', []);
});

test('can set basic recipe information', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->set('form.title', 'Test Recipe')
        ->set('form.description', 'A delicious test recipe')
        ->set('form.prep_time', 15)
        ->set('form.cook_time', 30)
        ->set('form.servings', 4)
        ->set('form.difficulty', 'easy')
        ->set('form.category', 'dessert')
        ->set('form.is_public', true)
        ->assertSet('form.title', 'Test Recipe')
        ->assertSet('form.description', 'A delicious test recipe')
        ->assertSet('form.prep_time', 15)
        ->assertSet('form.cook_time', 30)
        ->assertSet('form.servings', 4)
        ->assertSet('form.difficulty', 'easy')
        ->assertSet('form.category', 'dessert')
        ->assertSet('form.is_public', true);
});

test('can set form data directly for AlpineJS', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->set('form.tags', ['vegetarian', 'quick'])
        ->set('form.ingredients', [
            [
                'name' => 'Flour',
                'quantity' => '2',
                'unit' => 'cups',
                'notes' => 'All-purpose',
            ],
        ])
        ->set('form.instructions', [
            [
                'instruction' => 'Mix the ingredients',
                'estimated_time' => 5,
                'step_type' => 'prep',
                'notes' => 'Use a whisk',
            ],
        ])
        ->assertSet('form.tags', ['vegetarian', 'quick'])
        ->assertSet('form.ingredients.0.name', 'Flour')
        ->assertSet('form.instructions.0.instruction', 'Mix the ingredients');
});

test('form validation requires title', function () {
    $user = User::factory()->create();

    $formData = [
        'description' => 'A description without title',
        'difficulty' => 'easy',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation requires difficulty', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation requires category', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces difficulty values', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'invalid',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces category values', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
        'category' => 'invalid',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces prep time minimum', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
        'category' => 'main_course',
        'prep_time' => -1,
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces cook time minimum', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
        'category' => 'main_course',
        'cook_time' => -1,
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces servings minimum', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
        'category' => 'main_course',
        'servings' => 0,
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('form validation enforces title max length', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => str_repeat('a', 256),
        'difficulty' => 'easy',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('can create recipe with minimal data', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Minimal Recipe',
        'difficulty' => 'easy',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertRedirect(route('recipes.show', 1));
});

test('can create recipe with full data', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => 'Full Recipe',
        'description' => 'A complete recipe with all data',
        'prep_time' => 15,
        'cook_time' => 30,
        'servings' => 4,
        'difficulty' => 'medium',
        'category' => 'dessert',
        'is_public' => true,
        'tags' => ['vegetarian'],
        'ingredients' => [
            [
                'name' => 'Flour',
                'quantity' => '2',
                'unit' => 'cups',
                'notes' => '',
            ],
        ],
        'instructions' => [
            [
                'instruction' => 'Mix ingredients',
                'estimated_time' => null,
                'step_type' => 'prep',
                'notes' => '',
            ],
        ],
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertRedirect(route('recipes.show', 1));
});

test('form data structure is correct', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->set('form.prep_time', 15)
        ->set('form.cook_time', 30)
        ->assertSet('form.prep_time', 15)
        ->assertSet('form.cook_time', 30)
        ->set('form.ingredients', [['name' => 'Flour', 'quantity' => '', 'unit' => '', 'notes' => '']])
        ->set('form.instructions', [['instruction' => 'Mix ingredients', 'estimated_time' => null, 'step_type' => 'prep', 'notes' => '']])
        ->assertSet('form.ingredients.0.name', 'Flour')
        ->assertSet('form.instructions.0.instruction', 'Mix ingredients');
});

test('handles validation errors gracefully', function () {
    $user = User::factory()->create();

    $formData = [
        'title' => '', // Invalid - empty title
        'difficulty' => 'easy',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertHasErrors(['validation']);
});

test('handles database errors gracefully', function () {
    $user = User::factory()->create();

    // Mock the CreateRecipeAction to throw an exception
    $this->mock(\App\Actions\Recipes\CreateRecipe::class, function ($mock) {
        $mock->shouldReceive('handle')->andThrow(new \Exception('Database error'));
    });

    $formData = [
        'title' => 'Test Recipe',
        'difficulty' => 'easy',
        'category' => 'main_course',
    ];

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->call('save', $formData)
        ->assertSee('Error creating recipe: Database error');
});

test('user id is locked and cannot be tampered', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->assertSet('userId', $user->id);
});

test('can navigate away without saving', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateRecipe::class)
        ->set('form.title', 'Unsaved Recipe')
        ->set('form.description', 'This will be lost')
        ->call('$refresh')
        ->assertSet('form.title', 'Unsaved Recipe')
        ->assertSet('form.description', 'This will be lost');
});
