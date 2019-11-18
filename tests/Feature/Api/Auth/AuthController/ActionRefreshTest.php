<?php

namespace Tests\Feature\Api\Auth\AuthController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionRefreshTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
