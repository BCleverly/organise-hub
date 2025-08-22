<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users (including those created by RecipeSeeder)
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run DatabaseSeeder first.');

            return;
        }

        // Clear existing tasks to prevent duplicates
        Task::truncate();

        // Task data for different user types
        $taskData = [
            // Test User tasks (general tasks)
            [
                [
                    'title' => 'Review project documentation',
                    'description' => 'Go through the latest project documentation and update any outdated sections.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDays(3),
                    'tags' => ['work', 'documentation', 'review'],
                ],
                [
                    'title' => 'Schedule team meeting',
                    'description' => 'Coordinate with team members to schedule the weekly standup meeting.',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'due_date' => now()->addDay(),
                    'tags' => ['work', 'meeting', 'coordination'],
                ],
                [
                    'title' => 'Update personal portfolio',
                    'description' => 'Add recent projects and update skills section on personal website.',
                    'status' => 'todo',
                    'priority' => 'low',
                    'due_date' => now()->addDays(7),
                    'tags' => ['personal', 'portfolio', 'website'],
                ],
                [
                    'title' => 'Research new technologies',
                    'description' => 'Look into latest trends in web development and identify learning opportunities.',
                    'status' => 'awaiting',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(5),
                    'tags' => ['learning', 'research', 'technology'],
                ],
            ],
            // Admin User tasks (administrative tasks)
            [
                [
                    'title' => 'Review user permissions',
                    'description' => 'Audit current user permissions and update access controls as needed.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDays(2),
                    'tags' => ['admin', 'security', 'permissions'],
                ],
                [
                    'title' => 'Prepare quarterly report',
                    'description' => 'Compile data and create comprehensive quarterly performance report.',
                    'status' => 'in_progress',
                    'priority' => 'high',
                    'due_date' => now()->addDays(4),
                    'tags' => ['admin', 'reporting', 'quarterly'],
                ],
                [
                    'title' => 'Update system documentation',
                    'description' => 'Review and update system architecture and deployment documentation.',
                    'status' => 'completed',
                    'priority' => 'medium',
                    'due_date' => now()->subDays(2),
                    'completed_at' => now()->subDay(),
                    'tags' => ['admin', 'documentation', 'system'],
                ],
                [
                    'title' => 'Plan team training session',
                    'description' => 'Organise training session for new team members on system procedures.',
                    'status' => 'todo',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(10),
                    'tags' => ['admin', 'training', 'team'],
                ],
                [
                    'title' => 'Backup system data',
                    'description' => 'Perform routine system backup and verify data integrity.',
                    'status' => 'completed',
                    'priority' => 'high',
                    'due_date' => now()->subDays(1),
                    'completed_at' => now()->subHours(6),
                    'tags' => ['admin', 'backup', 'maintenance'],
                ],
            ],
            // Chef Sarah tasks (cooking and food-related)
            [
                [
                    'title' => 'Plan weekly meal prep',
                    'description' => 'Create meal plan for the week and prepare shopping list.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDays(1),
                    'tags' => ['cooking', 'meal-prep', 'planning'],
                ],
                [
                    'title' => 'Test new cookie recipe',
                    'description' => 'Experiment with new chocolate chip cookie variations.',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(2),
                    'tags' => ['cooking', 'baking', 'recipe-testing'],
                ],
                [
                    'title' => 'Organise kitchen pantry',
                    'description' => 'Sort and organise pantry items by category and expiration date.',
                    'status' => 'todo',
                    'priority' => 'low',
                    'due_date' => now()->addDays(5),
                    'tags' => ['cooking', 'organization', 'pantry'],
                ],
                [
                    'title' => 'Attend cooking workshop',
                    'description' => 'Participate in advanced pastry making workshop.',
                    'status' => 'completed',
                    'priority' => 'medium',
                    'due_date' => now()->subDays(3),
                    'completed_at' => now()->subDays(3),
                    'tags' => ['cooking', 'learning', 'workshop'],
                ],
            ],
            // Chef Michael tasks (professional cooking)
            [
                [
                    'title' => 'Prepare dinner service menu',
                    'description' => 'Plan and prepare menu items for tonight\'s dinner service.',
                    'status' => 'in_progress',
                    'priority' => 'high',
                    'due_date' => now()->addHours(4),
                    'tags' => ['cooking', 'menu', 'service'],
                ],
                [
                    'title' => 'Order fresh ingredients',
                    'description' => 'Place order with local suppliers for fresh produce and seafood.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDay(),
                    'tags' => ['cooking', 'supplies', 'ordering'],
                ],
                [
                    'title' => 'Train new kitchen staff',
                    'description' => 'Show new team members proper knife skills and safety procedures.',
                    'status' => 'awaiting',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(3),
                    'tags' => ['cooking', 'training', 'staff'],
                ],
                [
                    'title' => 'Update recipe database',
                    'description' => 'Add new recipes and update existing ones in the kitchen database.',
                    'status' => 'todo',
                    'priority' => 'low',
                    'due_date' => now()->addDays(7),
                    'tags' => ['cooking', 'recipes', 'database'],
                ],
            ],
            // Chef Emma tasks (appetizers and events)
            [
                [
                    'title' => 'Prepare party appetizers',
                    'description' => 'Make finger foods and appetizers for upcoming event.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDays(2),
                    'tags' => ['cooking', 'appetizers', 'party'],
                ],
                [
                    'title' => 'Create event menu',
                    'description' => 'Design menu for corporate event with dietary restrictions.',
                    'status' => 'in_progress',
                    'priority' => 'high',
                    'due_date' => now()->addDay(),
                    'tags' => ['cooking', 'menu', 'events'],
                ],
                [
                    'title' => 'Stock up on party supplies',
                    'description' => 'Purchase disposable plates, napkins, and serving utensils.',
                    'status' => 'todo',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(3),
                    'tags' => ['cooking', 'supplies', 'party'],
                ],
                [
                    'title' => 'Practice new appetizer recipes',
                    'description' => 'Test and perfect new appetizer recipes for upcoming events.',
                    'status' => 'awaiting',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(4),
                    'tags' => ['cooking', 'appetizers', 'recipe-testing'],
                ],
            ],
            // Chef David tasks (mixed categories)
            [
                [
                    'title' => 'Plan family dinner',
                    'description' => 'Create menu and prepare ingredients for family dinner.',
                    'status' => 'todo',
                    'priority' => 'high',
                    'due_date' => now()->addDay(),
                    'tags' => ['cooking', 'family', 'dinner'],
                ],
                [
                    'title' => 'Update cooking blog',
                    'description' => 'Write new blog post about recent cooking experiments.',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(3),
                    'tags' => ['cooking', 'blog', 'writing'],
                ],
                [
                    'title' => 'Attend food photography workshop',
                    'description' => 'Learn techniques for better food photography.',
                    'status' => 'completed',
                    'priority' => 'low',
                    'due_date' => now()->subDays(5),
                    'completed_at' => now()->subDays(5),
                    'tags' => ['cooking', 'photography', 'learning'],
                ],
                [
                    'title' => 'Organise recipe collection',
                    'description' => 'Sort and categorise personal recipe collection.',
                    'status' => 'todo',
                    'priority' => 'low',
                    'due_date' => now()->addDays(10),
                    'tags' => ['cooking', 'organization', 'recipes'],
                ],
            ],
        ];

        // Create tasks for each user
        foreach ($users as $index => $user) {
            $userTasks = $taskData[$index] ?? $taskData[0]; // Default to first set if not enough data

            foreach ($userTasks as $taskInfo) {
                $tags = $taskInfo['tags'];
                unset($taskInfo['tags']);

                $task = $user->tasks()->create($taskInfo);
                $task->syncTags($tags);
            }
        }

        // Create some additional random tasks for variety
        $additionalTasks = [
            [
                'title' => 'Review code changes',
                'description' => 'Review pull requests and provide feedback to team members.',
                'status' => 'todo',
                'priority' => 'high',
                'due_date' => now()->addDays(2),
                'tags' => ['work', 'code-review', 'development'],
            ],
            [
                'title' => 'Update project timeline',
                'description' => 'Review and update project milestones and deadlines.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'due_date' => now()->addDays(3),
                'tags' => ['work', 'project-management', 'timeline'],
            ],
            [
                'title' => 'Prepare presentation slides',
                'description' => 'Create slides for upcoming client presentation.',
                'status' => 'todo',
                'priority' => 'high',
                'due_date' => now()->addDays(4),
                'tags' => ['work', 'presentation', 'client'],
            ],
        ];

        // Assign additional tasks to random users
        foreach ($additionalTasks as $taskInfo) {
            $tags = $taskInfo['tags'];
            unset($taskInfo['tags']);

            $user = $users->random();
            $task = $user->tasks()->create($taskInfo);
            $task->syncTags($tags);
        }

        // Output info if running from command
        if ($this->command) {
            $this->command->info('Task seeder completed!');
            $this->command->info('Created tasks for '.$users->count().' users');
            $this->command->info('Total tasks created: '.Task::count());

            // Show task distribution
            $statusCounts = Task::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $this->command->info('Task status distribution:');
            foreach ($statusCounts as $status => $count) {
                $this->command->info("  - {$status}: {$count}");
            }
        }
    }
}
