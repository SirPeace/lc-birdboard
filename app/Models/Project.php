<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public function path(): string
    {
        return "/projects/{$this->id}";
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id')
            ->oldest('created_at');
    }

    public function addTask(Task $task): void
    {
        $this->tasks()->save($task);
    }

    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class, 'project_id', 'id');
    }

    public function recordActivity(string $slug): void
    {
        $this->activity()->create([
            'slug' => $slug
        ]);
    }
}
