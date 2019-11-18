<?php

namespace Tests\Feature\Api\Auth\AuthController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionLogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
}
