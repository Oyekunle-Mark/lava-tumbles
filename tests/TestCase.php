<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create test user
     *
     * @return \App\Models\User
     */
    protected function user()
    {
        return User::factory()->create();
    }
}
