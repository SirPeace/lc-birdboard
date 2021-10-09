<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_projects()
    {
        $user = User::factory()->create();

        $project = Project::factory()->for($user, 'owner')->create();

        $this->assertEquals($user->projects[0]->id, $project->id);
    }
}
