<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_mypage_display(): void
    {
        $user = User::factory()->create(['name' => 'name']);
        $this->actingAs($user);
        Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => 'dummy.jpg'
        ]);
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'sell_item',
            'status' => 1,
        ]);
        $buyItemModel = Item::factory()->create([
            'item_name' => 'buy_item',
            'status' => 2,
        ]);
        $buyItem = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItemModel->id,
        ]);
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('dummy.jpg');
        $response->assertSee('sell_item');
        $response->assertSee('buy_item');
    }

    public function test_mypage_sell_only_display(): void
    {
        $user = User::factory()->create(['name' => 'name']);
        $this->actingAs($user);
        Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => 'dummy.jpg'
        ]);
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'sell_item',
            'status' => 1,
        ]);
        $buyItemModel = Item::factory()->create([
            'item_name' => 'buy_item',
            'status' => 2,
        ]);
        $buyItem = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItemModel->id,
        ]);
        $response = $this->get('/mypage?page=sell');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('dummy.jpg');
        $response->assertSee('sell_item');
        $response->assertDontSee('buy_item');
    }

    public function test_mypage_buy_only_display(): void
    {
        $user = User::factory()->create(['name' => 'name']);
        $this->actingAs($user);
        Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => 'dummy.jpg'
        ]);
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'sell_item',
            'status' => 1,
        ]);
        $buyItemModel = Item::factory()->create([
            'item_name' => 'buy_item',
            'status' => 2,
        ]);
        $buyItem = Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItemModel->id,
        ]);
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('dummy.jpg');
        $response->assertDontSee('sell_item');
        $response->assertSee('buy_item');
    }
}
