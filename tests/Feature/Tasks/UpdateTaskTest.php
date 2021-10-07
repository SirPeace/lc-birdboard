<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_update_project_task()
    {
        $task = Task::factory()->create();

        $this->patch($task->path(), ['body' => 'New task body'])
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('tasks', ['body' => 'New task body']);
    }

    /** @test */
    public function user_cannot_update_tasks_for_foreign_projects()
    {
        $task = Task::factory()->create();

        $this->signIn();

        $this->patch($task->path(), ['body' => 'New task body'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'New task body']);
    }

    /** @test */
    public function user_can_update_tasks_for_owned_projects()
    {
        $this->withoutExceptionHandling();

        $task = Task::factory()->create();

        $this->signIn($task->project->owner);

        $attributes = [
            'body' => 'New task body',
            'completed' => '1'
        ];

        $this->patch($task->path(), $attributes)
            ->assertRedirect($task->project->path());

        $this->assertDatabaseHas('tasks', $attributes);

        $this->get($task->project->path())
            ->assertSee($attributes['body']);
    }

    /** @test */
    public function task_requires_body()
    {
        $task = Task::factory()->create();

        $attributes = Task::factory()->for($task->project)->raw(['body' => '']);

        $this->signIn($task->project->owner);

        $this->patch($task->path(), $attributes)
            ->assertSessionHasErrors(['body']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function task_completed_field_must_be_boolean()
    {
        $task = Task::factory()->create();

        $attributes = Task::factory()->for($task->project)->raw([
            'completed' => 'alert("Hello there")'
        ]);

        $this->signIn($task->project->owner);

        $this->patch($task->path(), $attributes)
            ->assertSessionHasErrors(['completed']);

        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function task_completed_field_is_updated_correctly()
    {
        $this->withoutExceptionHandling();

        $task = Task::factory()->create(['completed' => false]);

        $this->signIn($task->project->owner);

        $this->patch($task->path(), ['body' => '1', 'completed' => '1']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);

        $this->patch($task->path(), ['body' => '1']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => false,
        ]);
    }
}
