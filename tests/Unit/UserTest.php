<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_owned_projects()
    {
        $user = User::factory()->create();

        $project = Project::factory()->for($user, 'owner')->create();

        $this->assertEquals($user->projects[0]->id, $project->id);
    }

    /** @test */
    public function it_has_all_projects()
    {
        $john = User::factory()->create();
        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $johnProject = Project::factory()->for($john, 'owner')->create();

        $this->signIn($john);
        $johnProject->invite($sally);

        $this->assertCount(1, $john->allProjects());
        $this->assertCount(1, $john->projects);

        $this->assertCount(1, $sally->allProjects());
        $this->assertCount(0, $sally->projects);

        $this->assertCount(0, $nick->allProjects());
        $this->assertCount(0, $nick->projects);
    }

    /** @test */
    public function it_has_theme_preference()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'dark_theme' => false
        ]);
    }
}
