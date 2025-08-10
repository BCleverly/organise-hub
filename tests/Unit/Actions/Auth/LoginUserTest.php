<?php

use App\Actions\Auth\LoginUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('login user action authenticates with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => false,
    ];

    $authenticatedUser = LoginUser::run($loginData);

    $this->assertInstanceOf(User::class, $authenticatedUser);
    $this->assertEquals($user->id, $authenticatedUser->id);
    $this->assertAuthenticated();
});

test('login user action fails with invalid credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->expectException(ValidationException::class);

    LoginUser::run([
        'email' => 'test@example.com',
        'password' => 'wrong-password',
        'remember' => false,
    ]);
});

test('login user action validates required fields', function () {
    $this->expectException(ValidationException::class);

    LoginUser::run([]);
});

test('login user action validates email format', function () {
    $this->expectException(ValidationException::class);

    LoginUser::run([
        'email' => 'not-an-email',
        'password' => 'password123',
        'remember' => false,
    ]);
});
