<?php

use App\Models\Recipe;
use App\Models\User;

// Guest Routes Tests

test('login page can be accessed by guests', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Sign in to your account');
    $response->assertSee('Email address');
    $response->assertSee('Password');
});

test('register page can be accessed by guests', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Create your account');
    $response->assertSee('Full name');
    $response->assertSee('Email address');
    $response->assertSee('Password');
    $response->assertSee('Confirm password');
});

test('forgot password page can be accessed by guests', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
    $response->assertSee('Reset your password');
    $response->assertSee('Email address');
    $response->assertSee('Send password reset link');
});

test('reset password page can be accessed with valid token', function () {
    $response = $this->get('/reset-password/test-token');

    $response->assertStatus(200);
    $response->assertSee('Reset your password');
    $response->assertSee('Email address');
    $response->assertSee('New password');
    $response->assertSee('Confirm new password');
});

// Authenticated Routes Tests

test('dashboard can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Welcome to OrganizeHub!');
});

test('tasks page can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/tasks');

    $response->assertStatus(200);
    $response->assertSee('Task Manager');
    $response->assertSee('Manage your daily tasks easily');
});

test('recipes page can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/recipes');

    $response->assertStatus(200);
    $response->assertSee('Recipe Book');
    $response->assertSee('Discover and organize your favorite recipes');
});

test('create recipe page can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/recipes/create');

    $response->assertStatus(200);
    $response->assertSee('Create New Recipe');
    $response->assertSee('Add a new recipe to your collection');
});

test('edit recipe page can be accessed by recipe owner', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get("/recipes/{$recipe->id}/edit");

    $response->assertStatus(200);
    $response->assertSee('Edit Recipe');
});

test('recipe detail page can be accessed by authenticated users', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get("/recipes/{$recipe->id}");

    $response->assertStatus(200);
    $response->assertSee($recipe->title);
});

test('root route redirects authenticated users to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect('/dashboard');
});

// Authentication Required Tests

test('dashboard requires authentication', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('tasks requires authentication', function () {
    $response = $this->get('/tasks');

    $response->assertRedirect('/login');
});

test('recipes requires authentication', function () {
    $response = $this->get('/recipes');

    $response->assertRedirect('/login');
});

test('create recipe requires authentication', function () {
    $response = $this->get('/recipes/create');

    $response->assertRedirect('/login');
});

test('edit recipe requires authentication', function () {
    $recipe = Recipe::factory()->create();

    $response = $this->get("/recipes/{$recipe->id}/edit");

    $response->assertRedirect('/login');
});

test('recipe detail requires authentication', function () {
    $recipe = Recipe::factory()->create();

    $response = $this->get("/recipes/{$recipe->id}");

    $response->assertRedirect('/login');
});

test('root route redirects unauthenticated users to login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

// Guest Route Redirects for Authenticated Users

test('login page redirects authenticated users to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/login');

    $response->assertRedirect('/dashboard');
});

test('register page redirects authenticated users to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/register');

    $response->assertRedirect('/dashboard');
});

test('forgot password page redirects authenticated users to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/forgot-password');

    $response->assertRedirect('/dashboard');
});

test('reset password page redirects authenticated users to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/reset-password/test-token');

    $response->assertRedirect('/dashboard');
});
