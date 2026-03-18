<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'started_at',
        'ended_at',
        'duration_minutes',
        'description',
        'is_billable',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'is_billable' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function scopeForUser($query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    public function scopeForProject($query, int $projectId): void
    {
        $query->where('project_id', $projectId);
    }

    public function scopeActive($query): void
    {
        $query->whereNull('ended_at');
    }

    protected static function booted(): void
    {
        static::saving(function (TimeEntry $entry): void {
            if ($entry->started_at && $entry->ended_at) {
                $entry->duration_minutes = $entry->started_at->diffInMinutes($entry->ended_at);
            }
        });
    }
}
