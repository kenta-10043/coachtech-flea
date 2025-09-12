<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\User;

class ProfileCreatePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_information_display(): void
    {
        $user = User::factory()->create([
            'name' => 'name',
        ]);
        $this->actingAs($user);
        Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => 'dummy.jpg',
            'postal_code' => '123-4567',
            'address' => 'サンプル住所',
        ]);
        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('dummy.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('サンプル住所');
    }
}
