<?php

namespace Tests\Notifications;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testActionNotification()
    {
        Notification::fake();

        $user = factory(User::class)->create();
        $token = VerificationToken::createToken($user->id, 'email');

        $url = url("/register/verify_email?token={$token['token']}");
            
        Notification::send($user, new VerifyEmail);

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