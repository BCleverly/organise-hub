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
        Schema::create('trackable_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trackable_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('completed_date');
            $table->integer('count')->default(1); // For count-based goals
            $table->integer('duration_minutes')->nullable(); // For duration-based goals
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure one completion per trackable per day
            $table->unique(['trackable_id', 'completed_date']);
            $table->index(['user_id', 'completed_date']);
            $table->index(['trackable_id', 'completed_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackable_completions');
    }
};
