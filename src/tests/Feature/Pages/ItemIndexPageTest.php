<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;

class ItemIndexPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_index_page_can_be_accessed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_item_index_page_purchasedItem(): void
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

    public function test_item_index_page_exhibitionItem(): void
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
