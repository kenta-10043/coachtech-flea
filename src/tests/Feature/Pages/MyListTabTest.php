<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MyListTabTest extends TestCase
{
    use RefreshDatabase;

    public function test_myList_tab_can_be_accessed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);


        $likeItem = Item::factory()->create([
            'item_name' => 'like_item',
        ]);

        $user->likes()->create([
            'item_id' => $likeItem->id,
        ]);

        $otherItem = Item::factory()->create([
            'item_name' => 'other_item',
        ]);

        $purchasedLikeItem = Item::factory()->create([
            'item_name' => 'sold_item',
            'status' => 2,
        ]);

        $user->likes()->create([
            'item_id' => $purchasedLikeItem->id,
        ]);



        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('like_item');
        $response->assertDontSee('other_item');
        $response->assertSee('sold_item');
        $response->assertSee('Sold');
    }

    public function test_myList_tab_for_guest(): void
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('like_item');
        $response->assertDontSee('other_item');
        $response->assertDontSee('sold_item');
        $response->assertDontSee('Sold');
        $response->assertDontSee('available_item');
    }
}
