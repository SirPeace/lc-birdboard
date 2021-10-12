<?php

namespace App\Models\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    public array $oldAttributes = [];

    /**
     * Boot the model trait.
     *
     * @return void
     */
    public static function bootRecordsActivity(): void
    {
        static::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        foreach (static::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity(static::activitySlug($event));
            });
        }
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function recordActivity(string $slug): void
    {
        $activity = $this->activity()->make([
            'user_id' => ($this->project ?? $this)->owner->id,
            'slug' => $slug,
            'project_id' => $this->project_id
        ]);

        if ($this->wasChanged()) {
            $activity->setAttribute('changes', $this->activityChanges());
        }

        $activity->save();
    }

    protected function activityChanges(): array
    {
        $changes = collect($this->getChanges())->except(['updated_at']);

        return [
            'before' => $changes->map(
                fn ($_, $key) => @$this->oldAttributes[$key] ?? null
            ),
            'after' => $changes->toArray()
        ];
    }

    protected static function activitySlug(string $event): string
    {
        return strtolower(class_basename(static::class))."_{$event}";
    }

    protected static function recordableEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }
}
