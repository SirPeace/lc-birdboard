<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function guest_cannot_reach_endpoint()
    {
        $this->patchJson('/user', ['dark_theme' => true])->assertStatus(401);
    }

    /** @test */
    public function user_can_update_theme()
    {
        $user = $this->signIn();

        $this->assertFalse($user->dark_theme);

        $this->patchJson('/user', ['dark_theme' => true])->assertStatus(204);

        $this->assertTrue($user->refresh()->dark_theme);
    }
}
