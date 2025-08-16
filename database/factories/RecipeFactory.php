<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3, 6),
            'description' => $this->faker->optional()->paragraph(),
            'prep_time' => $this->faker->optional()->numberBetween(5, 60),
            'cook_time' => $this->faker->optional()->numberBetween(10, 180),
            'servings' => $this->faker->optional()->numberBetween(1, 12),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'category' => $this->faker->randomElement(['main_course', 'appetizer', 'dessert', 'breakfast', 'snacks']),
            'rating' => $this->faker->optional()->randomFloat(1, 1, 5),
            'review_count' => $this->faker->numberBetween(0, 100),
            'is_public' => $this->faker->boolean(20), // 20% chance of being public
        ];
    }

    /**
     * Indicate that the recipe is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    /**
     * Indicate that the recipe is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }

    /**
     * Indicate that the recipe is easy to make.
     */
    public function easy(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'easy',
            'prep_time' => $this->faker->numberBetween(5, 20),
            'cook_time' => $this->faker->numberBetween(10, 45),
        ]);
    }

    /**
     * Indicate that the recipe is highly rated.
     */
    public function highlyRated(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'review_count' => $this->faker->numberBetween(10, 100),
        ]);
    }
}
