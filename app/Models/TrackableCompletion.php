<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackableCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'trackable_id',
        'user_id',
        'completed_date',
        'count',
        'duration_minutes',
        'notes',
    ];

    protected $casts = [
        'completed_date' => 'date',
    ];

    /**
     * Get the trackable that owns the completion.
     */
    public function trackable(): BelongsTo
    {
        return $this->belongsTo(Trackable::class);
    }

    /**
     * Get the user that owns the completion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include completions for a specific user.
     */
    public function scopeForUser($query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include completions for a specific date range.
     */
    public function scopeForDateRange($query, string $startDate, string $endDate): void
    {
        $query->whereBetween('completed_date', [$startDate, $endDate]);
    }
}
