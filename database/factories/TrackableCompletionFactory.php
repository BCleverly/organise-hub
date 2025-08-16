<?php

namespace Database\Factories;

use App\Models\Trackable;
use App\Models\TrackableCompletion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrackableCompletion>
 */
class TrackableCompletionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trackable_id' => Trackable::factory(),
            'user_id' => User::factory(),
            'completed_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'count' => $this->faker->numberBetween(1, 5),
            'duration_minutes' => $this->faker->optional()->numberBetween(5, 120),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the completion is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_date' => now()->toDateString(),
        ]);
    }

    /**
     * Indicate that the completion is for yesterday.
     */
    public function yesterday(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_date' => now()->subDay()->toDateString(),
        ]);
    }

    /**
     * Indicate that the completion has a specific count.
     */
    public function count(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'count' => $count,
        ]);
    }

    /**
     * Indicate that the completion has a specific duration.
     */
    public function duration(int $minutes): static
    {
        return $this->state(fn (array $attributes) => [
            'duration_minutes' => $minutes,
        ]);
    }
}
