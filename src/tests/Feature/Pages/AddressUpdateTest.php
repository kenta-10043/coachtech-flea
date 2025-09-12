<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Http;


class AddressUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_address_update_and_display()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $formData = [
            'shopping_postal_code' => '145-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'payment_method' => 1,
        ];
        $response = $this->actingAs($user)
            ->put(route('address.update', ['item_id' => $item->id]), $formData);
        $this->assertDatabaseHas('orders', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'status' => 'draft',
            'shopping_postal_code' => '145-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'payment_method'       => 1,
        ]);
        $response = $this->actingAs($user)
            ->get(route('address.edit', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('145-4567');
        $response->assertSee('サンプル住所');
        $response->assertSee('サンプル建物名');
    }

    public function test_buy_item_attached_address(): void
    {
        Http::fake([
            'api.stripe.com/*' => Http::response([
                'id' => 'cs_test_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_123'
            ], 200)
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create();
        $formData = [
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'status' => 'draft',
        ];
        $response = $this->post(route('purchase.checkout', ['item_id' => $item->id]), $formData);
        $order = Order::where('item_id', $item->id)->first();
        $order->update(['status' => 'paid']);
        $response->assertRedirect();
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));
        $this->assertDatabaseHas('orders', [
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'status' => 'paid',
        ]);
    }
}
