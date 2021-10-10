<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $touches = ['project'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function path(): string
    {
        return "/tasks/$this->id";
    }

    public function complete(): void
    {
        $this->update(['completed' => true]);

        $this->project->recordActivity('task_completed');
    }

    public function incomplete(): void
    {
        $this->update(['completed' => false]);
    }
}
