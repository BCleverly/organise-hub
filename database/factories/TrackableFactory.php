<?php

namespace Database\Factories;

use App\Models\Trackable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trackable>
 */
class TrackableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['HABIT', 'SKILL']);
        $goalMetric = $this->faker->randomElement(['checkbox', 'duration', 'count']);
        
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'type' => $type,
            'goal_metric' => $goalMetric,
            'parent_skill_id' => null,
            'target_count' => $goalMetric === 'count' ? $this->faker->numberBetween(1, 10) : null,
            'target_duration_minutes' => $goalMetric === 'duration' ? $this->faker->numberBetween(15, 120) : null,
            'frequency' => $type === 'HABIT' ? $this->faker->randomElement(['daily', 'weekly', 'monthly']) : null,
            'frequency_days' => null,
            'current_streak' => $this->faker->numberBetween(0, 30),
            'longest_streak' => $this->faker->numberBetween(0, 100),
            'last_completed_at' => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'is_active' => true,
            'progress_percentage' => $type === 'SKILL' ? $this->faker->numberBetween(0, 100) : 0,
            'target_completion_date' => $type === 'SKILL' ? $this->faker->optional()->dateTimeBetween('now', '+6 months') : null,
        ];
    }

    /**
     * Indicate that the trackable is a habit.
     */
    public function habit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'HABIT',
            'progress_percentage' => 0,
            'target_completion_date' => null,
        ]);
    }

    /**
     * Indicate that the trackable is a skill.
     */
    public function skill(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'SKILL',
            'frequency' => null,
            'frequency_days' => null,
        ]);
    }

    /**
     * Indicate that the trackable uses checkbox goal metric.
     */
    public function checkbox(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_metric' => 'checkbox',
            'target_count' => null,
            'target_duration_minutes' => null,
        ]);
    }

    /**
     * Indicate that the trackable uses duration goal metric.
     */
    public function durationGoal(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_metric' => 'duration',
            'target_count' => null,
            'target_duration_minutes' => $this->faker->numberBetween(15, 120),
        ]);
    }

    /**
     * Indicate that the trackable uses count goal metric.
     */
    public function countGoal(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_metric' => 'count',
            'target_count' => $this->faker->numberBetween(1, 10),
            'target_duration_minutes' => null,
        ]);
    }

    /**
     * Indicate that the trackable is daily.
     */
    public function daily(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'daily',
            'frequency_days' => null,
        ]);
    }

    /**
     * Indicate that the trackable is weekly.
     */
    public function weekly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'weekly',
            'frequency_days' => $this->faker->randomElements([1, 2, 3, 4, 5, 6, 0], $this->faker->numberBetween(1, 3)),
        ]);
    }

    /**
     * Indicate that the trackable is monthly.
     */
    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'monthly',
            'frequency_days' => $this->faker->randomElements(range(1, 31), $this->faker->numberBetween(1, 3)),
        ]);
    }
}
