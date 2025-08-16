<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Spatie\Tags\HasTags;

class Recipe extends Model implements ReactableInterface
{
    use HasFactory, HasTags, Reactable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'category',
        'rating',
        'review_count',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the recipe.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include recipes for a specific user.
     */
    public function scopeForUser($query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include public recipes.
     */
    public function scopePublic($query): void
    {
        $query->where('is_public', true);
    }

    /**
     * Scope a query to only include recipes with a specific category.
     */
    public function scopeWithCategory($query, string $category): void
    {
        $query->where('category', $category);
    }

    /**
     * Scope a query to only include recipes with a specific difficulty.
     */
    public function scopeWithDifficulty($query, string $difficulty): void
    {
        $query->where('difficulty', $difficulty);
    }

    /**
     * Get the total time in minutes (prep + cook time).
     */
    protected function totalTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->prep_time || $this->cook_time) {
                    return ($this->prep_time ?? 0) + ($this->cook_time ?? 0);
                }

                return null;
            }
        );
    }

    /**
     * Format the total time as a human-readable string.
     */
    protected function formattedTotalTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalMinutes = $this->total_time;

                if (! $totalMinutes) {
                    return null;
                }

                $hours = floor($totalMinutes / 60);
                $minutes = $totalMinutes % 60;

                if ($hours > 0) {
                    return $hours.'h '.$minutes.'m';
                }

                return $minutes.'m';
            }
        );
    }

    /**
     * Get the formatted rating with stars.
     */
    protected function formattedRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->rating) {
                    return 'No ratings';
                }

                return number_format((float) $this->rating, 1).' ('.$this->review_count.' reviews)';
            }
        );
    }

    /**
     * Get the ingredients for this recipe.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
            ->using(RecipeIngredient::class)
            ->withPivot(['quantity', 'unit', 'notes', 'group', 'group_order', 'order'])
            ->orderBy('pivot_order')
            ->withTimestamps();
    }

    /**
     * Get the ingredients grouped by their group.
     */
    protected function groupedIngredients(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var \Illuminate\Database\Eloquent\Collection<int, Ingredient> $ingredients */
                $ingredients = $this->ingredients;

                $grouped = $ingredients->groupBy(function ($ingredient) {
                    return $ingredient->pivot->group ?: 'Main Ingredients';
                })->map(function ($groupIngredients, $groupName) {
                    return [
                        'name' => $groupName,
                        'ingredients' => $groupIngredients->sortBy('pivot.group_order'),
                    ];
                });

                return $grouped->sortKeys();
            }
        );
    }

    /**
     * Get the instructions for this recipe.
     */
    public function instructions(): HasMany
    {
        return $this->hasMany(RecipeInstruction::class)->ordered();
    }

    /**
     * Get the ingredients as a formatted string (for backward compatibility).
     */
    protected function ingredientsText(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var \Illuminate\Database\Eloquent\Collection<int, Ingredient> $ingredients */
                $ingredients = $this->ingredients;

                return $ingredients->map(function (Ingredient $ingredient) {
                    /** @var RecipeIngredient $pivot */
                    $pivot = $ingredient->pivot;
                    $text = '';
                    if ($pivot->quantity) {
                        $text .= $pivot->quantity;
                    }
                    if ($pivot->unit) {
                        $text .= ' '.$pivot->unit;
                    }
                    $text .= ' '.$ingredient->name;
                    if ($pivot->notes) {
                        $text .= ' ('.$pivot->notes.')';
                    }

                    return $text;
                })->implode("\n");
            }
        );
    }

    /**
     * Get the instructions as a formatted string (for backward compatibility).
     */
    protected function instructionsText(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var \Illuminate\Database\Eloquent\Collection<int, RecipeInstruction> $instructions */
                $instructions = $this->instructions;

                return $instructions->map(function (RecipeInstruction $instruction) {
                    return $instruction->step_number.'. '.$instruction->instruction;
                })->implode("\n");
            }
        );
    }

    /**
     * Attach ingredients to the recipe with quantities and units.
     *
     * @param  array<int, array<string, mixed>>  $ingredients
     */
    public function attachIngredients(array $ingredients): void
    {
        $order = 0;
        $groupOrders = []; // Track order within each group

        foreach ($ingredients as $ingredientData) {
            $ingredient = Ingredient::firstOrCreate(
                ['name' => $ingredientData['name']],
                [
                    'description' => $ingredientData['description'] ?? null,
                    'category' => $ingredientData['category'] ?? null,
                    'is_allergen' => $ingredientData['is_allergen'] ?? false,
                ]
            );

            // Check if ingredient is already attached to this recipe
            if (! $this->ingredients()->where('ingredient_id', $ingredient->id)->exists()) {
                $group = $ingredientData['group'] ?? null;

                // Track order within group
                if ($group) {
                    if (! isset($groupOrders[$group])) {
                        $groupOrders[$group] = 0;
                    }
                    $groupOrder = $groupOrders[$group]++;
                } else {
                    $groupOrder = 0;
                }

                $this->ingredients()->attach($ingredient->id, [
                    'quantity' => $ingredientData['quantity'] ?? null,
                    'unit' => $ingredientData['unit'] ?? null,
                    'notes' => $ingredientData['notes'] ?? null,
                    'group' => $group,
                    'group_order' => $groupOrder,
                    'order' => $order++,
                ]);
            }
        }
    }

    /**
     * Attach instructions to the recipe as individual steps.
     *
     * @param  array<int, array<string, mixed>>  $instructions
     */
    public function attachInstructions(array $instructions): void
    {
        foreach ($instructions as $index => $instructionData) {
            $this->instructions()->create([
                'step_number' => $index + 1,
                'instruction' => $instructionData['instruction'],
                'estimated_time' => $instructionData['estimated_time'] ?? null,
                'step_type' => $instructionData['step_type'] ?? null,
                'notes' => $instructionData['notes'] ?? null,
            ]);
        }
    }
}
