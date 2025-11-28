<?php

namespace Tests\Feature\Forms;

use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellItemFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_sell_item_create_post(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);
        $categories = Category::factory()->count(3)->create();
        $condition = Condition::factory()->create();
        $formData = [
            'item_name' => 'メガネ',
            'brand_name' => 'ブランド',
            'price' => 2000,
            'description' => '商品説明文',
            'condition' => $condition->id,
            'category' => $categories->pluck('id')->toArray(),
            'item_image' => UploadedFile::fake()->image('test.jpg'),
        ];
        $response = $this->post(route('sell.store'), $formData);
        $response->assertRedirect(route('index'));
        $item = DB::table('items')->first();
        $this->assertEquals('メガネ', $item->item_name);
        $this->assertEquals('ブランド', $item->brand_name);
        $this->assertEquals(2000, $item->price);
        $this->assertEquals('商品説明文', $item->description);
        $this->assertEquals($user->id, $item->user_id);
        $this->assertStringContainsString('sample_images/', $item->item_image);
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $item->id,
                'category_id' => $category->id,
            ]);
        }
        Storage::disk('public')->assertExists($item->item_image);
    }
}
