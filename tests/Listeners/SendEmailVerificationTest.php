<?php

namespace Tests\Listeners;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Events\Registered;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendEmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendEmailVerificationTest extends TestCase
{
    use RefreshDatabase;
    
    protected function despatchedListener($user)
    {
        Event::fake();

        $event = Mockery::mock(Registered::class, [$user]);
        $event->shouldReceive([
            'getUser' => $user
        ]);

        $listener = App::make(SendEmailVerification::class);
        $listener->handle($event);
    }

    public function testGenerateTokenVerification()
    {
        $user = \factory(User::class)->create();

        $this->despatchedListener($user);
        
        $token = $user->verificationToken()->where('type', 'email')->first();
        $this->assertNotEmpty($token);
    }

    public function testCallNotification()
    {
        
        Notification::fake();

        $user = \factory(User::class)->create();

        $this->despatchedListener($user);

        Notification::assertSentTo($user, VerifyEmail::class);

    }
}