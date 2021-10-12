<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_belongs_to_user()
    {
        $user = $this->signIn();

        $project = Project::factory()->for($user, 'owner')->create();
        $activity = $project->activity->last();

        $this->assertTrue($activity->user->is($user));

        $project->update(['title' => 'changes']);
        $activity = $project->refresh()->activity->last();

        $this->assertTrue($activity->user->is($user));
    }
}
