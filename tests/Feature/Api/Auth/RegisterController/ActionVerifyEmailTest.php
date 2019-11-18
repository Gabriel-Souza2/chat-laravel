<?php

namespace Tests\Feature\Api\Auth\RegisterController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionVerifyEmailTest extends TestCase
{

    public function testEmailVerifiedSucess()
    {
        $user = \factory(User::class)->create(['email_verified_at' => null]);
        $token = VerificationToken::createToken($user->id, 'email');

        $response = $this->actingAs($user)
                    ->get("api/auth/register/verify/{$token['token']}")
                    ->assertStatus(204);
        $this->assertNotEmpty($user->email_verified_at);
    }

    public function testNotPassedToken()
    {
        $user = \factory(User::class)->create(['email_verified_at' => null]);
        $response = $this->actingAs($user)
                    ->get("api/auth/register/verify")
                    ->assertStatus(422)
                    ->assertJson(['message'=>'token not passed']);

        $this->assertEmpty($user->email_verified_at);
    }

    public function testTokenExpired()
    {
        $user = \factory(User::class)->create(['email_verified_at' => null]);
        $token = VerificationToken::create([
            'token' => Str::random(60), 
            'type' => 'email', 
            'user_id' => $user->id, 
            'exp' => now()->subHours()
        ]);
        
        $response = $this->actingAs($user)
                    ->get("api/auth/register/verify/{$token['token']}")
                    ->assertStatus(422)
                    ->assertJson(['message' => 'Token is not valid or expired']);

        $this->assertEmpty($user->email_verified_at);
    }
}
