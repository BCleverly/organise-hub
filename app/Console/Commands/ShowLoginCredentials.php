<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowLoginCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:credentials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show login credentials for seeded users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Login Credentials for Development:');
        $this->newLine();

        $users = User::all();

        if ($users->isEmpty()) {
            $this->warn('No users found. Run "php artisan db:seed" to create test users.');

            return 1; // Indicate failure
        }

        foreach ($users as $user) {
            $this->line("Name: <info>{$user->name}</info>");
            $this->line("Email: <info>{$user->email}</info>");
            $this->line('Password: <info>password</info>');
            $this->line('Email Verified: '.($user->email_verified_at ? '<info>Yes</info>' : '<error>No</error>'));
            $this->newLine();
        }

        $this->info('You can use these credentials to log in at:');
        $this->line('<info>'.url('/login').'</info>');

        return 0; // Indicate success
    }
}
