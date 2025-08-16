<?php

use App\Livewire\Auth\ResetPasswordForm;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

test('reset password form component renders correctly', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->assertSee('Reset your password')
        ->assertSee('Email address')
        ->assertSee('New password')
        ->assertSee('Confirm new password')
        ->assertSee('Reset password');
});

test('reset password form component validates required fields', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->call('resetPassword')
        ->assertHasErrors([
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);
});

test('reset password form component validates email format', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'not-an-email')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'email']);
});

test('reset password form component validates password confirmation', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'different-password')
        ->call('resetPassword')
        ->assertHasErrors(['password_confirmation' => 'same']);
});

test('reset password form component validates password minimum length', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'min']);
});

test('reset password form component resets password with valid data', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('reset')
        ->once()
        ->andReturnUsing(function ($credentials, $callback) use ($user) {
            $callback($user, 'newpassword123');

            return Password::PASSWORD_RESET;
        });

    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertSet('passwordReset', true)
        ->assertHasNoErrors();
});

test('reset password form component handles password reset failure', function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_TOKEN);

    Livewire::test(ResetPasswordForm::class, ['token' => 'invalid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email']);
});

test('reset password form component handles user not found', function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_USER);

    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'nonexistent@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email']);
});

test('reset password form component initializes with token', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->assertSet('token', 'valid-token')
        ->assertSet('email', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertSet('passwordReset', false);
});

test('reset password form component can update email field', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->assertSet('email', 'test@example.com');
});

test('reset password form component can update password field', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('password', 'newpassword123')
        ->assertSet('password', 'newpassword123');
});

test('reset password form component can update password confirmation field', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('password_confirmation', 'newpassword123')
        ->assertSet('password_confirmation', 'newpassword123');
});

test('reset password form component shows success message after reset', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('reset')
        ->once()
        ->andReturnUsing(function ($credentials, $callback) use ($user) {
            $callback($user, 'newpassword123');

            return Password::PASSWORD_RESET;
        });

    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertSet('passwordReset', true);
});

test('reset password form component handles validation exceptions correctly', function () {
    Livewire::test(ResetPasswordForm::class, ['token' => 'valid-token'])
        ->set('email', 'test@example.com')
        ->set('password', '')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'required']);
});
