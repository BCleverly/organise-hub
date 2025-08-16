<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestInstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Chef',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create a test recipe with structured instructions
        $recipe = $user->recipes()->create([
            'title' => 'Test Recipe with Instructions',
            'description' => 'A test recipe to verify the instruction system works.',
            'prep_time' => 10,
            'cook_time' => 20,
            'servings' => 4,
            'difficulty' => 'easy',
            'category' => 'main_course',
            'is_public' => true,
        ]);

        // Attach ingredients
        $recipe->attachIngredients([
            ['name' => 'test ingredient', 'quantity' => 1, 'unit' => 'cup', 'category' => 'pantry'],
        ]);

        // Attach instructions
        $recipe->attachInstructions([
            [
                'instruction' => 'Preheat the oven to 350°F',
                'step_type' => 'prep',
                'estimated_time' => 5,
            ],
            [
                'instruction' => 'Mix all ingredients together',
                'step_type' => 'prep',
                'estimated_time' => 10,
            ],
            [
                'instruction' => 'Bake for 20 minutes',
                'step_type' => 'bake',
                'estimated_time' => 20,
            ],
            [
                'instruction' => 'Let cool for 5 minutes before serving',
                'step_type' => 'rest',
                'estimated_time' => 5,
            ],
        ]);

        // Add tags
        $recipe->syncTags(['test', 'instruction', 'demo']);

        $this->command->info('Test instruction seeder completed!');
        $this->command->info('Created recipe with '.$recipe->instructions()->count().' instructions');
    }
}
