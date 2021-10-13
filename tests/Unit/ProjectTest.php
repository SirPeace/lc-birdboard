<?php

namespace Tests\Unit;

use App\Models\Activity;
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

    /** @test */
    public function it_has_activity()
    {
        $project = Project::factory()->create();

        $this->assertTrue(
            $project->activity->every(fn ($item) => $item instanceof Activity)
        );
    }

    /** @test */
    public function old_attributes_are_saved_after_update()
    {
        $project = Project::factory()->create();
        $oldAttributes = $project->getAttributes();

        $newAttributes = Project::factory()->raw();
        $project->update($newAttributes);

        $this->assertDatabaseHas('projects', $newAttributes);
        $this->assertEquals($oldAttributes, $project->oldAttributes);
    }

    /** @test */
    public function it_has_members()
    {
        $project = Project::factory()
            ->has(User::factory(), 'members')
            ->create();

        $this->assertContainsOnlyInstancesOf(User::class, $project->members);
    }

    /** @test */
    public function it_can_invite_member()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $this->signIn($project->owner);

        $project->invite($user);

        $this->assertTrue($project->members->last()->is($user));
    }
}
