<?php

namespace App\Console\Commands;

use Database\Seeders\RecipeSeeder;
use Database\Seeders\TaskSeeder;
use Illuminate\Console\Command;

class SeedRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:recipes {--fresh : Run fresh migrations before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with recipe data for testing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('fresh')) {
            $this->info('Running fresh migrations...');
            $this->call('migrate:fresh');
        }

        $this->info('Seeding recipes...');
        $recipeSeeder = new RecipeSeeder;
        $recipeSeeder->run();

        $this->info('Seeding tasks...');
        $taskSeeder = new TaskSeeder;
        $taskSeeder->setCommand($this);
        $taskSeeder->run();

        $this->info('Recipe and task seeding completed successfully!');
        $this->info('You can now test both recipe and task features with realistic data.');
        $this->info('');
        $this->info('Test users created:');
        $this->info('- Test User (test@example.com) - General tasks');
        $this->info('- Admin User (admin@example.com) - Administrative tasks');
        $this->info('- Chef Sarah (sarah@example.com) - Desserts & Breakfast + Cooking tasks');
        $this->info('- Chef Michael (michael@example.com) - Main Courses + Professional cooking tasks');
        $this->info('- Chef Emma (emma@example.com) - Appetizers & Snacks + Event tasks');
        $this->info('- Chef David (david@example.com) - Mixed Categories + Mixed tasks');
        $this->info('');
        $this->info('All users have password: password');

        return 0;
    }
}
