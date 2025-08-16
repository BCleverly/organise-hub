<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['dairy', 'produce', 'pantry', 'meat', 'spices'];
        $category = $this->faker->randomElement($categories);

        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->optional()->sentence(),
            'category' => $category,
            'is_allergen' => $this->faker->boolean(20), // 20% chance of being an allergen
        ];
    }

    /**
     * Indicate that the ingredient is an allergen.
     */
    public function allergen(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_allergen' => true,
        ]);
    }

    /**
     * Indicate that the ingredient is not an allergen.
     */
    public function nonAllergen(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_allergen' => false,
        ]);
    }

    /**
     * Indicate that the ingredient is in the dairy category.
     */
    public function dairy(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'dairy',
        ]);
    }

    /**
     * Indicate that the ingredient is in the produce category.
     */
    public function produce(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'produce',
        ]);
    }

    /**
     * Indicate that the ingredient is in the pantry category.
     */
    public function pantry(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'pantry',
        ]);
    }

    /**
     * Indicate that the ingredient is in the meat category.
     */
    public function meat(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'meat',
        ]);
    }

    /**
     * Indicate that the ingredient is in the spices category.
     */
    public function spices(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'spices',
        ]);
    }
}
