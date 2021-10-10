<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

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
        if ($this->completed === false) {
            $this->update(['completed' => true]);

            $this->project->recordActivity('task_completed');
        }
    }

    public function incomplete(): void
    {
        if ($this->completed === true) {
            $this->update(['completed' => false]);

            $this->project->recordActivity('task_incompleted');
        }
    }
}
