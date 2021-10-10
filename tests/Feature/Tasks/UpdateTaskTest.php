<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->create();
    }

    /** @test */
    public function guest_cannot_update_project_task()
    {
        $this->patch($this->task->path(), ['body' => 'New task body'])
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('tasks', ['body' => 'New task body']);
    }

    /** @test */
    public function user_cannot_update_tasks_for_foreign_projects()
    {
        $this->signIn();

        $this->patch($this->task->path(), ['body' => 'New task body'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'New task body']);
    }

    /** @test */
    public function user_can_update_tasks_for_owned_projects()
    {
        $this->signIn($this->task->project->owner);

        $attributes = [
            'body' => 'New task body',
            'completed' => '1'
        ];

        $this->patch($this->task->path(), $attributes)
            ->assertRedirect($this->task->project->path());

        $this->assertDatabaseHas('tasks', $attributes);

        $this->get($this->task->project->path())
            ->assertSee($attributes['body']);
    }

    /** @test */
    public function task_requires_body()
    {
        $attributes = Task::factory()
            ->for($this->task->project)
            ->raw(['body' => '']);

        $this->signIn($this->task->project->owner);

        $this->patch($this->task->path(), $attributes)
            ->assertSessionHasErrors(['body']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function task_completed_field_must_be_boolean()
    {
        $attributes = Task::factory()
            ->for($this->task->project)
            ->raw(['completed' => 'alert("Hello there")']);

        $this->signIn($this->task->project->owner);

        $this->patch($this->task->path(), $attributes)
            ->assertSessionHasErrors(['completed']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function task_completed_field_is_updated_correctly()
    {
        $this->task->completed = false;

        $this->signIn($this->task->project->owner);

        $this->patch($this->task->path(), ['body' => '1', 'completed' => '1']);

        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id,
            'completed' => true,
        ]);

        $this->patch($this->task->path(), ['body' => '1']);

        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id,
            'completed' => false,
        ]);
    }
}
