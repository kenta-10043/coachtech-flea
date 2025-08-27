<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $user = Auth::user();

        return view('index', compact('items', 'user'));
    }

    public function show($item_id)
    {
        $item = Item::with('comments.user', 'likes.user', 'condition', 'categories')
            ->withCount('comments', 'likes')
            ->findOrFail($item_id);

        $userId = Auth::id();
        $isLiked = $userId ? $item->likes()->where('user_id', $userId)->exists() : false;

        return view('show', compact('item', 'isLiked'));
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

    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $query = Item::query();

        if ($request->filled('keyword')) {

            $query->where('item_name', 'LIKE', '%' . $keyword . '%');
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
