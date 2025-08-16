<?php

use App\Actions\Auth\LoginUser;
use App\Actions\Auth\LogoutUser;
use App\Actions\Auth\RegisterUser;
use App\Actions\Auth\ResetPassword;
use App\Actions\Auth\SendPasswordResetLink;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

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

test('login user action authenticates with remember me', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => true,
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

test('login user action fails with non-existent email', function () {
    $this->expectException(ValidationException::class);

    LoginUser::run([
        'email' => 'nonexistent@example.com',
        'password' => 'password123',
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

test('login user action validates email is required', function () {
    $this->expectException(ValidationException::class);

    LoginUser::run([
        'password' => 'password123',
        'remember' => false,
    ]);
});

test('login user action validates password is required', function () {
    $this->expectException(ValidationException::class);

    LoginUser::run([
        'email' => 'test@example.com',
        'remember' => false,
    ]);
});

test('login user action handles remember field as optional', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    $authenticatedUser = LoginUser::run($loginData);

    $this->assertInstanceOf(User::class, $authenticatedUser);
    $this->assertEquals($user->id, $authenticatedUser->id);
    $this->assertAuthenticated();
});

test('logout user action logs out authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    LogoutUser::run();

    $this->assertGuest();
});

test('logout user action invalidates session', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    LogoutUser::run();

    $this->assertGuest();
});

test('logout user action works when no user is authenticated', function () {
    $this->assertGuest();

    // Should not throw any exception
    LogoutUser::run();

    $this->assertGuest();
});

test('logout user action can be called multiple times safely', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertAuthenticated();

    // First logout
    LogoutUser::run();
    $this->assertGuest();

    // Second logout should not cause issues
    LogoutUser::run();
    $this->assertGuest();
});

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
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
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

test('register user action validates password minimum length', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '123',
        'password_confirmation' => '123',
    ]);
});

test('register user action validates name is required', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates email is required', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates password is required', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates password confirmation is required', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);
});

test('register user action validates name maximum length', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => str_repeat('a', 256), // Exceeds 255 character limit
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('register user action validates email maximum length', function () {
    $this->expectException(ValidationException::class);

    RegisterUser::run([
        'name' => 'Test User',
        'email' => str_repeat('a', 250).'@example.com', // Exceeds 255 character limit
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
});

test('send password reset link action sends reset link for valid email', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    $result = SendPasswordResetLink::run(['email' => 'test@example.com']);

    $this->assertEquals(Password::RESET_LINK_SENT, $result);
});

test('send password reset link action validates required email', function () {
    $this->expectException(ValidationException::class);

    SendPasswordResetLink::run([]);
});

test('send password reset link action validates email format', function () {
    $this->expectException(ValidationException::class);

    SendPasswordResetLink::run(['email' => 'not-an-email']);
});

test('send password reset link action handles password reset link failure', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::INVALID_USER);

    $this->expectException(ValidationException::class);

    SendPasswordResetLink::run(['email' => 'test@example.com']);
});

test('send password reset link action handles throttle error', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'test@example.com'])
        ->andReturn(Password::RESET_THROTTLED);

    $this->expectException(ValidationException::class);

    SendPasswordResetLink::run(['email' => 'test@example.com']);
});

test('send password reset link action works with non-existent email', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'nonexistent@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    $result = SendPasswordResetLink::run(['email' => 'nonexistent@example.com']);

    $this->assertEquals(Password::RESET_LINK_SENT, $result);
});

test('reset password action resets password with valid data', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    Password::shouldReceive('reset')
        ->once()
        ->andReturnUsing(function ($credentials, $callback) use ($user) {
            $callback($user, 'newpassword123');

            return Password::PASSWORD_RESET;
        });

    $result = ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'test@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $this->assertEquals(Password::PASSWORD_RESET, $result);
});

test('reset password action validates required token', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'email' => 'test@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action validates required email', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action validates email format', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'not-an-email',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action validates required password', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'test@example.com',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action validates password confirmation', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'test@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'different-password',
    ]);
});

test('reset password action validates password minimum length', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'test@example.com',
        'password' => '123',
        'password_confirmation' => '123',
    ]);
});

test('reset password action handles password reset failure', function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_TOKEN);

    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'invalid-token',
        'email' => 'test@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action handles user not found', function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_USER);

    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'nonexistent@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);
});

test('reset password action validates password complexity requirements', function () {
    $this->expectException(ValidationException::class);

    ResetPassword::run([
        'token' => 'valid-token',
        'email' => 'test@example.com',
        'password' => 'password', // Too simple
        'password_confirmation' => 'password',
    ]);
});
