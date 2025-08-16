<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Tags\HasTags;

class Trackable extends Model
{
    use HasFactory, HasTags;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'goal_metric',
        'parent_skill_id',
        'target_count',
        'target_duration_minutes',
        'frequency',
        'frequency_days',
        'current_streak',
        'longest_streak',
        'last_completed_at',
        'is_active',
        'progress_percentage',
        'target_completion_date',
    ];

    protected $casts = [
        'frequency_days' => 'array',
        'last_completed_at' => 'date',
        'target_completion_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the trackable.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent skill (for habits).
     */
    public function parentSkill(): BelongsTo
    {
        return $this->belongsTo(Trackable::class, 'parent_skill_id');
    }

    /**
     * Get the child habits (for skills).
     */
    public function childHabits(): HasMany
    {
        return $this->hasMany(Trackable::class, 'parent_skill_id')->where('type', 'HABIT');
    }

    /**
     * Get all completions for this trackable.
     */
    public function completions(): HasMany
    {
        return $this->hasMany(TrackableCompletion::class);
    }

    /**
     * Get today's completion.
     */
    public function todayCompletion(): HasOne
    {
        return $this->hasOne(TrackableCompletion::class)->where('completed_date', today());
    }

    /**
     * Check if the trackable is completed today.
     */
    public function isCompletedToday(): bool
    {
        return $this->todayCompletion()->exists();
    }

    /**
     * Get the completion count for today.
     */
    public function getTodayCount(): int
    {
        return $this->todayCompletion?->count ?? 0;
    }

    /**
     * Get the duration for today.
     */
    public function getTodayDuration(): int
    {
        return $this->todayCompletion?->duration_minutes ?? 0;
    }

    /**
     * Check if this trackable should be shown today based on frequency.
     */
    public function shouldShowToday(): bool
    {
        if ($this->type === 'SKILL') {
            return true; // Skills are always shown
        }

        if (!$this->frequency) {
            return true; // Default to daily if no frequency set
        }

        switch ($this->frequency) {
            case 'daily':
                return true;
            case 'weekly':
                // Show on frequency_days or default to Monday
                $days = $this->frequency_days ?? [1]; // Monday = 1
                return in_array(now()->dayOfWeek, $days);
            case 'monthly':
                // Show on frequency_days or default to 1st of month
                $days = $this->frequency_days ?? [1];
                return in_array(now()->day, $days);
            default:
                return true;
        }
    }

    /**
     * Mark the trackable as completed for today.
     */
    public function markCompletedToday(int $count = 1, ?int $durationMinutes = null, ?string $notes = null): void
    {
        $this->completions()->updateOrCreate(
            ['completed_date' => today()],
            [
                'user_id' => $this->user_id,
                'count' => $count,
                'duration_minutes' => $durationMinutes,
                'notes' => $notes,
            ]
        );

        $this->update([
            'last_completed_at' => today(),
            'current_streak' => $this->calculateCurrentStreak(),
            'longest_streak' => max($this->longest_streak, $this->calculateCurrentStreak()),
        ]);

        // Update skill progress if this is a habit with a parent skill
        if ($this->type === 'HABIT' && $this->parent_skill_id) {
            $this->parentSkill->updateProgress();
        }
    }

    /**
     * Calculate the current streak.
     */
    public function calculateCurrentStreak(): int
    {
        $streak = 0;
        $currentDate = today();

        while (true) {
            $completion = $this->completions()
                ->where('completed_date', $currentDate)
                ->first();

            if (!$completion) {
                break;
            }

            $streak++;
            $currentDate = $currentDate->subDay();
        }

        return $streak;
    }

    /**
     * Update progress percentage for skills.
     */
    public function updateProgress(): void
    {
        if ($this->type !== 'SKILL') {
            return;
        }

        $totalHabits = $this->childHabits()->count();
        if ($totalHabits === 0) {
            return;
        }

        $completedHabits = $this->childHabits()
            ->whereHas('completions', function ($query) {
                $query->where('completed_date', today());
            })
            ->count();

        $progress = round(($completedHabits / $totalHabits) * 100);
        $this->update(['progress_percentage' => $progress]);
    }

    /**
     * Scope a query to only include trackables for a specific user.
     */
    public function scopeForUser($query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include active trackables.
     */
    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope a query to only include habits.
     */
    public function scopeHabits($query): void
    {
        $query->where('type', 'HABIT');
    }

    /**
     * Scope a query to only include skills.
     */
    public function scopeSkills($query): void
    {
        $query->where('type', 'SKILL');
    }

    /**
     * Scope a query to only include trackables that should be shown today.
     */
    public function scopeForToday($query): void
    {
        $query->where(function ($q) {
            $q->where('type', 'SKILL')
                ->orWhere(function ($subQ) {
                    $subQ->where('type', 'HABIT')
                        ->where(function ($freqQ) {
                            $freqQ->whereNull('frequency')
                                ->orWhere('frequency', 'daily')
                                ->orWhere(function ($weeklyQ) {
                                    $weeklyQ->where('frequency', 'weekly')
                                        ->whereJsonContains('frequency_days', now()->dayOfWeek);
                                })
                                ->orWhere(function ($monthlyQ) {
                                    $monthlyQ->where('frequency', 'monthly')
                                        ->whereJsonContains('frequency_days', now()->day);
                                });
                        });
                });
        });
    }
}
