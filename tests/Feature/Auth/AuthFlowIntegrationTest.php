<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

test('complete auth flow: register, login, logout', function () {
    // Step 1: Register a new user
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

    // Step 2: Logout
    Livewire::test('auth.logout')
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();

    // Step 3: Login with the same credentials
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('auth flow with remember me functionality', function () {
    // Register user
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    // Logout
    Livewire::test('auth.logout')
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();

    // Login with remember me
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('remember', true)
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('auth flow with password reset', function () {
    // Create user
    $user = User::factory()->create(['email' => 'test@example.com']);

    // Request password reset
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    Livewire::test('auth.forgot-password')
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertSet('emailSent', true);

    // Reset password
    Password::shouldReceive('reset')
        ->once()
        ->andReturnUsing(function ($credentials, $callback) use ($user) {
            $callback($user, 'newpassword123');

            return Password::PASSWORD_RESET;
        });

    Livewire::test('auth.reset-password-form', ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertSet('passwordReset', true);

    // Login with new password
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('auth flow handles invalid credentials gracefully', function () {
    // Try to login with non-existent user
    Livewire::test('auth.login')
        ->set('email', 'nonexistent@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();

    // Register user
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    // Try to login with wrong password
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);

    // The user should still be authenticated from the previous successful login
    // Let's logout first to test the wrong password scenario properly
    Livewire::test('auth.logout')
        ->call('logout');

    $this->assertGuest();

    // Login with correct password
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('auth flow with validation errors', function () {
    // Try to register with invalid data
    Livewire::test('auth.register')
        ->set('name', '')
        ->set('email', 'not-an-email')
        ->set('password', '123')
        ->set('password_confirmation', 'different')
        ->call('register')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'email',
            'password' => 'min',
            'password_confirmation' => 'same',
        ]);

    $this->assertGuest();

    // Register with valid data
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('auth flow with duplicate email registration', function () {
    // Register first user
    Livewire::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    // Logout
    Livewire::test('auth.logout')
        ->call('logout')
        ->assertRedirect('/login');

    $this->assertGuest();

    // Try to register with same email
    Livewire::test('auth.register')
        ->set('name', 'Another User')
        ->set('email', 'test@example.com')
        ->set('password', 'password456')
        ->set('password_confirmation', 'password456')
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);

    $this->assertGuest();

    // Login with original credentials
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});
