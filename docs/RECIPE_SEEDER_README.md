# Recipe Seeder Documentation

This document explains how to use the recipe seeding functionality for testing and development.

## Overview

The recipe seeder creates realistic test data for the recipe feature, including:
- 4 test users with different cooking specialties
- 5 recipes across various categories and difficulty levels
- Proper tagging system implementation
- Mix of public and private recipes
- **New**: Structured ingredient system with quantities, units, and categories
- **New**: Ingredient reuse across recipes to save database space
- **New**: Step-by-step instruction system with timing and categorization

## Quick Start

### Basic Seeding
To seed the database with recipe data:

```bash
php artisan seed:recipes
```

### Fresh Database Seeding
To start with a fresh database (drops all tables and runs migrations):

```bash
php artisan seed:recipes --fresh
```

## Test Users Created

The seeder creates 4 test users with different specialties:

1. **Chef Sarah** (sarah@example.com)
   - Specialises in desserts and breakfast
   - Recipes: Chocolate Chip Cookies, Blueberry Pancakes, Tiramisu

2. **Chef Michael** (michael@example.com)
   - Specialises in main courses
   - Recipes: Grilled Salmon, Beef Stir Fry, Homemade Pizza

3. **Chef Emma** (emma@example.com)
   - Specialises in appetizers and snacks
   - Recipes: Guacamole, Bruschetta, Energy Balls

4. **Chef David** (david@example.com)
   - Mixed categories
   - Recipes: Chicken Tikka Masala, Caesar Salad, French Toast

**All users have password: `password`**

## Recipe Categories

The seeder creates recipes in the following categories:
- **main_course**: Hearty dishes like salmon, stir fry, pizza
- **dessert**: Sweet treats like cookies, tiramisu, lava cake
- **breakfast**: Morning meals like pancakes, French toast, yogurt parfait
- **appetizer**: Starters like guacamole, bruschetta, Caesar salad
- **snacks**: Quick bites like energy balls

## Recipe Difficulties

Recipes are distributed across difficulty levels:
- **easy**: Quick recipes with simple instructions
- **medium**: Moderate complexity with multiple steps
- **hard**: Complex recipes requiring advanced techniques

## Recipe Data Structure

Each recipe includes:
- **Title**: Descriptive recipe name
- **Description**: Brief overview of the dish
- **Ingredients**: Structured ingredient list with quantities, units, and notes
- **Instructions**: Step-by-step cooking instructions
- **Prep Time**: Preparation time in minutes
- **Cook Time**: Cooking time in minutes
- **Servings**: Number of people the recipe serves
- **Difficulty**: easy/medium/hard
- **Category**: Recipe category
- **Tags**: Relevant tags for filtering and search
- **Public/Private**: Visibility setting

### Ingredient System

The new ingredient system provides:
- **Ingredient Database**: Centralised ingredient storage with categories
- **Quantity & Units**: Precise measurements (cups, grams, tablespoons, etc.)
- **Notes**: Additional instructions (e.g., "softened", "finely chopped")
- **Categories**: dairy, produce, pantry, meat, spices
- **Allergen Tracking**: Flag ingredients that are common allergens
- **Reuse**: Same ingredient can be used across multiple recipes
- **Order**: Maintains ingredient order in recipes

### Instruction System

The new instruction system provides:
- **Step-by-Step Instructions**: Individual steps with sequential numbering
- **Step Types**: Categorization (prep, cook, bake, rest, serve, chill, garnish)
- **Estimated Times**: Time estimates for each step in minutes
- **Notes**: Additional tips or warnings for specific steps
- **Order Management**: Automatic step numbering and ordering
- **Flexibility**: Support for various cooking techniques and methods

## Testing

### Running Tests
To run the recipe seeder tests:

```bash
php artisan test tests/Feature/RecipeSeederTest.php
```

