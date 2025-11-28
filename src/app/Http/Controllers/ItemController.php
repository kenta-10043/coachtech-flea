<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function show($item_id)
    {
        $item = Item::with('comments.user', 'likes.user', 'condition', 'categories')
            ->withCount('comments', 'likes')
            ->findOrFail($item_id);
        $userId = Auth::id();
        $isLiked = $userId ? $item->likes()->where('user_id', $userId)->exists() : false;

        return view('show', compact('item', 'isLiked', 'userId'));
    }

    public function toggleLike($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $existing = $item->likes()->where('user_id', $user->id)->first();
        if ($existing) {
            $existing->delete();
        } else {
            $item->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $query = Item::query();

        if ($request->query('tab') === 'mylist') {
            if (auth()->check()) {
                $user = Auth::user();
                $likedItemIds = $user->likes()->pluck('item_id');
                $query->whereIn('id', $likedItemIds);
                $query->where('user_id', '!=', auth()->id());
            } else {
                $items = collect();

                return view('index', compact('items', 'keyword'));
            }
        } else {
            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }
        }

        if ($request->filled('keyword')) {
            $query->where('item_name', 'LIKE', '%'.$keyword.'%');
        }
        $items = $query->get();

        return view('index', compact('items', 'keyword'));
    }

    public function order($item_id)
    {
        $item = Item::with('comments.user', 'likes.user', 'condition', 'categories')->findOrFail($item_id);

        return view('purchases.purchase', compact('item'));
    }
}
