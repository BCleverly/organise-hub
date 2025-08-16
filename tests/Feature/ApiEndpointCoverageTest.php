<?php

use App\Models\User;

// API Auth Tests

test('api user endpoint can be accessed by authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->get('/api/user');

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

test('api user endpoint requires authentication', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401);
});

// API v1 Auth Tests

test('api v1 register endpoint can register new users', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/v1/register', $userData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'user' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ],
        'token',
    ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
});

test('api v1 login endpoint can authenticate users', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/v1/login', $loginData);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'user' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ],
        'token',
    ]);
});

test('api v1 logout endpoint can logout authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/logout');

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Logged out successfully']);
});

test('api v1 user endpoint can return authenticated user data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/user');

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

test('api v1 logout endpoint requires authentication', function () {
    $response = $this->postJson('/api/v1/logout');

    $response->assertStatus(401);
});

test('api v1 user endpoint requires authentication', function () {
    $response = $this->getJson('/api/v1/user');

    $response->assertStatus(401);
});

// API Validation Tests

test('api v1 register endpoint validates required fields', function () {
    $response = $this->postJson('/api/v1/register', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});

test('api v1 register endpoint validates email format', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/v1/register', $userData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
});

test('api v1 register endpoint validates password confirmation', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different-password',
    ];

    $response = $this->postJson('/api/v1/register', $userData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['password']);
});

test('api v1 login endpoint validates required fields', function () {
    $response = $this->postJson('/api/v1/login', []);

    $response->assertStatus(401);
    $response->assertJsonValidationErrors(['email', 'password']);
});

test('api v1 login endpoint validates email format', function () {
    $loginData = [
        'email' => 'invalid-email',
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/v1/login', $loginData);

    $response->assertStatus(401);
    $response->assertJsonValidationErrors(['email']);
});

test('api v1 login endpoint fails with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ];

    $response = $this->postJson('/api/v1/login', $loginData);

    $response->assertStatus(401);
    $response->assertJson(['message' => 'Invalid credentials']);
});
