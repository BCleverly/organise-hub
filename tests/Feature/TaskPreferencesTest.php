<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('task preferences are saved and applied', function () {
    $this->user->setPreference('task_view_mode', 'minimal');
    $this->user->setPreference('task_show_overview', 'false');
    $this->user->setPreference('task_show_priority', 'true');
    $this->user->setPreference('task_show_due_date', 'false');
    $this->user->setPreference('task_show_description', 'true');
    $this->user->setPreference('task_collapsed_columns', 'true');
    
    $this->user->refresh();
    
    expect($this->user->getPreference('task_view_mode'))->toBe('minimal');
    expect($this->user->getPreference('task_show_overview'))->toBe('false');
    expect($this->user->getPreference('task_show_priority'))->toBe('true');
    expect($this->user->getPreference('task_show_due_date'))->toBe('false');
    expect($this->user->getPreference('task_show_description'))->toBe('true');
    expect($this->user->getPreference('task_collapsed_columns'))->toBe('true');
});

test('task preferences have default values', function () {
    expect($this->user->getPreference('task_view_mode', 'detailed'))->toBe('detailed');
    expect($this->user->getPreference('task_show_overview', 'true'))->toBe('true');
    expect($this->user->getPreference('task_show_priority', 'true'))->toBe('true');
    expect($this->user->getPreference('task_show_due_date', 'true'))->toBe('true');
    expect($this->user->getPreference('task_show_description', 'true'))->toBe('true');
    expect($this->user->getPreference('task_collapsed_columns', 'false'))->toBe('false');
});

test('task preferences persist across sessions', function () {
    $this->user->setPreference('task_view_mode', 'minimal');
    $this->user->setPreference('task_show_overview', 'false');
    
    // Simulate a new session
    $this->actingAs($this->user);
    
    expect($this->user->getPreference('task_view_mode'))->toBe('minimal');
    expect($this->user->getPreference('task_show_overview'))->toBe('false');
});

test('task component loads user preferences', function () {
    $this->user->setPreference('task_view_mode', 'minimal');
    $this->user->setPreference('task_show_overview', 'false');
    
    Livewire::test(\App\Livewire\Tasks::class)
        ->assertSet('viewMode', 'minimal')
        ->assertSet('showOverview', false);
});

test('task preferences can be updated individually', function () {
    // Test view mode
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'minimal')
        ->assertSet('viewMode', 'minimal');
    
    // Test overview toggle
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('showOverview', false)
        ->assertSet('showOverview', false);
    
    // Test changing back
    Livewire::test(\App\Livewire\Tasks::class)
        ->set('viewMode', 'detailed')
        ->set('showOverview', true)
        ->assertSet('viewMode', 'detailed')
        ->assertSet('showOverview', true);
});
