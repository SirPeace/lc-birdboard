<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function signIn(User $user = null): User
    {
        /** @var User $user */
        $user = $user ?? User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
