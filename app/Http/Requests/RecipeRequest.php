<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prep_time' => ['nullable', 'integer', 'min:0'],
            'cook_time' => ['nullable', 'integer', 'min:0'],
            'servings' => ['nullable', 'integer', 'min:1'],
            'difficulty' => ['required', 'string', Rule::in(['easy', 'medium', 'hard'])],
            'category' => ['required', 'string', Rule::in(['main_course', 'appetizer', 'dessert', 'breakfast', 'snacks'])],
            'is_public' => ['boolean'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:50'],
            'ingredients' => ['array'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity' => ['nullable', 'string', 'max:50'],
            'ingredients.*.unit' => ['nullable', 'string', 'max:50'],
            'ingredients.*.notes' => ['nullable', 'string', 'max:255'],
            'instructions' => ['array'],
            'instructions.*.instruction' => ['required', 'string'],
            'instructions.*.estimated_time' => ['nullable', 'integer', 'min:0'],
            'instructions.*.step_type' => ['nullable', 'string', 'max:50'],
            'instructions.*.notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A recipe title is required.',
            'title.max' => 'The recipe title cannot exceed 255 characters.',
            'difficulty.in' => 'Please select a valid difficulty level.',
            'category.in' => 'Please select a valid category.',
            'ingredients.*.name.required' => 'Each ingredient must have a name.',
            'instructions.*.instruction.required' => 'Each instruction step must have content.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'recipe title',
            'description' => 'recipe description',
            'prep_time' => 'preparation time',
            'cook_time' => 'cooking time',
            'servings' => 'number of servings',
            'difficulty' => 'difficulty level',
            'category' => 'recipe category',
            'is_public' => 'public visibility',
            'tags' => 'recipe tags',
            'ingredients' => 'recipe ingredients',
            'instructions' => 'recipe instructions',
        ];
    }
}
