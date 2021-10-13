<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectMembersTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();
    }

    /** @test */
    public function only_project_owner_can_invite_members()
    {
        $user = User::factory()->create();

        $this->project->invite($user);

        $this->signIn($user);
        $this->project->invite($user);

        $this->assertDatabaseCount('project_members', 0);
    }

    /** @test */
    public function project_members_can_create_tasks()
    {
        $user = User::factory()->create();

        $this->signIn($this->project->owner);
        $this->project->invite($user);

        $this->signIn($user);
        $this->post($this->project->path().'/tasks', ['body' => 'New task'])
            ->assertRedirect($this->project->path());

        $this->assertDatabaseHas('tasks', ['body' => 'New task']);
    }
}
