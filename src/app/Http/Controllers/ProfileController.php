<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Rating;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        return view('profiles.create', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();
        $sellItems = $user->items()->where('status', 1)->get();  // 出品中
        $buyItems = $user->orders()->whereNotNull('paid_at')->whereHas('item')->with('item')->get();
        $transactionItems = Item::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)->orWhere('buyer_id', $user->id);
        })->where('transaction_status', 2)->withMax(['chats' => function ($q) {
            $q->where('receiver_id', auth()->id());
        }], 'created_at')
            ->orderBy('chats_max_created_at', 'desc')
            ->with('chats.receiver')->withCount(['chats as unread_count' => function ($query) use ($user) {
                $query->where('receiver_id', $user->id)->where('unread', 1);
            }])->get();  // 取引中 自分宛てのメッセージ新しい順 アイテムと未読件数のカウント

        $ratings = Rating::where('reviewee_id', $user->id)->get();
        $ratingAvg = $ratings->isEmpty()
            ? null : round($ratings->avg('rating'));

        $totalUnread = Chat::where('receiver_id', $user->id)->where('unread', 1)->count();


        return view('profiles.profile', compact('user', 'sellItems', 'buyItems', 'transactionItems', 'ratingAvg', 'totalUnread'));
    }


    public function store(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
        ]);
        $profileDate = [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $profileDate['profile_image'] = $profileImagePath;
        }
        if ($user->profile) {
            $user->profile->update($profileDate);
        } else {
            $user->profile()->create($profileDate);
        }
        $user->load('profile');
        if ($user->profile && $user->profile->postal_code && $user->profile->address) {
            $user->update(['profile_completed' => true]);
        }

        return redirect()->route('index')->with('success', 'プロフィールを更新しました');
    }
}
