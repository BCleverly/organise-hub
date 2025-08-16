<?php

namespace App\Console\Commands;

use Database\Seeders\TaskSeeder;
use Illuminate\Console\Command;

class SeedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:tasks {--fresh : Run fresh migrations before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with task data for testing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('fresh')) {
            $this->info('Running fresh migrations...');
            $this->call('migrate:fresh');
        }

        $this->info('Seeding tasks...');

        // Run the task seeder
        $seeder = new TaskSeeder;
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Task seeding completed successfully!');
        $this->info('You can now test the task feature with realistic data.');

        $this->newLine();
        $this->info('Test users created:');
        $this->info('- Test User (test@example.com) - General tasks');
        $this->info('- Admin User (admin@example.com) - Administrative tasks');
        $this->info('- Chef Sarah (sarah@example.com) - Cooking tasks');
        $this->info('- Chef Michael (michael@example.com) - Professional cooking tasks');
        $this->info('- Chef Emma (emma@example.com) - Event and appetizer tasks');
        $this->info('- Chef David (david@example.com) - Mixed category tasks');

        $this->newLine();
        $this->info('All users have password: password');

        return 0;
    }
}
