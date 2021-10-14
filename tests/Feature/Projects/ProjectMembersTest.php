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
    public function unauthorized_user_cannot_invite_members_to_project()
    {
        $this->post($this->project->path().'/invitations')
            ->assertRedirect('/login');

        $this->signIn();
        $this->post($this->project->path().'/invitations')
            ->assertStatus(403);
    }

    /** @test */
    public function project_owner_cannot_invite_nonexisting_members_to_project()
    {
        $this->signIn($this->project->owner);
        $response = $this->post(
            $this->project->path().'/invitations',
            ['email' => 'notuser@mail.com']
        );

        $response->assertSessionHasErrors([
            'email' => 'User with such email does not exist.'
        ]);

        $this->assertCount(0, $this->project->members);
    }

    /** @test */
    public function project_owner_can_invite_members_to_project()
    {
        $user = User::factory()->create();

        $this->signIn($this->project->owner);
        $response = $this->post(
            $this->project->path().'/invitations',
            ['email' => $user->email]
        );

        $response->assertRedirect($this->project->path());

        $this->assertCount(1, $this->project->members);
    }

    /** @test */
    public function project_members_can_create_tasks()
    {
        $user = User::factory()->create();

        $this->project->invite($user);

        $this->signIn($user);
        $this->post($this->project->path().'/tasks', ['body' => 'New task'])
            ->assertRedirect($this->project->path());

        $this->assertDatabaseHas('tasks', ['body' => 'New task']);
    }
}
