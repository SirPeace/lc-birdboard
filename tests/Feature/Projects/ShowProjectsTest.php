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
    public function guest_cannot_see_nor_view_others_projects()
    {
        $projects = Project::factory(2)->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get($projects[0]->path())->assertRedirect('/login');
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
    }

    /** @test */
    public function user_can_see_and_view_its_projects()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->signIn($user);

        $projects = Project::factory(2)->for($user, 'owner')->create();

        $this->get('/projects')
            ->assertSee($projects[0]->title)
            ->assertSee($projects[1]->title);
    }

    /** @test */
    public function user_can_view_its_project()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->signIn($user);

        $project = Project::factory()->for($user, 'owner')->create();

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
        /** @var User $user */
        $user = User::factory()->create();
        $this->signIn($user);

        $second = Project::factory()->for($user, 'owner')->create();
        $first = Project::factory()->for($user, 'owner')->create([
            'updated_at' => now()->addMinute()
        ]);

        $this->get('/projects')
            ->assertSeeInOrder([$first->title, $second->title]);
    }
}
