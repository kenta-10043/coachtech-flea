<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_toggle_like()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user)
            ->post(route('item.like', ['item_id' => $item->id]));
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->actingAs($user)
            ->post(route('item.like', ['item_id' => $item->id]));
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
