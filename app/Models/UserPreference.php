<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array',
    ];

    /**
     * Get the user that owns the preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a specific preference value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->preferences, $key, $default);
    }

    /**
     * Set a preference value.
     */
    public function set(string $key, mixed $value): void
    {
        $preferences = $this->preferences ?? [];
        data_set($preferences, $key, $value);
        $this->preferences = $preferences;
        $this->save();
    }

    /**
     * Remove a preference value.
     */
    public function remove(string $key): void
    {
        $preferences = $this->preferences ?? [];
        data_forget($preferences, $key);
        $this->preferences = $preferences;
        $this->save();
    }

    /**
     * Check if a preference exists.
     */
    public function has(string $key): bool
    {
        return data_get($this->preferences, $key) !== null;
    }
}
