<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProjectTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();

        $this->attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'notes' => $this->faker->paragraphs(asText: true)
        ];
    }

    /** @test */
    public function guest_cannot_update_project()
    {
        $this->patch($this->project->path(), $this->attributes)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('projects', $this->attributes);
    }

    /** @test */
    public function user_cannot_update_others_project()
    {
        $this->signIn();

        $this->patch($this->project->path(), $this->attributes)
            ->assertStatus(403);

        $this->assertDatabaseMissing('projects', $this->attributes);
    }

    /** @test */
    public function user_can_update_owned_project()
    {
        $this->signIn($this->project->owner);

        $response = $this->patch($this->project->path(), $this->attributes);

        $response->assertRedirect(
            Project::where($this->attributes)->first()->path()
        );

        $this->assertDatabaseHas('projects', $this->attributes);

        $this->get($this->project->path())
            ->assertSee($this->attributes['title'])
            ->assertSee($this->attributes['description'])
            ->assertSee($this->attributes['notes']);
    }

    /** @test */
    public function project_title_must_be_less_than_255_chars()
    {
        $this->signIn($this->project->owner);

        $attributes = Project::factory()->raw([
            'title' => str_repeat('a', 256)
        ]);

        $this->patch($this->project->path(), $attributes)
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function project_description_must_be_less_than_255_chars()
    {
        $this->signIn($this->project->owner);

        $attributes = Project::factory()->raw([
            'description' => str_repeat('a', 256)
        ]);

        $this->patch($this->project->path(), $attributes)
            ->assertSessionHasErrors(['description']);
    }
}