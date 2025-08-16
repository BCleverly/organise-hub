<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trackables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['HABIT', 'SKILL']);
            $table->enum('goal_metric', ['checkbox', 'duration', 'count']);
            $table->foreignId('parent_skill_id')->nullable()->constrained('trackables')->cascadeOnDelete();
            
            // Goal configuration
            $table->integer('target_count')->nullable(); // For count-based goals
            $table->integer('target_duration_minutes')->nullable(); // For duration-based goals
            $table->string('frequency')->nullable(); // daily, weekly, monthly for habits
            $table->json('frequency_days')->nullable(); // [1,3,5] for specific days of week
            
            // Progress tracking
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->date('last_completed_at')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Skill-specific fields
            $table->integer('progress_percentage')->default(0); // For skills
            $table->date('target_completion_date')->nullable(); // For skills
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'is_active']);
            $table->index(['parent_skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackables');
    }
};
