<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test first user creation.
     *
     * @return void
     */
    public function testCreatingFirstUser()
    {
        $response = $this->postJson('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
    }
}
