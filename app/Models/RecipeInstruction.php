<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'step_number',
        'instruction',
        'estimated_time',
        'step_type',
        'notes',
    ];

    protected $casts = [
        'estimated_time' => 'integer',
    ];

    /**
     * Get the recipe that owns the instruction.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Scope a query to only include instructions for a specific recipe.
     */
    public function scopeForRecipe($query, int $recipeId): void
    {
        $query->where('recipe_id', $recipeId);
    }

    /**
     * Scope a query to only include instructions of a specific type.
     */
    public function scopeOfType($query, string $stepType): void
    {
        $query->where('step_type', $stepType);
    }

    /**
     * Scope a query to order instructions by step number.
     */
    public function scopeOrdered($query): void
    {
        $query->orderBy('step_number');
    }

    /**
     * Get the formatted step number.
     */
    protected function formattedStepNumber(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 'Step '.$this->step_number;
            }
        );
    }

    /**
     * Get the formatted estimated time.
     */
    protected function formattedEstimatedTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->estimated_time) {
                    return null;
                }

                $hours = floor($this->estimated_time / 60);
                $minutes = $this->estimated_time % 60;

                if ($hours > 0) {
                    return $hours.'h '.$minutes.'m';
                }

                return $minutes.'m';
            }
        );
    }

    /**
     * Get the step type display name.
     */
    protected function stepTypeDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                $types = [
                    'prep' => 'Preparation',
                    'cook' => 'Cooking',
                    'rest' => 'Resting',
                    'serve' => 'Serving',
                    'bake' => 'Baking',
                    'chill' => 'Chilling',
                    'garnish' => 'Garnishing',
                ];

                return $types[$this->step_type] ?? ucfirst($this->step_type ?? 'General');
            }
        );
    }
}
