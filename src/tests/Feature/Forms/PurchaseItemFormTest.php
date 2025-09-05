<?php

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Stripe\Checkout\Session as StripeSession;

class PurchaseItemFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_item_buy(): void
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
        $item->update(['status' => 2]);
        $this->assertDatabaseHas('orders', ['status' => 'paid']);


        $response->assertRedirect();
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas(
            'items',
            [
                'id' => $item->id,
                'status' => 2,
            ]
        );
    }


    public function test_purchaseItem_displayed_sold_on_index(): void
    {
        Http::fake([
            'api.stripe.com/*' => Http::response([
                'id' => 'cs_test_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_123'
            ], 200)
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'item_name' => 'sold_item',
            'status' => 1,
        ]);

        $formData = [
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'status' => 'draft',
        ];

        $response = $this->post(route('purchase.checkout', ['item_id' => $soldItem->id]), $formData);

        $response->assertRedirect();
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));

        $order = Order::where('item_id', $soldItem->id)->first();

        $order->update(['status' => 'paid']);
        $soldItem->update(['status' => 2]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $soldItem->id,
            'status' => 2,
        ]);

        $availableItem = Item::factory()->create([
            'item_name' => 'available_item',
            'status' => 1,
        ]);

        $indexResponse = $this->get(route('index'));

        $indexResponse->assertSee('sold_item');
        $indexResponse->assertSee('Sold');
        $indexResponse->assertSee('available_item');
    }

    public function test_purchaseItem_displayed_sold_on_mylist(): void
    {
        Http::fake([
            'api.stripe.com/*' => Http::response([
                'id' => 'cs_test_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_123'
            ], 200)
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'item_name' => 'sold_item',
            'status' => 1,
        ]);

        $formData = [
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
            'status' => 'draft',
        ];

        $response = $this->post(route('purchase.checkout', ['item_id' => $soldItem->id]), $formData);

        $response->assertRedirect();
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));

        $order = Order::where('item_id', $soldItem->id)->first();

        $order->update(['status' => 'paid']);
        $soldItem->update(['status' => 2]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
            'payment_method' => 2,
            'shopping_postal_code' => '123-4567',
            'shopping_address' => 'サンプル住所',
            'shopping_building' => 'サンプル建物名',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $soldItem->id,
            'status' => 2,
        ]);

        $availableItem = Item::factory()->create([
            'item_name' => 'available_item',
            'status' => 1,
        ]);

        $indexResponse = $this->get(route('profile.index'));
        $indexResponse->assertSee('sold_item');
        $indexResponse->assertSee('Sold');
        $indexResponse->assertSee('available_item');
    }
}
