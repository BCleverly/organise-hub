<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property RecipeIngredient $pivot
 */
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'is_allergen',
    ];

    protected $casts = [
        'is_allergen' => 'boolean',
    ];

    /**
     * Get the recipes that use this ingredient.
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient')
            ->using(RecipeIngredient::class)
            ->withPivot(['quantity', 'unit', 'notes', 'order'])
            ->withTimestamps();
    }

    /**
     * Scope a query to only include ingredients in a specific category.
     */
    public function scopeInCategory($query, string $category): void
    {
        $query->where('category', $category);
    }

    /**
     * Scope a query to only include allergens.
     */
    public function scopeAllergens($query): void
    {
        $query->where('is_allergen', true);
    }

    /**
     * Scope a query to only include non-allergens.
     */
    public function scopeNonAllergens($query): void
    {
        $query->where('is_allergen', false);
    }

    /**
     * Search ingredients by name.
     */
    public function scopeSearch($query, string $search): void
    {
        $searchTerm = '%'.$search.'%';
        $query->where('name', 'like', $searchTerm)
            ->orWhere('description', 'like', $searchTerm);
    }

    /**
     * Get the formatted name with allergen indicator.
     */
    protected function formattedName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->is_allergen ? $this->name.' (Allergen)' : $this->name;
            }
        );
    }

    /**
     * Get common units for this ingredient category.
     *
     * @return array<int, string>
     */
    protected function commonUnits(): Attribute
    {
        return Attribute::make(
            get: function () {
                $unitsByCategory = [
                    'dairy' => ['ml', 'litres', 'cups', 'tablespoons', 'teaspoons', 'grams', 'kg'],
                    'produce' => ['pieces', 'whole', 'grams', 'kg', 'cups', 'tablespoons'],
                    'pantry' => ['grams', 'kg', 'cups', 'tablespoons', 'teaspoons', 'ml', 'litres'],
                    'meat' => ['grams', 'kg', 'pieces', 'whole'],
                    'spices' => ['grams', 'teaspoons', 'tablespoons', 'pinch', 'dash'],
                ];

                return $unitsByCategory[$this->category] ?? ['grams', 'kg', 'ml', 'litres', 'cups', 'tablespoons', 'teaspoons', 'pieces', 'whole'];
            }
        );
    }
}
