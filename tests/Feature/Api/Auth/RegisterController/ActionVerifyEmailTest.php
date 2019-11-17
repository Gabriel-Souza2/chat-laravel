<?php

namespace Tests\Feature\Api\Auth\RegisterController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionVerifyEmailTest extends TestCase
{
    protected function createUser($token = null)
    {
        $user = \factory(User::class)->create(['email_verified_at' => null]);
        $token = Str::random(60);
        $user->verificationToken()->create(['token' => $token, 'type' => 'email']);
        return ['user' => $user, 'token' => $token];
    }

    public function testEmailVerifiedSucess()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user['user'])
                    ->get("api/auth/register/verify/{$user['token']}")
                    ->assertStatus(204);
        
        $this->assertNotEmpty($user['user']->email_verified_at);
    }

    public function testNotPassedToken()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user['user'])
                    ->get("api/auth/register/verify")
                    ->assertStatus(422);

        $this->assertEmpty($user['user']->email_verified_at);
    }
}
