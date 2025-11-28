<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\user;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_search_部分一致(): void
    {
        Item::factory()->create(['item_name' => '野球ボール']);
        Item::factory()->create(['item_name' => 'サッカーボール']);
        Item::factory()->create(['item_name' => 'テニスラケット']);
        $response = $this->get('/?keyword=ボール');
        $response->assertStatus(200);
        $response->assertDontSee('テニスラケット');
        $response->assertSee('野球ボール');
        $response->assertSee('サッカーボール');
    }

    public function test_my_list_tab_can_be_accessed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $likeItem1 = Item::factory()->create([
            'item_name' => '牛肉',
        ]);
        $likeItem2 = Item::factory()->create([
            'item_name' => '豚肉',
        ]);
        $likeItem3 = Item::factory()->create([
            'item_name' => '唐揚げ',
        ]);
        $user->likes()->create([
            'item_id' => $likeItem1->id,
        ]);
        $user->likes()->create([
            'item_id' => $likeItem2->id,
        ]);
        $user->likes()->create([
            'item_id' => $likeItem3->id,
        ]);
        $response = $this->get('/?keyword=肉&tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('唐揚げ');
        $response->assertSee('豚肉');
        $response->assertSee('牛肉');
    }
}
