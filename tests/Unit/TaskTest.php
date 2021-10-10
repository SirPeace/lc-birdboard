<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class TaskTest extends TestCase
{
    /** @test */
    public function it_belongs_to_project()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->for($project)->create();

        $this->assertTrue($task->project->is($project));
    }

    /** @test */
    public function it_has_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals("/tasks/{$task->id}", $task->path());
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->completed);
    }
}
