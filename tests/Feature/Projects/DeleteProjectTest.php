<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();
    }

    /** @test */
    public function guest_cannot_delete_project()
    {
        $this->delete($this->project->path())->assertRedirect('/login');

        $this->assertDatabaseHas('projects', ['id' => $this->project->id]);
    }

    /** @test */
    public function user_cannot_delete_others_project()
    {
        $this->signIn();

        $this->delete($this->project->path())->assertStatus(403);

        $this->assertDatabaseHas('projects', ['id' => $this->project->id]);
    }

    /** @test */
    public function user_can_delete_owned_project()
    {
        $this->signIn($this->project->owner);

        $this->delete($this->project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing(
            'projects',
            ['id' => $this->project->id]
        );

        $this->get('/projects')->assertDontSee($this->project->title);
    }
}
