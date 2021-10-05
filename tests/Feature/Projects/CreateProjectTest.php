<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function only_authenticated_user_can_create_project()
    {
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        $this->post('/projects', $attributes)->assertRedirect('/login');

        $this->assertDatabaseMissing('projects', $attributes);
    }

    /** @test */
    public function user_can_create_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function project_requires_title()
    {
        $this->actingAs($this->user);

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function project_requires_description()
    {
        $this->actingAs($this->user);

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['description']);
    }
}
