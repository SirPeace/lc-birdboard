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
            'created',
            $project->activity[0]->slug
        );
    }

    /** @test */
    public function updating_project_records_activity()
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals(
            'updated',
            $project->activity[1]->slug
        );
    }

    /** @test */
    public function creating_task_records_project_activity()
    {
        $task = Task::factory()->create();

        $this->assertCount(2, $task->project->activity);
        $this->assertEquals(
            'task_created',
            $task->project->activity[1]->slug
        );
    }

    /** @test */
    public function completing_task_records_project_activity()
    {
        $task = Task::factory()->create();

        $task->complete();

        $this->assertCount(3, $task->project->activity);
        $this->assertEquals(
            'task_completed',
            $task->project->activity[2]->slug
        );
    }
}
