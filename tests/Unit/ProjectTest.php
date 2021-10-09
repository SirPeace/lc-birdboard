<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_has_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals("/projects/{$project->id}", $project->path());
    }

    /** @test */
    public function it_belongs_to_owner()
    {
        $user = User::factory()->create();

        $project = Project::factory()->for($user, 'owner')->create();

        $this->assertEquals($user->id, $project->owner->id);
    }

    /** @test */
    public function it_has_tasks()
    {
        $project = Project::factory()->create();

        $tasks = Task::factory(2)->for($project)->create();

        $this->assertCount(2, $project->tasks);
        $this->assertTrue(
            $tasks->every(fn ($task) => $project->tasks->contains($task))
        );
    }

    /** @test */
    public function it_can_add_task()
    {
        $project = Project::factory()->create();

        $taskAttributes = Task::factory()->raw(['project_id' => null]);
        $project->addTask(new Task($taskAttributes));

        $this->assertDatabaseHas(
            'tasks',
            array_merge($taskAttributes, ['project_id' => $project->id])
        );
    }
}
