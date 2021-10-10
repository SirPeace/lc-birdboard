<?php

namespace Tests\Feature\Activity;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class RecordProjectActivityTest extends TestCase
{
    /** @test */
    public function creating_project()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->last()->slug);
    }

    /** @test */
    public function updating_project()
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->slug);
    }

    /** @test */
    public function creating_task()
    {
        $task = Task::factory()->create();

        $this->assertCount(2, $task->project->activity);

        $lastActivity = $task->project->activity->last();

        $this->assertEquals('task_created', $lastActivity->slug);
        $this->assertTrue($lastActivity->subject->is($task));
    }

    /** @test */
    public function completing_task()
    {
        $task = Task::factory()->create();

        $task->complete();

        $this->assertCount(3, $task->project->activity);

        $lastActivity = $task->project->activity->last();

        $this->assertEquals('task_completed', $lastActivity->slug);
        $this->assertTrue($lastActivity->subject->is($task));
    }

    /** @test */
    public function incompleting_task()
    {
        $task = Task::factory()->create(['completed' => true]);

        $task->incomplete();

        $this->assertCount(3, $task->project->activity);

        $lastActivity = $task->project->activity->last();

        $this->assertEquals('task_incompleted', $lastActivity->slug);
        $this->assertTrue($lastActivity->subject->is($task));
    }

    /** @test */
    public function deleting_task()
    {
        $task = Task::factory()->create();

        $task->delete();

        $this->assertCount(3, $task->project->activity);

        $lastActivity = $task->project->activity->last();

        $this->assertEquals('task_deleted', $lastActivity->slug);
    }
}
