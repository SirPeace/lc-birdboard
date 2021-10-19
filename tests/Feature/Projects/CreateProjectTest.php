<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cannot_create_project()
    {
        $attributes = Project::factory()->raw(['owner_id' => auth()->id()]);

        $this->post('/projects', $attributes)->assertRedirect('/login');

        $this->assertDatabaseMissing('projects', $attributes);
    }

    /** @test */
    public function user_can_create_project()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['owner_id' => auth()->id()]);

        $this->post('/projects', $attributes)
            ->assertRedirect(Project::where($attributes)->first()->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function project_requires_title_less_than_255_chars()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['title']);

        $attributes['title'] = str_repeat('a', 256);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function project_requires_description_less_than_255_chars()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['description']);

        $attributes['description'] = str_repeat('a', 256);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function get_valid_json_response_if_ajax_request_is_made()
    {
        $this->signIn();

        $response = $this->postJson('/projects', Project::factory()->raw());

        $response->assertJson([
            'status' => 'ok',
            'data' => [
                'path' => Project::first()->path()
            ]
        ]);
    }
}
