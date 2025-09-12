<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Category;
use App\Models\Profile;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_show_page_display(): void
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create(['id' => 1]);
        $item = Item::factory()->create([
            'item_image' => 'dummy1.jpg',
            'item_name' => 'name',
            'brand_name' => 'brand',
            'price' => 1200,
            'status' => 1,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'description' => '説明文',
        ]);
        $likeUser = User::factory()->create(['name' => 'like_user']);
        $commentUser = User::factory()->create(['name' => 'comment_user']);
        $commentUser->profile()->create(Profile::factory()->make()->toArray());
        Like::factory()->create([
            'user_id' => $likeUser->id,
            'item_id' => $item->id
        ]);
        Comment::factory()->create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'コメント本文'
        ]);
        $item = Item::withCount(['likes', 'comments'])->with('comments.user.profile', 'categories')->find($item->id);
        $category1 = Category::factory()->create(['category' => 1]);
        $category2 = Category::factory()->create(['category' => 2]);
        $category3 = Category::factory()->create(['category' => 3]);
        $item->categories()->attach([$category1->id, $category2->id, $category3->id]);
        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee('dummy1.jpg');
        $response->assertSee('name');
        $response->assertSee('brand');
        $response->assertSee('￥1,200（税込）');
        $response->assertSee('説明文');
        $response->assertSee('良好');
        $response->assertSee('dummy2.jpg');
        $response->assertSee('comment_user');
        $response->assertSee('コメント本文');
        $response->assertSee('ファッション');
        $response->assertSee('家電');
        $response->assertSee('インテリア');
        $response->assertSee($item->likes_count);
        $response->assertSee($item->comments_count);
    }
}
