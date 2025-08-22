<?php

namespace Database\Seeders;

use App\Models\Trackable;
use App\Models\TrackableCompletion;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrackableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create test users
        $chloe = User::firstOrCreate(
            ['email' => 'chloe@example.com'],
            [
                'name' => 'Chloe',
                'email' => 'chloe@example.com',
                'password' => bcrypt('password'),
            ]
        );

        $ana = User::firstOrCreate(
            ['email' => 'ana@example.com'],
            [
                'name' => 'Ana',
                'email' => 'ana@example.com',
                'password' => bcrypt('password'),
            ]
        );

        $ben = User::firstOrCreate(
            ['email' => 'ben@example.com'],
            [
                'name' => 'Ben',
                'email' => 'ben@example.com',
                'password' => bcrypt('password'),
            ]
        );

        // Chloe - Habit Tracker (Simple wellness habits)
        $this->createChloeData($chloe);

        // Ana - Skill Learner (Spanish learning with component habits)
        $this->createAnaData($ana);

        // Ben - Project-Based Learner (Guitar learning with specific projects)
        $this->createBenData($ben);
    }

    private function createChloeData(User $user): void
    {
        // Clear existing data
        Trackable::where('user_id', $user->id)->delete();

        // Create simple wellness habits
        $habits = [
            [
                'title' => 'Morning Meditation',
                'description' => 'Start the day with 10 minutes of mindfulness',
                'goal_metric' => 'duration',
                'target_duration_minutes' => 10,
                'frequency' => 'daily',
            ],
            [
                'title' => 'Drink 8 Glasses of Water',
                'description' => 'Stay hydrated throughout the day',
                'goal_metric' => 'count',
                'target_count' => 8,
                'frequency' => 'daily',
            ],
            [
                'title' => 'Take a Walk',
                'description' => 'Get some fresh air and exercise',
                'goal_metric' => 'checkbox',
                'frequency' => 'daily',
            ],
            [
                'title' => 'Read Before Bed',
                'description' => 'Read for at least 20 minutes',
                'goal_metric' => 'duration',
                'target_duration_minutes' => 20,
                'frequency' => 'daily',
            ],
        ];

        foreach ($habits as $habitData) {
            $habit = Trackable::create([
                'user_id' => $user->id,
                'type' => 'HABIT',
                'current_streak' => rand(0, 15),
                'longest_streak' => rand(15, 45),
                'is_active' => true,
                ...$habitData,
            ]);

            // Add some completion history
            $this->addCompletionHistory($habit, rand(10, 30));
        }
    }

    private function createAnaData(User $user): void
    {
        // Clear existing data
        Trackable::where('user_id', $user->id)->delete();

        // Create the main skill
        $spanishSkill = Trackable::create([
            'user_id' => $user->id,
            'type' => 'SKILL',
            'title' => 'Learn Spanish',
            'description' => 'Become conversational in Spanish',
            'goal_metric' => 'checkbox',
            'progress_percentage' => 35,
            'target_completion_date' => now()->addMonths(6),
            'is_active' => true,
        ]);

        // Create component habits
        $habits = [
            [
                'title' => 'Practice Vocabulary',
                'description' => 'Learn 10 new words daily',
                'goal_metric' => 'count',
                'target_count' => 10,
                'frequency' => 'daily',
            ],
            [
                'title' => 'Listen to Spanish Podcast',
                'description' => 'Improve listening comprehension',
                'goal_metric' => 'duration',
                'target_duration_minutes' => 15,
                'frequency' => 'daily',
            ],
            [
                'title' => 'Practice Speaking',
                'description' => 'Have a conversation in Spanish',
                'goal_metric' => 'checkbox',
                'frequency' => 'weekly',
                'frequency_days' => [1, 3, 5], // Mon, Wed, Fri
            ],
            [
                'title' => 'Complete Grammar Lesson',
                'description' => 'Work through one grammar concept',
                'goal_metric' => 'checkbox',
                'frequency' => 'weekly',
                'frequency_days' => [2, 4], // Tue, Thu
            ],
        ];

        foreach ($habits as $habitData) {
            $habit = Trackable::create([
                'user_id' => $user->id,
                'type' => 'HABIT',
                'parent_skill_id' => $spanishSkill->id,
                'current_streak' => rand(0, 20),
                'longest_streak' => rand(20, 60),
                'is_active' => true,
                ...$habitData,
            ]);

            // Add some completion history
            $this->addCompletionHistory($habit, rand(15, 40));
        }

        // Update skill progress
        $spanishSkill->updateProgress();
    }

    private function createBenData(User $user): void
    {
        // Clear existing data
        Trackable::where('user_id', $user->id)->delete();

        // Create the main skill
        $guitarSkill = Trackable::create([
            'user_id' => $user->id,
            'type' => 'SKILL',
            'title' => 'Learn Guitar',
            'description' => 'Master the guitar and play favourite songs',
            'goal_metric' => 'checkbox',
            'progress_percentage' => 25,
            'target_completion_date' => now()->addMonths(12),
            'is_active' => true,
        ]);

        // Create component habits
        $habits = [
            [
                'title' => 'Practice Chords',
                'description' => 'Work on chord transitions and finger strength',
                'goal_metric' => 'duration',
                'target_duration_minutes' => 30,
                'frequency' => 'daily',
            ],
            [
                'title' => 'Learn New Song',
                'description' => 'Work on learning a new song',
                'goal_metric' => 'checkbox',
                'frequency' => 'weekly',
                'frequency_days' => [6], // Saturday
            ],
            [
                'title' => 'Practice Scales',
                'description' => 'Improve finger dexterity and music theory',
                'goal_metric' => 'duration',
                'target_duration_minutes' => 15,
                'frequency' => 'daily',
            ],
        ];

        foreach ($habits as $habitData) {
            $habit = Trackable::create([
                'user_id' => $user->id,
                'type' => 'HABIT',
                'parent_skill_id' => $guitarSkill->id,
                'current_streak' => rand(0, 25),
                'longest_streak' => rand(25, 70),
                'is_active' => true,
                ...$habitData,
            ]);

            // Add some completion history
            $this->addCompletionHistory($habit, rand(20, 50));
        }

        // Create specific project trackables
        $projects = [
            [
                'title' => 'Learn "Wonderwall"',
                'description' => 'Master the iconic Oasis song',
                'goal_metric' => 'checkbox',
                'progress_percentage' => 60,
            ],
            [
                'title' => 'Learn "Hotel California"',
                'description' => 'Practice the famous Eagles guitar solo',
                'goal_metric' => 'checkbox',
                'progress_percentage' => 30,
            ],
            [
                'title' => 'Learn "Stairway to Heaven"',
                'description' => 'Tackle the legendary Led Zeppelin song',
                'goal_metric' => 'checkbox',
                'progress_percentage' => 15,
            ],
        ];

        foreach ($projects as $projectData) {
            Trackable::create([
                'user_id' => $user->id,
                'type' => 'SKILL',
                'parent_skill_id' => $guitarSkill->id,
                'is_active' => true,
                ...$projectData,
            ]);
        }

        // Update skill progress
        $guitarSkill->updateProgress();
    }

    private function addCompletionHistory(Trackable $trackable, int $days): void
    {
        $startDate = now()->subDays($days);

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);

            // 70% chance of completion on any given day
            if (rand(1, 100) <= 70) {
                $completionData = [
                    'trackable_id' => $trackable->id,
                    'user_id' => $trackable->user_id,
                    'completed_date' => $date->toDateString(),
                    'count' => 1,
                ];

                if ($trackable->goal_metric === 'duration') {
                    $completionData['duration_minutes'] = rand(
                        max(1, $trackable->target_duration_minutes - 5),
                        $trackable->target_duration_minutes + 10
                    );
                } elseif ($trackable->goal_metric === 'count') {
                    $completionData['count'] = rand(
                        max(1, $trackable->target_count - 2),
                        $trackable->target_count + 3
                    );
                }

                TrackableCompletion::create($completionData);
            }
        }
    }
}
