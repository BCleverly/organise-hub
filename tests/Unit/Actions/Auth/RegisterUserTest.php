<?php

use App\Actions\Auth\RegisterUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('register user action creates a new user', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $user = RegisterUser::run($userData);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals('Test User', $user->name);
    $this->assertEquals('test@example.com', $user->email);
    $this->assertTrue(Hash::check('password123', $user->password));
});

test('register user action validates required fields', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([]);
});

test('register user action validates email format', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'not-an-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates unique email', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates password confirmation', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different-password',
    ]);
});
