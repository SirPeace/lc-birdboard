<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_see_others_projects()
    {
        $this->withoutExceptionHandling();

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $projects = Project::factory(2)->create();

        $this->get('/projects')
            ->assertSee('No projects yet.')
            ->assertDontSee($projects[0]->title)
            ->assertDontSee($projects[1]->title);
    }

    /** @test */
    public function user_can_see_its_projects()
    {
        $this->withoutExceptionHandling();

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $projects = Project::factory(2)->for($user, 'owner')->create();

        $this->get('/projects')
            ->assertSee($projects[0]->title)
            ->assertSee($projects[1]->title);
    }

    /** @test */
    public function user_cannot_view_others_project()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function user_can_view_its_project()
    {
        $this->withoutExceptionHandling();

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->for($user, 'owner')->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function receive_404_if_project_does_not_exist()
    {
        $this->get("/projects/1")->assertStatus(404);
    }
}
