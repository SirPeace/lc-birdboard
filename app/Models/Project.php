<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory, RecordsActivity;

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
        return $this->hasMany(Activity::class, 'project_id', 'id')->latest();
    }

    protected static function recordableEvents(): array
    {
        return ['created', 'updated'];
    }

    public function invite(User $user): void
    {
        if (auth()->id() !== $this->owner->id) {
            return;
        }

        $this->members()->attach($user);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
