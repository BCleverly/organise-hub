<?php

namespace App\Livewire\Recipes;

use App\Actions\Recipes\DeleteRecipe;
use App\Models\Recipe;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.app')]
class RecipeDetail extends Component
{
    public Recipe $recipe;

    public bool $showDeleteConfirmation = false;

    // Locked properties for sensitive data
    #[Locked]
    public int $userId;

    #[Computed]
    public function isOwner(): bool
    {
        return $this->recipe->user_id === $this->userId;
    }

    #[Computed]
    public function canEdit(): bool
    {
        return $this->isOwner() || auth()->user()->can('edit', $this->recipe);
    }

    #[Computed]
    public function canDelete(): bool
    {
        return $this->isOwner() || auth()->user()->can('delete', $this->recipe);
    }

    #[Computed]
    public function totalTime(): int
    {
        return ($this->recipe->prep_time ?? 0) + ($this->recipe->cook_time ?? 0);
    }

    #[Computed]
    public function reactionSummary(): array
    {
        return $this->recipe->reaction_summary->toArray();
    }

    #[Computed]
    public function isLikedByCurrentUser(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        return $this->recipe->isReactBy(auth()->user());
    }

    #[Computed]
    public function likeCount(): int
    {
        return $this->reactionSummary()['like'] ?? 0;
    }

    public function mount(Recipe $recipe): void
    {
        $this->recipe = $recipe->load(['ingredients', 'instructions', 'tags', 'user']);
        $this->userId = (int) (auth()->id() ?? 0);
    }

    public function toggleLike(): void
    {
        if (!auth()->check()) {
            // Redirect to login or show message
            session()->flash('error', 'Please log in to like recipes.');
            return;
        }

        $user = auth()->user();
        
        if ($this->isLikedByCurrentUser()) {
            // Remove like
            $user->removeReactionFrom($this->recipe);
            session()->flash('message', 'Recipe unliked!');
        } else {
            // Add like
            $user->reactTo($this->recipe, 'like');
            session()->flash('message', 'Recipe liked!');
        }

        // Refresh the recipe to get updated reaction data
        $this->recipe->refresh();
    }

    public function deleteRecipe(DeleteRecipe $deleteRecipe): mixed
    {
        if (! $this->canDelete()) {
            abort(403, 'You do not have permission to delete this recipe.');
        }

        $deleteRecipe->handle($this->recipe);
        session()->flash('message', 'Recipe deleted successfully!');

        return $this->redirectRoute('recipes');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.recipes.recipe-detail');
    }
}
