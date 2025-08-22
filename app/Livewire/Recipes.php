<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithUserPreferences;
use App\Models\Recipe;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Recipes extends Component
{
    use WithPagination, WithUserPreferences;

    #[Url]
    public string $search = '';

    #[Url]
    public string $categoryFilter = '';

    #[Url]
    public string $difficultyFilter = '';

    #[Url]
    public string $viewMode = 'my'; // 'my', 'discover', or 'favourites'

    /** @var array<string, string> */
    protected $listeners = [
        'recipe-saved' => '$refresh',
    ];

    #[Computed]
    public function recipes(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Recipe::query()
            ->when($this->search, function ($query) {
                $searchTerm = '%'.$this->search.'%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('ingredients', 'like', $searchTerm);
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->withCategory($this->categoryFilter);
            })
            ->when($this->difficultyFilter, function ($query) {
                $query->withDifficulty($this->difficultyFilter);
            });

        // Filter by view mode
        if ($this->viewMode === 'my') {
            $query->forUser((int) (auth()->id() ?? 0));
        } elseif ($this->viewMode === 'favourites') {
            if (! auth()->check()) {
                return collect()->paginate(12);
            }
            $query->whereReactedBy(auth()->user());
        } else {
            $query->public();
        }

        return $query->with(['user', 'tags'])->orderBy('created_at', 'desc')->paginate(12);
    }

    #[Computed]
    /**
     * @return array<string, string>
     */
    public function categories(): array
    {
        return [
            'main_course' => 'Main Course',
            'appetizer' => 'Appetizer',
            'dessert' => 'Dessert',
            'breakfast' => 'Breakfast',
            'snacks' => 'Snacks',
        ];
    }

    #[Computed]
    /**
     * @return array<string, string>
     */
    public function difficulties(): array
    {
        return [
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard',
        ];
    }

    #[Computed]
    public function hasFilters(): bool
    {
        return ! empty($this->search) || ! empty($this->categoryFilter) || ! empty($this->difficultyFilter);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDifficultyFilter(): void
    {
        $this->resetPage();
    }

    public function updatingViewMode(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'categoryFilter', 'difficultyFilter']);
        $this->resetPage();
    }

    public function toggleLike(int $recipeId): void
    {
        if (! auth()->check()) {
            session()->flash('error', 'Please log in to like recipes.');

            return;
        }

        $recipe = Recipe::findOrFail($recipeId);
        $user = auth()->user();

        if ($recipe->isReactBy($user)) {
            // Remove like
            $user->removeReactionFrom($recipe);
            session()->flash('message', 'Recipe unliked!');
        } else {
            // Add like
            $user->reactTo($recipe, 'like');
            session()->flash('message', 'Recipe liked!');
        }
    }

    public function render(): \Illuminate\View\View
    {
        $this->injectUserPreferences();

        return view('livewire.recipes', [
            'recipes' => $this->recipes(),
            'categories' => $this->categories(),
            'difficulties' => $this->difficulties(),
        ]);
    }
}
