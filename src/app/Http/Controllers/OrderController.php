<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function order($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchases.purchase', compact('item', 'user'));
    }

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;

        return view('purchases.address', compact('item', 'user', 'profile'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $order = Order::where('item_id', $item->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update([
            'shopping_postal_code' => $request->shopping_postal_code,
            'shopping_address' => $request->shopping_address,
            'shopping_building' => $request->shopping_building,
        ]);
        return redirect(route('purchase.edit', ['item_id' => $item->id]));
    }
}
