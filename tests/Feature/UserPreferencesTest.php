<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user can access preferences page', function () {
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    $response->assertSee('User Preferences');
});

test('user preferences are saved to database', function () {
    $this->user->setPreference('theme', 'dark');
    $this->user->setPreference('sidebar_collapsed', 'true');
    
    $this->user->refresh();
    
    expect($this->user->getPreference('theme'))->toBe('dark');
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');
});

test('user preferences have default values', function () {
    expect($this->user->getPreference('theme', 'light'))->toBe('light');
    expect($this->user->getPreference('sidebar_collapsed', 'false'))->toBe('false');
    expect($this->user->getPreference('compact_mode', 'false'))->toBe('false');
});

test('user can update existing preferences', function () {
    $this->user->setPreference('theme', 'light');
    $this->user->setPreference('theme', 'dark');
    
    $this->user->refresh();
    
    expect($this->user->getPreference('theme'))->toBe('dark');
});

test('preferences are injected into view', function () {
    $response = $this->get('/preferences');
    $response->assertStatus(200);
    
    $content = $response->getContent();
    
    expect($content)->toContain('window.userPreferences');
    expect($content)->toContain('"theme":"light"');
    expect($content)->toContain('"sidebarCollapsed":"false"');
});

test('user model preference methods work', function () {
    $this->user->setPreference('test_key', 'test_value');
    
    expect($this->user->getPreference('test_key'))->toBe('test_value');
    expect($this->user->hasPreference('test_key'))->toBeTrue();
    
    $this->user->removePreference('test_key');
    
    expect($this->user->hasPreference('test_key'))->toBeFalse();
    expect($this->user->getPreference('test_key'))->toBeNull();
});
