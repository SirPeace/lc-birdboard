<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ShowProjectsTest extends TestCase
{
    /** @test */
    public function guest_cannot_see_nor_view_others_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
    }

    /** @test */
    public function user_cannot_see_nor_view_others_projects()
    {
        $projects = Project::factory(2)->create();

        $this->signIn();

        $this->get('/projects')
            ->assertSee('No projects yet.')
            ->assertDontSee($projects[0]->title)
            ->assertDontSee($projects[1]->title);

        $this->get($projects[0]->path())->assertStatus(403);
        $this->get($projects[1]->path())->assertStatus(403);
    }

    /** @test */
    public function user_can_see_and_view_its_projects()
    {
        $user = User::factory()->create();
        $projects = Project::factory(2)->for($user, 'owner')->create();

        $this->signIn($user);

        $this->get('/projects')
            ->assertSee($projects[0]->title)
            ->assertSee($projects[1]->title);
    }

    /** @test */
    public function user_can_see_projects_he_was_invited_in()
    {
        $john = User::factory()->create();
        $sally = User::factory()->create();

        $johnProject = Project::factory()->for($john, 'owner')->create();

        $johnProject->invite($sally);

        $this->signIn($sally);
        $this->get('/projects')->assertSee($johnProject->title);
    }

    /** @test */
    public function user_can_view_its_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user, 'owner')->create();

        $this->signIn($user);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function receive_404_if_project_does_not_exist()
    {
        $this->signIn();

        $this->get("/projects/1")->assertStatus(404);
    }

    /** @test */
    public function latest_updated_projects_are_shown_first()
    {
        $user = $this->signIn();

        $second = Project::factory()->for($user, 'owner')->create();
        $first = Project::factory()->for($user, 'owner')->create([
            'updated_at' => now()->addMinute()
        ]);

        $this->get('/projects')
            ->assertSeeInOrder([$first->title, $second->title]);
    }
}
