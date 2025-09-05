<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware()->actingAs($user)->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
