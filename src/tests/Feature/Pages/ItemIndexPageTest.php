<?php

namespace Tests\Feature\Pages;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemIndexPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_index_page_can_be_accessed(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_item_index_page_purchased_item(): void
    {
        $purchasedItem = Item::factory()->create([
            'item_name' => 'sold_item',
            'status' => 2,
        ]);
        $availableItem = Item::factory()->create([
            'item_name' => 'available_item',
            'status' => 1,
        ]);
        $response = $this->get('/');
        $response->assertSee('sold_item');
        $response->assertSee('Sold');
        $response->assertSee('available_item');
    }

    public function test_item_index_page_exhibition_item(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $exhibitionItem = Item::factory()->create([
            'item_name' => 'sell_item',
            'user_id' => $user->id,
        ]);
        $otherItem = Item::factory()->create([
            'item_name' => 'other_item',
            'user_id' => $otherUser->id,
        ]);
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertDontSee('sell_item');
        $response->assertSee('other_item');
    }
}
