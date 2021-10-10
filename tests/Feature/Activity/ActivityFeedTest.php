<?php

namespace Tests\Feature\Activity;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    /** @test */
    public function creating_project_records_activity()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals(
            'Project is created',
            $project->activity[0]->description
        );
    }

    /** @test */
    public function updating_project_records_activity()
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals(
            'Project is updated',
            $project->activity[1]->description
        );
    }

    /** @test */
    public function creating_project_task_records_activity()
    {
        $task = Task::factory()->create();

        $this->assertCount(2, $task->project->activity);
        $this->assertEquals(
            'Task is created',
            $task->project->activity[1]->description
        );
    }

    /** @test */
    public function completing_project_task_records_activity()
    {
        $task = Task::factory()->create();

        $task->complete();

        $this->assertCount(3, $task->project->activity);
        $this->assertEquals(
            'Task is completed',
            $task->project->activity[2]->description
        );
    }
}
