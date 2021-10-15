<?php

namespace Tests\Feature\Projects;

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

        $activity = $project->activity->last();

        $this->assertEquals('project_created', $activity->slug);
        $this->assertNull($activity->changes);
    }

    /** @test */
    public function updating_project()
    {
        $project = Project::factory()->create();
        $original = $project->getAttributes();

        $project->update([
            'title' => 'Changed',
            'description' => 'Updated',
            'notes' => 'Added'
        ]);

        $this->assertCount(2, $project->activity);

        $activity = $project->activity->last();
        $expectedChanges = [
            'before' => [
                'title' => $original['title'],
                'description' => $original['description'],
                'notes' => null,
            ],
            'after' => [
                'title' => 'Changed',
                'description' => 'Updated',
                'notes' => 'Added'
            ]
        ];

        $this->assertEquals('project_updated', $activity->slug);
        $this->assertEquals($expectedChanges, $activity->changes);
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
