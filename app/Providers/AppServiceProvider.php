<?php

namespace App\Providers;

use App\Models\Recipe;
use App\Models\Task;
use App\Policies\RecipePolicy;
use App\Policies\TaskPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::calculateTaxes();

        Model::shouldBeStrict();

        // Register policies
        Gate::policy(Recipe::class, RecipePolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
    }
}
