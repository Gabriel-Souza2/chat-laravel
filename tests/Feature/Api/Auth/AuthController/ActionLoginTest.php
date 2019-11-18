<?php

namespace Tests\Feature\Api\Auth\AuthController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionLoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginSucess()
    {
        $user = factory(User::class)->create();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function testUserNotExist()
    {
        $user = \factory(User::class)->make();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(422);
    }

    public function testPasswordError()
    {
        $user = \factory(User::class)->create();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'pass'
        ]);

        $response->assertStatus(401);
    }
}
