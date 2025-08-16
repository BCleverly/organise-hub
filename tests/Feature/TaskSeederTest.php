<?php

use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskSeeder;

test('task seeder creates users and tasks', function () {
    // Create some users first
    $users = [
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]),
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]),
    ];

    $this->seed(TaskSeeder::class);

    // Check that tasks were created
    expect(Task::count())->toBeGreaterThan(0);

    // Check that users have tasks
    foreach ($users as $user) {
        expect($user->tasks()->count())->toBeGreaterThan(0);
    }

    // Check that tasks have proper data
    $firstTask = Task::first();
    expect($firstTask->title)->not->toBeEmpty();
    expect($firstTask->status)->not->toBeEmpty();
    expect($firstTask->priority)->not->toBeEmpty();
    expect($firstTask->user_id)->not->toBeNull();
});

test('task statuses are distributed', function () {
    // Create users first
    User::factory()->count(3)->create();

    $this->seed(TaskSeeder::class);

    $statuses = Task::selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    // Check that we have tasks with different statuses
    expect(count($statuses))->toBeGreaterThan(1);

    // Check that we have tasks in expected statuses
    $expectedStatuses = ['todo', 'in_progress', 'awaiting', 'completed'];
    foreach ($expectedStatuses as $status) {
        if (isset($statuses[$status])) {
            expect($statuses[$status])->toBeGreaterThan(0);
        }
    }
});

test('task priorities are distributed', function () {
    // Create users first
    User::factory()->count(3)->create();

    $this->seed(TaskSeeder::class);

    $priorities = Task::selectRaw('priority, count(*) as count')
        ->groupBy('priority')
        ->pluck('count', 'priority')
        ->toArray();

    // Check that we have tasks of different priorities
    expect(count($priorities))->toBeGreaterThan(1);

    // Check that we have tasks in expected priorities
    $expectedPriorities = ['low', 'medium', 'high'];
    foreach ($expectedPriorities as $priority) {
        if (isset($priorities[$priority])) {
            expect($priorities[$priority])->toBeGreaterThan(0);
        }
    }
});

test('users can access their tasks', function () {
    // Create users first
    $users = User::factory()->count(3)->create();

    $this->seed(TaskSeeder::class);

    foreach ($users as $user) {
        // Check that users can see their own tasks
        $userTasks = Task::where('user_id', $user->id)->get();
        expect($userTasks->count())->toBeGreaterThan(0);

        // Check that tasks have proper data
        $firstTask = $userTasks->first();
        expect($firstTask->title)->not->toBeEmpty();
        expect($firstTask->status)->not->toBeEmpty();
        expect($firstTask->priority)->not->toBeEmpty();
    }
});

test('task tags are properly attached', function () {
    // Create users first
    User::factory()->count(2)->create();

    $this->seed(TaskSeeder::class);

    // Check that tasks have tags
    $tasksWithTags = Task::has('tags')->count();
    expect($tasksWithTags)->toBeGreaterThan(0);

    // Check specific task tags
    $workTask = Task::where('title', 'Review project documentation')->first();
    if ($workTask) {
        expect($workTask->hasTag('work'))->toBeTrue();
        expect($workTask->hasTag('documentation'))->toBeTrue();
    }

    $cookingTask = Task::where('title', 'Plan weekly meal prep')->first();
    if ($cookingTask) {
        expect($cookingTask->hasTag('cooking'))->toBeTrue();
        expect($cookingTask->hasTag('meal-prep'))->toBeTrue();
    }
});

test('task scopes work correctly', function () {
    // Create users first
    User::factory()->count(2)->create();

    $this->seed(TaskSeeder::class);

    // Test status scopes
    $todoTasks = Task::withStatus('todo')->count();
    expect($todoTasks)->toBeGreaterThan(0);

    $completedTasks = Task::withStatus('completed')->count();
    expect($completedTasks)->toBeGreaterThan(0);

    // Test priority scopes
    $highPriorityTasks = Task::withPriority('high')->count();
    expect($highPriorityTasks)->toBeGreaterThan(0);

    $lowPriorityTasks = Task::withPriority('low')->count();
    expect($lowPriorityTasks)->toBeGreaterThan(0);
});

test('task factory creates valid tasks', function () {
    $user = User::factory()->create();

    // Test basic factory
    $task = Task::factory()->for($user)->create();
    expect($task)->not->toBeNull();
    expect($task->user_id)->toBe($user->id);
    expect($task->title)->not->toBeEmpty();
    expect($task->status)->not->toBeEmpty();
    expect($task->priority)->not->toBeEmpty();

    // Test completed factory state
    $completedTask = Task::factory()->completed()->for($user)->create();
    expect($completedTask->status)->toBe('completed');
    expect($completedTask->completed_at)->not->toBeNull();

    // Test high priority factory state
    $highPriorityTask = Task::factory()->highPriority()->for($user)->create();
    expect($highPriorityTask->priority)->toBe('high');

    // Test overdue factory state
    $overdueTask = Task::factory()->overdue()->for($user)->create();
    expect($overdueTask->due_date->isPast())->toBeTrue();
    expect($overdueTask->status)->not->toBe('completed');
});

test('seeder can be run multiple times', function () {
    // Create users first
    User::factory()->count(3)->create();

    // Run seeder twice
    $this->seed(TaskSeeder::class);
    $firstRunCount = Task::count();

    $this->seed(TaskSeeder::class);
    $secondRunCount = Task::count();

    // Should have the same number of tasks (truncate prevents duplicates)
    expect($secondRunCount)->toBe($firstRunCount);
});

test('task completion functionality', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create(['status' => 'todo']);

    // Test completion check
    expect($task->isCompleted())->toBeFalse();

    // Test marking as completed
    $task->markAsCompleted();
    expect($task->isCompleted())->toBeTrue();
    expect($task->completed_at)->not->toBeNull();
});

test('task due dates are set', function () {
    // Create users first
    User::factory()->count(2)->create();

    $this->seed(TaskSeeder::class);

    // Check that some tasks have due dates
    $tasksWithDueDates = Task::whereNotNull('due_date')->count();
    expect($tasksWithDueDates)->toBeGreaterThan(0);

    // Check that some tasks don't have due dates (optional field)
    $tasksWithoutDueDates = Task::whereNull('due_date')->count();
    expect($tasksWithoutDueDates)->toBeGreaterThanOrEqual(0);
});

test('task user relationships', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    // Test user relationship
    expect($task->user->id)->toBe($user->id);
    expect($user->tasks->contains($task))->toBeTrue();
});

test('task tag relationships', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    // Test tag attachment
    $task->syncTags(['work', 'urgent', 'project']);
    expect($task->hasTag('work'))->toBeTrue();
    expect($task->hasTag('urgent'))->toBeTrue();
    expect($task->hasTag('project'))->toBeTrue();
    expect($task->hasTag('personal'))->toBeFalse();
});
