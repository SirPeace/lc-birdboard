<?php

namespace App\Models;

use App\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory, RecordsActivity;

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

            $this->recordActivity('task_completed');
        }
    }

    public function incomplete(): void
    {
        if ($this->completed === true) {
            $this->update(['completed' => false]);

            $this->recordActivity('task_incompleted');
        }
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected static function recordableEvents(): array
    {
        return ['created', 'deleted'];
    }
}
