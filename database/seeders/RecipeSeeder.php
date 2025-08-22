<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get test users
        $predefinedUsers = [
            User::firstOrCreate(
                ['email' => 'sarah@example.com'],
                [
                    'name' => 'Chef Sarah',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            ),
            User::firstOrCreate(
                ['email' => 'michael@example.com'],
                [
                    'name' => 'Chef Michael',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            ),
            User::firstOrCreate(
                ['email' => 'emma@example.com'],
                [
                    'name' => 'Chef Emma',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            ),
            User::firstOrCreate(
                ['email' => 'david@example.com'],
                [
                    'name' => 'Chef David',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            ),
        ];

        // Get all existing users from the database
        $existingUsers = User::all();

        // Combine predefined users with existing users, avoiding duplicates
        $users = collect($predefinedUsers)->merge($existingUsers)->unique('id');

        // Clear existing recipes for these users to prevent duplicates
        foreach ($users as $user) {
            $user->recipes()->delete();
        }

        // Recipe data for each user
        $recipeData = [
            // Chef Sarah's recipes (mostly desserts and breakfast)
            [
                [
                    'title' => 'Classic Chocolate Chip Cookies',
                    'description' => 'Soft and chewy chocolate chip cookies that are perfect for any occasion.',
                    'ingredients' => [
                        ['name' => 'all-purpose flour', 'quantity' => 2.25, 'unit' => 'cups', 'category' => 'pantry'],
                        ['name' => 'baking soda', 'quantity' => 1, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'salt', 'quantity' => 1, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'butter', 'quantity' => 1, 'unit' => 'cup', 'notes' => 'softened', 'category' => 'dairy'],
                        ['name' => 'granulated sugar', 'quantity' => 0.75, 'unit' => 'cup', 'category' => 'pantry'],
                        ['name' => 'brown sugar', 'quantity' => 0.75, 'unit' => 'cup', 'notes' => 'packed', 'category' => 'pantry'],
                        ['name' => 'eggs', 'quantity' => 2, 'unit' => 'large', 'category' => 'dairy'],
                        ['name' => 'vanilla extract', 'quantity' => 2, 'unit' => 'teaspoons', 'category' => 'pantry'],
                        ['name' => 'chocolate chips', 'quantity' => 2, 'unit' => 'cups', 'category' => 'pantry'],
                    ],
                    'instructions' => [
                        [
                            'instruction' => 'Preheat oven to 375°F (190°C)',
                            'step_type' => 'prep',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'Mix flour, baking soda, and salt in a small bowl',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Beat butter, granulated sugar, and brown sugar until creamy',
                            'step_type' => 'prep',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'Add eggs and vanilla; beat well',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Gradually add flour mixture; mix well',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Stir in chocolate chips',
                            'step_type' => 'prep',
                            'estimated_time' => 1,
                        ],
                        [
                            'instruction' => 'Drop by rounded tablespoon onto ungreased baking sheets',
                            'step_type' => 'prep',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'Bake for 9 to 11 minutes or until golden brown',
                            'step_type' => 'bake',
                            'estimated_time' => 10,
                        ],
                        [
                            'instruction' => 'Cool on baking sheets for 2 minutes; remove to wire racks',
                            'step_type' => 'rest',
                            'estimated_time' => 2,
                        ],
                    ],
                    'prep_time' => 15,
                    'cook_time' => 10,
                    'servings' => 24,
                    'difficulty' => 'easy',
                    'category' => 'dessert',
                    'is_public' => true,
                    'tags' => ['cookies', 'chocolate', 'dessert', 'baking'],
                ],
                [
                    'title' => 'Blueberry Pancakes',
                    'description' => 'Fluffy pancakes loaded with fresh blueberries and served with maple syrup.',
                    'ingredients' => [
                        ['name' => 'all-purpose flour', 'quantity' => 1.5, 'unit' => 'cups', 'category' => 'pantry'],
                        ['name' => 'baking powder', 'quantity' => 3.5, 'unit' => 'teaspoons', 'category' => 'pantry'],
                        ['name' => 'salt', 'quantity' => 1, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'sugar', 'quantity' => 1, 'unit' => 'tablespoon', 'category' => 'pantry'],
                        ['name' => 'milk', 'quantity' => 1.25, 'unit' => 'cups', 'category' => 'dairy'],
                        ['name' => 'egg', 'quantity' => 1, 'unit' => 'whole', 'category' => 'dairy'],
                        ['name' => 'butter', 'quantity' => 3, 'unit' => 'tablespoons', 'notes' => 'melted', 'category' => 'dairy'],
                        ['name' => 'blueberries', 'quantity' => 1, 'unit' => 'cup', 'notes' => 'fresh', 'category' => 'produce'],
                    ],
                    'instructions' => [
                        [
                            'instruction' => 'In a large bowl, sift together flour, baking powder, salt, and sugar',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Make a well in the centre and pour in milk, egg, and melted butter',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Mix until smooth',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Gently fold in blueberries',
                            'step_type' => 'prep',
                            'estimated_time' => 1,
                        ],
                        [
                            'instruction' => 'Heat a lightly oiled griddle or frying pan over medium-high heat',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake',
                            'step_type' => 'cook',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Cook until bubbles form and the edges are dry, then flip and cook until browned on the other side',
                            'step_type' => 'cook',
                            'estimated_time' => 4,
                        ],
                    ],
                    'prep_time' => 10,
                    'cook_time' => 15,
                    'servings' => 4,
                    'difficulty' => 'easy',
                    'category' => 'breakfast',
                    'is_public' => true,
                    'tags' => ['breakfast', 'pancakes', 'blueberries', 'quick'],
                ],
            ],
            // Chef Michael's recipes (mostly main courses)
            [
                [
                    'title' => 'Grilled Salmon with Lemon Herb Butter',
                    'description' => 'Perfectly grilled salmon fillet with a flavorful lemon herb butter sauce.',
                    'ingredients' => [
                        ['name' => 'salmon fillets', 'quantity' => 4, 'unit' => 'pieces', 'notes' => '6 oz each', 'category' => 'meat'],
                        ['name' => 'butter', 'quantity' => 0.25, 'unit' => 'cup', 'notes' => 'softened', 'category' => 'dairy'],
                        ['name' => 'lemon juice', 'quantity' => 2, 'unit' => 'tablespoons', 'category' => 'produce'],
                        ['name' => 'fresh dill', 'quantity' => 2, 'unit' => 'tablespoons', 'notes' => 'chopped', 'category' => 'produce'],
                        ['name' => 'fresh parsley', 'quantity' => 2, 'unit' => 'tablespoons', 'notes' => 'chopped', 'category' => 'produce'],
                        ['name' => 'garlic', 'quantity' => 2, 'unit' => 'cloves', 'notes' => 'minced', 'category' => 'produce'],
                        ['name' => 'salt', 'quantity' => null, 'unit' => null, 'notes' => 'to taste', 'category' => 'pantry'],
                        ['name' => 'black pepper', 'quantity' => null, 'unit' => null, 'notes' => 'to taste', 'category' => 'pantry'],
                        ['name' => 'lemon', 'quantity' => 1, 'unit' => 'whole', 'notes' => 'for serving', 'category' => 'produce'],
                    ],
                    'instructions' => [
                        [
                            'instruction' => 'Preheat grill to medium-high heat',
                            'step_type' => 'prep',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'In a small bowl, mix butter, lemon juice, dill, parsley, and garlic',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Season salmon fillets with salt and pepper',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Place salmon on preheated grill, skin side down',
                            'step_type' => 'cook',
                            'estimated_time' => 1,
                        ],
                        [
                            'instruction' => 'Grill for 4-5 minutes, then carefully flip',
                            'step_type' => 'cook',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'Grill for another 4-5 minutes until fish flakes easily',
                            'step_type' => 'cook',
                            'estimated_time' => 5,
                        ],
                        [
                            'instruction' => 'Top with lemon herb butter and serve with lemon wedges',
                            'step_type' => 'serve',
                            'estimated_time' => 2,
                        ],
                    ],
                    'prep_time' => 10,
                    'cook_time' => 10,
                    'servings' => 4,
                    'difficulty' => 'medium',
                    'category' => 'main_course',
                    'is_public' => true,
                    'tags' => ['seafood', 'grilled', 'healthy', 'dinner'],
                ],
            ],
            // Chef Emma's recipes (mostly appetizers and snacks)
            [
                [
                    'title' => 'Guacamole',
                    'description' => 'Fresh and creamy guacamole with the perfect balance of flavors.',
                    'ingredients' => [
                        ['name' => 'avocados', 'quantity' => 3, 'unit' => 'whole', 'notes' => 'ripe', 'category' => 'produce'],
                        ['name' => 'lime', 'quantity' => 1, 'unit' => 'whole', 'notes' => 'juiced', 'category' => 'produce'],
                        ['name' => 'salt', 'quantity' => 0.5, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'ground cumin', 'quantity' => 0.5, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'cayenne pepper', 'quantity' => 0.5, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'onion', 'quantity' => 0.5, 'unit' => 'medium', 'notes' => 'diced', 'category' => 'produce'],
                        ['name' => 'roma tomatoes', 'quantity' => 2, 'unit' => 'whole', 'notes' => 'diced', 'category' => 'produce'],
                        ['name' => 'fresh cilantro', 'quantity' => 1, 'unit' => 'tablespoon', 'notes' => 'chopped', 'category' => 'produce'],
                        ['name' => 'garlic', 'quantity' => 1, 'unit' => 'clove', 'notes' => 'minced', 'category' => 'produce'],
                    ],
                    'instructions' => [
                        [
                            'instruction' => 'In a large bowl, mash avocados with a fork',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Stir in lime juice, salt, cumin, and cayenne pepper',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Fold in onion, tomatoes, cilantro, and garlic',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Let sit at room temperature for 1 hour before serving',
                            'step_type' => 'rest',
                            'estimated_time' => 60,
                        ],
                        [
                            'instruction' => 'Serve with tortilla chips',
                            'step_type' => 'serve',
                            'estimated_time' => 1,
                        ],
                    ],
                    'prep_time' => 15,
                    'cook_time' => 0,
                    'servings' => 6,
                    'difficulty' => 'easy',
                    'category' => 'appetizer',
                    'is_public' => true,
                    'tags' => ['mexican', 'dip', 'avocado', 'party'],
                ],
            ],
            // Chef David's recipes (mixed categories)
            [
                [
                    'title' => 'French Toast',
                    'description' => 'Delicious French toast made with thick bread and a rich custard mixture.',
                    'ingredients' => [
                        ['name' => 'bread', 'quantity' => 6, 'unit' => 'slices', 'notes' => 'thick', 'category' => 'pantry'],
                        ['name' => 'eggs', 'quantity' => 2, 'unit' => 'large', 'category' => 'dairy'],
                        ['name' => 'milk', 'quantity' => 0.5, 'unit' => 'cup', 'category' => 'dairy'],
                        ['name' => 'heavy cream', 'quantity' => 0.25, 'unit' => 'cup', 'category' => 'dairy'],
                        ['name' => 'vanilla extract', 'quantity' => 1, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'ground cinnamon', 'quantity' => 0.5, 'unit' => 'teaspoon', 'category' => 'pantry'],
                        ['name' => 'butter', 'quantity' => 2, 'unit' => 'tablespoons', 'category' => 'dairy'],
                        ['name' => 'maple syrup', 'quantity' => null, 'unit' => null, 'notes' => 'for serving', 'category' => 'pantry'],
                    ],
                    'instructions' => [
                        [
                            'instruction' => 'In a shallow dish, whisk together eggs, milk, cream, vanilla, and cinnamon',
                            'step_type' => 'prep',
                            'estimated_time' => 3,
                        ],
                        [
                            'instruction' => 'Heat butter in a large skillet over medium heat',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Dip bread slices in egg mixture, coating both sides',
                            'step_type' => 'prep',
                            'estimated_time' => 2,
                        ],
                        [
                            'instruction' => 'Place in skillet and cook for 2-3 minutes per side until golden brown',
                            'step_type' => 'cook',
                            'estimated_time' => 6,
                        ],
                        [
                            'instruction' => 'Serve hot with maple syrup',
                            'step_type' => 'serve',
                            'estimated_time' => 1,
                        ],
                    ],
                    'prep_time' => 10,
                    'cook_time' => 10,
                    'servings' => 3,
                    'difficulty' => 'easy',
                    'category' => 'breakfast',
                    'is_public' => true,
                    'tags' => ['breakfast', 'french', 'sweet', 'quick'],
                ],
            ],
        ];

        // Create recipes for each user
        foreach ($users as $index => $user) {
            // Only create recipes if we have recipe data for this index
            if (isset($recipeData[$index])) {
                foreach ($recipeData[$index] as $recipeInfo) {
                    $tags = $recipeInfo['tags'];
                    $ingredients = $recipeInfo['ingredients'];
                    $instructions = $recipeInfo['instructions'];
                    unset($recipeInfo['tags'], $recipeInfo['ingredients'], $recipeInfo['instructions']);

                    $recipe = $user->recipes()->create($recipeInfo);
                    $recipe->syncTags($tags);
                    $recipe->attachIngredients($ingredients);
                    $recipe->attachInstructions($instructions);
                }
            }
        }

        // Output info if running from command
        if ($this->command) {
            $this->command->info('Recipe seeder completed!');
            $this->command->info('Created '.count($users).' users with recipes');
            $this->command->info('Total recipes created: '.Recipe::count());
            $this->command->info('Total ingredients created: '.\App\Models\Ingredient::count());
            $this->command->info('Total instructions created: '.\App\Models\RecipeInstruction::count());
        }
    }
}
