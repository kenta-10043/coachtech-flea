<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_verify_email(): void
    {
        Notification::fake();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect('/email/verify');
        $user = User::where('email', 'test@example.com')->first();
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class, function ($notification) use ($user) {
            $verificationUrl = $notification->toMail($user)->actionUrl;
            $response = $this->actingAs($user)->get($verificationUrl);
            $response->assertRedirect('/mypage/profile');
            $this->assertNotNull($user->fresh()->email_verified_at);
            return true;
        });
    }
}
