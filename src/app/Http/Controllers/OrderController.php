<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaymentMethod;
use Carbon\Carbon;



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
        $building = $latestOrder?->shopping_building ?? $user->profile->building;
        $paymentMethods = PaymentMethod::cases();

        return view('purchases.purchase', compact('item', 'user', 'profile', 'paymentMethods', 'postalCode', 'address', 'building'));
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

    public function update(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

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
                'payment_method' => 1,
            ]
        );

        return redirect(route('purchase.order', ['item_id' => $item->id]))->with('success', '配送先住所を登録しました');;
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        $order = Order::firstOrNew([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $order->order_price = $item->price;
        $order->payment_method = $request->payment_method;
        $order->shopping_postal_code = $request->shopping_postal_code;
        $order->shopping_address = $request->shopping_address;
        $order->shopping_building = $request->shopping_building;
        $order->status = 'confirmed';
        $order->paid_at = Carbon::now();
        $order->save();

        $item->status = 2;
        $item->save();

        return redirect(route('index'))->with('success', '商品を購入しました');
    }
}
