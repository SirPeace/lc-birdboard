<?php

namespace Tests\Feature\Activity;

use App\Models\Project;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    /** @test */
    public function creating_project_generates_activity()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals(
            'Project is created',
            $project->activity[0]->description
        );
    }

    /** @test */
    public function updating_project_generates_activity()
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals(
            'Project is updated',
            $project->activity[1]->description
        );
    }
}
