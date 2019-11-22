<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Events\Registered;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use App\Repositories\EmailTokenRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    private function getData()
    {
        $user = ['email' => 'email@test.com', 'password' => 'password'];
        $profile = \factory(Profile::class)->make()->toArray();

        return \array_merge($user, $profile);
    }
    
    public function testRegisterNewUser()
    {
        $data = $this->getData();
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function testEmailNotUnique()
    {
        factory(User::class)->create(['email' => 'email@test.com']);
        $response = $this->postJson('/api/auth/register', $this->getData());
        $response->assertStatus(422);
    }

    public function testRequiredFields()
    {
        $response = $this->postJson('/api/auth/register', []);
        $response->assertStatus(422);
    }

    public function testDespatchedRegisteredEvent()
    {
        Event::fake();
        $response = $this->postJson('/api/auth/register', $this->getData());
        Event::assertDispatched(Registered::class);
    }

    public function testDespatchedVerifyEmailNotfication()
    {
        Notification::fake();
        $response = $this->postJson('/api/auth/register', $this->getData());
        Notification::assertSentTo(User::first(), VerifyEmail::class);
    }

    public function testEmailVerifiedSucess()
    {
        $user = factory(User::class)->create();
        $model = resolve(EmailTokenRepository::class)->createToken($user->id);
        $response = $this->actingAs($user)
                    ->get("api/auth/register/verify?token={$model->token}")
                    ->assertStatus(204);
    }

    public function testNotPassedToken()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
                    ->get("api/auth/register/verify")
                    ->assertStatus(422);
    }


}