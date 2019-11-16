<?php

namespace Tests\Notifications;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testActionNotification()
    {
        Notification::fake();

        $token = Str::random(60);
        $user = factory(User::class)->create();
        $user->verificationToken()->create([
            'token' => $token,
            'type' => 'email'
            ]);

        $url = url("/register/verify_email?token={$token}");
            
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