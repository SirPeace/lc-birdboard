<?php

namespace Tests\Feature\Tasks;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'body' => $this->faker->sentence()
        ];
    }

    /** @test */
    public function guest_cannot_create_project_task()
    {
        $project = Project::factory()->create();

        $this->post($project->path().'/tasks', $this->attributes)
            ->assertRedirect('/login');

        $this->assertDatabaseCount('tasks', 0);
    }

    /** @test */
    public function user_cannot_create_tasks_for_foreign_projects()
    {
        $project = Project::factory()->create();

        $this->signIn();

        $this->post($project->path().'/tasks', $this->attributes)
            ->assertStatus(403);

        $this->assertDatabaseCount('tasks', 0);
    }

    /** @test */
    public function user_can_create_tasks_for_owned_projects()
    {
        $project = Project::factory()->create();

        $this->signIn($project->owner);

        $this->post($project->path().'/tasks', $this->attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $this->attributes);

        $this->get($project->path())->assertSee($this->attributes['body']);
    }

    /** @test */
    public function project_task_requires_body()
    {
        $project = Project::factory()->create();

        $attributes = Task::factory()->for($project)->raw(['body' => '']);

        $this->signIn($project->owner);

        $this->post($project->path().'/tasks', $attributes)
            ->assertSessionHasErrors(['body']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }
}
