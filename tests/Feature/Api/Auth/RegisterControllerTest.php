<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterController extends TestCase
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

        $this->assertDatabaseHas('users', [
            'email' => $data['email']
        ]);
        $this->assertDatabaseHas('profiles', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender']
        ]);
    }

    public function testEmailMustByUnique()
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

    public function testCreateVerificationToken()
    {
        $response = $this->postJson('/api/auth/register', $this->getData());
        $user = User::first();
        $token = $user->verificationToken()->where('type', 'email')->first();
        $this->assertNotEmpty($token);
    }

}