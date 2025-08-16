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
        Schema::create('recipe_instructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->integer('step_number');
            $table->text('instruction');
            $table->integer('estimated_time')->nullable(); // in minutes
            $table->string('step_type')->nullable(); // e.g., 'prep', 'cook', 'rest', 'serve'
            $table->text('notes')->nullable(); // Additional tips or warnings
            $table->timestamps();

            $table->unique(['recipe_id', 'step_number']);
            $table->index(['recipe_id', 'step_type']);
            $table->index('step_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_instructions');
    }
};
