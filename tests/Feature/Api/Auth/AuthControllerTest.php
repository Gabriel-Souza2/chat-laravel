<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

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

    public function testLogoutSucess()
    {
        $user = \factory(User::class)->create();
        Auth::login($user);
        
        $response = $this->post('/api/auth/logout');
        $response->assertStatus(200);
    }

    public function testLogoutUserUnauthenticated()
    {
        $user = \factory(User::class)->create();
        $response = $this->withHeaders(['Accept' => 'application/json'])
                    ->post('/api/auth/logout');
        $response->assertStatus(401);
    }

    public function testRefreshSucess()
    {
        $user = \factory(User::class)->create();
        Auth::login($user);

        $response = $this->post('/api/auth/refresh');
        $response->assertJsonStructure(['token'])->assertStatus(200);
    }

    public function testRefreshUnauthenticated()
    {
        $user = \factory(User::class)->create();
        $response = $this->withHeaders(['Accept' => 'application/json'])
                    ->post('/api/auth/refresh');
        $response->assertStatus(401);
    }
}
