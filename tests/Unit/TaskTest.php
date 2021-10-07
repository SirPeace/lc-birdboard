<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

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

        $this->assertEquals(
            $task->project->path()."/tasks/{$task->id}",
            $task->path()
        );
    }
}
