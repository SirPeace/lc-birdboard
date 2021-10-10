<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->recordActivity($project->id, 'Project is created');
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $this->recordActivity($project->id, 'Project is updated');
    }

    protected function recordActivity(int $projectId, string $description): void
    {
        Activity::create([
            'project_id' => $projectId,
            'description' => $description
        ]);
    }
}
