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
    public function task_completed_field_is_updated_correctly()
    {
        $this->signIn($this->task->project->owner);

        $this->assertFalse($this->task->completed);

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

    /** @test */
    public function activity_is_not_recorded_if_completed_field_is_not_updated()
    {
        $this->actingAs($this->task->project->owner)
            ->patch($this->task->path(), [
                'body' => '0',
                'completed' => '0'
            ]);

        $this->assertDatabaseCount('activities', 2);

        $completedTask = Task::factory()->create(['completed' => true]);

        $this->actingAs($completedTask->project->owner)
            ->patch($completedTask->path(), [
                'body' => '1',
                'completed' => '1'
            ]);

        $this->assertDatabaseCount('activities', 4);
    }

    /** @test */
    public function get_valid_json_response_if_ajax_request_is_made()
    {
        $this->signIn($this->task->project->owner);

        $response = $this->patchJson(
            $this->task->path(),
            Task::factory()->raw()
        );

        $response->assertJson(['status' => 'ok']);
    }
}
