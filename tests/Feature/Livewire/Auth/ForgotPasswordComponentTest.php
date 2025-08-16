<?php

use App\Livewire\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

test('forgot password component renders correctly', function () {
    Livewire::test(ForgotPassword::class)
        ->assertSee('Reset your password')
        ->assertSee('Email address')
        ->assertSee('Send password reset link')
        ->assertSee('Back to login');
});

test('forgot password component validates required email', function () {
    Livewire::test(ForgotPassword::class)
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'required']);
});

test('forgot password component validates email format', function () {
    Livewire::test(ForgotPassword::class)
        ->set('email', 'not-an-email')
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'email']);
});

test('forgot password component sends reset link for valid email', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    Livewire::test(ForgotPassword::class)
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertSet('emailSent', true)
        ->assertHasNoErrors();
});

test('forgot password component handles reset link failure', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::INVALID_USER);

    Livewire::test(ForgotPassword::class)
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertHasErrors(['email']);
});

test('forgot password component handles throttle error', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_THROTTLED);

    Livewire::test(ForgotPassword::class)
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertHasErrors(['email']);
});

test('forgot password component works with non-existent email', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'nonexistent@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    Livewire::test(ForgotPassword::class)
        ->set('email', 'nonexistent@example.com')
        ->call('sendResetLink')
        ->assertSet('emailSent', true)
        ->assertHasNoErrors();
});

test('forgot password component initializes with empty values', function () {
    Livewire::test(ForgotPassword::class)
        ->assertSet('email', '')
        ->assertSet('emailSent', false);
});

test('forgot password component can update email field', function () {
    Livewire::test(ForgotPassword::class)
        ->set('email', 'test@example.com')
        ->assertSet('email', 'test@example.com');
});

test('forgot password component shows success message after sending link', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    Livewire::test(ForgotPassword::class)
        ->set('email', 'test@example.com')
        ->call('sendResetLink')
        ->assertSet('emailSent', true);
});

test('forgot password component handles validation exceptions correctly', function () {
    Livewire::test(ForgotPassword::class)
        ->set('email', '')
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'required']);
});
