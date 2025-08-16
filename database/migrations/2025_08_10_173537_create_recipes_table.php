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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('prep_time')->nullable(); // in minutes
            $table->integer('cook_time')->nullable(); // in minutes
            $table->integer('servings')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->string('category')->default('main_course'); // main_course, appetizer, dessert, breakfast, snacks
            $table->decimal('rating', 2, 1)->nullable(); // 0.0 to 5.0
            $table->integer('review_count')->default(0);
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'category']);
            $table->index(['user_id', 'difficulty']);
            $table->index(['user_id', 'is_public']);
            $table->index(['rating', 'review_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
