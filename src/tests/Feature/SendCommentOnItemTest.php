<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class SendCommentOnItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_comment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create();
        $formData = [
            'comment' => 'コメント本文',
        ];
        $response = $this->post(route('comment.store', ['item_id' => $item->id]), $formData);
        $response->assertRedirect(route('item.show', ['item_id' => $item->id]));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'コメント本文',
        ]);
    }

    public function test_guest_cannot_send_comment(): void
    {
        $item = Item::factory()->create();
        $formData = [
            'comment' => 'コメント本文',
        ];
        $response = $this->post(route('comment.store', ['item_id' => $item->id]), $formData);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'コメント本文',
        ]);
    }

    public function test_send_comment_is_required()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create();
        $response = $this->withoutMiddleware()->post(route('comment.store', ['item_id' => $item->id]), [
            'comment' => '',
        ]);
        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    public function test_send_comment_is_max_length()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create();
        $response = $this->withoutMiddleware()->post(route('comment.store', ['item_id' => $item->id]), [
            'comment' => '00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
        ]);
        $response->assertSessionHasErrors([
            'comment' => 'コメントは250文字以内で入力してください',
        ]);
    }
}
