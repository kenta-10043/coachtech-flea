<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use App\Models\ChatImage;
use App\Http\Requests\ChatRequest;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function index($item_id)
    {
        $item = Item::With('user.profile')->findOrFail($item_id);
        $user = Auth::user();

        $buyerUserId = $item->buyer_id;
        $buyerUser = User::find($buyerUserId);
        $sellerUser = $item->user;


        $allMessages = Chat::with(['sender.profile', 'chatImages'])->where('item_id', $item->id)->orderBy('created_at')->get();


        if ($item->user_id === $user->id) {
            // $myMessages = Chat::where('item_id', $item->id)->where('sender_id', $sellerUser->id)->orderBy('created_at')->get();
            // $partnerMessages = Chat::where('item_id', $item->id)->where('sender_id', $buyerUserId)->orderBy('created_at')->get();

            return view('chats.chat_seller', compact('item', 'user', 'buyerUser', 'sellerUser', 'allMessages'));
        } else {
            // $myMessages = Chat::where('item_id', $item->id)->where('sender_id', $buyerUserId)->orderBy('created_at')->get();
            // $partnerMessages = Chat::where('item_id', $item->id)->where('sender_id', $sellerUser->id)->orderBy('created_at')->get();

            return view('chats.chat_buyer', compact('item', 'user', 'buyerUser', 'sellerUser', 'allMessages'));
        }
    }

    public function send(ChatRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $senderId = Auth::id();            //送信者
        $sellerId = $item->user_id;  //出品者
        $buyerId = $item->buyer_id ?? null;  //購入者

        $receiverId = ($senderId === $sellerId) ? $buyerId : $sellerId; //受信者

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

        return back();
    }
}
