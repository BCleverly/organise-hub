<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
});

test('reset password page can be rendered', function () {
    $token = Password::createToken($this->user);

    $response = $this->get("/reset-password/{$token}");

    $response->assertStatus(200);
});

test('password can be reset with valid token', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertSet('passwordReset', true);

    $this->user->refresh();
    $this->assertTrue(Hash::check('newpassword123', $this->user->password));
});

test('token is required', function () {
    Livewire::test('auth.reset-password-form', ['token' => ''])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['token' => 'required']);
});

test('email is required', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'required']);
});

test('email must be valid email format', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'not-an-email')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'email']);
});

test('password is required', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'required']);
});

test('password must be at least 8 characters', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'min']);
});

test('password confirmation is required', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['password_confirmation' => 'required']);
});

test('password confirmation must match password', function () {
    $token = Password::createToken($this->user);

    Livewire::test('auth.reset-password-form', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'different-password')
        ->call('resetPassword')
        ->assertHasErrors(['password_confirmation' => 'same']);
});