### Test Coverage
The test suite covers:
- ✅ User and recipe creation
- ✅ Category and difficulty distribution
- ✅ User-recipe relationships
- ✅ Tag attachment and validation
- ✅ Time calculations and formatting
- ✅ Model scopes (public, category, difficulty)
- ✅ Recipe factory functionality
- ✅ Multiple seeder runs (idempotency)
- ✅ **New**: Ingredient system and relationships
- ✅ **New**: Ingredient categories and allergen tracking
- ✅ **New**: Ingredient factory functionality
- ✅ **New**: Pivot table data validation
- ✅ **New**: Instruction system and step management
- ✅ **New**: Instruction step types and timing
- ✅ **New**: Instruction factory functionality

### Manual Testing
After seeding, you can:

1. **Login as test users**:
   - Use any of the test user emails with password `password`

2. **Browse recipes**:
   - View public recipes
   - Filter by category, difficulty, or tags
   - Test search functionality

3. **Test recipe features**:
   - View recipe details
   - Check time calculations
   - Verify tag filtering

## Database Statistics

After running the seeder, you'll have:
- **4 users** with verified email addresses
- **5 recipes** with complete data
- **5 public recipes** with proper tagging
- **Multiple categories** and **difficulty levels**
- **32 unique ingredients** across 4 categories
- **32 recipe-ingredient relationships** with quantities and units
- **33 recipe instructions** with step-by-step guidance
- **Ingredient reuse** - same ingredients used across multiple recipes
- **Structured instructions** - categorized steps with timing estimates

## Troubleshooting

### Common Issues

1. **Duplicate User Error**
   - The seeder now uses `firstOrCreate` to handle existing users
   - Existing recipes for test users will be cleared and recreated

2. **Mass Assignment Error**
   - Fixed by adding `email_verified_at` to User model fillable array

3. **Missing Tags**
   - Ensure the Spatie Tags package is properly installed and migrated

4. **Duplicate Ingredient Error**
   - The seeder handles duplicate ingredients within recipes
   - Ingredients are reused across recipes to save database space

5. **Ingredient Relationship Issues**
   - Ensure the pivot table migration has been run
   - Check that the Recipe model has the `attachIngredients` method

6. **Instruction System Issues**
   - Ensure the recipe_instructions table migration has been run
   - Check that the Recipe model has the `attachInstructions` method
   - Verify step numbers are unique within each recipe

### Reset Database
If you need to start completely fresh:

```bash
php artisan migrate:fresh --seed
```

This will run all migrations and seeders, including the recipe seeder.

## Development Workflow

### For Feature Development
1. Run `php artisan seed:recipes --fresh` to get a clean database
2. Develop your feature using the test data
3. Run tests to ensure everything works
4. Commit your changes

### For Testing
1. Use the existing test suite for automated testing
2. Add new tests to `tests/Feature/RecipeSeederTest.php` as needed
3. Ensure all tests pass before committing

## Customization

### Adding New Recipes
To add new recipes, edit `database/seeders/RecipeSeeder.php`:

1. Add recipe data to the `$recipeData` array
2. Include all required fields
3. Add appropriate tags
4. Run the seeder to test

### Modifying Test Users
To change test users:

1. Update the user creation section in the seeder
2. Modify the recipe assignments
3. Update the test expectations if needed

### Adding New Categories
To add new recipe categories:

1. Update the Recipe model's category validation
2. Add recipes with the new category
3. Update tests to include the new category

## Integration with Other Features

The recipe seeder is designed to work with:
- **User authentication** (verified users)
- **Tag system** (Spatie Tags)
- **Recipe permissions** (public/private)
- **Search and filtering** (tags, categories, difficulty)
- **Time calculations** (prep + cook time)
- **Ingredient management** (categories, allergens, quantities)
- **Recipe scaling** (adjust quantities based on servings)
- **Shopping lists** (aggregate ingredients across recipes)
- **Nutritional analysis** (based on ingredient data)
- **Step-by-step cooking guides** (instruction management)
- **Cooking timers** (based on step timing)
- **Progress tracking** (step completion)
- **Recipe sharing** (structured instruction format)

This provides a solid foundation for testing all recipe-related features in your application.
