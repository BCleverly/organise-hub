<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user preferences persist across login sessions', function () {
    // Set some preferences
    $this->user->setPreference('theme', 'dark');
    $this->user->setPreference('sidebar_collapsed', 'true');
    $this->user->setPreference('compact_mode', 'true');
    
    // Logout
    \App\Actions\Auth\LogoutUser::run();
    expect(auth()->check())->toBeFalse();
    
    // Login again
    \App\Actions\Auth\LoginUser::run([
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    expect(auth()->check())->toBeTrue();
    
    // Verify preferences are still there
    $this->user->refresh();
    expect($this->user->getPreference('theme'))->toBe('dark');
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');
    expect($this->user->getPreference('compact_mode'))->toBe('true');
});

test('user preferences are applied on dashboard load', function () {
    // Set preferences
    $this->user->setPreference('theme', 'dark');
    $this->user->setPreference('sidebar_collapsed', 'true');
    $this->user->setPreference('compact_mode', 'true');
    
    // Load dashboard
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    
    // Check that preferences are applied
    expect($content)->toContain('class="dark"');
    expect($content)->toContain('sidebar-collapsed');
    expect($content)->toContain('compact-mode');
    
    // Check that user preferences are injected
    expect($content)->toContain('window.userPreferences');
    expect($content)->toContain('"theme":"dark"');
    expect($content)->toContain('"sidebarCollapsed":"true"');
    expect($content)->toContain('"compactMode":"true"');
});

test('user preferences have default values for new users', function () {
    // Check default values
    expect($this->user->getPreference('theme', 'light'))->toBe('light');
    expect($this->user->getPreference('sidebar_collapsed', 'false'))->toBe('false');
    expect($this->user->getPreference('compact_mode', 'false'))->toBe('false');
    expect($this->user->getPreference('notifications_enabled', 'true'))->toBe('true');
    expect($this->user->getPreference('email_notifications', 'true'))->toBe('true');
});

test('user preferences can be updated and persist', function () {
    // Set initial preferences
    $this->user->setPreference('theme', 'light');
    $this->user->setPreference('sidebar_collapsed', 'false');
    
    // Update preferences
    $this->user->setPreference('theme', 'dark');
    $this->user->setPreference('sidebar_collapsed', 'true');
    
    $this->user->refresh();
    
    // Verify updates
    expect($this->user->getPreference('theme'))->toBe('dark');
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');
    
    // Verify they persist across page loads
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    expect($content)->toContain('class="dark"');
    expect($content)->toContain('sidebar-collapsed');
});
