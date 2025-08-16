<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

test('login component renders correctly', function () {
    Livewire::test(Login::class)
        ->assertSee('Sign in to your account')
        ->assertSee('Email address')
        ->assertSee('Password')
        ->assertSee('Remember me')
        ->assertSee('Sign in with Email')
        ->assertSee('Forgot your password?')
        ->assertSee('create a new account');
});

test('login component validates required fields', function () {
    Livewire::test(Login::class)
        ->call('login')
        ->assertHasErrors(['email' => 'required', 'password' => 'required']);
});

test('login component validates email format', function () {
    Livewire::test(Login::class)
        ->set('email', 'not-an-email')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email' => 'email']);
});

test('login component authenticates with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('login component authenticates with remember me', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('login component shows error for invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

test('login component shows error for non-existent email', function () {
    Livewire::test(Login::class)
        ->set('email', 'nonexistent@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

test('login component handles validation exceptions correctly', function () {
    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', '')
        ->call('login')
        ->assertHasErrors(['password' => 'required']);
});

test('login component initializes with empty values', function () {
    Livewire::test(Login::class)
        ->assertSet('email', '')
        ->assertSet('password', '')
        ->assertSet('remember', false);
});

test('regular login still works when quick login is available', function () {
    // Set to local environment to show quick login
    config(['app.env' => 'local']);

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('login component can update email field', function () {
    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->assertSet('email', 'test@example.com');
});

test('login component can update password field', function () {
    Livewire::test(Login::class)
        ->set('password', 'password123')
        ->assertSet('password', 'password123');
});

test('login component can toggle remember me', function () {
    Livewire::test(Login::class)
        ->set('remember', true)
        ->assertSet('remember', true)
        ->set('remember', false)
        ->assertSet('remember', false);
});
