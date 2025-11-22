<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaymentMethod;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;



class OrderController extends Controller
{
    public function order($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;
        $latestOrder = $user->orders()
            ->where('item_id', $item->id)
            ->latest()
            ->first();
        $postalCode = $latestOrder?->shopping_postal_code ?? $user->profile->postal_code;
        $address = $latestOrder?->shopping_address ?? $user->profile->address;
        $building = $latestOrder?->shopping_building ??  $user->profile->building;
        $paymentMethods = PaymentMethod::cases();
        $selectedPayment = $latestOrder?->payment_method
            ? PaymentMethod::from($latestOrder->payment_method)->label()
            : null;

        return view('purchases.purchase', compact('item', 'user', 'profile', 'paymentMethods', 'postalCode', 'address', 'building', 'selectedPayment'));
    }

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;
        $order = $user->orders()
            ->where('item_id', $item->id)
            ->latest()
            ->first();

        return view('purchases.address', compact('item', 'user', 'profile', 'order'));
    }

    public function createCheckoutSession(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $method = PaymentMethod::from((int)$request->payment_method);
        $order = Order::updateOrCreate(
            [
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ],
            [
                'shopping_postal_code' => $request->shopping_postal_code,
                'shopping_address' => $request->shopping_address,
                'shopping_building' => $request->shopping_building,
                'order_price' => $item->price,
                'payment_method' => (int)$request->payment_method,
            ]
        );
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $allowed = [$method->stripeCode()];
        $session = CheckoutSession::create([
            'payment_method_types' => $allowed,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'client_reference_id' => (string)$order->id,
            'success_url' => route('purchase.success', ['item_id' => $item->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.cancel', ['item_id' => $item->id]),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('purchase.order', ['item_id' => $item->id])->with('error', 'セッションIDが見つかりません');
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = CheckoutSession::retrieve($sessionId);
        $order = Order::where('id', $session->client_reference_id ?? null)
            ->where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->where('status', 'draft')
            ->first();
        if (!$order) {
            return redirect()->route('index')->with('success', '購入処理は完了しています');
        }
        if (!empty($order->checkout_session_id)) {
            return redirect()->route('index')->with('success', '購入処理は完了しています');
        }
        $method = PaymentMethod::from((int)$order->payment_method);
        $isPaid = ($session->payment_status === 'paid');
        if ($method === PaymentMethod::CARD && $isPaid) {
            $this->finalizePaidOrder($order, $item, $sessionId);
            return redirect()->route('index')->with('success', '商品を購入しました');
        }
        $order->status = 'pending';
        $order->checkout_session_id = $sessionId;
        $order->save();

        return redirect()->route('index')->with('success', 'お支払い手続きの案内を送信しました（コンビニ払い待ち）');
    }

    private function finalizePaidOrder(Order $order, Item $item, string $sessionId): void
    {
        $userId = auth()->id();

        $order->status = 'paid';
        $order->paid_at = now();
        $order->checkout_session_id = $sessionId;
        $order->save();

        $item->status = 2;  //購入状況：購入済み
        $item->buyer_id = $userId;
        $item->transaction_status = 2;  //取引状況：取引中  1:pending 2:in_progress 3:completed
        $item->save();
    }



    public function update(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $building = $request->shopping_building;

        // フォームが空でも空文字を代入
        if ($building === null) {
            $building = '';
        }
        $order = Order::updateOrCreate(
            [
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ],
            [
                'shopping_postal_code' => $request->shopping_postal_code,
                'shopping_address' => $request->shopping_address,
                'shopping_building' => $building,
                'order_price' => $item->price,
                'payment_method' => (int)$request->payment_method,
            ]
        );

        return redirect(route('purchase.order', ['item_id' => $item->id]))->with('success', '配送先住所を登録しました');;
    }
}
