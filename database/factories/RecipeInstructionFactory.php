<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\RecipeInstruction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeInstruction>
 */
class RecipeInstructionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeInstruction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stepTypes = ['prep', 'cook', 'bake', 'rest', 'serve', 'chill', 'garnish'];

        return [
            'recipe_id' => Recipe::factory(),
            'step_number' => $this->faker->numberBetween(1, 10),
            'instruction' => $this->faker->sentence(10, 20),
            'estimated_time' => $this->faker->optional()->numberBetween(1, 60),
            'step_type' => $this->faker->randomElement($stepTypes),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the instruction is a preparation step.
     */
    public function prep(): static
    {
        return $this->state(fn (array $attributes) => [
            'step_type' => 'prep',
            'estimated_time' => $this->faker->numberBetween(1, 30),
        ]);
    }

    /**
     * Indicate that the instruction is a cooking step.
     */
    public function cook(): static
    {
        return $this->state(fn (array $attributes) => [
            'step_type' => 'cook',
            'estimated_time' => $this->faker->numberBetween(5, 45),
        ]);
    }

    /**
     * Indicate that the instruction is a baking step.
     */
    public function bake(): static
    {
        return $this->state(fn (array $attributes) => [
            'step_type' => 'bake',
            'estimated_time' => $this->faker->numberBetween(10, 60),
        ]);
    }

    /**
     * Indicate that the instruction is a resting step.
     */
    public function rest(): static
    {
        return $this->state(fn (array $attributes) => [
            'step_type' => 'rest',
            'estimated_time' => $this->faker->numberBetween(5, 120),
        ]);
    }

    /**
     * Indicate that the instruction is a serving step.
     */
    public function serve(): static
    {
        return $this->state(fn (array $attributes) => [
            'step_type' => 'serve',
            'estimated_time' => $this->faker->numberBetween(1, 10),
        ]);
    }
}
