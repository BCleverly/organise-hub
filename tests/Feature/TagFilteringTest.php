<?php

use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('tag filter dropdown shows available tags', function () {
    // Create tasks with different tags
    $task1 = Task::factory()->create(['user_id' => $this->user->id]);
    $task1->attachTag('work');
    $task1->attachTag('urgent');

    $task2 = Task::factory()->create(['user_id' => $this->user->id]);
    $task2->attachTag('personal');
    $task2->attachTag('low-priority');

    $task3 = Task::factory()->create(['user_id' => $this->user->id]);
    $task3->attachTag('work');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->assertSee('work')
        ->assertSee('urgent')
        ->assertSee('personal')
        ->assertSee('low-priority');
});

test('tag filter filters tasks correctly', function () {
    // Create tasks with different tags
    $workTask = Task::factory()->create(['user_id' => $this->user->id]);
    $workTask->attachTag('work');

    $personalTask = Task::factory()->create(['user_id' => $this->user->id]);
    $personalTask->attachTag('personal');

    $urgentTask = Task::factory()->create(['user_id' => $this->user->id]);
    $urgentTask->attachTag('urgent');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->assertSee($workTask->title)
        ->assertDontSee($personalTask->title)
        ->assertDontSee($urgentTask->title);
});

test('tag filter can be cleared', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);
    $task->attachTag('work');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->assertSet('tagFilters', ['work'])
        ->call('removeTagFilter', 'work')
        ->assertSet('tagFilters', []);
});

test('clear filters button clears all filters including tag filter', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);
    $task->attachTag('work');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->set('search', 'test')
        ->call('addTagFilter', 'work')
        ->set('statusFilter', 'todo')
        ->set('priorityFilter', 'high')
        ->call('clearFilters')
        ->assertSet('search', '')
        ->assertSet('tagFilters', [])
        ->assertSet('statusFilter', '')
        ->assertSet('priorityFilter', '');
});

test('tag filter works with other filters', function () {
    // Create tasks with different combinations
    $workTask = Task::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'todo',
        'priority' => 'high',
    ]);
    $workTask->attachTag('work');

    $personalTask = Task::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'todo',
        'priority' => 'low',
    ]);
    $personalTask->attachTag('personal');

    $urgentTask = Task::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'in_progress',
        'priority' => 'high',
    ]);
    $urgentTask->attachTag('urgent');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->set('statusFilter', 'todo')
        ->set('priorityFilter', 'high')
        ->assertSee($workTask->title)
        ->assertDontSee($personalTask->title)
        ->assertDontSee($urgentTask->title);
});

test('tag filter shows correct count in task stats', function () {
    // Create tasks with different tags
    $workTask1 = Task::factory()->create(['user_id' => $this->user->id, 'status' => 'todo']);
    $workTask1->attachTag('work');

    $workTask2 = Task::factory()->create(['user_id' => $this->user->id, 'status' => 'in_progress']);
    $workTask2->attachTag('work');

    $personalTask = Task::factory()->create(['user_id' => $this->user->id, 'status' => 'completed']);
    $personalTask->attachTag('personal');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->assertSee('2') // Should show 2 tasks with 'work' tag
        ->assertDontSee($personalTask->title);
});

test('multiple tag filters work correctly', function () {
    // Create tasks with different tag combinations
    $workTask = Task::factory()->create(['user_id' => $this->user->id]);
    $workTask->attachTag('work');

    $urgentTask = Task::factory()->create(['user_id' => $this->user->id]);
    $urgentTask->attachTag('urgent');

    $workUrgentTask = Task::factory()->create(['user_id' => $this->user->id]);
    $workUrgentTask->attachTag('work');
    $workUrgentTask->attachTag('urgent');

    $personalTask = Task::factory()->create(['user_id' => $this->user->id]);
    $personalTask->attachTag('personal');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->call('addTagFilter', 'urgent')
        ->assertSee($workTask->title)
        ->assertSee($urgentTask->title)
        ->assertSee($workUrgentTask->title)
        ->assertDontSee($personalTask->title);
});

test('tag filter dropdown shows selected tags count', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);
    $task->attachTag('work');

    Livewire::actingAs($this->user)
        ->test(\App\Livewire\Tasks::class)
        ->call('addTagFilter', 'work')
        ->assertSee('1 tag') // Should show '1 tag' in the button text
        ->call('addTagFilter', 'urgent')
        ->assertSee('2 tags'); // Should show '2 tags' in the button text
});
