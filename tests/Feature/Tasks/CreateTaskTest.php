<?php

namespace Tests\Feature\Tasks;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();

        $this->attributes = [
            'body' => $this->faker->sentence(),
        ];
    }

    /** @test */
    public function guest_cannot_create_project_task()
    {
        $this->post($this->project->path().'/tasks', $this->attributes)
            ->assertRedirect('/login');

        $this->assertDatabaseCount('tasks', 0);
    }

    /** @test */
    public function user_cannot_create_tasks_for_foreign_projects()
    {
        $this->signIn();

        $this->post($this->project->path().'/tasks', $this->attributes)
            ->assertStatus(403);

        $this->assertDatabaseCount('tasks', 0);
    }

    /** @test */
    public function user_can_create_tasks_for_owned_projects()
    {
        $this->signIn($this->project->owner);

        $this->post($this->project->path().'/tasks', $this->attributes)
            ->assertRedirect($this->project->path());

        $this->assertDatabaseHas('tasks', $this->attributes);

        $this->get($this->project->path())
            ->assertSee($this->attributes['body']);
    }

    /** @test */
    public function project_task_requires_body()
    {
        $attributes = Task::factory()->for($this->project)->raw(['body' => '']);

        $this->signIn($this->project->owner);

        $this->post($this->project->path().'/tasks', $attributes)
            ->assertSessionHasErrors(['body']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }
}
