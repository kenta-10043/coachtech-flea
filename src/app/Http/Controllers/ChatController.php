<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use App\Models\ChatImage;
use App\Models\Rating;
use App\Http\Requests\ChatRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{
    public function index($item_id)
    {
        $item = Item::With('user.profile')->findOrFail($item_id);
        $user = Auth::user();
        $chat = Chat::where('item_id', $item->id)->first();

        $buyerUserId = $item->buyer_id;
        $buyerUser = User::find($buyerUserId);
        $sellerUser = $item->user;

        $allMessages = Chat::with(['sender.profile', 'chatImages'])->where('item_id', $item->id)->orderBy('created_at')->simplePaginate(5);

        $transactionItems = Item::where('transaction_status', 2)
            ->withMax(['chats' => function ($q) {
                $q->where('receiver_id', auth()->id());
            }], 'created_at')
            ->orderBy('chats_max_created_at', 'desc')
            ->with('chats.receiver')
            ->get();

        if ($item->user_id === $user->id) {

            return view('chats.chat_seller', compact('item', 'user', 'chat', 'buyerUser', 'sellerUser', 'allMessages', 'transactionItems'));
        } else {

            return view('chats.chat_buyer', compact('item', 'user', 'chat', 'buyerUser', 'sellerUser', 'allMessages', 'transactionItems'));
        }
    }

    public function send(ChatRequest $request, $item_id)
    {

        $item = Item::findOrFail($item_id);
        $senderId = Auth::id();            //送信者
        $sellerId = $item->user_id;  //出品者
        $buyerId = $item->buyer_id ?? null;  //購入者

        $receiverId = ($senderId === $sellerId)
            ? ($buyerId ?? $sellerId) // buyer が null なら seller が入る
            : $sellerId; //受信者

        $chat = Chat::create([
            'item_id' => $item->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $request->body,

        ]);

        if ($request->hasFile('chat_images')) {
            foreach ($request->file('chat_images') as $file) {
                $path = $file->store('chat_images', 'public');
                ChatImage::create([
                    'chat_image' => $path,
                    'chat_id' => $chat->id,
                ]);
            }
        }

        event(new MessageSent($chat));

        return back();
    }


    public function update(Request $request, $chat_id)
    {

        $chat = Chat::findOrFail($chat_id);

        if ($chat->sender_id !== auth()->id()) {
            abort(403, "権限がありません");
        }
        $updateData = array_filter($request->only([
            'body',
        ]), function ($value) {
            return $value !== null && $value !== '';
        });
        $chat->update($updateData);

        return back()->with('success', "チャットの更新が完了しました");
    }


    public function destroy(Request $request, $chat_id)
    {

        $chat = Chat::findOrFail($chat_id);
        if ($chat->sender_id !== auth()->id()) {
            abort(403, "権限がありません");
        }

        $chat->delete();

        return back()->with('success', "チャットの削除が完了しました");
    }
}
