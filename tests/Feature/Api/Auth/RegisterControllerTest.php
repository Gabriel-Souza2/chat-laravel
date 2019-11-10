<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterController extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUser()
    {
        $user = ['email' => 'email@test.com', 'password' => 'password'];
        $profile = \factory(Profile::class)->make()->toArray();

        $response = $this->postJson('/api/auth/register', array_merge($user, $profile));
        $response->assertStatus(201)->assertJsonFragment(
            array_merge(['email' => $user['email']], $profile)
        );

        $this->assertDatabaseHas('users', ['email' => $user['email']]);
        $this->assertDatabaseHas('profiles', $profile);
    }

    public function testEmailMustByUnique()
    {
        factory(User::class)->create(['email' => 'admin@user.com']);
        $user = ['email' => 'admin@user.com', 'password' => 'password'];
        $profile = $profile = \factory(Profile::class)->make()->toArray();

        $response = $this->postJson('/api/auth/register', array_merge($user, $profile));
        $response->assertStatus(422);
    }
}
