<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path_to_project()
    {
        $project = Project::factory()->create();

        $this->assertEquals("/projects/{$project->id}", $project->path());
    }
}
