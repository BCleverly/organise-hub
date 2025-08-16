<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipeIngredient extends Pivot
{
    protected $table = 'recipe_ingredient';

    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'quantity',
        'unit',
        'notes',
        'group',
        'group_order',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'group_order' => 'integer',
    ];
}
