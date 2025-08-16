<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('sidebar toggle from preferences page saves to database', function () {
    // Test toggling sidebar collapsed from preferences page
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->set('sidebarCollapsed', 'true')
        ->assertSet('sidebarCollapsed', 'true');

    // Verify the preference is saved to database
    $this->user->refresh();
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');

    // Test toggling back to expanded
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->set('sidebarCollapsed', 'false')
        ->assertSet('sidebarCollapsed', 'false');

    // Verify the preference is updated
    $this->user->refresh();
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('false');
});

test('sidebar toggle event handler saves preference', function () {
    // Test that the sidebar toggle event handler saves the preference
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->call('handleSidebarToggle', true)
        ->assertSet('sidebarCollapsed', 'true');

    // Verify the preference is saved to database
    $this->user->refresh();
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');

    // Test toggling back
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->call('handleSidebarToggle', false)
        ->assertSet('sidebarCollapsed', 'false');

    // Verify the preference is updated
    $this->user->refresh();
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('false');
});

test('sidebar preference persists across page navigation', function () {
    // Set sidebar preference directly in database
    $this->user->setPreference('sidebar_collapsed', 'true');
    
    // Verify the preference is saved in database
    $this->user->refresh();
    expect($this->user->getPreference('sidebar_collapsed'))->toBe('true');

    // Navigate to dashboard and verify preference is applied
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    
    // Check that the sidebar-collapsed class is applied
    expect($content)->toContain('sidebar-collapsed');
    
    // Check that user preferences are injected with correct value
    expect($content)->toContain('"sidebarCollapsed":"true"');
});

test('sidebar preference is loaded on page refresh', function () {
    // Set sidebar preference in database
    $this->user->setPreference('sidebar_collapsed', 'true');
    
    // Load the dashboard and verify preference is loaded
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    
    // Check that the sidebar-collapsed class is applied
    expect($content)->toContain('sidebar-collapsed');
    
    // Check that user preferences are injected with correct value
    expect($content)->toContain('"sidebarCollapsed":"true"');
});

test('sidebar toggle dispatches livewire event', function () {
    // Test that toggling sidebar dispatches the correct event
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->set('sidebarCollapsed', 'true')
        ->assertDispatched('sidebar-toggled', collapsed: true);

    // Test toggling back
    Livewire::test(\App\Livewire\UserPreferences::class)
        ->set('sidebarCollapsed', 'false')
        ->assertDispatched('sidebar-toggled', collapsed: false);
});

test('sidebar preference has default value', function () {
    // Check default value for new users
    expect($this->user->getPreference('sidebar_collapsed', 'false'))->toBe('false');
});

test('sidebar toggle works from javascript toggle button', function () {
    // Load dashboard to ensure JavaScript is available
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $content = $response->getContent();
    
    // Check that the toggle button exists and has the correct onclick handler
    expect($content)->toContain('onclick="window.userPreferencesManager?.toggleSidebar()"');
    expect($content)->toContain('sidebar-toggle-btn');
    
    // Check that the toggleSidebar function is available in the JavaScript
    expect($content)->toContain('toggleSidebar()');
});
