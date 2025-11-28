<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemConfirmedMail;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function review(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->user_id === auth()->user()->id) {
            //ログインユーザーが出品者
            $revieweeId = $item->buyer_id;  // 購入者
            $reviewerId = $item->user_id;   // 出品者
            $isSeller = true;
        } else {
            //ログインユーザーが購買者
            $revieweeId = $item->user_id;   // 出品者
            $reviewerId = $item->buyer_id;  // 購入者
            $isSeller = false;
        }

        $exists = Rating::where('item_id', $item_id)
            ->where('reviewee_id', $revieweeId)
            ->where('reviewer_id', $reviewerId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'このユーザーはすでに評価済みです');
        }

        $data = $request->only('rating', 'transaction_status');

        Rating::create(
            [
                'item_id' => $item->id,
                'reviewee_id' => $revieweeId,
                'reviewer_id' => $reviewerId,
                'rating' => $data['rating'],
            ]
        );

        if ($isSeller) {
            $item->update([
                'transaction_status' => $data['transaction_status'],
            ]);
        }

        if (auth()->id() === $item->buyer_id) {
            Mail::to($item->user->email)
                ->send(new ItemConfirmedMail($item, $item->user));
        }

        return redirect(route('index'))->with('success', '評価を送信しました');
    }
}
