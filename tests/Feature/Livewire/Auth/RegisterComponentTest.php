<?php

use App\Livewire\Auth\Register;
use App\Models\User;
use Livewire\Livewire;

test('register component renders correctly', function () {
    Livewire::test(Register::class)
        ->assertSee('Create your account')
        ->assertSee('Full name')
        ->assertSee('Email address')
        ->assertSee('Password')
        ->assertSee('Confirm password')
        ->assertSee('Create account')
        ->assertSee('sign in to your existing account');
});

test('register component validates required fields', function () {
    Livewire::test(Register::class)
        ->call('register')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);
});

test('register component validates email format', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'not-an-email')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});

test('register component validates unique email', function () {
    User::factory()->create(['email' => 'test@example.com']);

    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});

test('register component validates password confirmation', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'different-password')
        ->call('register')
        ->assertHasErrors(['password_confirmation' => 'same']);
});

test('register component validates password minimum length', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('register')
        ->assertHasErrors(['password' => 'min']);
});

test('register component creates new user with valid data', function () {
    Livewire::test(Register::class)
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

test('register component validates name maximum length', function () {
    Livewire::test(Register::class)
        ->set('name', str_repeat('a', 256))
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['name' => 'max']);
});

test('register component validates email maximum length', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', str_repeat('a', 250).'@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['email' => 'max']);
});

test('register component handles validation exceptions correctly', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', '')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors(['password' => 'required']);
});

test('register component initializes with empty values', function () {
    Livewire::test(Register::class)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '');
});

test('register component can update name field', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->assertSet('name', 'Test User');
});

test('register component can update email field', function () {
    Livewire::test(Register::class)
        ->set('email', 'test@example.com')
        ->assertSet('email', 'test@example.com');
});

test('register component can update password field', function () {
    Livewire::test(Register::class)
        ->set('password', 'password123')
        ->assertSet('password', 'password123');
});

test('register component can update password confirmation field', function () {
    Livewire::test(Register::class)
        ->set('password_confirmation', 'password123')
        ->assertSet('password_confirmation', 'password123');
});
