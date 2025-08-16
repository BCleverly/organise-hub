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
        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 3)->nullable(); // Allows for fractions like 0.5, 1.25, etc.
            $table->string('unit')->nullable(); // e.g., 'grams', 'kg', 'ml', 'litres', 'cups', 'tablespoons', 'teaspoons', 'pieces', 'whole'
            $table->text('notes')->nullable(); // For additional instructions like "finely chopped", "room temperature", etc.
            $table->integer('order')->default(0); // To maintain ingredient order in the recipe
            $table->timestamps();

            $table->unique(['recipe_id', 'ingredient_id']); // Prevent duplicate ingredients in same recipe
            $table->index(['recipe_id', 'order']);
            $table->index('ingredient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredient');
    }
};
