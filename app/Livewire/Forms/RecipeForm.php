<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RecipeForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string')]
    public ?string $description = '';

    #[Validate('nullable|integer|min:0')]
    public ?int $prep_time = null;

    #[Validate('nullable|integer|min:0')]
    public ?int $cook_time = null;

    #[Validate('nullable|integer|min:1')]
    public ?int $servings = null;

    #[Validate('required|string|in:easy,medium,hard')]
    public string $difficulty = 'medium';

    #[Validate('required|string|in:main_course,appetizer,dessert,breakfast,snacks')]
    public string $category = 'main_course';

    #[Validate('boolean')]
    public bool $is_public = false;

    #[Validate('array')]
    /** @var array<int, string> */
    public array $tags = [];

    #[Validate('array')]
    /** @var array<int, array<string, mixed>> */
    public array $ingredients = [];

    #[Validate('array')]
    /** @var array<int, array<string, mixed>> */
    public array $instructions = [];

    public string $newTag = '';

    public string $ingredientName = '';

    public string $ingredientQuantity = '';

    public string $ingredientUnit = '';

    public string $ingredientNotes = '';

    public string $ingredientGroup = '';

    public string $instructionText = '';

    public ?int $instructionTime = null;

    public string $instructionType = 'prep';

    public string $instructionNotes = '';

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'category' => ['required', 'string', 'in:main_course,appetizer,dessert,breakfast,snacks'],
            'tags.*' => ['string', 'max:50'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity' => ['nullable', 'string', 'max:50'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:50'],
            'ingredients.*.notes' => ['nullable', 'string', 'max:255'],
            'ingredients.*.group' => ['nullable', 'string', 'max:100'],
            'instructions.*.instruction' => ['required', 'string'],
            'instructions.*.estimated_time' => ['nullable', 'integer', 'min:0'],
            'instructions.*.step_type' => ['nullable', 'string', 'max:50'],
            'instructions.*.notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function addTag(): void
    {
        $trimmedTag = trim($this->newTag);
        if (! empty($trimmedTag) && ! in_array($trimmedTag, $this->tags)) {
            $this->tags[] = $trimmedTag;
            $this->newTag = '';
        }
    }

    public function removeTag(int $index): void
    {
        if (isset($this->tags[$index])) {
            unset($this->tags[$index]);
            $this->tags = array_values($this->tags);
        }
    }

    public function addIngredient(): void
    {
        if (! empty($this->ingredientName)) {
            $this->ingredients[] = [
                'name' => trim($this->ingredientName),
                'quantity' => trim($this->ingredientQuantity),
                'unit' => trim($this->ingredientUnit),
                'notes' => trim($this->ingredientNotes),
                'group' => trim($this->ingredientGroup),
            ];

            // Reset form fields
            $this->ingredientName = '';
            $this->ingredientQuantity = '';
            $this->ingredientUnit = '';
            $this->ingredientNotes = '';
            $this->ingredientGroup = '';
        }
    }

    public function removeIngredient(int $index): void
    {
        if (isset($this->ingredients[$index])) {
            unset($this->ingredients[$index]);
            $this->ingredients = array_values($this->ingredients);
        }
    }

    public function addInstruction(): void
    {
        if (! empty($this->instructionText)) {
            $this->instructions[] = [
                'instruction' => trim($this->instructionText),
                'estimated_time' => $this->instructionTime,
                'step_type' => $this->instructionType,
                'notes' => trim($this->instructionNotes),
            ];

            // Reset form fields
            $this->instructionText = '';
            $this->instructionTime = null;
            $this->instructionType = 'prep';
            $this->instructionNotes = '';
        }
    }

    public function removeInstruction(int $index): void
    {
        if (isset($this->instructions[$index])) {
            unset($this->instructions[$index]);
            $this->instructions = array_values($this->instructions);
        }
    }

    public function moveInstructionUp(int $index): void
    {
        if ($index > 0 && isset($this->instructions[$index])) {
            $temp = $this->instructions[$index];
            $this->instructions[$index] = $this->instructions[$index - 1];
            $this->instructions[$index - 1] = $temp;
        }
    }

    public function moveInstructionDown(int $index): void
    {
        if ($index < count($this->instructions) - 1 && isset($this->instructions[$index])) {
            $temp = $this->instructions[$index];
            $this->instructions[$index] = $this->instructions[$index + 1];
            $this->instructions[$index + 1] = $temp;
        }
    }

    public function getTotalTime(): int
    {
        return ($this->prep_time ?? 0) + ($this->cook_time ?? 0);
    }

    public function hasIngredients(): bool
    {
        return count($this->ingredients) > 0;
    }

    public function hasInstructions(): bool
    {
        return count($this->instructions) > 0;
    }
}
