<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPreference>
 */
class UserPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'preferences' => [
                'theme' => $this->faker->randomElement(['light', 'dark', 'auto']),
                'sidebar_collapsed' => $this->faker->boolean(20),
                'compact_mode' => $this->faker->boolean(30),
                'notifications_enabled' => $this->faker->boolean(80),
                'email_notifications' => $this->faker->boolean(70),
                
                // Task-specific preferences
                'task_view_mode' => $this->faker->randomElement(['detailed', 'minimal', 'compact']),
                'task_show_overview' => $this->faker->boolean(70),
                'task_show_priority' => $this->faker->boolean(80),
                'task_show_due_date' => $this->faker->boolean(75),
                'task_show_description' => $this->faker->boolean(60),
                'task_collapsed_columns' => $this->faker->boolean(15),
            ],
        ];
    }

    /**
     * Indicate that the user prefers light theme.
     */
    public function lightTheme(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'theme' => 'light',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers dark theme.
     */
    public function darkTheme(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'theme' => 'dark',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers compact mode.
     */
    public function compactMode(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'compact_mode' => 'true',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers collapsed sidebar.
     */
    public function collapsedSidebar(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'sidebar_collapsed' => 'true',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers minimal task view.
     */
    public function minimalTaskView(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'task_view_mode' => 'minimal',
                'task_show_overview' => 'false',
                'task_show_priority' => 'false',
                'task_show_due_date' => 'false',
                'task_show_description' => 'false',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers compact task view.
     */
    public function compactTaskView(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'task_view_mode' => 'compact',
                'task_show_description' => 'false',
                'task_collapsed_columns' => 'true',
            ]),
        ]);
    }

    /**
     * Indicate that the user prefers collapsed task columns.
     */
    public function collapsedTaskColumns(): static
    {
        return $this->state(fn (array $attributes) => [
            'preferences' => array_merge($attributes['preferences'] ?? [], [
                'task_collapsed_columns' => 'true',
            ]),
        ]);
    }
}
