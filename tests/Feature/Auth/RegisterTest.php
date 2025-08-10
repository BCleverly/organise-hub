<?php

use App\Models\User;
use Livewire\Livewire;

test('registration page can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
});

test('name is required', function () {
    Livewire::test('auth.register')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['name' => 'required']);
});

test('email is required', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'required']);
});

test('email must be valid email format', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'not-an-email')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});

test('email must be unique', function () {
    User::factory()->create(['email' => 'test@example.com']);

    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});

test('password is required', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['password' => 'required']);
});

test('password must be at least 8 characters', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('register')
        ->assertHasErrors(['password' => 'min']);
});

test('password confirmation is required', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('register')
        ->assertHasErrors(['password_confirmation' => 'required']);
});

test('password confirmation must match password', function () {
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'different-password')
        ->call('register')
        ->assertHasErrors(['password_confirmation' => 'same']);
});

test('authenticated users are redirected to dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/register');

    $response->assertRedirect('/dashboard');
});
