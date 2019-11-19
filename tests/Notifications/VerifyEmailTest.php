<?php

namespace Tests\Notifications;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use App\Notifications\VerifyEmail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testActionNotification()
    {
        Notification::fake();

        $user = factory(User::class)->create();
        $repository = (new UserRepository($user))
                        ->createToken('email')
                        ->notify(VerifyEmail::class);

        $url = url("/register/verify_email?token={$repository->getToken('email')}");

        Notification::assertSentTo($user, VerifyEmail::class, 
            function($notification, $channels) use ($user, $url){
                $mail = $notification->toMail($user)->toArray();
                $this->assertEquals(
                    "Olá {$user->profile->name}, click no botão abaixo para ativar seu email!", 
                    $mail['introLines'][0]);
                $this->assertEquals($url, $mail['actionUrl']);
                return true;
            }
        );
    }
}